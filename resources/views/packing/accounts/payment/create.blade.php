
@extends('packing.layouts.app')

@section('content')
<!-- start main content section -->

						<!-- <ul class="flex space-x-2 rtl:space-x-reverse">
                            <li>
                                <a href="{{ route('payment_list')}}" class="text-primary hover:underline">Payment</a>
                            </li>
                            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                                <span><a href="{{ route('payment_create')}}" class="text-primary hover:underline">Create</a></span>
                            </li>
                        </ul> -->
						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Payment</h5>
                        
						<div class="pX-5 panel w-full">
						   
						  <div class="container">
							 <div class="row">
							 <div class="col-sm-12">
							 <form class="form-horizontal"  id="add_payment" name="add_payment" action="{{ url('payment_packing') }}" method="POST" enctype="multipart/form-data" onsubmit="return disableSubmitButton()">
					@csrf
						<div class="form-body">
				
							<div class="row">
							<div class="form-group col-sm-3">
									<label for="reference_no">Packing<span style="color: #EB2D30">*</span> </label>
									<select id="fitting_or_packing" name="fitting_or_packing" class="form-input flex-1">
                                                
                                                  <option value="Packing" {{ old('fitting_or_packing') == 'Packing' ? 'selected' : '' }}>Packing</option>
                                              </select>
											    @error('fitting_or_packing')
											    <small class='text-danger'>{{ $message }}</small>
												@enderror
								</div> 
								<div class="form-group col-sm-3">
									<label for="reference_no">Reference No<span style="color: #EB2D30"></span> </label>
										<input type="text" id="reference_no" value="{{$r_no}}" class="form-input" readonly="readonly" name="reference_no" autocomplete="off">
										
								</div> 
                                <div class="form-group col-sm-3">
									<label for="t_date">Date<span style="color: #EB2D30">*</span> </label>
										<input type="date" id="t_date" value="{{date('Y-m-d')}}" class="form-input" placeholder="" name="t_date" autocomplete="off">
										@error('t_date')
											<small class='text-danger'>{{ $message }}</small>
										@enderror	
								</div> 
								<div class="form-group col-sm-3">
									<label for="type">Type<span style="color: #EB2D30">*</span> </label>
										<select id="type" name="type" class="form-input" >
                                        <option  value="" selected>Select</option>
                                        <option  value="black" {{ old('type') == 'black' ? 'selected' : '' }}>Pencil</option>
										<option  value="white" {{ old('type') == 'white' ? 'selected' : '' }}>Pen</option> 
                                        </select>
										@error('type')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
                                <div class="form-group col-sm-4">
									<label for="cr_ledger_id">From<span style="color: #EB2D30">*</span> </label>
										<select id="cr_ledger_id" name="cr_ledger_id" class="form-input" >
                                        <option  value="" selected>Select</option>
                                            @foreach ($lg_lists_b_c as $row)
                                                <option value="{{ $row->id; }}" {{ old('cr_ledger_id') == $row->id ? 'selected' : '' }}>{{ $row->ledger; }}</option>
                                            @endforeach
                                        </select>
										<span class="balance" id="cr_ledger_text"></span>
										@error('cr_ledger_id')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
                                <div class="form-group col-sm-4">
									<label for="dr_ledger_id">To<span style="color: #EB2D30">*</span> </label>
										<select id="dr_ledger_id" name="dr_ledger_id" class="form-input" >
                                        <option  value="" selected>Select</option>
                                            @foreach ($lg_lists as $row)
                                                <option value="{{ $row->id; }}" {{ old('dr_ledger_id') == $row->id ? 'selected' : '' }}>{{ $row->ledger; }}</option>
                                            @endforeach
                                        </select>
										<span class="balance" id="dr_ledger_text"></span>
										@error('dr_ledger_id')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
								
                                <div class="form-group col-sm-4" style="display:none">
									<label for="currency_id">Currency<span style="color: #EB2D30">*</span> </label>
										<select id="currency_id" name="currency_id" class="form-input" onchange='return get_balance();'>
                                        <option  value="" selected>Select</option>
                                            @foreach ($currency_lists as $row)
                                                <option value="{{ $row->id; }}" {{ $row->id == 1 ? 'selected' : '' }}>{{ $row->code; }}</option>
                                            @endforeach
                                        </select>
										@error('currency_id')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
                                <div class="form-group col-sm-4">
									<label for="amount">Amount<span style="color: #EB2D30">*</span> </label>
										<input type="number" step="0.00001" id="amount" value="{{old('amount')}}" class="form-input" placeholder="" name="amount" autocomplete="off">
										@error('amount')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
                                <div class="form-group col-sm-12">
                                    <label for="narration">Narration<span style="color: #EB2D30"></span> </label>
									<textarea class="form-input" name="narration" id="narration">{{old('narration')}}</textarea>
										
								</div> 
								
							</div>
							

                        </div>
               
						      </div>

						<!-- <div class="col-sm-2">
						<div class="c_div px-2">
							<h6 class="text-left mt-2" >Cash Account</h6>
												<table class="table table-striped">

												@foreach($c_balance as $c_b)
													
													<tr><td>{{ $c_b[0]}}</td><td>{{ $c_b[1]}}</td></tr>
												@endforeach
												</table>
							</div>
						</div> -->
							 </div>
</div>
<button type="submit" name="sbt" id="submitButton" class="btn btn-primary !mt-6">Create&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
</form> 
                        </div>

                    <!-- end main content section -->


@endsection
@section('scripts')
<script>
	function get_balance(){
		cr_ledger = $("#cr_ledger_id").val();
        dr_ledger = $("#dr_ledger_id").val();
        currency_id = $("#currency_id").val();
		 $.ajax({
				url: '{{route('get_total_balance_packing')}}',
				type: 'GET',
				data: {cr_ledger: cr_ledger,dr_ledger:dr_ledger,currency_id:currency_id},
				success: function(data) {
					$("#cr_ledger_text").text("Balance = "+data.total_cr_ledger);
                    $("#dr_ledger_text").text("Balance = "+data.total_dr_ledger);

				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
	}
 </script>
 <script>
$(document).ready(function(){
  $("#cr_ledger_id").change(function(){
	cr_ledger = $("#cr_ledger_id").val();
	currency_id = $("#currency_id").val(); 
	$.ajax({
				url: '{{route('get_total_credit_balance_packing')}}',
				type: 'GET',
				data: {cr_ledger: cr_ledger,currency_id:currency_id},
				success: function(data) {
					$("#cr_ledger_text").text("Balance = "+data);

				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});

	});
	});
</script>
<script>
$(document).ready(function(){
  $("#dr_ledger_id").change(function(){
	dr_ledger = $("#dr_ledger_id").val();
	currency_id = $("#currency_id").val(); 
	$.ajax({
				url: '{{route('get_total_debit_balance_packing')}}',
				type: 'GET',
				data: {dr_ledger: dr_ledger,currency_id:currency_id},
				success: function(data) {
					$("#dr_ledger_text").text("Balance = "+data);

				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});

	});
	});
</script>
<script>
    function disableSubmitButton() {
        // Disable the submit button to prevent multiple submissions
        document.getElementById('submitButton').disabled = true;
        return true; // Allow the form to be submitted
    }
</script>
@endsection