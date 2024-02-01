
@extends('confirmation.layouts.app')

@section('content')

<!-- start main content section -->


<div x-data="">


<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Pending Order</h5>





                        <div class="panel">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
									
                                    <div>
<select id="fitting_or_packing" name="fitting_or_packing" class="form-input">
<option value="">Select</option>
<option value="Fitting" {{ old('fitting_or_packing') == 'Fitting' ? 'selected' : '' }}>Fitting</option>
<option value="Packing" {{ old('fitting_or_packing') == 'Packing' ? 'selected' : '' }}>Packing</option>
</select>
                                    </div>


                                    <div>	
    <button type="button" id="btn_search" name="search"   class="btn btn-primary">Search <i class="fa fa-search position-right"></i></button>
</div>
</div>
							<div class="md:absolute md:top-5 ltr:md:left-5 rtl:md:right-5">
                                    <div class="mb-5 flex items-center gap-2">
                                        
                                        
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
$(document).ready(function () {
    var oTable = $('#myTable').DataTable({
        dom: 'Blfrtip',
        "ajax": {
            "url": "{{ route('get_pending_order_list_confirmation') }}",
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
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'excelHtml5',
                footer: true,
                title: 'Pending Order List',
                titleAttr: 'Pending Order List',
                className: 'btn btn-success',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'print',
                footer: true,
                title: 'Pending Order List',
                titleAttr: 'Pending Order List',
                className: 'btn btn-success',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            }
        ]
    });

    // Optional: Add a success callback to handle the fetched data
    oTable.on('xhr.dt', function (e, settings, json, xhr) {
        oTable.clear().rows.add(json.data).draw();
    });

    $("#btn_search").click(function () {
        fitting_or_packing = $("#fitting_or_packing").val();

        // Clear the table before making the new AJAX request
        oTable.clear().draw();

        $.ajax({
            url: '{{ route('get_pending_order_by_fp') }}',
            type: 'GET',
            data: { fitting_or_packing: fitting_or_packing },
            dataType: "json",
            success: function (json) {
                // Add the new data to the table and draw
                oTable.clear().rows.add(json.data).draw();
            },
            error: function (xhr, status, error) {
                // Handle errors if needed
                console.error(xhr.responseText);
            }
        });
    });
});

</script>








@endsection