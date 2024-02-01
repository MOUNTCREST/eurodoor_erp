
@extends('white.layouts.app')

@section('content')

<!-- start main content section -->


<div x-data="">
<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Sales Invoice</h5>
                        <div class="panel">
							<div class="md:absolute md:top-5 ltr:md:left-5 rtl:md:right-5">
                                    <div class="mb-5 flex items-center gap-2">
                                        
                                        
                                    </div>
                                </div>
                                <br><br><br>
                            <table id="myTable" class="table-hover whitespace-nowrap">
							<thead>
							<tr>
							<th>Sl No</th>
							<th>Date</th>
                            <th>Invoice No</th>
                            <th>Customer</th>
                            <th>Total</th>
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
            "url": "{{route('get_sales_invoice_list_in_white')}}",
            "dataSrc": ""
        },
        
        buttons: [
            {
                extend: 'pdf',
                footer: true,
                title: 'Sales Invoice   List',
                titleAttr: 'Sales Invoice   List',
                className: 'btn btn-success',
                exportOptions: {
                     columns: [0, 1,2,3,4]
                }
            },
            {
                extend: 'excelHtml5',
                footer: true,
                title: 'Sales Invoice   List',
                titleAttr: 'Sales Invoice   List',
                className: 'btn btn-success',
                exportOptions: {
                     columns: [0, 1,2,3,4]
                }
            },
            {
                extend: 'print',
                footer: true,
                title: 'Sales Invoice   List',
                titleAttr: 'Sales Invoice   List',
                className: 'btn btn-success',
                exportOptions: {
                     columns: [0, 1,2,3,4]
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