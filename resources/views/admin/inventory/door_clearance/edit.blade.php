
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
						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Door Clearance</h5>

                        <div class="pX-5 panel w-full">
						   
						<form class="space-y-5"  id="edit_door_clearance" name="edit_door_clearance" action="{{ route('door_clearance_update',$result->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
						<div>
						<label for="ref_no">Reference No<span style="color: #EB2D30">*</span> </label>
							<input type="text" id="ref_no" value="{{$result->ref_no}}" readonly="readonly" class="form-input" placeholder="" name="ref_no" autocomplete="off">
							@error('ref_no')
								<small class='text-danger'>{{ $message }}</small>
							@enderror
						</div>
                        <div>
						<label for="dc_date">Date<span style="color: #EB2D30">*</span> </label>
							<input type="date" id="dc_date" value="{{old('dc_date') ? old('dc_date') : $result->dc_date}}" class="form-input" placeholder="" name="dc_date" autocomplete="off">
							@error('dc_date')
								<small class='text-danger'>{{ $message }}</small>
							@enderror
						</div>
					</div>

					<div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
						<div>
						<label for="frame_size">Frame Size<span style="color: #EB2D30">*</span> </label>
							<input type="text" id="frame_size" value="{{old('frame_size') ? old('frame_size') : $result->frame_size}}" class="form-input" placeholder="" name="frame_size" autocomplete="off">
							@error('frame_size')
								<small class='text-danger'>{{ $message }}</small>
							@enderror
						</div>
                        <div>
						<label for="frame_name">Frame Name<span style="color: #EB2D30">*</span> </label>
							<input type="text" id="frame_name" value="{{old('frame_name') ? old('frame_name') : $result->frame_name}}" class="form-input" placeholder="" name="frame_name" autocomplete="off">
							@error('frame_name')
								<small class='text-danger'>{{ $message }}</small>
							@enderror
						</div>
					</div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
						<div>
						<label for="width">Width<span style="color: #EB2D30">*</span> </label>
							<input type="number" step="any" id="width" value="{{old('width') ? old('width') : $result->width}}" class="form-input" placeholder="" name="width" autocomplete="off">
							@error('width')
								<small class='text-danger'>{{ $message }}</small>
							@enderror
						</div>
                        <div>
						<label for="height">Height<span style="color: #EB2D30">*</span> </label>
							<input type="number" step="any" id="height" value="{{old('height') ? old('height') : $result->height}}" class="form-input" placeholder="" name="height" autocomplete="off">
							@error('height')
								<small class='text-danger'>{{ $message }}</small>
							@enderror
						</div>
					</div>
					<div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                       <div>
						<label for="resin_qty">Resin Qty<span style="color: #EB2D30">*</span> </label>
						<input type="number" step="any" id="resin_qty" name="resin_qty" value="{{old('resin_qty') ? old('resin_qty') : $result->resin_qty}}" class="form-input">
						@error('resin_qty')
								<small class='text-danger'>{{ $message }}</small>
							@enderror
						</div>
						<div>
						<label for="paint_qty">Paint Qty<span style="color: #EB2D30">*</span> </label>
						<input type="number" step="any" id="paint_qty" name="paint_qty" value="{{old('paint_qty') ? old('paint_qty') : $result->paint_qty}}" class="form-input">
						@error('paint_qty')
								<small class='text-danger'>{{ $message }}</small>
							@enderror
						</div>
					</div>

					<button type="submit" name="sbt" class="btn btn-primary !mt-6">Update&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
						
                </form> 
	
                        </div>

                    <!-- end main content section -->


@endsection
@section('scripts')

@endsection