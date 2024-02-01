
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
						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Payment</h5>

                        <div class="pX-5 panel w-full">
						   
						<form class="space-y-5"  id="add_employee_payment" name="add_employee_payment" action="{{ route('employee_payment_update',$result->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
						<label for="date">Date<span style="color: #EB2D30">*</span> </label>
										<input type="date" id="date" value="{{old('date') ? old('date') : $result->date }}" class="form-input" placeholder="" name="date" autocomplete="off">
										@error('date')
														<small class='text-danger'>{{ $message }}</small>
													@enderror
						</div>
                        <div>
						<label for="ref_no">Ref No<span style="color: #EB2D30"></span> </label>
										<input type="text" id="ref_no" readonly='readonly' value="{{old('ref_no') ? old('ref_no') : $result->ref_no }}" class="form-input" placeholder="" name="ref_no" autocomplete="off">
						</div>
					
						
						
						
						
					</div>
					<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
					<label for="e_name">Employee<span style="color: #EB2D30">*</span> </label>
                        <select name="employee_id" class="form-control form_element s2" id="employee_id"  required="required" onchange="return get_employe_amnt();">
                                                              <option  value="" selected>Select</option>
                                                                @foreach ($ey_lists as $row): 
                                                                    <option value="{{ $row->id }}" {{ $result->employee_id == $row->id ? 'selected' : '' }}>{{ $row->e_name }}</option>
                                                                @endforeach
                                                     </select>
													 @error('employee_id')
														<small class='text-danger'>{{ $message }}</small>
													@enderror
						</div>
						<div>
						<label for="amount">Amount<span style="color: #EB2D30">*</span> </label>
										<input type="number" step="any" value="{{old('amount') ? old('amount') : $result->amount}}" class="form-input" placeholder="" name="amount" autocomplete="off">
										@error('amount')
														<small class='text-danger'>{{ $message }}</small>
													@enderror
									</div>
						
					</div>

				
					
   

					<button type="submit" name="sbt" class="btn btn-primary !mt-6">Create&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
						
                </form> 
	
                        </div>

                    <!-- end main content section -->


@endsection
@section('scripts')
<script>
	function get_employe_amnt(){
        employee_id = $("#employee_id").val(); 
	$.ajax({
				url: '{{route('get_employee_balance')}}',
				type: 'GET',
				data: {employee_id: employee_id},
				success: function(data) {
                 
					$("#amount").val(data.balance);

				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
    }
</script>
@endsection