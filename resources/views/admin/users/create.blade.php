
@extends('admin.layouts.app')

@section('content')
<!-- start main content section -->

						<!-- <ul class="flex space-x-2 rtl:space-x-reverse">
                            <li>
                                <a href="{{ route('ledger_list')}}" class="text-primary hover:underline">Ledgers</a>
                            </li>
                            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                                <span><a href="{{ route('ledger_create')}}" class="text-primary hover:underline">Create</a></span>
                            </li>
                        </ul> -->

						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Users</h5>


                        <div class="pX-5 panel w-full">
						   
						<form class="space-y-5"  id="add_user" name="add_user" action="{{ url('admin_user') }}" method="POST" enctype="multipart/form-data" onsubmit="return disableSubmitButton()">
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div>
						    <label for="name">Name<span style="color: #EB2D30">*</span> </label>
							<input type="text" id="name" value="{{old('name')}}"  class="form-input" placeholder="" name="name" autocomplete="off">
										@error('name')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
						</div>
						<div>
						<label for="email">Email <span style="color: #EB2D30">*</span> </label>
										<input type="email" id="email" value="{{old('email')}}" class="form-control form_element" placeholder="" name="email" autocomplete="off">
										@error('email')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
						</div>
                        <div>
                        <label for="phone_no">Phone <span style="color: #EB2D30">*</span> </label>
										<input type="number" step="any" id="phone_no" value="{{old('phone_no')}}" class="form-control form_element" placeholder="" name="phone_no" autocomplete="off">
										@error('phone_no')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
                        </div>
						<div>
                        <label for="department">Department <span style="color: #EB2D30">*</span> </label>
                        <select id="department" name="department" class="form-input">
                            <option value=""></option>
                            <option value="Fitting" {{ old('department') == 'Fitting' ? 'selected' : '' }}>Fitting</option>
                            <option value="Packing" {{ old('department') == 'Packing' ? 'selected' : '' }}>Packing</option>
                            <option value="Production" {{ old('department') == 'Production' ? 'selected' : '' }}>Production</option>
                            <option value="Account" {{ old('department') == 'Account' ? 'selected' : '' }}>Account</option>
							<option value="Executive" {{ old('department') == 'Executive' ? 'selected' : '' }}>Executive</option>
                            <option value="Confirmation" {{ old('department') == 'Confirmation' ? 'selected' : '' }}>Confirmation</option>
                        </select>
										
										@error('department')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
                        </div>
                        <div>
                        <label for="user_name">Username <span style="color: #EB2D30">*</span> </label>
										<input type="text" id="user_name" value="{{old('user_name')}}"  class="form-control form_element" placeholder="" name="user_name" autocomplete="off">
										@error('user_name')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
                        </div>
                        <div>
                        <label for="password">Password <span style="color: #EB2D30">*</span> </label>
										<input type="password" id="password" value="{{old('password')}}" class="form-control form_element" placeholder="" name="password" autocomplete="off">
										@error('password')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
                        </div>
                        
					</div>
					<div class="grid grid-cols-1 sm:grid-cols-6 gap-4">
					<div>
					    <label for="address">Address<span style="color: #EB2D30">*</span> </label>
						<textarea class='form-control form-element' name='address' id='address'>{{old('address')}}</textarea>
						@error('address')
							<small class='text-danger'>{{ $message }}</small>
						@enderror
					</div>
					</div>

   

					<button type="submit" id="submitButton" name="sbt" class="btn btn-primary !mt-6">Create&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
						
                </form> 
	
                        </div>

                    <!-- end main content section -->


@endsection
@section('scripts')
<script>
    function disableSubmitButton() {
        // Disable the submit button to prevent multiple submissions
        document.getElementById('submitButton').disabled = true;
        return true; // Allow the form to be submitted
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('user_name').value = '';
        document.getElementById('password').value = '';
    });
</script>
<script>
       document.addEventListener('DOMContentLoaded', function () {
        // Get the form element
        const myForm = document.getElementById('add_user');

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