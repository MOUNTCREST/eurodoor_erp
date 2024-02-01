@extends('superadmin.layouts.app')

@section('content')
<div class="container">
	<div class='row'>
		<div class='col-sm-1'></div>
		<div class='col-sm-10'>
		<div class="row">
		<div class="col-sm-3"><button class='btn cmn_btn'>Currency</button></div>
		<div class="col-sm-2"></div>
		<div class="col-sm-5"></div>
		<div class="col-sm-2"></div>
	</div>
	<!-- <div class="flash-message pt-4">
			@foreach (['danger', 'warning', 'success', 'info'] as $msg)
			@if(Session::has('alert-' . $msg))

			<p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
			@endif
			@endforeach
		</div> end .flash-message -->
	
		<div class="row pt-4">
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<a href="{{ route('currency_create')}}" class="nav-link">Add New</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('currency_list')}}" class="nav-link active">List</a>
				</li>
			</ul>
		</div>



   <div class='row pt-4'>

     
			 <div class=" tbl_div div_form">
						<table class="table table-striped text-center data-table" id="tbl_list">
						<thead>
							<tr>
							<th>Currency</th>
							<th>Country</th>
							<th>Code</th>
							
							<th>Actions</th>
							
							</tr>
							</thead>
							<tbody>
								@foreach($currency_lists as $currency_list)
								<tr>
									<td>{{$currency_list->country}}</td>
									<td>{{$currency_list->currency}}</td>
									<td>{{$currency_list->code}}</td>
									<td>
									<form method="post" action="{{ url('currency/'.$currency_list->id) }}">
									@csrf
									<button class='' type='button'><a href="{{ route('currency_edit',$currency_list->id) }}"><i class="fa fa-edit"></i></a></button>

									
											
											@method('DELETE')
										<button class='' onClick="return confirm('Are you sure?');" type="submit"><i class="fa fa-trash"></i></button>
										</form></td>
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
<!-- For datatable -->
<script type="text/javascript">
$(document).ready(function() {
var oTable = $('#tbl_list').DataTable( {
        dom: 'Blfrtip',
        buttons: [
       {
           extend: 'pdf',
           footer: true,
           title: 'Currency List',
            titleAttr: 'Currency List',
            className: 'btn btn-success',
           exportOptions: {
                columns: [0,1,2]
            }
       },
       {
           extend: 'excelHtml5',
           footer: true,
            title: 'Currency  List',
            titleAttr: 'Currency  List',
            className: 'btn btn-success',
           exportOptions: {
                columns: [0,1,2]
            }
          },
          {
           extend: 'print',
           footer: true,
            title: 'Currency  List',
            titleAttr: 'Currency  List',
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
