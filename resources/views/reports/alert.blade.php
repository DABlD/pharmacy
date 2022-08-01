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

                        {{-- @include('reports.toolbars.binCard') --}}
                    </div>

                    <div class="card-body table-responsive">
                    	<table id="table" class="table table-hover">
                    		<thead>
                    			<tr>
                    				<th></th>
                    				<th>Message</th>
                    				<th>Time</th>
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
		$(document).ready(()=> {
			var table = $('#table').DataTable({
				ajax: {
					url: "{{ route('report.getAlert') }}",
                	dataType: "json",
                	dataSrc: "",
				},
				columns: [
					{data: 'created_at', visible: false},
					{data: 'message'},
					{data: 'created_at', width: "10%"},
				],
        		pageLength: 25,
        		order: [],
		        drawCallback: function (settings) {
		            let api = this.api();
		            let rows = api.rows({ page: 'current' }).nodes();
		            let last = null;
		 
		            api.column(0, { page: 'current' })
		                .data()
		                .each(function (date, i, row) {
		                    if (last !== date) {
		                        $(rows)
		                            .eq(i)
		                            .before(`
		                            	<tr class="group">
		                            		<td colspan="3">
		                            			${moment(date).format('MMM DD, YYYY')}
		                            		</td>
		                            	</tr>
		                            `);
		 
		                        last = date;
		                    }
		                });

		            
		        	// let groups = $('tr.group td');

		        	// if(groups.length){
		        	// 	groups.each((index, row) => {
		        	// 		let stock = $(row).parent().next().find('.stock').data('stock');
		        	// 		$(row).after(`
		        	// 			<td class="rb">${stock}</td>
		        	// 			<td></td>
		        	// 		`);
		        	// 	});

		        	// 	$('.rb').css({
		        	// 		"color": 'black',
		        	// 		"font-weight": "bold"
		        	// 	});
		        	// }

		        	let grps = $('[class="group"]');
		        	grps.each((index, group) => {
		        		if(!$(group).next().is(':visible')){
		        			$(group).remove();
		        		}
		        	});
		        },
		        columnDefs: [
		        	{
		        		targets: 0,
		        		render: date =>{;
		        			return moment(date).format('MMM DD, YYYY');
		        		}
		        	},
		        	{
		        		targets: 2,
		        		render: time =>{;
		        			return moment(time).format('h:mm A');
		        		}
		        	}
		        ],
				// drawCallback: function(){
				// 	init();
				// }
			});
		});
	</script>
@endpush