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
			$('#table').DataTable({
				ajax: {
					url: "{{ route('datatable.rhu') }}",
                	dataType: "json",
                	dataSrc: "",
					data: {
						table: 'Rhu',
						cols: "*",
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
					{data: 'id'},
				]
			});
		});

		$("[title='Add RHU']").on('click', () => {
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
			            			cols: "id",
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
			            						cols: "id",
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
						}
					})
				}
			});
		});
	</script>
@endpush