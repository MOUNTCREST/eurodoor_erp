
@extends('admin.layouts.app')

@section('content')
<!-- start main content section -->

						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Opening Balance</h5>

						<div class="pX-5 panel w-full">
						   
						<form class="space-y-5"  id="add_opening_balance" name="add_opening_balance" action="{{ url('opening_balance') }}" method="POST" enctype="multipart/form-data" onsubmit="return disableSubmitButton()">
					@csrf

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


					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div>
						<label for="reference_no">Reference No<span style="color: #EB2D30"></span> </label>
						<input type="text" id="reference_no" value="{{$r_no}}" class="form-input" readonly="readonly" name="reference_no" autocomplete="off">
						</div>
						<div>
						<label for="t_date">Date<span style="color: #EB2D30"></span> </label>
						<input type="date" id="t_date" value="{{date('Y-m-d')}}" class="form-input" placeholder="" name="t_date" autocomplete="off">
						@error('t_date')
							<small class='text-danger'>{{ $message }}</small>
						@enderror
						</div>
						<div>
						<label for="ledger_id">Ledgers<span style="color: #EB2D30">*</span> </label>
						<select id="ledger_id" name="ledger_id" class="form-input" >
						<option  value="" selected>Select</option>
							@foreach ($lg_lists as $row)
								<option value="{{ $row->id; }}" {{ old('ledger_id') == $row->id ? 'selected' : '' }}>{{ $row->ledger; }}</option>
							@endforeach
						</select>
						@error('ledger_id')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
						</div>
						<div>
						<label for="type">Type<span style="color: #EB2D30">*</span> </label>
							<select id="type" name="type" class="form-input" >
							<option  value="" selected>Select</option>
								<option value='cr' {{ old('type') == 'cr' ? 'selected' : '' }}>CR</option>
								<option value='dr' {{ old('type') == 'dr' ? 'selected' : '' }}>DR</option>
							</select>
							@error('type')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
						</div>
					</div>
					<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div>
					<label for="currency_id">Currency<span style="color: #EB2D30">*</span> </label>
										<select id="currency_id" name="currency_id" class="form-input" >
                                        <option  value="" selected>Select</option>
                                            @foreach ($currency_lists as $row)
											<option value="{{ $row->id }}" {{ old('currency_id') == $row->id ? 'selected' : '' }}>
												{{ $row->code }}
											</option>
                                            @endforeach
                                        </select>
										@error('currency_id')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
										
                    </div>
                    <div>
					<label for="amount">Amount<span style="color: #EB2D30">*</span> </label>
										<input type="number" step="0.00001" id="amount" value="{{old('amount')}}" class="form-input" placeholder="" name="amount" autocomplete="off">
										@error('amount')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
                    </div>
                    <div class="md:col-span-2">
                    <label for="narration">Narration<span style="color: #EB2D30"></span> </label>
					<textarea
                                            id="narration"
                                            name="narration"
                                            class="form-textarea min-h-[130px]"
                                            placeholder=""
                                        >{{old('narration') }}</textarea>
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
        const myForm = document.getElementById('add_opening_balance');

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