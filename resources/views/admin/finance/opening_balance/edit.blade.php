
@extends('admin.layouts.app')

@section('content')
<!-- start main content section -->

						<!-- <ul class="flex space-x-2 rtl:space-x-reverse">
                            <li>
                                <a href="{{ route('opening_balance_list')}}" class="text-primary hover:underline">Opening Balance</a>
                            </li>
                            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                                <span><a href="{{ route('opening_balance_create')}}" class="text-primary hover:underline">Create</a></span>
                            </li>
                        </ul> -->

						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Opening Balance</h5>
						<div class="pX-5 panel w-full">
						   
						<form class="space-y-5"  id="edit_opening_balance" name="edit_opening_balance" action="{{ route('opening_balance_update',$result->account_id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div>
						<label for="reference_no">Reference No<span style="color: #EB2D30"></span> </label>
						<input type="text" id="reference_no" value="{{$result->reference_no}}" class="form-input" readonly="readonly" name="reference_no" autocomplete="off">
						</div>
						<div>
						<label for="t_date">Date<span style="color: #EB2D30"></span> </label>
						<input type="date" id="t_date" value="{{$result_a->t_date}}" class="form-input" placeholder="" name="t_date" autocomplete="off">
						@error('t_date')
							<small class='text-danger'>{{ $message }}</small>
						@enderror
						</div>
						<div>
						<label for="ledger_id">Ledgers<span style="color: #EB2D30"></span> </label>
						<select id="ledger_id" name="ledger_id" class="form-input" >
						<option  value="" selected>Select</option>
							@foreach ($lg_lists as $row)
								<option value="{{ $row->id; }}"  {{ $row->id == $result_b->ledger_id ? 'selected' : '' }}>{{ $row->ledger; }}</option>
							@endforeach
						</select>
						@error('ledger_id')
							<small class='text-danger'>{{ $message }}</small>
						@enderror
						</div>
						<div>
						<label for="type">Type<span style="color: #EB2D30"></span> </label>
							<select id="type" name="type" class="form-input" >
							<option  value="" selected>Select</option>
							    <option value="cr" {{ $result_b->type == 'cr' ? 'selected' : '' }}>Cr</option>
                                <option value="dr" {{ $result_b->type == 'dr' ? 'selected' : '' }}>Dr</option>
							</select>
							@error('type')
							<small class='text-danger'>{{ $message }}</small>
						   @enderror
						</div>
					</div>
					<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div>
					<label for="currency_id">Currency<span style="color: #EB2D30"></span> </label>
										<select id="currency_id" name="currency_id" class="form-input" >
                                        <option  value="" selected>Select</option>
                                            @foreach ($currency_lists as $row)
                                                <option value="{{ $row->id; }}" {{ $row->id == $result_a->currency_id ? 'selected' : '' }}>{{ $row->code; }}</option>
                                            @endforeach
                                        </select>
										
                    </div>
                    <div>
					<label for="amount">Amount<span style="color: #EB2D30">*</span> </label>
										<input type="number" step="0.00001" id="amount" value="{{$result_a->amount}}" class="form-input" placeholder="" name="amount" autocomplete="off">
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
                                        >{{$result_a->narration}}</textarea>
                    </div>
                </div>


					   
					   
   
	  
   
					   <button type="submit" name="sbt" class="btn btn-primary !mt-6">Update&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
						   
				   </form> 
	   
						   </div>





                    <!-- end main content section -->


@endsection
@section('scripts')

@endsection