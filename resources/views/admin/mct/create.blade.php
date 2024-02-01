
@extends('admin.layouts.app')

@section('content')
<!-- start main content section -->

						<!-- <ul class="flex space-x-2 rtl:space-x-reverse">
                            <li>
                                <a href="{{ route('multi_currency_list')}}" class="text-primary hover:underline">Multi Currency Transfer</a>
                            </li>
                            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                                <span><a href="{{ route('multi_currency_create')}}" class="text-primary hover:underline">Create</a></span>
                            </li>
                        </ul> -->
						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Multi Currency Transfer</h5>

                        <div class="pX-5 panel w-full">
						<div class="container">
							 <div class="row">
							 <div class="col-sm-10">
						<form class="form-horizontal"  id="add_mct" name="add_mct" action="{{ url('multicurrencytransfer') }}" method="POST" enctype="multipart/form-data">
					@csrf
						<div class="form-body">
				
							<div class="row">
								<div class="form-group col-sm-6">
									<label for="reference_no">Reference No<span style="color: #EB2D30"></span> </label>
										<input type="text" id="reference_no" value="{{$r_no}}" class="form-input" readonly="readonly" name="reference_no" autocomplete="off">
										
								</div> 
                                <div class="form-group col-sm-6">
									<label for="date">Date<span style="color: #EB2D30"></span> </label>
										<input type="date" id="date" value="{{date('Y-m-d')}}" class="form-input" placeholder="" name="date" autocomplete="off">
										
								</div> 
                                <div class="form-group col-sm-6">
									<label for="account_dr">From<span style="color: #EB2D30"></span> </label>
										<select id="account_dr" name="account_dr" class="form-input" >
                                        <option  value="" selected>Select</option>
                                            @foreach ($lg_lists as $row)
                                                <option value="{{ $row->id; }}">{{ $row->ledger; }}</option>
                                            @endforeach
                                        </select>
										<span class="balance" id="dr_ledger_text"></span>
										
								</div> 
                                <div class="form-group col-sm-6">
									<label for="from_currency">From Currency<span style="color: #EB2D30"></span> </label>
										<select id="from_currency" name="from_currency" class="form-input" onchange="return get_balance_dr();">
                                        <option  value="" selected>Select</option>
                                            @foreach ($currency_lists as $row)
                                                <option value="{{ $row->id; }}">{{ $row->code; }}</option>
                                            @endforeach
                                        </select>
										
								</div> 
                                <div class="form-group col-sm-6">
									<label for="account_cr">To<span style="color: #EB2D30"></span> </label>
										<select id="account_cr" name="account_cr" class="form-input" >
                                        <option  value="" selected>Select</option>
                                            @foreach ($lg_lists as $row)
                                                <option value="{{ $row->id; }}">{{ $row->ledger; }}</option>
                                            @endforeach
                                        </select>
										<span class="balance" id="cr_ledger_text"></span>
										
								</div> 
                                <div class="form-group col-sm-6">
									<label for="to_currency">To Currency<span style="color: #EB2D30"></span> </label>
										<select id="to_currency" name="to_currency" class="form-input" onchange="return get_balance_cr();" >
                                        <option  value="" selected>Select</option>
                                            @foreach ($currency_lists as $row)
                                                <option value="{{ $row->id; }}">{{ $row->code; }}</option>
                                            @endforeach
                                        </select>
										
								</div> 
                                <div class="form-group col-sm-4">
									<label for="current_rate">Currenct Rate<span style="color: #EB2D30">*</span> </label>
										<input type="number" step="0.00001" id="current_rate" oninput="return calculation();" value="{{old('current_rate')}}" class="form-input" placeholder="" name="current_rate" autocomplete="off">
										@error('current_rate')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
                                <div class="form-group col-sm-4">
									<label for="from_amount">From Amount<span style="color: #EB2D30">*</span> </label>
										<input type="number" step="0.00001" id="from_amount" oninput="return calculation();" value="{{old('from_amount')}}" class="form-input" placeholder="" name="from_amount" autocomplete="off">
										@error('from_amount')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
                                <div class="form-group col-sm-4">
									<label for="m_d_type">Type<span style="color: #EB2D30"></span> </label>
										<select id="m_d_type" name="m_d_type" class="form-input" onchange="return calculation();" >
                                        <option  value="" selected>Select</option>
                                        <option  value="DV">Division</option>
                                        <option  value="MT">Multiplication</option>
                                        </select>
								</div> 
                                <div class="form-group col-sm-4">
									<label for="to_amount">To Amount<span style="color: #EB2D30">*</span> </label>
										<input type="number" step="0.00001" id="to_amount" value="{{old('to_amount')}}" class="form-input" placeholder="" name="to_amount" autocomplete="off">
										@error('to_amount')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
                                <div class="form-group col-sm-8">
                                    <label for="narration">Narration<span style="color: #EB2D30"></span> </label>
									<textarea class="form-input" name="narration" id="narration"></textarea>
										
								</div> 
                                
								
								
								
							</div>
							

                        </div>
                
						</div>

						<div class="col-sm-2">
						<div class="c_div px-2">
							<h6 class="text-left mt-2" >Cash Account</h6>
												<table class="table table-striped">

												@foreach($c_balance as $c_b)
													
													<tr><td>{{ $c_b[0]}}</td><td>{{ $c_b[1]}}</td></tr>
												@endforeach
												</table>
							</div>
						</div>
							 </div>
