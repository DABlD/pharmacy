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
                    </div>

                    <div class="card-body table-responsive">
                    	<table id="table" class="table table-hover">
                    		<thead>
                    			<tr>
                    				<th>Ref</th>
                    				<th>Category</th>
                    				<th>Item</th>
                    				<th>Request Date</th>
                    				<th>Qty</th>
                    				<th>Approved On</th>
                    				<th>Qty</th>
                    				<th>Dispatched On</th>
                    				<th>Received On</th>
                    				<th>Qty</th>
                    				<th>Status</th>
                    				<th>Action</th>
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
	<link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
	
	<style>
		.table td{
			text-align: center;
		}
	</style>
@endpush

@push('scripts')
	<script src="{{ asset('js/datatables.min.js') }}"></script>
	<script src="{{ asset('js/select2.min.js') }}"></script>
	<script src="{{ asset('js/flatpickr.min.js') }}"></script>

	<script>
		$(document).ready(()=> {
			var table = $('#table').DataTable({
				ajax: {
					url: "{{ route('datatable.receive') }}",
                	dataType: "json",
                	dataSrc:'',
					data: {
						select: "*",
						load: ['medicine.category'],
						where: [
							'user_id', "{{ auth()->user()->id }}",
							'created_at', '>', moment().subtract(30, 'days').format('YYYY-MM-DD')
						],
						whereIn: ['status', ['For Delivery', 'Incomplete Qty', 'Delivered']]
					}
				},
				columns: [
					{data: 'reference'},
					{data: 'medicine.category.name'},
					{data: 'medicine.name'},
					{data: 'transaction_date'},
					{data: 'request_qty'},
					{data: 'date_approved'},
					{data: 'approved_qty'},
					{data: 'date_dispatched'},
					{data: 'received_date'},
					{data: 'received_qty'},
					{data: 'status'},
					{data: 'actions'},
				],
        		order: [],
        		pageLength: 25,
				columnDefs: [
					{
						targets: [3,5,7,8],
						render: date =>{;
							if(date){
								return moment(date).format(dateFormat2);
							}
							else{
								return "N/A";
							}
						}
					}
				]
			});
		});

		function receive(id){
			$.ajax({
				url: "{{ route('request.get') }}",
				data: {
					select: '*',
					where: ['id', id],
					load: ['medicine']
				},
				success: req => {
					req = JSON.parse(req)[0];
					
					Swal.fire({
						html: `
			                ${input("reference", "Reference", req.reference, 5, 7, 'text', ' disabled')}
			                ${input("medicine", "Item", req.medicine.name, 5, 7, 'text', ' disabled')}
			                ${input("qty", "Approved Qty", req.approved_qty, 5, 7, 'text', ' disabled')}
			                </br></br>
			                ${input("date", "Received Date", null, 5, 7)}
			                ${input("qty2", "Received Qty", null, 5, 7, 'number', ' min=0')}
						`,
						width: '400px',
						confirmButtonText: 'Receive',
						showCancelButton: true,
						cancelButtonColor: errorColor,
						cancelButtonText: 'Cancel',
						didOpen: () => {
							$("[name='date']").flatpickr({
								altInput: true,
								altFormat: "F j, Y",
								dateFormat: "Y-m-d",
								defaultDate: dateNow()
							});
						},
						preConfirm: () => {
						    swal.showLoading();
						    return new Promise(resolve => {
						    	let bool = true;
					            if($("[name='qty2']").val() == ""){
					                Swal.showValidationMessage('Received Qty must not be empty');
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
							let qty = $("[name='qty']").val();
							let qty2 = $("[name='qty2']").val();
							let status = qty == qty2 ? "Delivered" : "Incomplete Qty";

							update({
								url: "{{ route('request.update') }}",
								data: {
									where: ["id", id],
									status: status,
									received_date: $("[name='date']").val(),
									received_qty: qty2
								},
							}, () => {
								ss("Success");
								reload();
							});
						}
					});
				}
			});
		}
	</script>
@endpush