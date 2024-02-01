
@extends('admin.layouts.app')

@section('content')
<!-- start main content section -->

						<!-- <ul class="flex space-x-2 rtl:space-x-reverse">
                            <li>
                                <a href="{{ route('unit_list')}}" class="text-primary hover:underline">Units</a>
                            </li>
                            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                                <span><a href="{{ route('unit_create')}}" class="text-primary hover:underline">Create</a></span>
                            </li>
                        </ul> -->
						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Die</h5>

                        <div class="pX-5 panel w-full">
						   
						<form class="space-y-5"  id="add_die" name="add_die" action="{{ url('door_die') }}" method="POST" enctype="multipart/form-data" onsubmit="return disableSubmitButton()">
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                            <label for="die_side">Side<span style="color: #EB2D30">*</span> </label>
                            <select id="die_side" name="die_side" class="form-input flex-1" onchange="return fncs();">                                            >
                                <option  value="" >Select</option>
                                <option  value="Front" {{ old('die_side') == 'Front' ? 'selected' : '' }}>Front</option>
                                <option  value="Back" {{ old('die_side') == 'Back' ? 'selected' : '' }}>Back</option>
                            </select>
                            @error('die_side')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
          
						</div>
                        <div id="div_model">
                            <label for="model_id">Door Model<span style="color: #EB2D30"></span> </label>
                            <select id="model_id" name="model_id" class="form-input flex-1" onchange="return fncs();">
                            <option  value="" >Select</option>
                                @foreach ($model_lists as $row)
                                    <option value="{{ $row->id; }}" {{ old('model_id') == $row->id ? 'selected' : '' }}>{{ $row->model_name; }}</option>
                                @endforeach
                            </select>
                    
						</div>
					    <div>
                            <label for="die_no">Die No<span style="color: #EB2D30">*</span> </label>
                                <input id="die_no" name="die_no" class="form-input" value="{{old('die_no') }}" readonly="readonly">
                                @error('die_no')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
						</div>
						

                        
						
					</div>
					
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
					    <div>
                            <label for="location_id">Die Location<span style="color: #EB2D30">*</span> </label>
                               <select id="location_id" name="location_id" class="form-input">
                                 <option  value="">Select</option>
                                    @foreach ($production_unit as $row)
                                        <option value="{{ $row->id; }}" {{ old('location_id') == $row->id ? 'selected' : '' }}>{{ $row->production_unit_name; }}</option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
						</div>
						<div>
                            <label for="die_status">Die Status<span style="color: #EB2D30">*</span> </label>
                            <select id="die_status" name="die_status" class="form-input">
                                 <option value="">Select</option>
                                 <option value="Active" {{ old('location_id') == 'Active' ? 'selected' : '' }}>Active</option>
                                 <option value="Inactive" {{ old('location_id') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                 <option value="Repairing" {{ old('location_id') == 'Repairing' ? 'selected' : '' }}>Repairing</option>
                                </select>
                                @error('die_status')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
						</div>
						
					</div>

					<button type="submit" name="sbt" id="submitButton" onclick="return check_field_values();" class="btn btn-primary !mt-6">Create&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
						
                </form> 
	
                        </div>

                    <!-- end main content section -->


@endsection
@section('scripts')
<script>
    $(document).ready(function(){
     

        var die_side =  $("#die_side").val();
             if(die_side == 'Front'){
                $("#div_model").show();
             }
             else if(die_side == 'Back'){
                $("#div_model").hide();
                $("#model_id").prop('selectedIndex', 0);
             }
        $("#die_side").change(function(){
            var die_side =  $("#die_side").val();
             if(die_side == 'Front'){
                $("#div_model").show();
             }
             else if(die_side == 'Back'){
                $("#div_model").hide();
                $("#model_id").prop('selectedIndex', 0);
             }
            
        });
    });
function die_no_generation(){
    model_id = $("#model_id").val();
    die_side =  $("#die_side").val();
    $.ajax({
				url: '{{route('generate_die_no')}}',
                data: {model_id: model_id,die_side:die_side},
				type: 'GET',
				success: function(data) {
                   $('#die_no').val(data.t_no);
                 
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
}
</script>
<script>
    function disableSubmitButton() {
        // Disable the submit button to prevent multiple submissions
        document.getElementById('submitButton').disabled = true;
        return true; // Allow the form to be submitted
    }
</script>
<script>
    function check_field_values(){
        die_side = $('#die_side').val();
        model_id =$('#model_id').val();
         if(die_side == 'Front'){
            if (model_id === null || model_id.trim() === ''){
            $('#submitButton').prop('disabled', true);
          
        }
        else{
            $('#submitButton').prop('disabled', false);
           
        
         }
        }
         else if(die_side == 'Back'){
            $('#submitButton').prop('disabled', false);
          
         }
    }
    function fncs(){
        die_no_generation();
        check_field_values();
    }
</script>
<script>
       document.addEventListener('DOMContentLoaded', function () {
        // Get the form element
        const myForm = document.getElementById('add_die');

        // Attach a keydown event listener to the form fields
        myForm.addEventListener('keydown', function (event) {
            // Check if the pressed key is Enter (key code 13)
            if (event.key === 'Enter') {
                // Prevent the default behavior (form submission)
                event.preventDefault();
            }
        });
    });
</script>

@endsection