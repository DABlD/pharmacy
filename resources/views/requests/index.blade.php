@extends('layouts.app')
@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">

	        <div class="col-lg-3 col-6">
	            <div class="small-box bg-info">
	                <div class="inner">
	                    <h3>
	                    	For Approval:
	                    	<span id="fa">0</span>
	                    </h3>
	                </div>

	                <div class="icon">
	                    <i class="fa-solid fa-clipboard-list-check"></i>
	                </div>
	            </div>
	        </div>
        	
	        <div class="col-lg-3 col-6">
	            <div class="small-box bg-warning">
	                <div class="inner">
	                    <h3>
	                    	Approved:
	                    	<span id="fi">0</span>
	                    </h3>
	                </div>

	                <div class="icon">
	                    <i class="fa-solid fa-check"></i>
	                </div>
	            </div>
	        </div>

	        <div class="col-lg-3 col-6">
	            <div class="small-box bg-success">
	                <div class="inner">
	                    <h3>
	                    	For Delivery:
	                    	<span id="fd">0</span>
	                    </h3>
	                </div>

	                <div class="icon">
	                    <i class="fa-solid fa-truck-arrow-right"></i>
	                </div>
	            </div>
	        </div>

        </div>

        <div class="row">
            <section class="col-lg-12 connectedSortable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-table mr-1"></i>
                            List
                        </h3>

                        @if(auth()->user()->role == "RHU")
                        	@include('requests.includes.toolbar')
                        @elseif(auth()->user()->role == "Admin")
                        	@include('requests.includes.toolbar2')
                        @endif
                    </div>

                    <div class="card-body table-responsive">
                    	<table id="table" class="table table-hover">
                    		<thead>
                    			<tr>
                    				<th>ID</th>
                    				<th>RHU</th>
                    				<th>Ref No</th>
                    				<th>Requestor</th>
                    				<th>Category</th>
                    				<th>Item</th>
                    				<th>Stock</th>
                    				<th>Request Qty</th>
                    				<th>Approved Qty</th>
                    				<th>Request Date</th>
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

	<style>
		.icon i{
			font-size: 50px !important;
		}

		.bg-warning .inner{
			color: white;
		}
	</style>
@endpush

@push('scripts')
	<script src="{{ asset('js/datatables.min.js') }}"></script>
	<script src="{{ asset('js/select2.min.js') }}"></script>

	<script>
		var search = "%%";

		$(document).ready(()=> {
			var table = $('#table').DataTable({
				ajax: {
					url: "{{ route('datatable.requests') }}",
                	dataType: "json",
                	dataSrc: "",
					data: f => {
						f.table = 'requests';
						f.select = ['requests.*'];
						f.load = ['rhu', 'medicine.category', 'reorder'];
						f.order = ["created_at", "desc"];
						f.status = search;
						@if(in_array(auth()->user()->role, ["RHU"]))
							f.where = ["user_id", {{ auth()->user()->id }}];
						@elseif(in_array(auth()->user()->role, ["Approver"]))
							f.where = ["status", "For Approval"];
						@endif
					}
				},
				columns: [
					{data: 'id'},
					{data: 'rhu.company_name', visible: false},
					{data: 'reference'},
					{data: 'requested_by'},
					{data: 'medicine.category.name'},
					{data: 'medicine.name'},
					{
						data: 'stock', 
						className: 'center',
						render: (stock, display, row) => {
							return `
								<div id="stock${row.id}">
									${row.reorder.stock}
								</div>
							`;
						}
					},
					{data: 'request_qty', className: 'center'},
					{
						data: 'approved_qty', 
						className: 'center',
						width: "10%",
						render: (qty, display, row) => {
							@if(in_array(auth()->user()->role, ["Admin", "Approver"]))
							if(row.status == "For Approval"){
								return `
									<div id=qty${row.id}>
										${input("approved_qty", "", row.request_qty, 0, 12, 'number', ` min=1 max="${row.request_qty}"`)}
									</div>
								`;
							}
							else
							@endif
							{
								if(qty == undefined){
									return "N/A";
								}
								else{
									return qty;
								}
							}
						}
					},
					{
						data: 'transaction_date',
						render: date => {
							return moment(date).format('MMM DD, YYYY');
						}
					},
					{data: 'status'},
					{data: 'actions'},
				],
        		order: [],
        		pageLength: 25,
        		language: {
        			emptyTable: "No pending request for approval"
        		},
        		rowCallback: function( row, data, index ) {
				    if (data['id'] == null) {
				        $(row).hide();
				    }
				},
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
		                            		<td colspan="11">
		                            			${company}
		                            		</td>
		                            	</tr>
		                            `);
		 
		                        last = company;
		                    }
		                });

		        	let grps = $('[class="group"]');
		        	grps.each((index, group) => {
		        		if(!$(group).next().is(':visible')){
		        			$(group).remove();
		        		}
		        	});

		        	$('[name="approved_qty"]').css('text-align', 'center');
		        },
			});
			
			initCount();
        	$('#search').on('change', e => {
        		search = e.target.value;
        		reload();
        	});
		});

		function initCount(){
			$.ajax({
				url: '{{ route("request.getPendingRequests") }}',
				data: {
					select: ['status'],
				},
				success: requests => {
					requests = JSON.parse(requests);
					
					let fa = 0;
					let fd = 0;
					let fi = 0;

					requests.forEach(request => {
						if(request.status == "For Approval"){
							fa++;
						}
						else if(request.status == "Approved"){
							fi++;
						}
						else if(request.status == "For Delivery"){
							fd++;
						}
					});

					$('#fa').html(fa);
					$('#fd').html(fd);
					$('#fi').html(fi);
				}
			})
		}

		function updateStatus(id, action, status){
			sc("Confirmation", `Are you sure you want to ${action}?`, result => {
				if(result.value){
					swal.showLoading();


					if(action == "Approve"){
						let qty = $(`#qty${id}`).find('input');
						let stock = $(`#stock${id}`).text().trim();

						if(qty.val() < qty.attr('min') || qty.val() > qty.attr('max')){
							Swal.fire({
								icon: "error",
								title: `Qty  must be ≥ ${qty.attr('min')} and ≤ ${qty.attr('max')}`,
							});
						}
						else if(parseInt(qty.val()) > parseInt(stock)){
							Swal.fire({
								icon: "error",
								title: `Qty is greater than stock`,
							});
						}
						else{
							doUpdate(id, status, qty.val(), dateTimeNow());
						}
					}
					else{
						doUpdate(id, status);
					}
				}
			});
		}

		function doUpdate(id, status, qty = 0, date_approved = null){
			update({
				url: "{{ route('request.update') }}",
				data: {
					id: id,
					status: status,
					approved_qty: qty,
					date_approved: date_approved
				},
				message: "Success"
			}, () => {
				reload();
			})
		}

		function inputInfo(ref){
			window.location.href = `{{ route('request.inputInfo') }}?ref=${ref}`;
		}

		function exportReport(){
			let data = {
				search: search,
				table: 'requests',
				select: ['requests.*'],
				load: ['rhu', 'medicine.category'],
				order: ["created_at", "desc"]
			};

			window.open("/export/exportRequests?" + $.param(data), "_blank");
		}

		// REFRESH EVERY 60 SECONDS
		function refresh(){
			setTimeout(() => {
				reload();
				initCount();
				refresh();
				console.log('Refreshed');
			}, 60000); //60 SECONDS
		}
		refresh();
	</script>
@endpush