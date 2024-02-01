
@extends('executive.layouts.app')

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

						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Change Password</h5>
                        <div class="pX-5 panel w-full">
                        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
						<form class="space-y-5"  id="edit_password" name="edit_password" action="{{ route('change_password_executive',Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div>
						<label for="password">New Password<span style="color: #EB2D30">*</span> </label>
										<input type="password" id="password" value="{{old('password')}}" class="form-input" placeholder="" name="password" autocomplete="off">
										@error('password')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
						</div>
						
					</div>
					
   

					<button type="submit" name="sbt" class="btn btn-primary !mt-6">Change Password&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
						
                </form> 
	
                        </div>

                    <!-- end main content section -->


@endsection
@section('scripts')

@endsection