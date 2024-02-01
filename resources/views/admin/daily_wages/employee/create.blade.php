
@extends('admin.layouts.app')

@section('content')
<!-- start main content section -->

						<!-- <ul class="flex space-x-2 rtl:space-x-reverse">
                            <li>
                                <a href="{{ route('employee_list')}}" class="text-primary hover:underline">Employee</a>
                            </li>
                            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                                <span><a href="{{ route('employee_create')}}" class="text-primary hover:underline">Create</a></span>
                            </li>
                        </ul> -->
						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Employee</h5>

                        <div class="pX-5 panel w-full">
						   
						<form class="space-y-5"  id="add_employee" name="add_employee" action="{{ url('employee') }}" method="POST" enctype="multipart/form-data" onsubmit="return disableSubmitButton()">
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div>
						<label for="e_name">Name<span style="color: #EB2D30">*</span> </label>
										<input type="text" id="e_name" value="{{old('e_name')}}" class="form-input" placeholder="" name="e_name" autocomplete="off">
										@error('e_name')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
						</div>
						<div>
						<label for="mobile_no">Mobile No<span style="color: #EB2D30">*</span> </label>
										<input type="number" step="any" id="mobile_no" value="{{old('mobile_no')}}" class="form-input" placeholder="" name="mobile_no" autocomplete="off">
										@error('mobile_no')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
						</div>
						
						
					</div>
					<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
					<div>
						<label for="joining_date">Joining Date<span style="color: #EB2D30"></span> </label>
										<input type="date" id="joining_date" value="{{old('joining_date')}}" class="form-input" placeholder="" name="joining_date" autocomplete="off">
						</div>
					<div>
						<label for="daily_wage">Daily Wage<span style="color: #EB2D30"></span> </label>
										<input type="number" step="any" id="daily_wage" oninput="return calculate_per_hour(); " value="{{old('daily_wage')}}" class="form-input" placeholder="" name="daily_wage" autocomplete="off">
						</div>
						<div>
						<label for="per_hour_amount">Per Hour<span style="color: #EB2D30"></span> </label>
										<input type="text" readonly="readonly" id="per_hour_amount" value="{{old('per_hour_amount')}}" class="form-input" placeholder="" name="per_hour_amount" autocomplete="off">
						</div>
						
					</div>

				<div class="grid grid-cols-1 sm:grid-cols-6 gap-4">
				        <div>
							<label for="address">Address<span style="color: #EB2D30"></span> </label>
							<textarea id="address" name="address" class="form-textarea min-h-[130px]">{{old('address')}}</textarea>
						</div>
				</div>
					
   

					<button type="submit" name="sbt" id="submitButton" class="btn btn-primary !mt-6">Create&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
						
                </form> 
	
                        </div>

                    <!-- end main content section -->


@endsection
@section('scripts')
<script>
	function calculate_per_hour(){
		daily_wage = $('#daily_wage').val();
		var amnt = parseFloat(daily_wage) / 8;
		$('#per_hour_amount').val(amnt);
	}
</script>
<script>
    function disableSubmitButton() {
        // Disable the submit button to prevent multiple submissions
        document.getElementById('submitButton').disabled = true;
        return true; // Allow the form to be submitted
    }
</script>
@endsection