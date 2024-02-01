
@extends('accounts.layouts.app')

@section('content')
<!-- start main content section -->
<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Sales Invoice</h5>
<div x-data="invoiceAdd" class="pX-5 panel w-full">

<form class="form-horizontal"  id="add_sales_invoice" name="add_sales_invoice" action="{{ url('sales_invoice_account') }}" method="POST" enctype="multipart/form-data" onsubmit="return disableSubmitButton()">
					@csrf
                       



<div class="mt-8 px-4">
<div class="flex flex-col justify-between lg:flex-row">
                                        <div class="mb-6 w-full lg:w-1/2 ltr:lg:mr-6 ">
                                            <div class="mt-3 flex items-center">
                                                <label for="order_no" class="mb-0 w-1/3 ltr:mr-2 rtl:ml-2">Order No</label>
                                                <select id="order_no" name="order_no" class="form-input flex-1" onchange="return get_remarks();">
                                                  <option value="">Select</option>
                                                  @foreach ($order_nos as $row)
                                                          <option value="{{ $row->order_no; }}"  {{ old('order_no') == $row->order_no ? 'selected' : '' }}>{{ $row->order_no; }}</option>
                                                      @endforeach
                                              </select>                                       
                                              </div>          
                                            </div>
                                            <div class="mb-6 w-full lg:w-1/2 ltr:lg:mr-6 ">
                                            <div class="mt-3 flex items-center">
                                                <label for="due_date_no" class="mb-0 w-1/3 ltr:mr-2 rtl:ml-2">Due Date<span style="color: #EB2D30">*</span></label>
                                                <select id="due_date_no" name="due_date_no" class="form-input flex-1" required='required'>
                                                  <option value="">Select</option>
                                                  @for ($i = 1; $i <= 30; $i++)
                                                          <option value="{{ $i }}" {{ old('due_date_no') == $i ? 'selected' : '' }}>{{ $i; }}</option>
                                                  @endfor
                                              </select>   
                                              @error('due_date_no')
                                                <small class='text-danger'>{{ $message }}</small>
                                              @enderror                                               
                                              </div>          
                                            </div>
                                            <div class="mb-6 w-full lg:w-1/2 ltr:lg:mr-6 ">
                                            <div class="mt-3 flex items-center">
                                                <label for="sale_type" class="mb-0 w-1/3 ltr:mr-2 rtl:ml-2">Sale Type<span style="color: #EB2D30">*</span></label>
                                                <select id="sale_type" name="sale_type" class="form-input flex-1" onchange="return get_order_no();" required='required'>
                                                  <option value="">Select</option>
                                                  <option value="B To B" {{ old('sale_type') == 'B To B' ? 'selected' : '' }}>B To B</option>
                                                  <option value="B To C" {{ old('sale_type') == 'B To C' ? 'selected' : '' }}>B To C</option>
                                              </select> 
                                              @error('sale_type')
                                                <small class='text-danger'>{{ $message }}</small>
                                              @enderror                                      
                                              </div>          
                                            </div>

</div>          
<div class="flex flex-col justify-between lg:flex-row">
                                        <div class="mb-6 w-full lg:w-1/2 ltr:lg:mr-6 ">
                                        
                                            <div class="mt-3 flex items-center">
                                                <label for="fitting_or_packing" class="mb-0 w-1/3 ltr:mr-2 rtl:ml-2">Fitting/Packing</label>
                                                <select id="fitting_or_packing" name="fitting_or_packing" class="form-input flex-1">
                                                  <option value="">Select</option>
                                                  <option value="Fitting" {{ old('fitting_or_packing') == 'Fitting' ? 'selected' : '' }}>Fitting</option>
                                                  <option value="Packing" {{ old('fitting_or_packing') == 'Packing' ? 'selected' : '' }}>Packing</option>
                                              </select>
                                              
                                              </div>  
                                              
                                        
                                           
                                        </div>
                                        <div class="mb-6 w-full lg:w-1/2 ltr:lg:mr-6">
                                        <div class="mt-3 flex items-center">
                                                <label for="s_i_no" class="mb-0 w-1/3 ltr:mr-2 rtl:ml-2">Invoice Number<span style="color: #EB2D30">*</span></label>
                                                <input type="text" id="s_i_no" class="form-input flex-1" required='required' readonly="readonly" placeholder="" name="s_i_no" value="{{old('s_i_no')}}" autocomplete="off">
                                              
                                                @error('s_i_no')
                                                <small class='text-danger'>{{ $message }}</small>
                                              @enderror

                                                <div class="mt-4 flex items-center" style="display:none">
                                                  <label for="currency_id">Currency<span style="color: #EB2D30">*</span> </label>
                                                  <select id="currency_id" name="currency_id" class="form-input flex-1" >
                                                  <option  value="" selected>Select</option>
                                                      @foreach ($currency_lists as $row)
                                                          <option value="{{ $row->id; }}" {{ $row->id == 1 ? 'selected' : '' }}>{{ $row->code; }}</option>
                                                      @endforeach
                                                  </select>
                                               </div>
                                            </div>
