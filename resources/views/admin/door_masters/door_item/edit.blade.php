
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

						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Door(Item)</h5>
                        <div class="pX-5 panel w-full">
						   
						<form class="space-y-5"  id="edit_model" name="edit_model" action="{{ route('door_item_update',$result->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div>
							<label for="ref_no">Ref No<span style="color: #EB2D30">*</span> </label>
							<input type="text" id="ref_no" value="{{$result->ref_no}}" class="form-input flex-1" readonly="readonly" placeholder="" name="ref_no" autocomplete="off">
						</div>
						<div>
						<label for="model_id">Model<span style="color: #EB2D30">*</span> </label>
						<select id="model_id" name="model_id" class="form-input" onchange="return create_item_name();" >
								<option val="">Select</option>
								@foreach ($model_list as $row)
									<option value="{{ $row->id; }}" {{ $result->model_id == $row->id ? 'selected' : '' }}>{{ $row->model_name; }}</option>
								@endforeach
							</select>
						</div>
						
					</div>
					
					<div class="grid grid-cols-1 sm:grid-cols-3 gap-4" style="padding-top: 1%;">

						<div>
						<label for="color_type">Color Type<span style="color: #EB2D30"></span> </label>
						<select id="color_type" name="color_type" class="form-input">
							<option val="">Select</option>
							<option val="Single" {{ $result->color_type == 'Single' ? 'selected' : '' }}>Single</option>
							<option val="Combo" {{ $result->color_type == 'Combo' ? 'selected' : '' }}>Combo</option>
							<option val="Triple" {{ $result->color_type == 'Triple' ? 'selected' : '' }}>Triple</option>
						</select>
						</div>

						
						<div id="clr_div">
						<label for="color_id">Color<span style="color: #EB2D30"></span> </label>
						<select id="color_id" name="color_id" class="form-input" onchange="return create_item_name();">
							<option val="">Select</option>
							@foreach ($color_lists as $row)
                                                        <option value="{{ $row->id; }}" {{ $row->id == $result->color_id ? 'selected' : '' }}>@if ($row->color_type == "Single"){{$row->s_c_p_name}}@elseif ($row->color_type == "Combo"){{$row->s_c_p_name}} & {{$row->c_c_p_name}}@elseif ($row->color_type == "Triple"){{$row->s_c_p_name}} & {{$row->c_c_p_name}} & {{$row->t_c_p_name}}@endif
                                                        </option>
                             @endforeach
						</select>
						</div>
						<div>
						<label for="item_name">Item Name<span style="color: #EB2D30">*</span> </label>
							<input type="text" id="item_name" value="{{$result->item_name}}" class="form-input" placeholder="" readonly="readonly" name="item_name" autocomplete="off">
							
						</div>
						<!-- <div>
						<label for="resin_qty">Resin Qty<span style="color: #EB2D30"></span> </label>
						<input type="text" id="resin_qty" value="{{$result->resin_qty}}" name="resin_qty" class="form-input">
						</div> -->

					</div>

					<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
						<div id="paint_qty_color_1_div">
							<label for="paint_qty_color_1">Paint Qty Color 1<span style="color: #EB2D30"></span> </label>
							<input type="text" value="{{$result->paint_qty_color_1}}" id="paint_qty_color_1"  class="form-input flex-1"  placeholder="" name="paint_qty_color_1" autocomplete="off">
						</div>
						<div id="paint_qty_color_2_div">
						    <label for="paint_qty_color_2">Paint Qty Color 2<span style="color: #EB2D30"></span> </label>
							<input type="text" value="{{$result->paint_qty_color_2}}" id="paint_qty_color_2" class="form-input" placeholder="" name="paint_qty_color_2" autocomplete="off">
						</div>
						<div id="paint_qty_color_3_div">
						    <label for="paint_qty_color_3">Paint Qty Color 3<span style="color: #EB2D30"></span> </label>
							<input type="text" id="paint_qty_color_3" value="{{$result->paint_qty_color_3}}"  class="form-input" placeholder="" name="paint_qty_color_3" autocomplete="off">
						</div>
					</div>
					
   

					<button type="submit" name="sbt" class="btn btn-primary !mt-6">Update&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
						
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
		  else{
			$("#paint_qty_color_1_div").show();
		    $("#paint_qty_color_2_div").show();
			$("#paint_qty_color_3_div").show();
		  }
	}

		
});
</script>
<script>
	function create_item_name(){
		model_name = $("#model_id option:selected").text();
		color_name = $("#color_id option:selected").text();
	
		if(model_name == 'Select'){
			$("#item_name").val(" ");
		}
		else if(color_name =='Select'){
			$("#item_name").val(" ");
		}
		else{
			$("#item_name").val(model_name +''+color_name );
		}
		

	}
</script>
@endsection