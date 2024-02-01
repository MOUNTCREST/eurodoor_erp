
@extends('admin.layouts.app')

@section('content')
<!-- start main content section -->

						<!-- <ul class="flex space-x-2 rtl:space-x-reverse">
                            <li>
                                <a href="{{ route('product_category_list')}}" class="text-primary hover:underline">Product Category</a>
                            </li>
                            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                                <span><a href="{{ route('product_category_create')}}" class="text-primary hover:underline">Create</a></span>
                            </li>
                        </ul> -->

						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Product Category</h5>
                        <div class="pX-5 panel w-full">
						   
						<form class="space-y-5"  id="edit_product_category" name="edit_product_category" action="{{ route('product_category_update',$result->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div>
						<label for="category_name">Category<span style="color: #EB2D30">*</span> </label>
						<input type="text" id="category_name" value="{{old('category_name') ? old('category_name') : $result->category_name }}" class="form-input" placeholder="" name="category_name" autocomplete="off">
						@error('category_name')
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