</div>
                                        <div class="mb-6 w-full lg:w-1/2 ltr:lg:mr-6 ">
                                        
                                            <div class="mt-3 flex items-center">
                                                <label for="s_date" class="mb-0 w-1/3 ltr:mr-2 rtl:ml-2">Invoice Date<span style="color: #EB2D30">*</span></label>
                                                <input type="date" required='required' id="s_date" class="form-input flex-1"value="{{date('Y-m-d')}}" max='<?php echo date("Y-m-d"); ?>' placeholder="" name="s_date" autocomplete="off">
                                                @error('s_date')
                                                  <small class='text-danger'>{{ $message }}</small>
                                                @enderror
                                                
                                            </div>
                                            
                                       
                                    </div>
                                </div>
                             
                                
                                <div class="">
                                    <div class="flex flex-col justify-between lg:flex-row">
                                        <div class="mb-6 w-full lg:w-1/2 ltr:lg:mr-6 rtl:lg:ml-6">
                                        
                                            <div class="mt-4 flex items-center">
                                                <label for="customer_id" class="mb-0 w-1/5 ltr:mr-2 rtl:ml-2">Customer<span style="color: #EB2D30">*</span></label>
                                                  
                                              <select id="customer_id" name="customer_id" class="form-input flex-1"
                                              required='required'>
                                                                  <option  value="" selected>Select</option>
                                                                      @foreach ($customer_lists as $row)
                                                                          <option value="{{ $row->ledger_id; }}" {{ old('customer_id') == $row->ledger_id ? 'selected' : '' }}>{{ $row->customer_name; }}</option>
                                                                      @endforeach
                                                                  </select>
                                              @error('customer_id')
                                                <small class='text-danger'>{{ $message }}</small>
                                              @enderror



 <!-- large -->
 <div x-data="modal" >
                        <!-- button -->
                        <button type="button"  @click="toggle">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path d="M16 6C16 8.20914 14.2091 10 12 10C9.79086 10 8 8.20914 8 6C8 3.79086 9.79086 2 12 2C14.2091 2 16 3.79086 16 6Z" fill="#1C274C"/>
  <path opacity="0.5" d="M14.4774 21.9208C13.7513 21.9728 12.9296 22 12 22C4 22 4 19.9853 4 17.5C4 15.0147 7.58172 13 12 13C14.8806 13 17.4056 13.8564 18.8142 15.1412C18.298 15 17.5737 15 16.5 15C14.8501 15 14.0251 15 13.5126 15.5126C13 16.0251 13 16.8501 13 18.5C13 20.1499 13 20.9749 13.5126 21.4874C13.7501 21.725 14.0547 21.8524 14.4774 21.9208Z" fill="#1C274C"/>
  <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5 22C14.8501 22 14.0251 22 13.5126 21.4874C13 20.9749 13 20.1499 13 18.5C13 16.8501 13 16.0251 13.5126 15.5126C14.0251 15 14.8501 15 16.5 15C18.1499 15 18.9749 15 19.4874 15.5126C20 16.0251 20 16.8501 20 18.5C20 20.1499 20 20.9749 19.4874 21.4874C18.9749 22 18.1499 22 16.5 22ZM17.0833 16.9444C17.0833 16.6223 16.8222 16.3611 16.5 16.3611C16.1778 16.3611 15.9167 16.6223 15.9167 16.9444V17.9167H14.9444C14.6223 17.9167 14.3611 18.1778 14.3611 18.5C14.3611 18.8222 14.6223 19.0833 14.9444 19.0833H15.9167V20.0556C15.9167 20.3777 16.1778 20.6389 16.5 20.6389C16.8222 20.6389 17.0833 20.3777 17.0833 20.0556V19.0833H18.0556C18.3777 19.0833 18.6389 18.8222 18.6389 18.5C18.6389 18.1778 18.3777 17.9167 18.0556 17.9167H17.0833V16.9444Z" fill="#1C274C"/>
