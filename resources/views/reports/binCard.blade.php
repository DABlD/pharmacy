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

                        @include('reports.toolbars.binCard')
                    </div>

                    <div class="card-body table-responsive">
                    	<table id="table" class="table table-hover">
                    		<thead>
                    			<tr>
                    				<th>Item</th>
                    				<th>Transaction</th>
                    				<th>Receiving</th>
                    				<th>Issuance</th>
                    				<th>Running Balance</th>
                    				<th>Date</th>
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

	<style>
		#table tbody td:not(:first-child){
			text-align: center;
		}

		.sorting_1{
			color: white;
		}
	</style>
@endpush

@push('scripts')
	<script src="{{ asset('js/datatables.min.js') }}"></script>
	{{-- <script src="{{ asset('js/datatables-jquery.min.js') }}"></script> --}}

	<script>
		var tableData = [];

		$(document).ready(()=> {
			var table = $('#table').DataTable({
				ajax: {
					url: "{{ route('report.getBinCard') }}",
                	dataType: "json",
                	dataSrc: "",
				},
				columns: [
					{data: 'item', width: "50%"},
					{data: 'tx'},
					{data: 'rcv'},
					{data: 'issue'},
					{data: 'bal'},
					{data: 'date'},
				],
        		pageLength: 25,
		        drawCallback: function (settings) {
		            let api = this.api();
		            let rows = api.rows({ page: 'current' }).nodes();
		            let last = null;

		            api.column(0, { page: 'current' })
		                .data()
		                .each(function (item, i, row) {
		                    if (last !== item) {
		                        $(rows)
		                            .eq(i)
		                            .before(`
		                            	<tr class="group">
		                            		<td colspan="4">
		                            			${item}
		                            		</td>
		                            	</tr>
		                            `);
		 
		                        last = item;
		                    }
		                });

		        	tableData = api.rows().data().toArray();
		        	let groups = $('tr.group td');

		        	if(groups.length){
		        		groups.each((index, row) => {
		        			let stock = $(row).parent().next().find('.stock').data('stock');
		        			$(row).after(`
		        				<td class="rb">${stock}</td>
		        				<td></td>
		        			`);
		        		});

		        		$('.rb').css({
		        			"color": 'black',
		        			"font-weight": "bold"
		        		});
		        	}

		        	let grps = $('[class="group"]');
		        	grps.each((index, group) => {
		        		if(!$(group).next().is(':visible')){
		        			$(group).remove();
		        		}
		        	});
		        },
		        columnDefs: [
		        	{
		        		targets: 4,
		        		render: (bal, i, row) =>{;
		        			return`<span class='stock' data-stock='${row.stock}'>${bal}</span`;
		        		}
		        	}
		        ],
				// drawCallback: function(){
				// 	init();
				// }
			});
		});

		function exportReport(){
			window.open("/export/exportBinCard", "_blank");
		}
	</script>
@endpush