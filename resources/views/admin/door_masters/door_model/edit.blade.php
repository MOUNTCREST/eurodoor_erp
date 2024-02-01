
@extends('admin.layouts.app')

@section('content')
<!-- start main content section -->

						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Model</h5>
                        <div class="pX-5 panel w-full">
						   
						<form class="space-y-5"  id="edit_model" name="edit_model" action="{{ route('door_model_update',$result->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
						<div>
							<label for="ref_no">Ref No<span style="color: #EB2D30">*</span> </label>
							<input type="text" id="ref_no" value="{{$result->ref_no}}" class="form-input flex-1" readonly="readonly" placeholder="" name="ref_no" autocomplete="off">
						</div>
						<div>
						<label for="model_name">Model<span style="color: #EB2D30">*</span> </label>
							<input type="text" id="model_name" value="{{$result->model_name }}" class="form-input" placeholder="" name="model_name" autocomplete="off">
							@error('model_name')
								<small class='text-danger'>{{ $message }}</small>
							@enderror
						</div>
						<div>
						<label for="die_type">Die Type<span style="color: #EB2D30">*</span> </label>
							<select id="die_type" name="die_type" class="form-input" >
								<option value="">Select</option>
								<option value="BACK PLAIN" {{ $result->die_type == 'BACK PLAIN' ? 'selected' : '' }}>BACK PLAIN</option>
								<option value="BACK SAME DIE" {{ $result->die_type == 'BACK SAME DIE' ? 'selected' : '' }}>BACK SAME DIE</option>
							</select>
							@error('die_type')
								<small class='text-danger'>{{ $message }}</small>
							@enderror
						</div>
					</div>
					<div class="grid grid-cols-1 sm:grid-cols-3 gap-4" style="padding-top: 1%;">

						<div>
						<label for="color_type">Color Type<span style="color: #EB2D30"></span> </label>
						<select id="color_type" name="color_type" class="form-input" onchange="retrun check_all_fileds();">
							<option value="">Select</option>
							<option value="Single" {{ $result->color_type == 'Single' ? 'selected' : '' }}>Single</option>
							<option value="Combo" {{ $result->color_type == 'Combo' ? 'selected' : '' }}>Combo</option>
							<option value="Triple" {{ $result->color_type == 'Triple' ? 'selected' : '' }}>Triple</option>
						</select>
						@error('color_type')
								<small class='text-danger'>{{ $message }}</small>
							@enderror
						</div>

						
						
					
						<!-- <div>
						<label for="resin_qty">Resin Qty<span style="color: #EB2D30"></span> </label>
						<input type="text" id="resin_qty" value="{{$result->resin_qty}}" name="resin_qty" class="form-input">
						</div> -->

					</div>

					<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
						<div id="paint_qty_color_1_div">
							<label for="paint_qty_color_1">Paint Qty Color 1<span style="color: #EB2D30"></span> </label>
							<input type="number" step="any" value="{{$result->paint_qty_color_1}}" id="paint_qty_color_1" oninput="return check_all_fileds();"   class="form-input flex-1"  placeholder="" name="paint_qty_color_1" autocomplete="off">
						</div>
						<div id="paint_qty_color_2_div">
						    <label for="paint_qty_color_2">Paint Qty Color 2<span style="color: #EB2D30"></span> </label>
							<input type="number" step="any" value="{{$result->paint_qty_color_2}}" id="paint_qty_color_2" oninput="return check_all_fileds();"  class="form-input" placeholder="" name="paint_qty_color_2" autocomplete="off">
						</div>
						<div id="paint_qty_color_3_div">
						    <label for="paint_qty_color_3">Paint Qty Color 3<span style="color: #EB2D30"></span> </label>
							<input type="number" step="any" id="paint_qty_color_3" value="{{$result->paint_qty_color_3}}" oninput="return check_all_fileds();"   class="form-input" placeholder="" name="paint_qty_color_3" autocomplete="off">
						</div>
					</div>
				
					
   

					<button type="submit" name="sbt" id="submitButton" onclick="return check_all_fileds();" class="btn btn-primary !mt-6">Update&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
						
                </form> 
	
                        </div>

                    <!-- end main content section -->


@endsection
@section('scripts')
<script>
    $(document).ready(function () {
		get_paint_colors();
	$("#color_type").change(function(){
		get_paint_colors();
		color_type = $("#color_type").val();

		$.ajax({
				url: '{{route('get_color_list')}}',
				type: 'GET',
				data: {color_type: color_type},
				success: function(data) {
                    clr_list = data.color_list;
                    $('#color_id').empty();

                    $('#color_id').append('<option value=" ">Select</option>');
					$.each(clr_list, function(key, value) {
    var comboColor = value.combo_color_name;
    var tripleColor = value.triple_color_name;
    var optionText;

    if (value.color_type == "Single") {
        optionText = value.color_name;
    } else if (value.color_type == "Combo") {
        optionText = value.color_name + (comboColor ? ' & ' + comboColor : '');
    } else if (value.color_type == "Triple") {
        optionText = value.color_name + ' & ' + comboColor + ' & ' + tripleColor;
    }

    $('#color_id').append('<option value="' + value.id + '">' + optionText + '</option>');
});
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
	});
	function get_paint_colors(){
		color_type = $("#color_type").val();
		  if(color_type == 'Single'){
			$("#paint_qty_color_1_div").show();
		    $("#paint_qty_color_2_div").hide();
			$("#paint_qty_color_3_div").hide();
		  }
		  else if(color_type == 'Combo'){
			$("#paint_qty_color_1_div").show();
		    $("#paint_qty_color_2_div").show();
			$("#paint_qty_color_3_div").hide();
		  }
		  else if(color_type == 'Triple'){
			$("#paint_qty_color_1_div").show();
		    $("#paint_qty_color_2_div").show();
			$("#paint_qty_color_3_div").show();
		  }
		  else{
			$("#paint_qty_color_1_div").hide();
		    $("#paint_qty_color_2_div").hide();
			$("#paint_qty_color_3_div").hide();
		  }
	}

		
});
</script>
<script>
	function check_all_fileds() {
    var color_type = $("#color_type").val();
    var paint_qty_color_1 = $("#paint_qty_color_1").val();
    var paint_qty_color_2 = $("#paint_qty_color_2").val();
    var paint_qty_color_3 = $("#paint_qty_color_3").val();

    if (color_type === 'Single') {
		
        if (paint_qty_color_1 === null || paint_qty_color_1.trim() === '') {
			
            $('#submitButton').prop('disabled', true);
        } else {
			
            $('#submitButton').prop('disabled', false);
        }
    } else if (color_type === 'Combo') {
        if ((paint_qty_color_1 === null || paint_qty_color_1.trim() === '') || (paint_qty_color_2 === null || paint_qty_color_2.trim() === '')) {
            $('#submitButton').prop('disabled', true);
        } else {
            $('#submitButton').prop('disabled', false);
        }
    } else if (color_type === 'Triple') {
        if ((paint_qty_color_1 === null || paint_qty_color_1.trim() === '') || (paint_qty_color_2 === null || paint_qty_color_2.trim() === '') || (paint_qty_color_3 === null || paint_qty_color_3.trim() === '')) {
            $('#submitButton').prop('disabled', true);
        } else {
            $('#submitButton').prop('disabled', false);
        }
    }
}
</script>
@endsection