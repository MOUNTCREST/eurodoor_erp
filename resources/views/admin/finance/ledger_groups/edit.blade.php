
@extends('admin.layouts.app')

@section('content')
<!-- start main content section -->

						<!-- <ul class="flex space-x-2 rtl:space-x-reverse">
                            <li>
                                <a href="{{ route('ledger_group_list')}}" class="text-primary hover:underline">Ledger Groups</a>
                            </li>
                            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                                <span><a href="{{ route('ledger_group_create')}}" class="text-primary hover:underline">Create</a></span>
                            </li>
                        </ul> -->
						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Ledger Groups</h5>

						<div class="pX-5 panel w-full">
						   
						<form class="space-y-5"  id="edit_ledger_group" name="edit_ledger_group" action="{{ route('ledger_group_update',$result->id) }}" method="POST" enctype="multipart/form-data">
					@csrf

					<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
					<label for="account_group_name">Name<span style="color: #EB2D30">*</span> </label>
                        <input type="text" id="account_group_name" value="{{old('account_group_name') ? old('account_group_name') : $result->account_group_name}}"  class="form-input" placeholder="" name="account_group_name" autocomplete="off">
										@error('account_group_name')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
                    </div>
                    <div>
					<label for="Code">Code</label>
							   <input type="text" id="code" value="{{old('code') ? old('code') : $result->code }}" class="form-control form_element" placeholder="" name="code" autocomplete="off">
                    </div>
                    <div>
                    <label for="parent_group_id">Parent Group<span style="color: #EB2D30">*</span></label>
						   <select id='parent_group_id' name='parent_group_id' class='form-input'>
						   <option  value="" selected>Select</option>
											@foreach($pg_lists as $pg_list)
											  <option value='{{ $pg_list->id }}'  {{ $pg_list->id == $result->parent_group_id ? 'selected' : '' }}>{{ $pg_list->parent_group_name}}</option>
											@endforeach
										</select>
										@error('account_group_name')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
                    </div>
                </div>


					   
					   <div class="grid grid-cols-1 sm:grid-cols-6 gap-4">
			
					   
					   <div>
						   <label for="remarks">Remarks</label>
						   <textarea
                                            id="remarks"
                                            name="remarks"
                                            class="form-textarea min-h-[130px]"
                                            placeholder=""
                                        >{{old('remarks') ? old('remarks') : $result->remarks}}</textarea>
					   </div>
					   </div>
   
	  
   
					   <button type="submit" name="sbt" class="btn btn-primary !mt-6">Update&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
						   
				   </form> 
	   
						   </div>





                    <!-- end main content section -->


@endsection
@section('scripts')

@endsection