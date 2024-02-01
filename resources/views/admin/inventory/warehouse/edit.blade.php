@extends('admin.layouts.app')

@section('content')
<div class="container">
<div class='row'>
			<div class='col-sm-1'></div>
			<div class='col-sm-10'>
			<div class="row">
		<div class="col-sm-3"><button class='btn cmn_btn'>Warehouse</button></div>
		<div class="col-sm-2"></div>
		<div class="col-sm-5" style="text-align: right;"><a href="{{ route('warehouse_list') }}" ><button type="button" name="btn" class="btn btn_sbt">List</button></a></div>
		<div class="col-sm-2"></div>
	</div>
	<div class="row pt-4">
	
		<div class="col-sm-12 tbl_div div_form cmn_div">
        <form class="form-horizontal"  id="edit_warehouse" name="edit_warehouse" action="{{ route('warehouse_update',$result->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
						<div class="form-body">
				
							<div class="row">
								<div class="form-group col-sm-6">
									<label for="warehouse_name">Warehouse<span style="color: #EB2D30">*</span> </label>
										<input type="text" id="warehouse_name" value="{{old('warehouse_name') ? old('warehouse_name') : $result->warehouse_name }}" class="form-control form_element" placeholder="" name="warehouse_name" autocomplete="off">
										@error('warehouse_name')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
                                <div class="form-group col-sm-6">
									<label for="location">Location<span style="color: #EB2D30">*</span> </label>
										<textarea id="location" name="location" class="form-control form_element" placeholder="" autocomplete="off">{{old('location') ? old('location') : $result->location }}</textarea>
                                        @error('location')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
								<div class="form-group col-sm-6"  style="margin-top: 2%;">
									<button type="reset" onclick="myFunction()" class="btn btn_reset"><i class="fa fa-refresh" aria-hidden="true"></i> Reset </button>
									&nbsp;<button type="submit" name="sbt"  class="btn btn_sbt">Update <i class="fa fa-check-circle" aria-hidden="true"></i></button>
								</div>
								
								
							</div>

                        </div>
                </form> 
		
		</div>
	
	  
		
	</div>
			</div>
			<div class='col-sm-1'></div>
</div>
	
</div>
@endsection
