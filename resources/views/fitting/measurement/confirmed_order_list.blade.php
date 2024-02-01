
@extends('fitting.layouts.app')

@section('content')

<!-- start main content section -->


<div x-data="">
<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Confirmed Order</h5>
                        <div class="panel">
							<div class="md:absolute md:top-5 ltr:md:left-5 rtl:md:right-5">
                                    <div class="mb-5 flex items-center gap-2">
                                        
                                    
                                    </div>
                                </div>
                            <table id="myTable" class="table-hover whitespace-nowrap">
							<thead>
							<tr>
							<th>Sl No</th>
                            <th>Order No</th>
                            <th>Order Date</th>
                            <th>Customer</th>
                            <th>Brand</th>
                            <th>Delivery Date</th>
							<th>Actions</th>
							</tr>
							</thead>
							<tbody>
						
							</tbody>
							</table>
                        </div>
 </div>


					

                    <!-- end main content section -->


@endsection
@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
    var oTable = $('#myTable').DataTable({
        dom: 'Blfrtip',
        "ajax": {
            "url": "{{route('get_confirmed_order_list_fitting')}}",
            "dataSrc": ""
        },
        
        buttons: [
            {
                extend: 'pdf',
                footer: true,
                title: 'Confirmed Order List',
                titleAttr: 'Confirmed Order List',
                className: 'btn btn-success',
                exportOptions: {
                    columns: [0, 1, 2,3,4,5]
                }
            },
            {
                extend: 'excelHtml5',
                footer: true,
                title: 'Confirmed Order List',
                titleAttr: 'Confirmed Order List',
                className: 'btn btn-success',
                exportOptions: {
                    columns: [0, 1, 2,3,4,5]
                }
            },
            {
                extend: 'print',
                footer: true,
                title: 'Confirmed Order List',
                titleAttr: 'Confirmed Order List',
                className: 'btn btn-success',
                exportOptions: {
                    columns: [0, 1, 2,3,4,5]
                }
            }
        ]
    });

    // Optional: Add a success callback to handle the fetched data
    oTable.on('xhr.dt', function (e, settings, json, xhr) {
		 oTable.clear().rows.add(json.data).draw();
    });
});
</script>
@endsection