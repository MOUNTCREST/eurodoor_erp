
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
						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Production Unit</h5>

                        <div class="pX-5 panel w-full">
						   
                        <form class="space-y-5"  id="edit_production_unit" name="edit_production_unit" action="{{ route('production_unit_update',$result->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
					<div>
						<label for="color_type">Name<span style="color: #EB2D30">*</span> </label>
							<input id="production_unit_name" name="production_unit_name" class="form-input" value="{{ $result->production_unit_name}}">
							@error('production_unit_name')
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