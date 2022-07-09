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
                    				<th>Stock</th>
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
                	dataSrc:'',
					data: {
						select: "*",
						load: ['category', 'reorder']
					}
				},
				columns: [
					{data: 'id'},
					{data: 'category.name', visible: false},
					{data: 'image', visible: false},
					{data: 'code'},
					{data: 'brand'},
					{data: 'name'},
					{data: 'packaging'},
					{data: 'unit_price'},
					{data: 'cost_price'},
					{data: 'reorder.point'},
					{data: 'stock'},
					{data: 'actions'},
				],
        		order: [[1, 'asc']],
        		pageLength: 25,
        		rowCallback: function( row, data, index ) {
				    if (data['id'] == null) {
				        $(row).hide();
				    }
				},
				columnDefs: [
					{
						targets: [7,8],
						render: (value, display, row) =>{;
							return "₱" + parseFloat(value).toFixed(2);
						}
					}
				],
		        drawCallback: function (settings) {
		            let api = this.api();
		            let rows = api.rows({ page: 'current' }).nodes();
		            let last = null;
		 
		            api.column(1, { page: 'current' })
		                .data()
		                .each(function (medicine, i) {
		                    if (last !== medicine) {
		                        $(rows)
		                            .eq(i)
		                            .before(`
		                            	<tr class="group">
		                            		<td colspan="9">
		                            			${medicine}
		                            		</td>
		                            	</tr>
		                            `);
		 
		                        last = medicine;
		                    }
		                });


					let groups = $('tr.group td');

					if(groups.length){
						groups.each((index, row) => {
							let category = row.innerText;
							$(row).after(`
								<td>
									<a class='btn btn-primary btn-sm' data-toggle='tooltip' title='Add Item' onclick='create("${category}")'>
										<i class='fas fa-plus fa-2xl'></i>
									</a>
									<a class='btn btn-warning btn-sm' data-toggle='tooltip' title='Edit Category' onclick='editCategory("${category}")'>
										<i class='fas fa-pencil'></i>
									</a>
								</td>
							`);
						});
					}
				},
		        initComplete: () => {
		        }
			});
		});

		function create(selectedCategory = null){
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
	                ${input("code", "Code", null, 3, 9)}
	                ${input("brand", "Brand", null, 3, 9)}
	                ${input("name", "Generic Name", null, 3, 9)}
	                ${input("packaging", "Packaging", null, 3, 9)}
	                ${input("unit_price", "Unit Price", null, 3, 9, 'number')}
	                ${input("cost_price", "Cost Price", null, 3, 9, 'number')}
	                ${input("reorder_point", "Reorder Point", null, 3, 9)}
				`,
				width: '800px',
				confirmButtonText: 'Add',
				showCancelButton: true,
				cancelButtonColor: errorColor,
				cancelButtonText: 'Cancel',
				didOpen: () => {
					$.ajax({
						url: "{{ route('medicine.getCategories') }}",
						data: {
							select: "*",
						},
						success: categories => {
							categories = JSON.parse(categories);
							categoryString = "";

							categories.forEach(category => {
								categoryString += `
									<option value="${category.id}">${category.name}</option>
								`;
							});

							$("[name='category_id']").append(categoryString);
							$("[name='category_id']").select2({
								placeholder: "Select category"
							});

							if(selectedCategory){
								$("[name='category_id']").select2("val", $(`[name='category_id'] option:contains('${selectedCategory}')`).val());
							}
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
			            else if($('[name="unit_price"]').val() <= 0){
			                Swal.showValidationMessage('Unit Price must be greater than 0');
			            }
			            else if($('[name="cost_price"]').val() <= 0){
			                Swal.showValidationMessage('Cost Price must be greater than 0');
			            }
			            else if($('[name="reorder_point"]').val() < 0){
			                Swal.showValidationMessage('Cost Price must not be less than 0');
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
						url: "{{ route('medicine.store') }}",
						type: "POST",
						data: {
							category_id: $("[name='category_id']").val(),
							code: $("[name='code']").val(),
							brand: $("[name='brand']").val(),
							name: $("[name='name']").val(),
							packaging: $("[name='packaging']").val(),
							unit_price: $("[name='unit_price']").val(),
							cost_price: $("[name='cost_price']").val(),
							reorder_point: $("[name='reorder_point']").val(),
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
			            else{
			            	let bool = false;
			            	// Insert ajax validation
            				$.ajax({
            					url: "{{ route('medicine.getCategories') }}",
            					data: {
            						select: "id",
            						where: ["name", $("[name='name']").val()]
            					},
            					success: result => {
            						result = JSON.parse(result);
            						if(result.length){
            			    			Swal.showValidationMessage('Category already exists');
	            						setTimeout(() => {resolve()}, 500);
            						}
            					}
            				});

				            setTimeout(() => {resolve()}, 500);
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

		function editCategory(category){
			Swal.fire({
				html: `
	                ${input("name", "Name", category, 3, 9)}
				`,
				width: '400px',
				confirmButtonText: 'Update',
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
			            else{
			            	let bool = false;
			            	// Insert ajax validation
            				$.ajax({
            					url: "{{ route('medicine.getCategories') }}",
            					data: {
            						select: "id",
            						where: ["name", $("[name='name']").val()]
            					},
            					success: result => {
            						result = JSON.parse(result);
            						if(result.length){
            			    			Swal.showValidationMessage('Category already exists');
	            						setTimeout(() => {resolve()}, 500);
            						}
            					}
            				});

				            setTimeout(() => {resolve()}, 500);
			            }

			            bool ? setTimeout(() => {resolve()}, 500) : "";
				    });
				},
			}).then(result => {
				if(result.value){
					$.ajax({
						url: "{{ route('medicine.updateCategory') }}",
						type: "POST",
						data: {
							where: ["name", category],
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
				url: "{{ route('medicine.get') }}",
				data: {
					select: '*',
					where: ['id', id],
					load: ["category", 'reorder']
				},
				success: medicine => {
					medicine = JSON.parse(medicine)[0];
					showDetails(medicine);
				}
			})
		}

		function showDetails(medicine){
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
	                ${input("code", "Code", medicine.code, 3, 9)}
	                ${input("brand", "Brand", medicine.brand, 3, 9)}
	                ${input("name", "Generic Name", medicine.name, 3, 9)}
	                ${input("packaging", "Packaging", medicine.packaging, 3, 9)}
	                ${input("unit_price", "Unit Price", medicine.unit_price, 3, 9, 'number')}
	                ${input("cost_price", "Cost Price", medicine.cost_price, 3, 9, 'number')}
	                ${input("reorder_point", "Reorder Point", medicine.reorder.point, 3, 9)}
				`,
				width: '800px',
				confirmButtonText: 'Update',
				showCancelButton: true,
				cancelButtonColor: errorColor,
				cancelButtonText: 'Cancel',
				didOpen: () => {
					$.ajax({
						url: "{{ route('medicine.getCategories') }}",
						data: {
							select: "*",
						},
						success: categories => {
							categories = JSON.parse(categories);
							categoryString = "";

							categories.forEach(category => {
								categoryString += `
									<option value="${category.id}">${category.name}</option>
								`;
							});

							$("[name='category_id']").append(categoryString);
							$("[name='category_id']").select2({
								placeholder: "Select category"
							});

							$("[name='category_id']").val(medicine.category_id).trigger('change');
						}
					})
				},
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
					swal.showLoading();
					update({
						url: "{{ route('medicine.update') }}",
						data: {
							id: medicine.id,
							category_id: $("[name='category_id']").val(),
							code: $("[name='code']").val(),
							brand: $("[name='brand']").val(),
							name: $("[name='name']").val(),
							packaging: $("[name='packaging']").val(),
							unit_price: $("[name='unit_price']").val(),
							cost_price: $("[name='cost_price']").val(),
						},
					}, () => {
						update({
							url: "{{ route('medicine.updateReorder') }}",
							data: {
								where: [
									"medicine_id", medicine.id,
									"user_id", medicine.user_id
								],
								point: $("[name='reorder_point']").val(),
							},
							message: "Success"
						}, () => {
							reload();
						})
					})
				}
			});
		}

		function del(id){
			sc("Confirmation", "Are you sure you want to delete?", result => {
				if(result.value){
					swal.showLoading();
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