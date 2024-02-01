
@extends('executive.layouts.app')

@section('content')

<!-- start main content section -->


<div x-data="">
<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Pending Order</h5>
                        <div class="panel">
							<div class="md:absolute md:top-5 ltr:md:left-5 rtl:md:right-5">
                                    <div class="mb-5 flex items-center gap-2">
                                        
                                        <a href="{{ route('measurement_form_create_executive')}}" class="btn btn-primary gap-2">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="24px"
                                                height="24px"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="h-5 w-5"
                                            >
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                            Add New
                                        </a>
                                    </div>
                                </div>
                                <br><br><br>
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
<!--for datatable -->	
<script type="text/javascript">
$(document).ready(function() {
    var oTable = $('#myTable').DataTable({
        dom: 'Blfrtip',
        "ajax": {
            "url": "{{route('get_pending_order_list_executive')}}",
            "dataSrc": ""
        },
        
        buttons: [
            {
                extend: 'pdf',
                footer: true,
                title: 'Pending Order List',
                titleAttr: 'Pending Order List',
                className: 'btn btn-success',
                exportOptions: {
                    columns: [0, 1, 2,3,4,5]
                }
            },
            {
                extend: 'excelHtml5',
                footer: true,
                title: 'Pending Order List',
                titleAttr: 'Pending Order List',
                className: 'btn btn-success',
                exportOptions: {
                    columns: [0, 1, 2,3,4,5]
                }
            },
            {
                extend: 'print',
                footer: true,
                title: 'Pending Order List',
                titleAttr: 'Pending Order List',
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