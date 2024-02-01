@extends('admin.layouts.app')

@section('content')
<div class="container">
<div class='row'>
			<div class='col-sm-1'></div>
			<div class='col-sm-10'>
			<div class="row">
		<div class="col-sm-3"><button class='btn cmn_btn'>Warehouse</button></div>
	</div>
	<div class="row pt-4">
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<a href="{{ route('warehouse_create')}}" class="nav-link">Add New</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('warehouse_list')}}" class="nav-link active">List</a>
				</li>
			</ul>
		</div>
   <div class='row pt-4'>
     
			 <div class=" tbl_div div_form">
						<table class="table table-striped text-center" id="tbl_list">
						<thead>
							<tr>
							<th>Sl No</th>
							<th>Name</th>
                            <th>Location</th>
							<th>Actions</th>
							</tr>
							</thead>
							<tbody>
								@foreach($ws_lists as $ws_list)
								<tr>
								    <td>{{$no++}}</td>
									<td>{{$ws_list->warehouse_name}}</td>
                                    <td>{{$ws_list->location}}</td>
									<td>
									<form method="post" action="{{ url('warehouse/'.$ws_list->id) }}">
										<button class='' type='button'><a href="{{ route('warehouse_edit',$ws_list->id) }}"><i class="fa fa-edit"></i></a></button>

									
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
           title: 'Warehouse List',
            titleAttr: 'Warehouse List',
            className: 'btn btn-success',
           exportOptions: {
                columns: [0,1,2]
            }
       },
        {
           extend: 'excelHtml5',
           footer: true,
            title: 'Warehouse  List',
            titleAttr: 'Warehouse  List',
            className: 'btn btn-success',
           exportOptions: {
                columns: [0,1,2]
            }
          },
          {
           extend: 'print',
           footer: true,
            title: 'Warehouse  List',
            titleAttr: 'Warehouse  List',
            className: 'btn btn-success',
           exportOptions: {
                columns: [0,1,2]
            }
          }    
    ]  
    } );

} );
</script>
@endsection
