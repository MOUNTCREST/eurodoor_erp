
@extends('fitting.layouts.app')

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
							 <form class="form-horizontal"  id="edit_payment" name="edit_payment" action="{{ route('payment_fitting_update',$result->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
						<div class="form-body">
				
							<div class="row">
							<div class="form-group col-sm-3">
									<label for="reference_no">Fitting<span style="color: #EB2D30">*</span> </label>
									<select id="fitting_or_packing" name="fitting_or_packing" class="form-input flex-1">
                                                  <option value="Fitting" {{ $result->fitting_or_packing == 'Fitting' ? 'selected' : '' }}>Fitting</option>
                                              </select>
											  @error('fitting_or_packing')
											    <small class='text-danger'>{{ $message }}</small>
												@enderror
								</div> 
								<div class="form-group col-sm-3">
									<label for="reference_no">Reference No<span style="color: #EB2D30"></span> </label>
										<input type="text" id="reference_no" value="{{$result->reference_no}}" class="form-input" readonly="readonly" name="reference_no" autocomplete="off">
										
								</div> 
                                <div class="form-group col-sm-3">
									<label for="t_date">Date<span style="color: #EB2D30">*</span> </label>
										<input type="date" id="t_date" value="{{$result->added_date}}" class="form-input" placeholder="" name="t_date" autocomplete="off">
										@error('t_date')
											<small class='text-danger'>{{ $message }}</small>
										@enderror	
								</div> 
								<div class="form-group col-sm-3">
									<label for="type">Type<span style="color: #EB2D30">*</span> </label>
										<select id="type" name="type" class="form-input" >
                                        <option  value="" selected>Select</option>
                                        <option  value="black" {{ $result->type == 'black' ? 'selected' : '' }}>Pencil</option>
										<option  value="white" {{ $result->type == 'white' ? 'selected' : '' }}>Pen</option> 
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
                                                <option value="{{ $row->id; }}" {{ ($row->id == $result->from_ledger_id || $row->id == old('cr_ledger_id')) ? 'selected' : '' }}>{{ $row->ledger; }}</option>
                                            @endforeach
                                        </select>
										@error('cr_ledger_id')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
                                <div class="form-group col-sm-4">
									<label for="dr_ledger_id">To<span style="color: #EB2D30">*</span> </label>
										<select id="dr_ledger_id" name="dr_ledger_id" class="form-input" >
                                        <option  value="" selected>Select</option>
                                            @foreach ($lg_lists as $row)
                                                <option value="{{ $row->id; }}" {{ ($row->id == $result->to_ledger_id || $row->id == old('dr_ledger_id')) ? 'selected' : '' }}>{{ $row->ledger; }}</option>
                                            @endforeach
                                        </select>
										@error('dr_ledger_id')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
								 
                                <div class="form-group col-sm-4" style="display:none">
									<label for="currency_id">Currency<span style="color: #EB2D30">*</span> </label>
										<select id="currency_id" name="currency_id" class="form-input" onchange='return get_balance();' >
                                        <option  value="" selected>Select</option>
                                            @foreach ($currency_lists as $row)
                                                <option value="{{ $row->id; }}" {{ $row->id == $result->currency_id ? 'selected' : '' }}>{{ $row->code; }}</option>
                                            @endforeach
                                        </select>
										
								</div> 
                                <div class="form-group col-sm-4">
									<label for="amount">Amount<span style="color: #EB2D30">*</span> </label>
										<input type="number" step="0.00001" id="amount" value="{{$result->amount}}" class="form-input" placeholder="" name="amount" autocomplete="off">
										@error('amount')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
                                <div class="form-group col-sm-12">
                                    <label for="narration">Narration<span style="color: #EB2D30"></span> </label>
									<textarea class="form-input" name="narration" id="narration">{{$result->narration}}</textarea>
										
								</div> 
							</div>
							
                        </div>
             
						</div>

							 </div>
</div>
<button type="submit" name="sbt" class="btn btn-primary !mt-6">Update&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
</form> 
                        </div>

                    <!-- end main content section -->


@endsection
@section('scripts')
<!-- For calculation to get to amount -->
<script>
	function get_balance(){
		cr_ledger = $("#cr_ledger_id").val();
        dr_ledger = $("#dr_ledger_id").val();
        currency_id = $("#currency_id").val();
		 $.ajax({
				url: '{{route('get_total_balance_fitting')}}',
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
				url: '{{route('get_total_credit_balance_fitting')}}',
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
				url: '{{route('get_total_debit_balance_fitting')}}',
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
@endsection