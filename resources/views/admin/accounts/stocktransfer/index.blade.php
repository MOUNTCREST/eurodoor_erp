@extends('admin.layouts.app')

@section('content')
<div class="container">
<div class='row'>
			<div class='col-sm-1'></div>
			<div class='col-sm-10'>
			<div class="row">
		<div class="col-sm-3"><button class='btn cmn_btn'>Stock Transfer</button></div>
	</div>
	<div class="row pt-4">
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<a href="{{ route('stock_transfer_create')}}" class="nav-link">Add New</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('stock_transfer_list')}}" class="nav-link active">List</a>
				</li>
			</ul>
		</div>
   <div class='row pt-4'>
     
			 <div class=" tbl_div div_form">
						<table class="table table-striped text-center" id="tbl_list">
						<thead>
							<tr>
							<th>Sl No</th>
							<th>Reference No</th>
                            <th>Date</th>
                            <th>From Warehouse</th>
                            <th>To Warehouse</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Remarks</th>
							<th>Actions</th>
							</tr>
							</thead>
							<tbody>
								@foreach($st_data as $result)
								<tr>
									<td>{{$no++}}</td>
									<td>{{$result->ref_no}}</td>
                                    <td>{{$result->st_date}}</td>
                                    <td>{{$result->warehouse_name}}</td>
                                    <td>{{$result->warehouse_name}}</td>
                                    <td>{{$result->product_name}}</td>
                                    <td>{{$result->qty}}</td>
                                    <td>{{$result->remarks}}</td>
									<td>
									<form method="post" action="{{ url('stock_transfer/'.$result->id) }}">
										<button class='' type='button'><a href="{{ route('stock_transfer_edit',$result->id) }}"><i class="fa fa-edit"></i></a></button>
											@csrf
											@method('DELETE')
										<button class='' onClick="return confirm('Are you sure?');" type="submit"><i class="fa fa-trash"></i></button>
										</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
   </div>
</div>
			</div>
			<div class='col-sm-1'></div>
			</div>

</div>
@endsection
@section('scripts')
<!--for datatable-->
<script type="text/javascript">
$(document).ready(function() {
var oTable = $('#tbl_list').DataTable( {
        dom: 'Blfrtip',
        buttons: [
       {
           extend: 'pdf',
           footer: true,
           title: 'Stock Transfer',
            titleAttr: 'Stock Transfer',
            className: 'btn btn-success',
           exportOptions: {
                columns: [0,1,2,3,4,5,6,7]
            }
       },
        {
           extend: 'excelHtml5',
           footer: true,
            title: 'Stock Transfer',
            titleAttr: 'Stock Transfer',
            className: 'btn btn-success',
           exportOptions: {
                columns: [0,1,2,3,4,5,6,7]
            }
          },
          {
           extend: 'print',
           footer: true,
            title: 'Stock Transfer',
            titleAttr: 'Stock Transfer',
            className: 'btn btn-success',
           exportOptions: {
                columns: [0,1,2,3,4,5,6,7]
            }
          }    
    ]  
    } );

} );
</script>
@endsection
