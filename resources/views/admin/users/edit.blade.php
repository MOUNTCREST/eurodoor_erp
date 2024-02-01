
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
						   
						<form class="space-y-5"  id="edit_user" name="edit_user" action="{{ route('admin_user_update',$result->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<input type="hidden" id="user_id" name="user_id" value="{{$result->id}}">
						<div>
						    <label for="name">Name<span style="color: #EB2D30">*</span> </label>
							<input type="text" id="name" value="{{old('name') ? old('name') : $result->name}}"  class="form-input" placeholder="" name="name" autocomplete="off">
										@error('name')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
						</div>
						<div>
						<label for="email">Email <span style="color: #EB2D30">*</span> </label>
										<input type="email" id="email" value="{{old('email') ? old('email') : $result->email}}" class="form-control form_element" placeholder="" name="email" autocomplete="off">
										@error('email')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
						</div>
                        <div>
                        <label for="phone_no">Phone <span style="color: #EB2D30">*</span> </label>
										<input type="text" id="phone_no" value="{{old('phone_no') ? old('phone_no') : $result->phone_no}}" class="form-control form_element" placeholder="" name="phone_no" autocomplete="off">
										@error('phone_no')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
                        </div>
						<div>
                        <label for="department">Department <span style="color: #EB2D30">*</span> </label>
                        <select id="department" name="department" class="form-input">
                            <option value=""></option>
                            <option value="Fitting" {{ $result->department == 'Fitting' ? 'selected' : '' }}>Fitting</option>
                            <option value="Packing" {{ $result->department == 'Packing' ? 'selected' : '' }}>Packing</option>
                            <option value="Production" {{ $result->department == 'Production' ? 'selected' : '' }}>Production</option>
                            <option value="Account" {{ $result->department == 'Account' ? 'selected' : '' }}>Account</option>
							<option value="Executive" {{ $result->department == 'Executive' ? 'selected' : '' }}>Executive</option>
							<option value="Confirmation" {{ $result->department == 'Confirmation' ? 'selected' : '' }}>Confirmation</option>
                        </select>
										
										@error('department')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
                        </div>
                        <div>
                        <label for="user_name">Username <span style="color: #EB2D30">*</span> </label>
										<input type="text" id="user_name" value="{{old('user_name') ? old('user_name') : $result->user_name}}" class="form-control form_element" placeholder="" name="user_name" autocomplete="off">
										@error('user_name')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
                        </div>
                        <div>
							<br>
                             <!-- small -->
                    <div x-data="modal">
                        <!-- button -->
                        <button type="button" class="btn btn-secondary" @click="toggle">Change Password</button>
                            
                        <!-- modal --> 
                        <div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" :class="open && '!block'">
                            <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                                <div x-show="open" x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg overflow-hidden  w-full max-w-sm my-8">
                                    <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-2 py-3">
                                       <h3><b>CHANGE PASSWORD</b></h3>
                                    </div>
                                    <div class="p-2">
									<div>
                        <label for="password">New Password <span style="color: #EB2D30">*</span> </label>
										<input type="password" id="password_new" value="{{old('password')}}" class="form-control form_element" placeholder="" name="password_new" autocomplete="off">
										@error('password')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
                        </div>
						<div>
                        <label for="password">Confirm Password <span style="color: #EB2D30">*</span> </label>
										<input type="password" id="password_confirm" value="{{old('password')}}" class="form-control form_element" placeholder="" name="password_confirm" autocomplete="off">
										@error('password')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
                        </div>
						<div class="pt-2">
						<button type="button" id="change_password" name="change_password" class="btn btn-success" @click="check_passwords();toggle();" >Update</button>
					   </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>
                        
					</div>
					<div class="grid grid-cols-1 sm:grid-cols-6 gap-4">
					<div>
					    <label for="address">Address<span style="color: #EB2D30">*</span> </label>
						<textarea class='form-control form-element' name='address' id='address'>{{old('address') ? old('address') : $result->address}}</textarea>
						@error('address')
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
<!-- script -->
<script>
	document.addEventListener("alpine:init", () => {
		Alpine.data("modal", (initialOpenState = false) => ({
			open: initialOpenState,

			toggle() {
				this.open = !this.open;
			},
		}));
	});
</script>
<script>
	function check_passwords(){
		var user_id = $("#user_id").val();
		var password_new = $("#password_new").val();
		var password_confirm = $("#password_confirm").val();

		// Check if passwords match
		if (password_new !== password_confirm) {
			alert("Passwords do not match");
			return false;
		}

		// Check if the password meets your criteria (e.g., length requirements)
		if (password_new.length < 8) {
			alert("Password should be at least 8 characters long");
			return false;
		}


		$.ajax({
				url: '{{route('change_password_for_users')}}',
				type: 'GET',
				data: {user_id:user_id,password_confirm: password_confirm},
				success: function(data) {
					alert("Password changed successfully");

				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});



	}
</script>
@endsection