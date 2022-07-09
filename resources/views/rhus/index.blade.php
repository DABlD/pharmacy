@extends('layouts.app')
@section('content')

<section class="content">
    <div class="container-fluid">

        <div class="row">
            <section class="col-lg-12 connectedSortable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-table mr-1"></i>
                            List
                        </h3>

                        @include('rhus.includes.toolbar')
                    </div>

                    <div class="card-body table-responsive">
                    	<table id="table" class="table table-hover">
                    		<thead>
                    			<tr>
                    				<th>ID</th>
                    				<th>Name</th>
                    				<th>Company</th>
                    				<th>Code</th>
                    				<th>Contact</th>
                    				<th>Number</th>
                    				<th>Email</th>
                    				<th>Address</th>
                    				<th>Actions</th>
                    			</tr>
                    		</thead>

                    		<tbody>
                    		</tbody>
                    	</table>
                    </div>
                </div>
            </section>
        </div>
    </div>

</section>

@endsection

@push('styles')
	<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
	{{-- <link rel="stylesheet" href="{{ asset('css/datatables-jquery.min.css') }}"> --}}
@endpush

@push('scripts')
	<script src="{{ asset('js/datatables.min.js') }}"></script>
	{{-- <script src="{{ asset('js/datatables-jquery.min.js') }}"></script> --}}

	<script>
		$(document).ready(()=> {
			var table = $('#table').DataTable({
				ajax: {
					url: "{{ route('datatable.rhu') }}",
                	dataType: "json",
                	dataSrc: "",
					data: {
						table: 'Rhu',
						select: "*",
						load: ['user']
					}
				},
				columns: [
					{data: 'id'},
					{data: 'user.name'},
					{data: 'company_name'},
					{data: 'company_code'},
					{data: 'contact_personnel'},
					{data: 'user.contact'},
					{data: 'user.email'},
					{data: 'user.address'},
					{data: 'actions'},
				],
        		pageLength: 25,
				// drawCallback: function(){
				// 	init();
				// }
			});
		});

		function view(id){
			$.ajax({
				url: "{{ route('rhu.get') }}",
				data: {
					select: '*',
					where: ['id', id],
					load: ['user']
				},
				success: rhu => {
					rhu = JSON.parse(rhu)[0];
					showDetails(rhu);
				}
			})
		}

		function create(){
			Swal.fire({
				html: `
	                ${input("name", "Name", null, 3, 9)}
	                ${input("company_name", "Company Name", null, 3, 9)}
	                ${input("contact_personnel", "Contact Person", null, 3, 9)}
	                ${input("contact", "Contact #", null, 3, 9, "number")}
					${input("email", "Email", null, 3, 9, 'email')}
	                ${input("address", "Address", null, 3, 9)}
	                </br>
	                ${input("username", "Username", null, 3, 9, 'text', 'autocomplete="new-password"')}
                    ${input("password", "Password", null, 3, 9, 'password', 'autocomplete="new-password"')}
                    ${input("password_confirmation", "Confirm Password", null, 3, 9, 'password', 'autocomplete="new-password"')}
				`,
				width: '800px',
				confirmButtonText: 'Add',
				showCancelButton: true,
				cancelButtonColor: errorColor,
				cancelButtonText: 'Cancel',
				preConfirm: () => {
				    swal.showLoading();
				    return new Promise(resolve => {
				    	let bool = true;

			            if($('.swal2-container input:placeholder-shown').length){
			                Swal.showValidationMessage('Fill all fields');
			            }
			            else if($("[name='password']").val().length < 8){
			                Swal.showValidationMessage('Password must at least be 8 characters');
			            }
			            else if($("[name='password']").val() != $("[name='password_confirmation']").val()){
			                Swal.showValidationMessage('Password do not match');
			            }
			            else{
			            	let bool = false;
			            	$.ajax({
			            		url: "{{ route('user.get') }}",
			            		data: {
			            			select: "id",
			            			where: ["username", $("[name='username']").val()]
			            		},
			            		success: result => {
			            			result = JSON.parse(result);
			            			if(result.length){
			                			Swal.showValidationMessage('Username already exists');
			                			setTimeout(() => {resolve()}, 500);
			            			}
			            			else{
			            				$.ajax({
			            					url: "{{ route('user.get') }}",
			            					data: {
			            						select: "id",
			            						where: ["email", $("[name='email']").val()]
			            					},
			            					success: result => {
			            						result = JSON.parse(result);
			            						if(result.length){
			            			    			Swal.showValidationMessage('Email already used');
				            						setTimeout(() => {resolve()}, 500);
			            						}
			            					}
			            				});
			            			}

			            		}
			            	});
			            }

			            bool ? setTimeout(() => {resolve()}, 500) : "";
				    });
				},
			}).then(result => {
				if(result.value){
					swal.showLoading();
					$.ajax({
						url: "{{ route('rhu.store') }}",
						type: "POST",
						data: {
							name: $("[name='name']").val(),
							company_name: $("[name='company_name']").val(),
							contact_personnel: $("[name='contact_personnel']").val(),
							contact: $("[name='contact']").val(),
							email: $("[name='email']").val(),
							address: $("[name='address']").val(),
							username: $("[name='username']").val(),
							password: $("[name='password']").val(),
							_token: $('meta[name="csrf-token"]').attr('content')
						},
						success: () => {
							ss("Success");
							reload();
						}
					})
				}
			});
		}

		function showDetails(rhu){
			Swal.fire({
				html: `
	                ${input("id", "", rhu.user.id, 3, 9, 'hidden')}
	                ${input("name", "Name", rhu.user.name, 3, 9)}
	                ${input("company_name", "Company Name", rhu.company_name, 3, 9)}
	                ${input("contact_personnel", "Contact Person", rhu.contact_personnel, 3, 9)}
	                ${input("contact", "Contact #", rhu.user.contact, 3, 9, "number")}
					${input("email", "Email", rhu.user.email, 3, 9, 'email')}
	                ${input("address", "Address", rhu.user.address, 3, 9)}
	                </br>
	                ${input("username", "Username", rhu.user.username, 3, 9, 'text', 'autocomplete="new-password"')}
				`,
				width: '800px',
				confirmButtonText: 'Update',
				showCancelButton: true,
				cancelButtonColor: errorColor,
				cancelButtonText: 'Cancel',
                showDenyButton: true,
                denyButtonColor: successColor,
                denyButtonText: 'Change Password',
				preConfirm: () => {
				    swal.showLoading();
				    return new Promise(resolve => {
				    	let bool = true;

			            if($('.swal2-container input:placeholder-shown').length){
			                Swal.showValidationMessage('Fill all fields');
			            }
			            else{
			            	let bool = false;
			            	$.ajax({
			            		url: "{{ route('user.get') }}",
			            		data: {
			            			select: "id",
			            			where: ["username", $("[name='username']").val()]
			            		},
			            		success: result => {
			            			result = JSON.parse(result);
			            			if(result.length && result[0].id != rhu.user.id){
			                			Swal.showValidationMessage('Username already exists');
			                			setTimeout(() => {resolve()}, 500);
			            			}
			            			else{
			            				$.ajax({
			            					url: "{{ route('user.get') }}",
			            					data: {
			            						select: "id",
			            						where: ["email", $("[name='email']").val()]
			            					},
			            					success: result => {
			            						result = JSON.parse(result);
			            						if(result.length && result[0].id != rhu.user.id){
			            			    			Swal.showValidationMessage('Email already used');
				            						setTimeout(() => {resolve()}, 500);
			            						}
			            					}
			            				});
			            			}

			            		}
			            	});
			            }

			            bool ? setTimeout(() => {resolve()}, 500) : "";
				    });
				},
			}).then(result => {
				if(result.value){
					swal.showLoading();
					update({
						url: "{{ route('user.update') }}",
						data: {
							id: $("[name='id']").val(),
							name: $("[name='name']").val(),
							contact: $("[name='contact']").val(),
							email: $("[name='email']").val(),
							address: $("[name='address']").val(),
							username: $("[name='username']").val(),
						},
						message: false
					},	() => {
							update({
								url: "{{ route('rhu.update') }}",
								data: {
									id: $("[name='id']").val(),
									company_name: $("[name='company_name']").val(),
									contact_personnel: $("[name='contact_personnel']").val(),
									where: ['user_id', $("[name='id']").val()]
								},
								message: "Success"
							}, () => {
								reload();
							})
						}
					);
				}
				else if(result.isDenied){
					changePassword($("[name='id']").val());
				}
			});
		}

		function changePassword(id){
			Swal.fire({
			    html: `
			        ${input("password", "Password", null, 5, 7, 'password')}
			        ${input("password_confirmation", "Confirm Password", null, 5, 7, 'password')}
			    `,
			    confirmButtonText: 'Update',
			    showCancelButton: true,
			    cancelButtonColor: errorColor,
			    cancelButtonText: 'Exit',
			    width: "500px",
			    preConfirm: () => {
			        swal.showLoading();
			        return new Promise(resolve => {
			            setTimeout(() => {
			                if($('.swal2-container input:placeholder-shown').length){
			                    Swal.showValidationMessage('Fill all fields');
			                }
			                else if($("[name='password']").val().length < 8){
			                    Swal.showValidationMessage('Password must at least be 8 characters');
			                }
			                else if($("[name='password']").val() != $("[name='password_confirmation']").val()){
			                    Swal.showValidationMessage('Password do not match');
			                }
			            resolve()}, 500);
			        });
			    },
			}).then(result => {
				if(result.value){
					swal.showLoading();
					update({
						url: "{{ route('user.updatePassword') }}",
						data: {
							id: id,
							password: $("[name='password']").val(),
						}
					}, () => {
						ss("Success");
					});
				}
			});
		}

		function del(id){
			sc("Confirmation", "Are you sure you want to delete?", result => {
				if(result.value){
					swal.showLoading();
					update({
						url: "{{ route('rhu.delete') }}",
						data: {id: id},
						message: "Success"
					}, () => {
						reload();
					})
				}
			});
		}
	</script>
@endpush