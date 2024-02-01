
@extends('admin.layouts.app')

@section('content')
<!-- start main content section -->


						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Die</h5>

                        <div class="pX-5 panel w-full">
						   
						<form class="space-y-5"  id="edit_die" name="edit_die"action="{{ route('die_update',$result->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                            <label for="die_side">Side<span style="color: #EB2D30">*</span> </label>
                            <select id="die_side" name="die_side" class="form-input flex-1"  onchange="return fncs();">                                            >
                                <option  value="" selected>Select</option>
                                <option  value="Front" {{ $result->die_side == 'Front' ? 'selected' : '' }}>Front</option>
                                <option  value="Back" {{ $result->die_side == 'Back' ? 'selected' : '' }}>Back</option>
                            </select>
                            @error('die_side')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
						</div>
					   
						<div id="div_model">
                            <label for="color_type">Door Model<span style="color: #EB2D30"></span> </label>
                            <select id="model_id" name="model_id" class="form-input flex-1" onchange="return fncs();">
                            <option  value="" selected>Select</option>
                                @foreach ($model_lists as $row)
                                    <option value="{{ $row->id; }}" {{ $row->id == $result->model_id ? 'selected' : '' }}>{{ $row->model_name; }}</option>
                                @endforeach
                            </select>
						</div>
                        <div>
                            <label for="color_type">Die No<span style="color: #EB2D30">*</span> </label>
                                <input id="die_no" name="die_no" class="form-input" value="{{$result->die_no;}}" readonly="readonly">
                                @error('die_no')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
						</div>
						
					</div>
					
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
					    <div>
                            <label for="location_id">Die Location<span style="color: #EB2D30">*</span> </label>
                               <select id="location_id" name="location_id" class="form-input">
                                 <option  value="" selected>Select</option>
                                    @foreach ($production_unit as $row)
                                        <option value="{{ $row->id; }}" {{ $row->id == $result->location_id ? 'selected' : '' }}>{{ $row->production_unit_name; }}</option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
						</div>
						<div>
                            <label for="die_status">Die Status<span style="color: #EB2D30">*</span> </label>
                            <select id="die_status" name="die_status" class="form-input">
                                 <option value=" ">Select</option>
                                 <option value="Active" {{ $result->die_status == 'Active' ? 'selected' : '' }}>Active</option>
                                 <option value="Inactive" {{ $result->die_status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                 <option value="Repairing" {{ $result->die_status == 'Repairing' ? 'selected' : '' }}>Repairing</option>
                                </select>
                                @error('die_status')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
						</div>
						
					</div>

					<button type="submit" name="sbt" id="submitButton" onclick="return check_field_values();" class="btn btn-primary !mt-6">Update&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
						
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
             }
        $("#die_side").click(function(){
            var die_side =  $("#die_side").val();
            if(die_side == 'Front'){
                $("#div_model").show();
             }
             else if(die_side == 'Back'){
                $("#div_model").hide();
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
@endsection