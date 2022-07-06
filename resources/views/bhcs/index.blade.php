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

                        @include('bhcs.includes.toolbar')
                    </div>

                    <div class="card-body table-responsive">
                    	<table id="table" class="table table-hover">
                    		<thead>
                    			<tr>
                    				<th>ID</th>
                    				<th>RHU</th>
                    				<th>Code</th>
                    				<th>Name</th>
                    				<th>Region</th>
                    				<th>Municipality</th>
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
	<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endpush

@push('scripts')
	<script src="{{ asset('js/datatables.min.js') }}"></script>
	<script src="{{ asset('js/select2.min.js') }}"></script>

	<script>
		$(document).ready(()=> {
			var table = $('#table').DataTable({
				ajax: {
					url: "{{ route('datatable.bhc') }}",
                	dataType: "json",
                	dataSrc: "",
					data: {
						table: 'Rhu',
						select: "*",
						load: ['rhu']
					}
				},
				columns: [
					{data: 'id'},
					{data: 'rhu.company_name'},
					{data: 'code'},
					{data: 'name'},
					{data: 'region'},
					{data: 'municipality'},
					{data: 'actions'},
				],
        		order: [[1, 'asc']],
		        drawCallback: function (settings) {
		            let api = this.api();
		            let rows = api.rows({ page: 'current' }).nodes();
		            let last = null;
		 
		            api.column(1, { page: 'current' })
		                .data()
		                .each(function (company, i, row) {
		                    if (last !== company) {
		                        $(rows)
		                            .eq(i)
		                            .before(`
		                            	<tr class="group">
		                            		<td colspan="6">
		                            			${company}
		                            		</td>
		                            		<td>
		                            		</td>
		                            	</tr>
		                            `);
		 
		                        last = company;
		                    }
		                });
		        },
			});
		});

		function create(){
			Swal.fire({
				html: `
					<div class="row iRow">
					    <div class="col-md-3 iLabel">
					        RHU
					    </div>
					    <div class="col-md-9 iInput">
					        <select name="rhu_id" class="form-control">
					        	<option value=""></option>
					        </select>
					    </div>
					</div>
	                ${input("code", "Code", null, 3, 9)}
	                ${input("name", "Name", null, 3, 9)}
	                ${input("region", "Region", null, 3, 9)}
	                ${input("municipality", "Municipality", null, 3, 9)}
				`,
				width: '800px',
				confirmButtonText: 'Add',
				showCancelButton: true,
				cancelButtonColor: errorColor,
				cancelButtonText: 'Cancel',
				didOpen: () => {
					$.ajax({
						url: "{{ route('rhu.get') }}",
						data: {
							select: "*",
						},
						success: rhus => {
							rhus = JSON.parse(rhus);
							rhuString = "";

							rhus.forEach(rhu => {
								rhuString += `
									<option value="${rhu.id}">${rhu.company_name} - ${rhu.company_code}</option>
								`;
							});

							$("[name='rhu_id']").append(rhuString);
							$("[name='rhu_id']").select2({
								placeholder: "Select RHU"
							});
						}
					})
				},
				preConfirm: () => {
				    swal.showLoading();
				    return new Promise(resolve => {
				    	let bool = true;

			            if($('.swal2-container input:placeholder-shown').length || $("[name='rhu_id']").val() == ""){
			                Swal.showValidationMessage('Fill all fields');
			            }
			            else{
			            	let bool = false;
			            	// Insert ajax validation
				            setTimeout(() => {resolve()}, 500);
			            }

			            bool ? setTimeout(() => {resolve()}, 500) : "";
				    });
				},
			}).then(result => {
				if(result.value){
					$.ajax({
						url: "{{ route('bhc.store') }}",
						type: "POST",
						data: {
							rhu_id: $("[name='rhu_id']").val(),
							code: $("[name='code']").val(),
							name: $("[name='name']").val(),
							region: $("[name='region']").val(),
							municipality: $("[name='municipality']").val(),
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

		function create2(){
			Swal.fire({
				html: `
	                ${input("code", "Code", null, 3, 9)}
	                ${input("name", "Name", null, 3, 9)}
	                ${input("region", "Region", null, 3, 9)}
	                ${input("municipality", "Municipality", null, 3, 9)}
				`,
				width: '800px',
				confirmButtonText: 'Add',
				showCancelButton: true,
				cancelButtonColor: errorColor,
				cancelButtonText: 'Cancel',
				didOpen: () => {
					$.ajax({
						url: "{{ route('rhu.get') }}",
						data: {
							select: "*",
						},
						success: rhus => {
							rhus = JSON.parse(rhus);
							rhuString = "";

							rhus.forEach(rhu => {
								rhuString += `
									<option value="${rhu.id}">${rhu.company_name} - ${rhu.company_code}</option>
								`;
							});

							$("[name='rhu_id']").append(rhuString);
							$("[name='rhu_id']").select2({
								placeholder: "Select RHU"
							});
						}
					})
				},
				preConfirm: () => {
				    swal.showLoading();
				    return new Promise(resolve => {
				    	let bool = true;

			            if($('.swal2-container input:placeholder-shown').length || $("[name='rhu_id']").val() == ""){
			                Swal.showValidationMessage('Fill all fields');
			            }
			            else{
			            	let bool = false;
			            	// Insert ajax validation
				            setTimeout(() => {resolve()}, 500);
			            }

			            bool ? setTimeout(() => {resolve()}, 500) : "";
				    });
				},
			}).then(result => {
				if(result.value){
					$.ajax({
						url: "{{ route('bhc.store') }}",
						type: "POST",
						data: {
							rhu_id: $("[name='rhu_id']").val(),
							code: $("[name='code']").val(),
							name: $("[name='name']").val(),
							region: $("[name='region']").val(),
							municipality: $("[name='municipality']").val(),
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

		function view(id){
			$.ajax({
				url: "{{ route('bhc.get') }}",
				data: {
					select: '*',
					where: ['id', id],
				},
				success: bhc => {
					bhc = JSON.parse(bhc)[0];
					showDetails(bhc);
				}
			})
		}

		function showDetails(bhc){
			Swal.fire({
				html: `
	                ${input("id", "", bhc.id, 3, 9, 'hidden')}
	                ${input("code", "Code", bhc.code, 3, 9)}
	                ${input("name", "Name", bhc.name, 3, 9)}
	                ${input("region", "Region", bhc.region, 3, 9)}
	                ${input("municipality", "Municipality", bhc.municipality, 3, 9)}
				`,
				width: '800px',
				confirmButtonText: 'Update',
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
			            else{
			            	let bool = false;
			            	// Insert ajax validation
				            setTimeout(() => {resolve()}, 500);
			            }

			            bool ? setTimeout(() => {resolve()}, 500) : "";
				    });
				},
			}).then(result => {
				if(result.value){
					update({
						url: "{{ route('bhc.update') }}",
						data: {
							id: $("[name='id']").val(),
							code: $("[name='code']").val(),
							name: $("[name='name']").val(),
							region: $("[name='region']").val(),
							municipality: $("[name='municipality']").val(),
						},
						message: "Success"
					}, () => {
						reload();
					})
				}
				else if(result.isDenied){
					changePassword($("[name='id']").val());
				}
			});
		}

		function del(id){
			sc("Confirmation", "Are you sure you want to delete?", result => {
				if(result.value){
					update({
						url: "{{ route('bhc.delete') }}",
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