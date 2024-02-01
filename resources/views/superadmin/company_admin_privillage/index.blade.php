@extends('superadmin.layouts.app')
@section('content')
<div class="container">
	<div class='row'>
			<div class='col-sm-1'></div>
			<div class='col-sm-10'>
			<div class="row">
		<div class="col-sm-3"><button class='btn cmn_btn'>Company Admin Privillege</button></div>
		<div class="col-sm-2"></div>
		<div class="col-sm-5" style="text-align: right;"></div>
		<div class="col-sm-2"></div>
	</div>
	<!-- <div class="flash-message pt-4">
			@foreach (['danger', 'warning', 'success', 'info'] as $msg)
			@if(Session::has('alert-' . $msg))

			<p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
			@endif
			@endforeach
		</div> end .flash-message -->
   <div class='row'>
   <div id="error_msg" class="alert">
    </div>
   <form class="form-horizontal"  id="add_company_admin_privilleges" name="add_company_admin_privilleges" action="{{ url('companyadminprivillages') }}" method="POST" >
	@csrf
        <div class="row tbl_div div_form cmn_div">
        <div class="col-sm-2"></div>
            <div class="col-sm-4">
                                            <label>Admin<span style="color: #EB2D30">*</span> </label>
                                            <div class="form-group">
                                            <select id="admin_id" name="admin_id" class="form-control form_element s2" autofocus='on'>
                                                                    <option  value="" selected>Select</option>
                                                                        @foreach ($list_admin as $row)
                                                                            <option value="{{ $row->id; }}">{{ $row->name; }}</option>
                                                                        @endforeach
                                                            </select>
															@error('admin_id')
																<small class='text-danger'>{{ $message }}</small>
															@enderror
                                            </div>
                                            </div>
                                            <div class="col-sm-4">
                                            <label>Company<span style="color: #EB2D30">*</span> </label>
                                            <div class="form-group">
                                                <select id="company_id" name="company_id" class="form-control form_element s2"  >
                                                                    <option  value="" selected>Select</option>
                                                                        @foreach ($list_company as $row)
                                                                            <option value="{{ $row->id; }}">{{ $row->company_name; }}</option>
                                                                        @endforeach
                                                            </select>
															@error('company_id')
																<small class='text-danger'>{{ $message }}</small>
															@enderror
                                                        </div>
                                            </div>
                                            
                                            <div class="col-sm-2">
                                                <label></label>
                                            <div class="form-group"> <button type="submit" name="sbt"  class="btn btn_sbt">Add <i class="fa fa-check-circle" aria-hidden="true"></i></button></div>
                                            </div>
                                        </div>
                                        
                </form>
   </div>
   <div class='row pt-4'>
             <div class='col-sm-3'></div>
			 <div class="col-sm-6 tbl_div div_form">
						<table class="table table-striped text-center data-table" id="tbl_list">
						<thead>
							<tr>
							<th>Company</th>
							<th>Admin</th>
							<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($lists as $list)
								<tr>
									<td>{{$list->company_name}}</td>
									<td>{{$list->name}}</td>
									<td>

									<form method="post" action="{{ url('companyadminprivillages/'.$list->id) }}">
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
				   <div class='col-sm-3'></div>
</div>
			</div>
			<div class='col-sm-1'></div>
	</div>

</div>
@endsection

@section('scripts')
 <!-- Check whether company is add or not -->
<script>
$(document).ready(function() {
		$("#company_id").change(function(){
			
				var company_id = $('#company_id').val();
				var admin_id = $('#admin_id').val();
				var _token = $("input[name=_token]").val();
				$.ajax({
				url: '{{route('check_already_exists')}}',
				type: 'GET',
				data: {company_id: company_id,admin_id:admin_id, _token: _token},
				success: function(data) {
					if(data !=0){
						$(':input[type="submit"]').prop('disabled', true);
						$('#error_msg').addClass("alert-danger");
						$('#error_msg').text('Already Entered..!');
											}
											else{
						$(':input[type="submit"]').prop('disabled', false);
						$('#error_msg').removeClass("alert-danger");
						$('#error_msg').text('');
											}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});

			});
});
</script>
<!-- For datatable -->
<script type="text/javascript">
$(document).ready(function() {
var oTable = $('#tbl_list').DataTable( {
        dom: 'Blfrtip',
        buttons: [
       {
           extend: 'pdf',
           footer: true,
           title: 'Company Privillage',
            titleAttr: 'Company Privillage',
            className: 'btn btn-success',
           exportOptions: {
                columns: [0,1]
            }
       },
      {
           extend: 'excelHtml5',
           footer: true,
            title: 'Company Privillege',
            titleAttr: 'Company Privillege',
            className: 'btn btn-success',
           exportOptions: {
                columns: [0,1]
            }
          },
          {
           extend: 'print',
           footer: true,
            title: 'Company Privillege',
            titleAttr: 'Company Privillege',
            className: 'btn btn-success',
           exportOptions: {
                columns: [0,1]
            }
          }     
    ]  
    } );

} );
</script>
@endsection