</svg>
                        </button>
                        
                        <!-- modal --> 
                        <div class="fixed inset-0 bg-[black]/60 z-[999]  hidden" :class="open && '!block'" id="customer_modal">
                            <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                                <div x-show="open" x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg overflow-hidden  w-full max-w-xl my-8">
                                    <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                                         <h5 class="font-bold text-lg text-center" style="font-weight:700; padding:2%; font-size:xx-large;">Customer</h5>
                                    </div>
                                    
                                    <div class="p-4">
                                        

                                    <!-- <form class="space-y-5"  id="add_customer" name="add_customer" action="#" method="POST" enctype="multipart/form-data">
					@csrf -->
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div>
						    <label for="customer_name">Name<span style="color: #EB2D30"></span> </label>
							<input type="text" id="customer_name" value="{{old('customer_name')}}"  class="form-input" placeholder="" name="customer_name" autocomplete="off">
										@error('customer_name')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
						</div>
            <div>
							<label for="mobile_no">Phone No</label>
							<input type="text" id="mobile_no" value="{{old('mobile_no')}}" class="form-input" placeholder="" name="mobile_no" autocomplete="off">
						</div>
						<div>
							<label for="Code">Code</label>
							<input type="text" id="code" value="{{old('code')}}" class="form-input" placeholder="" name="code" autocomplete="off">
						</div>
                        <div>
							<label for="Code">Email Id</label>
							<input type="email" id="email_id" value="{{old('email_id')}}" class="form-input" placeholder="" name="email_id" autocomplete="off">
						</div>
                       
					</div>

                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label for="gst_no">Gst No</label>
                        <input type="number" id="gst_no" value="{{old('gst_no')}}" class="form-input" placeholder="" name="gst_no" autocomplete="off">
                    </div>
                    <div>
                    <label for="gst_no">Credit Limit</label>
                        <input type="number" id="credit_limit" value="{{old('credit_limit')}}" class="form-input" placeholder="" name="credit_limit" autocomplete="off">
                    </div>
                    <div>
                    <label for="discount">Discount %</label>
                        <input type="number" id="discount" value="{{old('discount')}}" class="form-input" placeholder="" name="discount" autocomplete="off">
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div>
						    <label for="permenant_address">Permanent Address </label>
                            <textarea
                                            id="permenant_address"
                                            name="permenant_address"
                                            class="form-textarea min-h-[80px]"
                                            placeholder=""
                                           
                                        ></textarea>
						</div>
                        <div>
							<label for="contact_address">Contact Address</label>
                            <textarea
                                            id="contact_address"
                                            name="contact_address"
                                            class="form-textarea min-h-[80px]"
                                            placeholder=""
                                            
                                        ></textarea>
						</div>
						
                       
					</div>

					<div class="grid grid-cols-1 sm:grid-cols-6 gap-4">
                    <div>
							<label for="web_address">Web Address</label>
							<input type="text" id="web_address" value="{{old('web_address')}}" class="form-input" placeholder="" name="web_address" autocomplete="off">
						</div>
                        <div style="display:none">
						<label for="country">Country</label>
						<select id='country' name='country' class='form-input'>
											<option val=''>Select</option>
                                            @foreach ($currency_lists as $row)
                                                <option value="{{ $row->id; }}" {{ $row->id == 1 ? 'selected' : '' }}>{{ $row->code; }}</option>
                                            @endforeach
										</select>
					</div>

                    <div>
							<label for="remarks">Remarks</label>
                            <textarea
                                            id="remarks"
                                            name="remarks"
                                            class="form-textarea min-h-[80px]"
                                            placeholder=""
                                           
                                        >{{old('remarks')}}</textarea>
						</div>
					
					</div>
                   

   

				
						
              


                <div class="flex justify-end items-center mt-8">
                                            <button type="button" class="btn btn-outline-danger" @click="toggle">Discard</button>
                                            <button type="button" id="customer_btn" class="btn btn-primary ltr:ml-4 rtl:mr-4" @click="toggle">Save</button>
                                        </div>

  <!-- </form>  -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                                            </div>
                                            
                                            <!-- <div class="mt-4 flex items-center">
                                                <label for="reciever-email" class="mb-0 w-1/3 ltr:mr-2 rtl:ml-2">Email</label>
                                                <input
                                                    id="reciever-email"
                                                    type="email"
                                                    name="reciever-email"
                                                    class="form-input flex-1"
                                                    x-model="params.to.email"
                                                    placeholder="Enter Email"
                                                />
                                            </div> -->
                                           
                                            <!-- <div class="mt-4 flex items-center">
                                                <label for="reciever-number" class="mb-0 w-1/3 ltr:mr-2 rtl:ml-2">Pnone Number</label>
                                                <input
                                                    id="reciever-number"
                                                    type="text"
                                                    name="reciever-number"
                                                    class="form-input flex-1"
                                                    x-model="params.to.phone"
                                                    placeholder="Enter Phone Number"
                                                />
                                            </div> -->
                                        </div>
                                        <div class="w-full lg:w-1/2">
                                        <div class="mt-3 flex items-center">
                                                <label for="customer_address" class="mb-0 w-1/5 ltr:mr-2 rtl:ml-2">Address</label>
                                                <textarea
                                            id="customer_address"
                                            name="customer_address"
                                            class="form-textarea min-h-[80px] flex-1" readonly="readonly"
                                           
                                        ></textarea>
                                            </div>
                                           
                                            <div class="mt-4 flex items-center" style="display:none">
                                                <label for="sales_account_id" class="mb-0 w-1/3 ltr:mr-2 rtl:ml-2">Sales Account</label>
                                                <select id="sales_account_id" name="sales_account_id" class="form-input flex-1">
                                        <option  value="" selected>Select</option>
                                            @foreach ($s_a_lists as $row)
                                                <option value="{{ $row->id; }}" {{ $row->ledger == 'LOCAL SALES' ? 'selected' : '' }}>{{ $row->ledger; }}</option>
                                            @endforeach
                                        </select>
                                                
                                            </div>
                                            <!-- <div class="mt-4 flex items-center">
                                                <label for="bank-name" class="mb-0 w-1/3 ltr:mr-2 rtl:ml-2">Bank Name</label>
                                                <input
                                                    id="bank-name"
                                                    type="text"
                                                    name="bank-name"
                                                    class="form-input flex-1"
                                                    x-model="params.bankInfo.name"
                                                    placeholder="Enter Bank Name"
                                                />
                                            </div>
                                            <div class="mt-4 flex items-center">
                                                <label for="swift-code" class="mb-0 w-1/3 ltr:mr-2 rtl:ml-2">SWIFT Number</label>
                                                <input
                                                    id="swift-code"
                                                    type="text"
                                                    name="swift-code"
                                                    class="form-input flex-1"
                                                    x-model="params.bankInfo.swiftCode"
                                                    placeholder="Enter SWIFT Number"
                                                />
                                            </div>
                                            <div class="mt-4 flex items-center">
                                                <label for="iban-code" class="mb-0 w-1/3 ltr:mr-2 rtl:ml-2">IBAN Number</label>
                                                <input
                                                    id="iban-code"
                                                    type="text"
                                                    name="iban-code"
                                                    class="form-input flex-1"
                                                    x-model="params.bankInfo.ibanNo"
                                                    placeholder="Enter IBAN Number"
                                                />
                                            </div>
                                            <div class="mt-4 flex items-center">
                                                <label for="country" class="mb-0 w-1/3 ltr:mr-2 rtl:ml-2">Country</label>
                                                
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-8">
                                <table id="tbl_items">
                                            <thead>
                                                    <tr>
                                                        <th  style="font-weight:bold"class="text-center" width="50">Slno</th>
                                                        <th  style="font-weight:bold" class="text-center">Item</th>
                                                        <th   style="font-weight:bold"class="text-center">Unit</th>
                                                        <th   style="font-weight:bold"class="text-center">Quantity</th>
                                                        <th   style="font-weight:bold"class="text-center">W Amount</th>
                                                        <th  style="font-weight:bold"class="text-center">Gst</th>
                                                        <th  style="font-weight:bold"class="text-center">B Amount</th>
                                                        <th  style="font-weight:bold"class="text-center">Total</th>
                                                        <th   style="font-weight:bold"class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody">
                                                  <tr id="R1">
                                                    <td class="text-center" style=" padding: 0.35rem 0.2rem !important;"><h6>1</h6></td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;" width="200">
                                                      <select name="item_id[]" class="form-input s2" id="itemid1" onchange="return get_unit_of_item(1);"  required="required">
                                                              <option  value="" selected>Select</option>
                                                                @foreach ($pt_lists as $row): 
                                                                    <option value="{{ $row->id }}">{{ $row->product_name }}</option>
                                                                @endforeach
                                                     </select>
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="text" readonly="readonly" class="form-input" name="item_unit_name[]" autocomplete="off" id="item_unit_name1" required="required">
                                                      <input type="hidden" readonly="readonly" class="form-input" name="item_unit[]" autocomplete="off" id="item_unit1">
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input qty" name="qty[]" autocomplete="off" id="qty1"  step="0.00001"  oninput="calculate_q_a(1);" required="required">
                                                    </td>
                                                    
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input" name="white_amount[]" autocomplete="off" id="white_amount1"  step="0.00001"  oninput="calculate_all_amount(1);" required="required">
                                                      <input type="hidden" class="form-input white_amount" name="white_amount_qty[]" autocomplete="off" id="white_amount_qty1"  step="0.00001"    >
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input" name="gst[]" autocomplete="off" id="gst1"  step="0.00001"  oninput="calculate(1);" required="required">
                                                      <input type="hidden" class="form-input gst" name="gst_qty[]" autocomplete="off" id="gst_qty1"  step="0.00001"  >
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input" name="black_amount[]" autocomplete="off" id="black_amount1"  step="0.00001"  required="required">
                                                      <input type="hidden" class="form-input black_amount" name="black_amount_qty[]" autocomplete="off" id="black_amount_qty1"  step="0.00001"  >
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input amount" name="amount[]" autocomplete="off" id="amount1"  step="0.00001"   oninput="calculate(1);"  required="required">
                                                    </td>
                                                    <td class="text-center" style=" padding: 0.35rem 0.2rem !important;">
                                                      <button type="button" >

                                                      <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    width="24px"
                                                                    height="24px"
                                                                    viewBox="0 0 24 24"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    stroke-width="1.5"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    class="h-5 w-5"
                                                                >
                                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                                </svg>
                                                      </button>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                                <tfoot style="display:none;">
                                                  <tr>
                                                    <td colspan="3" class="text-right">Total</td>
													   <td><input type="number" class="form-input"  name="total_q" id="total_q" step="0.00001" value="0"></td>
													  <td><input type="number" class="form-input"  name="total_w" id="total_w" step="0.00001" value="0"></td>
                            <td><input type="number" class="form-input"  name="total_g" id="total_g" step="0.00001" value="0"></td>
                            <td><input type="number" class="form-input"  name="total_b" id="total_b" step="0.00001" value="0"></td>
                                                    <td><input type="number" class="form-input"  name="total" id="total" step="0.00001" value="0"></td>
                                                    
                                                  </tr>
                                                </tfoot>
                                           </table>
                                    <div class="mt-6 flex flex-col justify-between px-4 sm:flex-row">
                                        <div class="mb-6 sm:w-2/5">
                                            <button type="button" class="btn btn-primary" id="addBtn" onclick="return get_items_list_click_add_btn();">Add Item</button>
                                            <label for="narration" style="margin-top:6%">Remarks</label>
                                        
                                        <textarea
                                            id="narration"
                                            name="narration"
                                            class="form-textarea min-h-[80px]"
                                            placeholder="Notes...."
                                       
                                        ></textarea>
                                        </div>
                                        <div class="sm:w-2/5">
                                            <div class="flex items-center justify-between">
                                                <div>W Amount Total</div>
                                                <div id="w_amount_net_total_div">
                                                  <input type="text" readonly="readonly" name="w_amount_net_total" id="w_amount_net_total" value=0 class="form-input">
                                                </div>
                                            </div>
                                            <div class="mt-1 flex items-center justify-between">
                                                <div>Gst</div>
                                                <div id="gst_net_total_div">
                                                <input type="text" readonly="readonly" name="gst_net_total" id="gst_net_total" value=0 class="form-input">
                                                </div>
                                            </div>
                                            <div class="mt-1 flex items-center justify-between">
                                                <div>B Amount Total</div>
                                                <div id="b_amount_net_total_div">
                                                <input type="text" readonly="readonly" name="b_amount_net_total" id="b_amount_net_total" value=0 class="form-input">
                                                </div>
                                            </div>
                                          
                                            <div class="mt-1 flex items-center justify-between font-semibold">
                                                <div>Grand Total</div>
                                                <div id="g_amount_net_total_div">
                                                <input type="text" readonly="readonly" name="g_amount_net_total" id="g_amount_net_total" value=0 class="form-input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="mt-8 px-4">
                                    <div>
                                        
                                    </div>
                                </div> -->
                            
                           
                     
                   

                    <div class="row" style="margin-top: 3%;">
                  
                    <div class="col-sm-3"></div>
                    <div class="col-sm-3"></div>
                                                                <div class="col-sm-3"></div>
                    <div class="form-group col-sm-3">
                <button type="submit" id="submitButton" name="sbt" class="btn btn-success w-full gap-2" onclick="return check_fields();">
                                            <svg
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 ltr:mr-2 rtl:ml-2"
                                            >
                                                <path
                                                    d="M3.46447 20.5355C4.92893 22 7.28595 22 12 22C16.714 22 19.0711 22 20.5355 20.5355C22 19.0711 22 16.714 22 12C22 11.6585 22 11.4878 21.9848 11.3142C21.9142 10.5049 21.586 9.71257 21.0637 9.09034C20.9516 8.95687 20.828 8.83317 20.5806 8.58578L15.4142 3.41944C15.1668 3.17206 15.0431 3.04835 14.9097 2.93631C14.2874 2.414 13.4951 2.08581 12.6858 2.01515C12.5122 2 12.3415 2 12 2C7.28595 2 4.92893 2 3.46447 3.46447C2 4.92893 2 7.28595 2 12C2 16.714 2 19.0711 3.46447 20.5355Z"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                />
                                                <path
                                                    d="M17 22V21C17 19.1144 17 18.1716 16.4142 17.5858C15.8284 17 14.8856 17 13 17H11C9.11438 17 8.17157 17 7.58579 17.5858C7 18.1716 7 19.1144 7 21V22"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                />
                                                <path opacity="0.5" d="M7 8H13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                            </svg>
                                            Save
                                        </button>
										
									</div>
                  
								
                    </div>
                                                                
                    </div>                                            
								
                  
                    
                </form> 
	
                        </div>

                    <!-- end main content section -->


