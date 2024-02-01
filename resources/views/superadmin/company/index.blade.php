@extends('superadmin.layouts.app')

@section('content')
<div class="container">
<div class='row'>
		<div class='col-sm-1'></div>
		<div class='col-sm-10'>
		<div class="row">
		<div class="col-sm-3"><button class='btn cmn_btn'>Company</button></div>
	</div>
	<div class="row pt-4">
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<a href="{{ route('company_create')}}" class="nav-link">Add New</a>
				</li>
				<li class="nav-item">
					<a href="{{ url('company')}}" class="nav-link active">List</a>
				</li>
			</ul>
		</div>
   <div class='row pt-4'>
			 <div class=" tbl_div div_form">
			 <table class="table table-striped text-center" id="tbl_list">
				<thead>
					<tr>
					<th>Company Name</th>
					<th>Phone</th>
					<th>Address</th>
					
					<th>Actions</th>
						</tr>
				 </thead>
				 <tbody>
					 @foreach($company_lists as $company_list)
					 <tr>
						 <td>{{$company_list->company_name}}</td>
						 <td>{{$company_list->phone}}</td>
						 <td>{{$company_list->address}}</td>
						 
						 <td>
						 <form method="post" action="{{ url('company/'.$company_list->id) }}">
								@csrf
						 <button class='' type='button'><a href="{{ route('company_edit',$company_list->id) }}"><i class="fa fa-edit"></i></a></button>

						
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
<script type="text/javascript">
$(document).ready(function() {
var oTable = $('#tbl_list').DataTable( {
        dom: 'Blfrtip',
        buttons: [
       {
           extend: 'pdf',
           footer: true,
           title: 'Company List',
            titleAttr: 'Company List',
            className: 'btn btn-success',
           exportOptions: {
                columns: [0,1,2]
            }
       },
       {
           extend: 'excelHtml5',
           footer: true,
            title: 'Company  List',
            titleAttr: 'Company  List',
            className: 'btn btn-success',
           exportOptions: {
                columns: [0,1,2]
            }
          },
          {
           extend: 'print',
           footer: true,
            title: 'Company  List',
            titleAttr: 'Company  List',
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