</div> 
						
					
   

					<button type="submit" name="sbt" class="btn btn-primary !mt-6">Create&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
				
					</form> 
                        </div>

                    <!-- end main content section -->


@endsection
@section('scripts')
<!-- For calculation to get to amount -->
<script type="text/javascript">
      function calculation(){
        current_rate = $("#current_rate").val();
        from_amount = $("#from_amount").val();
        type = $("#m_d_type").val();
        if(type == "MT"){
            result = parseFloat(current_rate) * parseFloat(from_amount);
        }
        else{
            result = parseFloat(from_amount) / parseFloat(current_rate);
        }
        $("#to_amount").val(result.toFixed(3));
      }
    </script>
<!-- For calculation to get from amount -->
<script type="text/javascript">
      function calculation_to(){
        current_rate = $("#current_rate").val();
        to_amount = $("#to_amount").val();
        type = $("#m_d_type").val();
        if(type == "MT"){
            result = parseFloat(current_rate) * parseFloat(to_amount);
        }
        else{
            result = parseFloat(to_amount) * parseFloat(current_rate);
        }
        $("#from_amount").val(result.toFixed(3));
      }
    </script>
 <script>
	function get_balance_dr(){
		dr_ledger = $("#account_dr").val();
        currency_id = $("#from_currency").val();
		 $.ajax({
				url: '{{route('get_total_debit_balance')}}',
				type: 'GET',
				data: {dr_ledger:dr_ledger,currency_id:currency_id},
				success: function(data) {
                    $("#dr_ledger_text").text("Balance = "+data);

				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
	}
 </script>
 <script>
	function get_balance_cr(){
		cr_ledger = $("#account_cr").val();
        currency_id = $("#from_currency").val();
		 $.ajax({
				url: '{{route('get_total_credit_balance')}}',
				type: 'GET',
				data: {cr_ledger:cr_ledger,currency_id:currency_id},
				success: function(data) {
                    $("#cr_ledger_text").text("Balance = "+data);

				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
	}
 </script>
 
 <script>
$(document).ready(function(){
  $("#account_cr").change(function(){
	cr_ledger = $("#account_cr").val();
	currency_id = $("#from_currency").val(); 
	$.ajax({
				url: '{{route('get_total_credit_balance')}}',
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
  $("#account_dr").change(function(){
	dr_ledger = $("#account_dr").val();
	currency_id = $("#to_currency").val(); 
	$.ajax({
				url: '{{route('get_total_debit_balance')}}',
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