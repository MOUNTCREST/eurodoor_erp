
@extends('production.layouts.app')

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
						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Production Pending List</h5>

                        <div class="pX-5 panel w-full">
						   
						<form class="space-y-5"  id="assign_order" name="assign_order" action="{{ route('assign_items_update',$result->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
					    <div>
                        <input type="hidden" id="m_items_id" name="m_items_id" value="{{$result->id}}" class="form-input">
                            <label for="model_name">Model<span style="color: #EB2D30"></span> </label>
                            <input id="model_id" name="model_id" type="hidden" value="{{$door_model->id}}" class="form-input" readonly="readonly">
                            <input id="model_name" name="model_name" type="text" value="{{$door_model->model_name}}" class="form-input" readonly="readonly">
						</div>
						<div>
                            <label for="location_id">Production Unit<span style="color: #EB2D30">*</span> </label>
                            <select id="location_id" name="location_id" class="form-input flex-1">
                            <option  value="" selected>Select</option>
                                   @foreach ($locations as $location)
                                        <option value="{{ $location->p_id }}">{{ $location->production_unit_name }}</option>
                                    @endforeach
                            </select>
                            @error('location_id')
								<small class='text-danger'>{{ $message }}</small>
							@enderror
						</div>

                        
						
					</div>
					
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                            <label for="die_no_front">Die No Front<span style="color: #EB2D30">*</span> </label>
                            <select id="die_no_front" name="die_no_front" class="form-input flex-1">                                          >
                                <option  value="" selected>Select</option>
                               
                            </select>
                            @error('die_no_front')
							 <small class='text-danger'>{{ $message }}</small>
							@enderror
						</div>
					    <div>
                            <label for="die_no_back">Die No Back<span style="color: #EB2D30"></span> </label>
                               <select id="die_no_back" name="die_no_back" class="form-input">
                                 <option val="">Select</option>
                                 <option  value="" selected>Select</option>
                                  
                                </select>
						</div>
						
						
					</div>

					<button type="submit" name="sbt" class="btn btn-primary !mt-6">Assign&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
						
                </form> 
	
                        </div>

                    <!-- end main content section -->


@endsection
@section('scripts')
<script>
    $("#location_id").change(function(){
        get_all_die_no_front();
        get_all_die_no_back();
    });
    function get_all_die_no_front(){
        model_id = $("#model_id").val();
        location_id = $("#location_id").val();

		$.ajax({
				url: '{{route('get_list_of_die_front_no_production')}}',
				type: 'GET',
				data: {model_id: model_id,location_id:location_id},
				success: function(data) {
                    die_front_no_list = data.die_front_no;
                    $('#die_no_front').empty();

                    $('#die_no_front').append('<option value=" ">Select</option>');
					$.each(die_front_no_list, function(key, value) {
						$('#die_no_front').append('<option value="' + value.id + '">' + value.die_no + '</option>');
					});
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
    }
    function get_all_die_no_back(){
        model_id = $("#model_id").val();
        location_id = $("#location_id").val();

        $.ajax({
				url: '{{route('get_list_of_die_back_no_production')}}',
				type: 'GET',
				data: {model_id: model_id,location_id:location_id},
				success: function(data) {
                    die_back_no_list = data.die_back_no;
                    $('#die_no_back').empty();

                    $('#die_no_back').append('<option value=" ">Select</option>');
					$.each(die_back_no_list, function(key, value) {
						$('#die_no_back').append('<option value="' + value.id + '">' + value.die_no + '</option>');
					});
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
    }
</script>
@endsection