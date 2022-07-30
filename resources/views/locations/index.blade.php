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

                        @include('locations.includes.toolbar')
                    </div>

                    <div class="card-body table-responsive">
                    	<table id="table" class="table table-hover">
                    		<thead>
                    			<tr>
                    				<th>ID</th>
                    				<th>Location</th>
                    				<th>Contact</th>
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
					url: "{{ route('datatable.location') }}",
                	dataType: "json",
                	dataSrc: "",
					data: {
						table: 'location',
						select: "*",
					}
				},
				columns: [
					{data: 'id'},
					{data: 'location'},
					{data: 'contact'},
					{data: 'actions'}
				],
        		pageLength: 25,
				// drawCallback: function(){
				// 	init();
				// }
			});
		});

		function create(){
			Swal.fire({
				html: `
	                ${input("location", "Location", null, 3, 9)}
	                ${input("contact", "Contact", null, 3, 9)}
				`,
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
			            else{
			            	let bool = false;
			            	// Insert ajax validation
            				$.ajax({
            					url: "{{ route('location.get') }}",
            					data: {
            						select: "id",
            						where: ["location", $("[name='location']").val()]
            					},
            					success: result => {
            						result = JSON.parse(result);
            						if(result.length){
            			    			Swal.showValidationMessage('Location already exists');
	            						setTimeout(() => {resolve()}, 500);
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
						url: "{{ route('location.store') }}",
						type: "POST",
						data: {
							location: $("[name='location']").val(),
							contact: $("[name='contact']").val(),
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
				url: "{{ route('location.get') }}",
				data: {
					select: '*',
					where: ['id', id],
				},
				success: location => {
					location = JSON.parse(location)[0];
					showDetails(location);
				}
			})
		}

		function showDetails(location){
			Swal.fire({
				html: `
	                ${input("id", "", location.id, 3, 9, 'hidden')}
	                ${input("location", "Location", location.location, 3, 9)}
	                ${input("contact", "Contact", location.contact, 3, 9)}
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
            				$.ajax({
            					url: "{{ route('location.get') }}",
            					data: {
            						select: "id",
            						where: ["location", $("[name='location']").val()]
            					},
            					success: result => {
            						result = JSON.parse(result);
            						if(result.length && result[0].id != location.id){
            			    			Swal.showValidationMessage('Location already exists');
	            						setTimeout(() => {resolve()}, 500);
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
						url: "{{ route('location.update') }}",
						data: {
							id: $("[name='id']").val(),
							location: $("[name='location']").val(),
							contact: $("[name='contact']").val(),
						},
						message: "Success"
					},	() => {
						reload();
					});
				}
			});
		}
	</script>
@endpush