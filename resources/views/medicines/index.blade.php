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

                        @include('medicines.includes.toolbar')
                    </div>

                    <div class="card-body table-responsive">
                    	<table id="table" class="table table-hover">
                    		<thead>
                    			<tr>
                    				<th>#</th>
                    				<th>Category</th>
                    				<th>Image</th>
                    				<th>Code</th>
                    				<th>Brand</th>
                    				<th>Name</th>
                    				<th>Packaging</th>
                    				<th>Unit Price</th>
                    				<th>Cost Price</th>
                    				<th>Reorder Point</th>
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
					url: "{{ route('datatable.medicine') }}",
                	dataType: "json",
                	dataSrc: "",
					data: {
						select: "*",
						load: ['category']
					}
				},
				columns: [
					{data: 'id'},
					{data: 'category.name'},
					{data: 'image'},
					{data: 'code'},
					{data: 'brand'},
					{data: 'name'},
					{data: 'packaging'},
					{data: 'unit_price'},
					{data: 'cost_price'},
					{data: 'reorder_point'},
					{data: 'actions'},
				],
        		order: [[1, 'asc']],
		        drawCallback: function (settings) {
		            let api = this.api();
		            let rows = api.rows({ page: 'current' }).nodes();
		            let last = null;
		 
		            api.column(1, { page: 'current' })
		                .data()
		                .each(function (medicine, i, row) {
		                    if (last !== medicine) {
		                        $(rows)
		                            .eq(i)
		                            .before(`
		                            	<tr class="group">
		                            		<td colspan="10">
		                            			${medicine}
		                            		</td>
		                            		<td>
		                            		</td>
		                            	</tr>
		                            `);
		 
		                        last = medicine;
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
					        Category
					    </div>
					    <div class="col-md-9 iInput">
					        <select name="category_id" class="form-control">
					        	<option value=""></option>
					        </select>
					    </div>
					</div>
	                ${input("image", "image", null, 3, 9)}
	                ${input("code", "code", null, 3, 9)}
	                ${input("brand", "brand", null, 3, 9)}
	                ${input("name", "name", null, 3, 9)}
	                ${input("packaging", "packaging", null, 3, 9)}
	                ${input("unit_price", "unit_price", null, 3, 9)}
	                ${input("cost_price", "cost_price", null, 3, 9)}
	                ${input("reorder_point", "reorder_point", null, 3, 9)}
				`,
				width: '800px',
				confirmButtonText: 'Add',
				showCancelButton: true,
				cancelButtonColor: errorColor,
				cancelButtonText: 'Cancel',
				didOpen: () => {
					$.ajax({
						url: "{{ route('medicine.getCategory') }}",
						data: {
							select: "*",
						},
						success: rhus => {
							categories = JSON.parse(categories);
							categoryiString = "";

							categories.forEach(category => {
								categoryString += `
									<option value="${category.id}">${category.name}</option>
								`;
							});

							$("[name='category_id']").append(categoryString);
							$("[name='category_id']").select2({
								placeholder: "Select Category"
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

		function createCategory(){
			Swal.fire({
				html: `
	                ${input("name", "Name", null, 3, 9)}
				`,
				width: '400px',
				confirmButtonText: 'Add',
				showCancelButton: true,
				cancelButtonColor: errorColor,
				cancelButtonText: 'Cancel',
				preConfirm: () => {
				    swal.showLoading();
				    return new Promise(resolve => {
				    	let bool = true;

			            if($('.swal2-container input:placeholder-shown').length || $("[name='rhu_id']").val() == ""){
			                Swal.showValidationMessage('Fill all fields');
			            }

			            bool ? setTimeout(() => {resolve()}, 500) : "";
				    });
				},
			}).then(result => {
				if(result.value){
					$.ajax({
						url: "{{ route('medicine.storeCategory') }}",
						type: "POST",
						data: {
							name: $("[name='name']").val(),
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