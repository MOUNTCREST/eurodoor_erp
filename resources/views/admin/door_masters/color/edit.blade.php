
@extends('admin.layouts.app')

@section('content')
<!-- start main content section -->

						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Color</h5>

                        <div class="pX-5 panel w-full">
						   
						<form class="space-y-5"  id="edit_color" name="edit_color" action="{{ route('color_update',$result->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
					<div>
						<label for="color_type">Type<span style="color: #EB2D30"></span> </label>
							<select id="color_type" name="color_type" class="form-input" >
								<option value="">Select</option>
								<option value="Single" {{ $result->color_type == 'Single' ? 'selected' : '' }}>Single</option>
								<option value="Combo" {{ $result->color_type == 'Combo' ? 'selected' : '' }}>Combo</option>
								<option value="Triple" {{ $result->color_type == 'Triple' ? 'selected' : '' }}>Triple</option>
							</select>
							@error('color_type')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
						</div>
						<div id="c_div1">
						<label for="color_name">Color<span style="color: #EB2D30"></span> </label>
						<select id="color_name" name="color_name" class="form-input" onchange="return check_values_filled();"  >
								<option val="">Select</option>
								@foreach ($color_list as $row)
									<option value="{{ $row->id; }}" {{ $row->id == $result->color_name_product_id ? 'selected' : '' }}>{{ $row->product_name; }}</option>
								@endforeach
							</select>
							
						</div>
						<div id="c_div2">
						<label for="combo_color_name">Color<span style="color: #EB2D30"></span> </label>
						<select id="combo_color_name" name="combo_color_name" class="form-input" onchange="return check_values_filled();"  >
								<option val="0">Select</option>
								@foreach ($color_list as $row)
									<option value="{{ $row->id; }}" {{ $row->id == $result->combo_color_name_product_id ? 'selected' : '' }}>{{ $row->product_name; }}</option>
								@endforeach
							</select>
						</div>
						<div id="c_div3">
						<label for="triple_color_name">Color<span style="color: #EB2D30"></span> </label>
						<select id="triple_color_name" name="triple_color_name" class="form-input"  onchange="return check_values_filled();" >
								<option val="0">Select</option>
								@foreach ($color_list as $row)
									<option value="{{ $row->id; }}" {{ $row->id == $result->triple_color_name_product_id ? 'selected' : '' }}>{{ $row->product_name; }}</option>
								@endforeach
							</select>
							
						</div>
					</div>
					
   

					<button type="submit" name="sbt" id="submitButton" onclick="return check_values_filled();"  class="btn btn-primary !mt-6">Update&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
						
                </form> 
	
                        </div>

                    <!-- end main content section -->


@endsection
@section('scripts')
<script>
    $(document).ready(function () {
		color_type = $("#color_type").val();
		  if(color_type == 'Single'){
			 $("#c_div1").show();
			 $("#c_div2").hide();
			 $("#c_div3").hide();
		  }
		  else if(color_type == 'Combo'){
			 $("#c_div1").show();
			 $("#c_div2").show();
			 $("#c_div3").hide();
		  }
		  else if(color_type == 'Triple'){
			 $("#c_div1").show();
			 $("#c_div2").show();
			 $("#c_div3").show();
		  }
		  else{
			 $("#c_div1").show();
			 $("#c_div2").show();
			 $("#c_div3").show();
		  }
	 $("#color_type").change(function(){
		color_type = $("#color_type").val();
		  if(color_type == 'Single'){
			 $("#c_div1").show();
			 $("#c_div2").hide();
			 $("#c_div3").hide();
		  }
		  else if(color_type == 'Combo'){
			 $("#c_div1").show();
			 $("#c_div2").show();
			 $("#c_div3").hide();
		  }
		  else if(color_type == 'Triple'){
			 $("#c_div1").show();
			 $("#c_div2").show();
			 $("#c_div3").show();
		  }
		  else{
			 $("#c_div1").hide();
			 $("#c_div2").hide();
			 $("#c_div3").hide();
		  }
	});

	});
</script>
<script>
	function check_values_filled(){
		color_type = $("#color_type").val();
		if(color_type == 'Single'){
		
			single_color =  $('#color_name').val();
				if(single_color == 'Select'){
					
					$('#submitButton').prop('disabled', true);
					
				}
				else{
					$('#submitButton').prop('disabled', false);
				}
		}
		else if(color_type == 'Combo'){
			
			single_color =  $('#color_name').val();
			combo_color =  $('#combo_color_name').val();
				if((single_color == 'Select') || (combo_color == 'Select')){
					
					$('#submitButton').prop('disabled', true);
					
				}
				else{
					$('#submitButton').prop('disabled', false);
				}
		}
		else if(color_type == 'Triple'){
			
			single_color =  $('#color_name').val();
			combo_color =  $('#combo_color_name').val();
			triple_color_name =  $('#triple_color_name').val();

				if((single_color == 'Select') || (combo_color == 'Select') || (triple_color_name == 'Select')){
				
					$('#submitButton').prop('disabled', true);
					
				}
				else{
					$('#submitButton').prop('disabled', false);
				}
		}
		else{
			$('#submitButton').prop('disabled', false);
		}
		
	}
</script>
@endsection