
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

						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Ledgers</h5>


                        <div class="pX-5 panel w-full">
						   
						<form class="space-y-5"  id="add_ledger" name="add_ledger" action="{{ url('ledger') }}" method="POST" enctype="multipart/form-data" onsubmit="return disableSubmitButton()">
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div>
						    <label for="ledger">Name<span style="color: #EB2D30">*</span> </label>
							<input type="text" id="ledger" value="{{old('ledger')}}"  class="form-input" placeholder="" name="ledger" autocomplete="off">
										@error('ledger')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
						</div>
						<div>
							<label for="Code">Code</label>
							<input type="text" id="code" value="{{old('code')}}" class="form-input" placeholder="" name="code" autocomplete="off">
						</div>
					</div>
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
					<div>
						<label for="account_group_id">Account Group<span style="color: #EB2D30">*</span></label>
						<select id='account_group_id' name='account_group_id' class='form-input'>
						<option  value="" selected>Select</option>
											@foreach($lg_lists as $lg_list)
											  <option value='{{ $lg_list->id }}'  {{ old('account_group_id') == $lg_list->id ? 'selected' : '' }}>{{ $lg_list->account_group_name}}</option>
											@endforeach
										</select>
										@error('account_group_id')
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
        // Get the form element
        const myForm = document.getElementById('add_ledger');

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