@endsection
@section('scripts')
<script>
  function get_remarks(){
    order_no = $("#order_no").val();
    $.ajax({
				url: '{{route('get_batch_nos_from_order_no_account')}}',
				type: 'GET',
				data: {order_no: order_no},
				success: function(data) {
          var narration = "";
          $.each(data.batch_nos, function(key, value) {
    if (narration !== "") {
        narration += ", "; // Add a comma and space before adding the next batch number
    }
    narration += value.batch_no;
});

$('#narration').text(narration);


				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
        get_details_frommeasurement_form();
  }
  function get_details_frommeasurement_form(){
    order_no = $("#order_no").val();
    $.ajax({
				url: '{{route('get_details_from_measurement_form_account')}}',
				type: 'GET',
				data: {order_no: order_no},
				success: function(data) {
          
          var fittingOrPacking = data.result.fitting_or_packing;
          var customer_ledger_id = data.result.ledger_id;
          var customer_address = data.result.permenant_address;
// Set the selected option in the dropdown
$('#fitting_or_packing').val(fittingOrPacking);
$('#customer_id').val(customer_ledger_id);
$('#customer_address').text(customer_address);


get_tbl_creation(order_no);


				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
  }

function get_tbl_creation(order_no){

  $.ajax({
				url: '{{route('get_m_items_for_sales_account')}}',
				type: 'GET',
				data: {order_no: order_no},
				success: function(data) {
          
          m_i_lists = data.m_items_lists;
          $('#tbl_items tbody').empty();
          var rowIdx = 0;
                        $.each(m_i_lists, function(key, value) {
                           


                          $('#tbody').append(`<tr id="R${++rowIdx}"><td class="text-center" style=" padding: 0.35rem 0.2rem !important;">${rowIdx}</td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;" width="200">
                                                      <select name="item_id[]" class="form-input s2"  id="itemid${rowIdx}" onchange="return get_unit_of_item(${rowIdx});" >
                                                              <option  value="" selected>Select</option>
                                                              @foreach ($pt_lists as $row): 
                                                                    <option value="{{ $row->id }}">{{ $row->product_name }}</option>
                                                                @endforeach
                                                     </select>
                                                    </td>
                                                     <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="hidden" readonly="readonly" class="form-input" name="item_unit[]" autocomplete="off" id="item_unit${rowIdx}">
                                                      <input type="text" readonly="readonly" class="form-input" name="item_unit_name[]" autocomplete="off" id="item_unit_name${rowIdx}">
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input qty" name="qty[]" id="qty${rowIdx}" autocomplete="off"  step="0.00001"  oninput="calculate_q_a(${rowIdx});">
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input" name="white_amount[]" autocomplete="off" id="white_amount${rowIdx}"  step="0.00001" oninput="calculate_all_amount(${rowIdx});" >
                                                      <input type="hidden" class="form-input white_amount" name="white_amount_qty[]" autocomplete="off" id="white_amount_qty${rowIdx}"  step="0.00001">
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input" name="gst[]" autocomplete="off" id="gst${rowIdx}"  step="0.00001" oninput="calculate(${rowIdx});" >
                                                      <input type="hidden" class="form-input gst" name="gst_qty[]" autocomplete="off" id="gst_qty${rowIdx}"  step="0.00001"  >
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input" name="black_amount[]" autocomplete="off" id="black_amount${rowIdx}"  step="0.00001" >
                                                      <input type="hidden" class="form-input black_amount" name="black_amount_qty[]" autocomplete="off" id="black_amount_qty${rowIdx}"  step="0.00001">
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input amount" name="amount[]" id="amount${rowIdx}" autocomplete="off"  oninput="calculate(${rowIdx});" step="0.00001"   >
                                                    </td>
                                                    <td class="text-center" style=" padding: 0.35rem 0.2rem !important;">
                                                    <button type="button" class="remove" >

<svg
              xmlns="http://www.w3.org/2000/svg"
              width="24px"
              height="24px"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.5"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="h-5 w-5"
          >
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
</button>
                                                    </td>
                                                  </tr>`);
                   


                                              if(value.order_type == 'Door With Frame'){
                                                    $('#itemid'+rowIdx).val(13);
                                                  }
                                                  else if(value.order_type == 'Door Only'){
                                                    $('#itemid'+rowIdx).val(14);
                                                  }
                                                  else if(value.order_type == 'Door Only Without Clearence'){
                                                    $('#itemid'+rowIdx).val(16);
                                                  }
                                                  else{
                                                    $('#itemid'+rowIdx).val(15);
                                                  }
                                                  $('select').select2({
                                                    placeholder: "Select",
                                                    allowClear: true
                                                    });
                                                  get_unit_of_item(rowIdx);

                        });


				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
     
}



  function get_order_no(){
    sale_type = $("#sale_type").val();
    $.ajax({
				url: '{{route('get_order_no_account')}}',
				type: 'GET',
				data: {sale_type: sale_type},
				success: function(data) {
          $('#s_i_no').val(data.r_no);


				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
  }
</script>
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
$(document).ready(function(){
  $("#customer_id").change(function(){
    customer_id = $("#customer_id").val();
    $.ajax({
				url: '{{route('get_address_account')}}',
				type: 'GET',
				data: {customer_id: customer_id},
				success: function(data) {
          $('#customer_address').text(data.customer_address);


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
  $("#customer_btn").click(function(){
    customer_name = $("#customer_name").val();
    mobile_no = $("#mobile_no").val();
    code = $("#code").val();
    email_id = $("#email_id").val();
    gst_no = $("#gst_no").val();
    credit_limit = $("#credit_limit").val();
    discount = $("#discount").val();
    permenant_address = $("#permenant_address").val();
    contact_address = $("#contact_address").val();
    web_address = $("#web_address").val();
    remarks = $("#remarks").val();
    country = $("#country").val();


    $.ajax({
				url: '{{route('save_customer_details_account')}}',
				type: 'GET',
				data: {customer_name: customer_name,mobile_no: mobile_no,code: code,email_id: email_id,gst_no: gst_no,credit_limit: credit_limit,discount: discount,permenant_address: permenant_address,contact_address: contact_address,web_address:web_address,remarks:remarks,country:country},
				success: function(data) {
         // $('#customer_address').text(data.customer_address);
        
                   $("#customer_name").val('');
                   $("#mobile_no").val('');
                   $("#code").val('');
                   $("#email_id").val('');
                   $("#gst_no").val('');
                   $("#credit_limit").val('');
                   $("#discount").val('');
                   $("#permenant_address").val('');
                   $("#contact_address").val('');
                   $("#web_address").val('');
                   $("#remarks").val('');
                   $("#country").val('');
                   get_customer_list();

				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
  });
});
</script>
<script>
  function get_customer_list(){
    $.ajax({
				url: '{{route('get_customer_list_account')}}',
				success: function(data) {
         cs_list = data.customer_lists;
          $('#customer_id').empty();
                    $('#customer_id').append('<option value=" ">Select</option>');
                        $.each(cs_list, function(key, value) {
                            $('#customer_id').append('<option value="'+ value.ledger_id +'">'+ value.customer_name  +'</option>');
                        });


				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
  }
</script>




<!--for item grid-->
<script>
    $(document).ready(function () {
     
      // Denotes total number of rows
      var rowIdx = 1;
  
      // jQuery button click event to add a row
      $('#addBtn').on('click', function () {
  		
        // Adding a row inside the tbody.
        $('#tbody').append(`<tr id="R${++rowIdx}"><td class="text-center" style=" padding: 0.35rem 0.2rem !important;">${rowIdx}</td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;" width="200">
                                                      <select name="item_id[]" class="form-input s2"  id="itemid${rowIdx}" onchange="return get_unit_of_item(${rowIdx});" >
                                                              <option  value="" selected>Select</option>
                                                              @foreach ($pt_lists as $row): 
                                                                    <option value="{{ $row->id }}">{{ $row->product_name }}</option>
                                                                @endforeach
                                                     </select>
                                                  
                                                    </td>
                                                     <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="hidden" readonly="readonly" class="form-input" name="item_unit[]" autocomplete="off" id="item_unit${rowIdx}">
                                                      <input type="text" readonly="readonly" class="form-input" name="item_unit_name[]" autocomplete="off" id="item_unit_name${rowIdx}">
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input qty" name="qty[]" id="qty${rowIdx}" autocomplete="off"  step="0.00001"  oninput="calculate_q_a(${rowIdx});">
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input" name="white_amount[]" autocomplete="off" id="white_amount${rowIdx}"  step="0.00001" oninput="calculate_all_amount(${rowIdx});" >
                                                      <input type="hidden" class="form-input white_amount" name="white_amount_qty[]" autocomplete="off" id="white_amount_qty${rowIdx}"  step="0.00001">
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input" name="gst[]" autocomplete="off" id="gst${rowIdx}"  step="0.00001" oninput="calculate(${rowIdx});" >
                                                      <input type="hidden" class="form-input gst" name="gst_qty[]" autocomplete="off" id="gst_qty${rowIdx}"  step="0.00001"  >
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input" name="black_amount[]" autocomplete="off" id="black_amount${rowIdx}"  step="0.00001"  >
                                                      <input type="hidden" class="form-input black_amount" name="black_amount_qty[]" autocomplete="off" id="black_amount_qty${rowIdx}"  step="0.00001">
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input amount" name="amount[]" id="amount${rowIdx}" autocomplete="off" oninput="calculate(${rowIdx});"  step="0.00001"   >
                                                    </td>
                                                    <td class="text-center" style=" padding: 0.35rem 0.2rem !important;">
                                                    <button type="button" class="remove" >

<svg
              xmlns="http://www.w3.org/2000/svg"
              width="24px"
              height="24px"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="1.5"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="h-5 w-5"
          >
              <line x1="18" y1="6" x2="6" y2="18"></line>
              <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
</button>
                                                    </td>
                                                  </tr>`);
		  

      });
  
      // jQuery button click event to remove a row.
      $('#tbody').on('click', '.remove', function () {
  
        // Getting all the rows next to the row
        // containing the clicked button
        var child = $(this).closest('tr').nextAll();
  
        // Iterating across all the rows 
        // obtained to change the index
        child.each(function () {
  
          // Getting <tr> id.
          var id = $(this).attr('id');
  
          // Getting the <p> inside the .row-index class.
          var idx = $(this).children('.row-index').children('p');
  
          // Gets the row number from <tr> id.
          var dig = parseInt(id.substring(1));
  
          // Modifying row index.
          idx.html(`Row ${dig - 1}`);
  
          // Modifying row id.
          $(this).attr('id', `R${dig - 1}`);
        });
  
        // Removing the current row.
        $(this).closest('tr').remove();
        calculate_remove();
        // Decreasing total number of rows by 1.
        var rowIdx = $('#tbody tr').length;
      });
    });
  </script> 
  <script>
  function calculate_remove(){
    var sum = 0;
  $(".amount").each(function(){
   // sum += parseFloat($(this).val());
   var inputValue = $(this).val();
   if (inputValue !== null && $.isNumeric(inputValue)) {
    sum += parseFloat(inputValue);
  } 
  });
  $('#total').val(sum.toFixed(3));

  var sum_w = 0;
  $(".white_amount").each(function(){
    //sum_w += parseFloat($(this).val());
    var inputValue = $(this).val();
    if (inputValue !== null && $.isNumeric(inputValue)) {
      sum_w += parseFloat(inputValue);
  } 
  });
  $('#total_w').val(sum_w.toFixed(3));

  var sum_g = 0;
  $(".gst").each(function(){
    // sum_g += parseFloat($(this).val());
    var inputValue = $(this).val();
    if (inputValue !== null && $.isNumeric(inputValue)) {
      sum_g += parseFloat(inputValue);
  } 
  });
  $('#total_g').val(sum_g.toFixed(3));

  var sum_b = 0;
  $(".black_amount").each(function(){
   // sum_b += parseFloat($(this).val());
   var inputValue = $(this).val();
    if (inputValue !== null && $.isNumeric(inputValue)) {
      sum_b += parseFloat(inputValue);
  } 
  });
  $('#total_b').val(sum_b.toFixed(3));


  var sum_qty = 0;
  $(".qty").each(function(){
    //sum_qty += parseFloat($(this).val());
    var inputValue = $(this).val();
    if (inputValue !== null && $.isNumeric(inputValue)) {
      sum_qty += parseFloat(inputValue);
  } 
  });
  
  $("#w_amount_net_total").val(sum_w.toFixed(2));
  $("#b_amount_net_total").val(sum_b.toFixed(2));
  $("#gst_net_total").val(sum_g.toFixed(2));
  $("#g_amount_net_total").val(sum.toFixed(2));
  }
  </script>
  <!-- calculate total dynamically change values-->
  <script type="text/javascript">
    function calculate_all_amount(rowid){
      white_amount = $('#white_amount'+rowid).val();
      gst = parseFloat(white_amount) * 18;
      total_gst = parseFloat(gst) / 100;
      $('#gst'+rowid).val(total_gst.toFixed(3));
      calculate(rowid);
    }
    function calculate(rowid){
      var total = $('#total').val();
      qty = $('#qty'+rowid).val();
      white_amount = $('#white_amount'+rowid).val();
      gst = $('#gst'+rowid).val();
      black_amount = $('#black_amount'+rowid).val();
      amnt = $('#amount'+rowid).val();
      
      if (qty === "") {
      qty = 0;
    }
    if (gst === "") {
      gst = 0;
    }
      if (white_amount === "") {
     white_amount = 0;
    }
    if (black_amount === "") {
      black_amount = 0;
    }

       sum = parseFloat(white_amount) + parseFloat(gst) + parseFloat(black_amount);
       //result = parseFloat(qty) *parseFloat(sum);

       sum_black_amnt = parseFloat(amnt) - parseFloat(white_amount) - parseFloat(gst);

      // $('#amount'+rowid).val(result.toFixed(3));

       waq = parseFloat(qty) * parseFloat(white_amount);
       gsq = parseFloat(qty) * parseFloat(gst);
       
       $('#white_amount_qty'+rowid).val(waq.toFixed(3));
       $('#gst_qty'+rowid).val(gsq.toFixed(3));
       

       $('#black_amount'+rowid).val(sum_black_amnt.toFixed(3));
       baq = parseFloat(qty) * parseFloat(sum_black_amnt);
       $('#black_amount_qty'+rowid).val(baq.toFixed(3));
       
       var sum = 0;
  $(".amount").each(function(){
   // sum += parseFloat($(this).val());
   var inputValue = $(this).val();
   if (inputValue !== null && $.isNumeric(inputValue)) {
    sum += parseFloat(inputValue);
  } 
  });
  $('#total').val(sum.toFixed(3));

  var sum_w = 0;
  $(".white_amount").each(function(){
    //sum_w += parseFloat($(this).val());
    var inputValue = $(this).val();
    if (inputValue !== null && $.isNumeric(inputValue)) {
      sum_w += parseFloat(inputValue);
  } 
  });
  $('#total_w').val(sum_w.toFixed(3));

  var sum_g = 0;
  $(".gst").each(function(){
    // sum_g += parseFloat($(this).val());
    var inputValue = $(this).val();
    if (inputValue !== null && $.isNumeric(inputValue)) {
      sum_g += parseFloat(inputValue);
  } 
  });
  $('#total_g').val(sum_g.toFixed(3));

  var sum_b = 0;
  $(".black_amount").each(function(){
   // sum_b += parseFloat($(this).val());
   var inputValue = $(this).val();
    if (inputValue !== null && $.isNumeric(inputValue)) {
      sum_b += parseFloat(inputValue);
  } 
  });
  $('#total_b').val(sum_b.toFixed(3));


  var sum_qty = 0;
  $(".qty").each(function(){
    //sum_qty += parseFloat($(this).val());
    var inputValue = $(this).val();
    if (inputValue !== null && $.isNumeric(inputValue)) {
      sum_qty += parseFloat(inputValue);
  } 
  });

  
  $("#w_amount_net_total").val(sum_w.toFixed(2));
  $("#b_amount_net_total").val(sum_b.toFixed(2));
  $("#gst_net_total").val(sum_g.toFixed(2));
  $("#g_amount_net_total").val(sum.toFixed(2));

    }
  </script>
  <!-- calculate total of qunatity dynamically change values-->
	<script>
		function calculate_q_a(rowid){
			calculate(rowid);
			
			  var total_q = $('#total_q').val();
      qty = $('#qty'+rowid).val();
       

var sum_q = 0;
  $(".qty").each(function(){
    sum_q += parseFloat($(this).val());
  });


       $('#total_q').val(sum_q.toFixed(3));
		}
	</script>
    <!--for get unit of item based on selection of item-->
  <script type="text/javascript">
    function get_unit_of_item(row_id){
      
      item_id = $("#itemid"+row_id).val();
      var rw = row_id;

      $.ajax({
				url: '{{route('get_unit_of_item_account')}}',
				type: 'GET',
				data: {item_id: item_id},
				success: function(data) {
					$("#item_unit"+row_id).val(data.unit_id);
          $("#item_unit_name"+row_id).val(data.unit_name);
          return get_avilable_stock(rw);

				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});

 
}
  </script>

  <!-- get avilabel stock by item id and warehouse id -->
<script>
	function get_avilable_stock(row_id){
		
		 item_id = $("#itemid"+row_id).val();
		 w_id = $("#warehouse_id").val();
		var length_of_tr = $('#tbody tr').length;
		var ln =  parseFloat(length_of_tr) - 1;
		
    $.ajax({
				url: '{{route('get_avilable_stock_account')}}',
				type: 'GET',
				data: {item_id: item_id,w_id:w_id},
				success: function(data) {
          if(data.result=='success')
                {
                  
                 
                  $('#a_st'+row_id).val(data.total.toFixed(3));
                  

            
              
            for(var i =1;  i < length_of_tr; i++){
              p_id = $("#itemid"+i).val();
              if(row_id == i){
                
              }
              else{
                if(item_id == p_id){
                  qty = $("#qty"+i).val();
                  a_s = $('#a_st'+i).val();
                  
                  g_s = parseFloat(a_s) - parseFloat(qty);
                
                $('#a_st'+row_id).val(g_s);
                  
              }
              }
              
	        	}
					
					
					
                }


				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});

		
	}
</script>


  <!-- get list of items by warehouse id-->
<script>
 function get_items_list(){
	 w_id = $("#warehouse_id").val();

   var rowId = $('#tbody tr').length;

     $.ajax({
				url: '{{route('list_of_products_account')}}',
				type: 'GET',
				data: {w_id: w_id},
				success: function(data) {
                    //$('.itm_id').empty();
                        $.each(data, function(key, value) {
                            $('#itemid'+rowId).append('<option value="'+ value.id +'">'+ value.product_name  +'</option>');
                        });

				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
 }
</script>

  <!-- get list of items by warehouse id-->
  <script>
 function get_items_list_click_add_btn(){
	 w_id = $("#warehouse_id").val();

   var rowIdx = $('#tbody tr').length;
   var rowId = parseFloat(rowIdx) + 1;

     $.ajax({
				url: '{{route('list_of_products_account')}}',
				type: 'GET',
				data: {w_id: w_id},
				success: function(data) {
                    //$('.itm_id').empty();
                        $.each(data, function(key, value) {
                            $('#itemid'+rowId).append('<option value="'+ value.id +'">'+ value.product_name  +'</option>');
                        });

				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
 }
</script>
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
        const myForm = document.getElementById('add_sales_invoice');

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
<script>
  function check_fields() {
    // Get values of specific fields
    var s_i_no = $('#s_i_no').val();
    var s_date = $('#s_date').val();
    var customer_id = $('#customer_id').val();

    // Flag to check if any row field is empty
    var isAnyRowEmpty = false;

    // Check each row in the tbody
    $('#tbody tr').each(function () {
      // Check if any field in the row is null or empty
      var isRowEmpty = $(this).find('select, input').filter(function () {
        return !$(this).val();
      }).length > 0;

      if (isRowEmpty) {
        isAnyRowEmpty = true;
        // Optionally, you can display an alert or perform other actions
        //alert('Please fill in all fields for each row before submitting.');
        return false; // Exit the loop early
      }
    });

    // Check if any row field is empty or if specific fields are not empty
    if (!isAnyRowEmpty && s_i_no.trim() !== "" && s_date.trim() !== "" && customer_id.trim() !== "") {
      // All conditions are met, you can proceed with your logic here
      return true;
    } else {
      alert('Please fill in all fields.');
      return false; // Prevent the form submission
    }
  }
</script>
@endsection