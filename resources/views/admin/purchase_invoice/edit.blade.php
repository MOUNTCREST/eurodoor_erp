
@extends('admin.layouts.app')

@section('content')
<!-- start main content section -->
<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Purchase Invoice</h5>
<div x-data="invoiceAdd" class="pX-5 panel w-full">
  <form class="form-horizontal"  id="edit_purchase_invoice" name="edit_purchase_invoice" action="{{ route('purchase_invoice_update',$result->account_id) }}" method="POST" enctype="multipart/form-data">
		@csrf
    <div class="mt-8 px-4">
    <div class="flex flex-col justify-between lg:flex-row">
                                        <div class="mb-6 w-full lg:w-1/2 ltr:lg:mr-6 ">
                                        
                                            <div class="mt-3 flex items-center">
                                                <label for="ref_no" class="mb-0 w-1/3 ltr:mr-2 rtl:ml-2">Reference No</label>
                                                <input type="text" id="ref_no" value="{{$result->ref_no}}" class="form-input flex-1" readonly="readonly" placeholder="" name="ref_no" autocomplete="off">
                                              
                                              </div>  
                                              
                                        
                                           
                                        </div>
                                        <div class="mb-6 w-full lg:w-1/2 ltr:lg:mr-6">
                                        <div class="mt-3 flex items-center">
                                                <label for="p_i_no" class="mb-0 w-1/3 ltr:mr-2 rtl:ml-2">Invoice Number<span style="color: #EB2D30">*</span></label>
                                                <input type="text" id="p_i_no" value="{{$result->p_i_no}}"  class="form-input flex-1"  placeholder="" name="p_i_no" autocomplete="off">
                                              
                                                @error('p_i_no')
                                                <small class='text-danger'>{{ $message }}</small>
                                              @enderror

                                                <div class="mt-4 flex items-center" style="display:none">
                                                  <label for="currency_id">Currency<span style="color: #EB2D30">*</span> </label>
                                                  <select id="currency_id" name="currency_id" class="form-input flex-1" >
                                                  <option  value="" selected>Select</option>
                                                      @foreach ($currency_lists as $row)
                                                          <option value="{{ $row->id; }}" {{ $row->id == $result->currency_id ? 'selected' : '' }}>{{ $row->code; }}</option>
                                                      @endforeach
                                                  </select>
                                               </div>
                                            </div>
</div>
                                        <div class="mb-6 w-full lg:w-1/2 ltr:lg:mr-6 ">
                                        
                                            <div class="mt-3 flex items-center">
                                                <label for="p_date" class="mb-0 w-1/3 ltr:mr-2 rtl:ml-2">Invoice Date<span style="color: #EB2D30">*</span></label>
                                                <input type="date" id="p_date" value="{{$result->p_date}}" max='<?php echo date("Y-m-d"); ?>'  class="form-input flex-1" placeholder="" name="p_date" autocomplete="off">
                                  @error('p_date')
                                    <small class='text-danger'>{{ $message }}</small>
                                  @enderror
                                                
                                            </div>
                                            
                                       
                                    </div>
                                </div>
                                <!-- <hr class="my-6 border-[#e0e6ed] dark:border-[#1b2e4b]" /> -->
                                <div class="">
                               

                                    <div class="flex flex-col justify-between lg:flex-row">
                                        <div class="mb-6 w-full lg:w-1/2 ltr:lg:mr-6 rtl:lg:ml-6">
                                        
                                            <div class="mt-4 flex items-center">
                                                <label for="supplier_id" class="mb-0 w-1/5 ltr:mr-2 rtl:ml-2">Supplier<span style="color: #EB2D30">*</span></label>
                                                  
                                              <select id="supplier_id" name="supplier_id" class="form-input flex-1"
                                                                            >
                                                                  <option  value="" selected>Select</option>
                                                                      @foreach ($supplier_lists as $row)
                                                                      <option value="{{ $row->ledger_id; }}" {{ $row->ledger_id == $result->supplier_id ? 'selected' : '' }}>{{ $row->supplier_name; }}</option>
                                                                      @endforeach
                                                                  </select>
                                              @error('supplier_id')
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
                    
                        <!-- <button type="button" class="btn btn-secondary" @click="toggle">Add</button> -->
                        
                        <!-- modal --> 
                        <div class="fixed inset-0 bg-[black]/60 z-[999]  hidden" :class="open && '!block'" id="customer_modal">
                            <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                                <div x-show="open" x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg overflow-hidden  w-full max-w-xl my-8">
                                    <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-1">
                                        <h5 class="font-bold text-lg text-center" style="font-weight:700; padding:2%; font-size:xx-large;">Supplier</h5>
                                    </div>
                                    
                                    <div class="p-4">
                                        

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div>
						    <label for="supplier_name">Name<span style="color: #EB2D30">*</span> </label>
							<input type="text" id="supplier_name" value="{{old('supplier_name')}}"  class="form-input" placeholder="" name="supplier_name" autocomplete="off">
										@error('supplier_name')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
						</div>
                        <div>
							<label for="mobile_no">Phone No<span style="color: #EB2D30">*</span> </label>
							<input type="text" id="mobile_no" value="{{old('mobile_no')}}" class="form-input" placeholder="" name="mobile_no" autocomplete="off">
						</div>
						<!-- <div>
							<label for="Code">Code</label>
							<input type="text" id="code" value="{{old('code')}}" class="form-input" placeholder="" name="code" autocomplete="off">
						</div> -->
           
                        <div>
							<label for="Code">Email Id</label>
							<input type="email" id="email_id" value="{{old('email_id')}}" class="form-input" placeholder="" name="email_id" autocomplete="off">
						</div>
            <div>
							<label for="web_address">Web Address</label>
							<input type="text" id="web_address" value="{{old('web_address')}}" class="form-input" placeholder="" name="web_address" autocomplete="off">
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
						    <label for="permenant_address">Permanent Address <span style="color: #EB2D30">*</span> </label>
                            <textarea
                                            id="permenant_address"
                                            name="permenant_address"
                                            class="form-textarea min-h-[80px]"
                                            placeholder=""
                                            x-model="params.notes"
                                        ></textarea>
						</div>
                        <div>
							<label for="contact_address">Contact Address</label>
                            <textarea
                                            id="contact_address"
                                            name="contact_address"
                                            class="form-textarea min-h-[80px]"
                                            placeholder=""
                                            x-model="params.notes"
                                        ></textarea>
						</div>
						
                       
					</div>

					<div class="grid grid-cols-1 sm:grid-cols-6 gap-4">
                    
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
                                            x-model="params.notes"
                                        ></textarea>
						</div>
					
					</div>
              


                <div class="flex justify-end items-center mt-8">
                                            <button type="button" class="btn btn-outline-danger" @click="toggle">Discard</button>
                                            <button type="button" id="supplier_btn" class="btn btn-primary ltr:ml-4 rtl:mr-4" @click="toggle">Save</button>
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
                                                <label for="supplier_address" class="mb-0 w-1/5 ltr:mr-2 rtl:ml-2">Address</label>
                                                <textarea
                                            id="supplier_address"
                                            name="supplier_address"
                                            class="form-textarea min-h-[80px] flex-1" readonly="readonly"
                                           
                                        >{{$result->permenant_address;}}</textarea>
                                            </div>
                                            <div class="mt-4 flex items-center" style="display:none">
                                                <label for="purchase_account_id" class="mb-0 w-1/3 ltr:mr-2 rtl:ml-2">Purchase Account</label>
                                                <select id="purchase_account_id" name="purchase_account_id" class="form-input flex-1">
                                        <option  value="" selected>Select</option>
                                            @foreach ($p_a_lists as $row)
                                            <option value="{{ $row->id; }}"  {{ $row->id == $result->purchase_account_id ? 'selected' : '' }}>{{ $row->ledger; }}</option>
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
                                                @foreach($p_items as $p_item)
                                                  <tr id="R{{$no++}}">
                                                    <td class="text-center" style=" padding: 0.35rem 0.2rem !important;"><h6>{{$no}}</h6></td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;" width="200">
                                                      <select name="item_id[]" class="form-input s2" id="itemid{{$no}}" onchange="return get_unit_of_item({{$no}});"  required="required">
                                                              <option  value="" selected>Select</option>
                                                                @foreach ($pt_lists as $row): 
                                                                    <option value="{{ $row->id }}" {{ $row->id == $p_item->item_id ? 'selected' : '' }}>{{ $row->product_name }}</option>
                                                                @endforeach
                                                     </select>
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="text" readonly="readonly" class="form-input" name="item_unit_name[]" value="{{$p_item->unit_name}}" autocomplete="off" id="item_unit_name{{$no}}" required="required">
                                                      <input type="hidden" readonly="readonly" class="form-input" value="{{$p_item->item_unit}}" name="item_unit[]" autocomplete="off" id="item_unit{{$no}}">
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input qty" name="qty[]" autocomplete="off" id="qty{{$no}}" value="{{$p_item->qty}}" step="0.00001"  oninput="calculate_q_a({{$no}});" required="required">
                                                    </td>
                                                    
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input" name="white_amount[]" autocomplete="off" id="white_amount{{$no}}"  step="0.00001"  value="{{$p_item->white_amount}}" oninput="calculate({{$no}});" required="required">
                                                      <input type="hidden" class="form-input white_amount" name="white_amount_qty[]" autocomplete="off" id="white_amount_qty{{$no}}"  step="0.00001"  value="{{$p_item->qty * $p_item->white_amount }}"  >
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input" name="gst[]" autocomplete="off" id="gst{{$no}}"  step="0.00001"  value="{{$p_item->gst}}" oninput="calculate({{$no}});" required="required">
                                                      <input type="hidden" class="form-input gst" name="gst_qty[]" autocomplete="off" id="gst_qty{{$no}}"  step="0.00001"  value="{{$p_item->qty * $p_item->gst }}" >
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input" name="black_amount[]" autocomplete="off" id="black_amount{{$no}}"  step="0.00001"  value="{{$p_item->black_amount}}" oninput="calculate({{$no}});" required="required">
                                                      <input type="hidden" class="form-input black_amount" name="black_amount_qty[]" autocomplete="off" id="black_amount_qty{{$no}}"  step="0.00001"  value="{{$p_item->qty * $p_item->black_amount }}" >
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input amount" name="amount[]" autocomplete="off" id="amount{{$no}}"  step="0.00001"   value="{{$p_item->amount}}" required="required">
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
                                                  </tr>
                                                  @endforeach
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
                                            class="form-textarea min-h-[80px] w-96"
                                            placeholder="Notes...."
                                       
                                        >{{ $result->narration }}</textarea>
                                          </div>

                                        
                                        <div class="sm:w-2/5">
                                            <div class="flex items-center justify-between">
                                                <div>W Amount Total</div>
                                                <div id="w_amount_net_total_div">
                                                <input type="text" readonly="readonly" name="w_amount_net_total" id="w_amount_net_total" value="{{$result->w_a_total}}" class="form-input">
                                                </div>
                                            </div>
                                            <div class="mt-1 flex items-center justify-between">
                                                <div>Gst</div>
                                                <div id="gst_net_total_div">
                                                <input type="text" readonly="readonly" name="gst_net_total" id="gst_net_total" value="{{$result->gst_total}}" class="form-input">
                                                </div>
                                            </div>
                                            <div class="mt-1 flex items-center justify-between">
                                                <div>B Amount Total</div>
                                                <div id="b_amount_net_total_div">
                                                <input type="text" readonly="readonly" name="b_amount_net_total" id="b_amount_net_total" value="{{$result->b_a_total}}" class="form-input">
                                                </div>
                                            </div>
                                          
                                            <div class="mt-1 flex items-center justify-between font-semibold">
                                                <div>Grand Total</div>
                                                <div id="g_amount_net_total_div">
                                                <input type="text" readonly="readonly" name="g_amount_net_total" id="g_amount_net_total" value="{{$result->total}}" class="form-input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            
                           
                     
                   

                    <div class="row" style="margin-top: 3%;">
                   
                  
                  <div class="form-group col-sm-2">
               
                  </div>
						
									<div class="form-group col-sm-2">
                 
										
									</div>
                  <div class="form-group col-sm-2">
                  
                                                                </div>
                                                                <div class="col-sm-3"></div>
                                                                <div class="form-group col-sm-3">
                <button type="submit" name="sbt" id="submitButton" class="btn btn-success w-full gap-2" onclick="return check_fields();">
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
                                            Update
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
  $("#supplier_id").change(function(){
    supplier_id = $("#supplier_id").val();
    $.ajax({
				url: '{{route('get_supplier_address')}}',
				type: 'GET',
				data: {supplier_id: supplier_id},
				success: function(data) {
          $('#supplier_address').text(data.supplier_address);


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
  $("#supplier_btn").click(function(){
    supplier_name = $("#supplier_name").val();
    mobile_no = $("#mobile_no").val();

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
				url: '{{route('save_supplier_details')}}',
				type: 'GET',
				data: {supplier_name: supplier_name,mobile_no: mobile_no,email_id: email_id,gst_no: gst_no,credit_limit: credit_limit,discount: discount,permenant_address: permenant_address,contact_address: contact_address,web_address:web_address,remarks:remarks,country:country},
				success: function(data) {
         // $('#customer_address').text(data.customer_address);
        
                   $("#supplier_name").val('');
                   $("#mobile_no").val('');
                  
                   $("#email_id").val('');
                   $("#gst_no").val('');
                   $("#credit_limit").val('');
                   $("#discount").val('');
                   $("#permenant_address").val('');
                   $("#contact_address").val('');
                   $("#web_address").val('');
                   $("#remarks").val('');
                   $("#country").val('');
                   get_supplier_list();

				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
  });
});
</script>
<script>
  function get_supplier_list(){
    $.ajax({
				url: '{{route('get_supplier_list')}}',
				success: function(data) {
         splr_list = data.supplier_lists;
          $('#supplier_id').empty();
                    $('#supplier_id').append('<option value=" ">Select</option>');
                        $.each(splr_list, function(key, value) {
                            $('#supplier_id').append('<option value="'+ value.ledger_id +'">'+ value.supplier_name  +'</option>');
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
      var rowIdx = $('#tbody tr').length;
  
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
                                                      <input type="number" class="form-input" name="white_amount[]" autocomplete="off" id="white_amount${rowIdx}"  step="0.00001" oninput="calculate(${rowIdx});" >
                                                      <input type="hidden" class="form-input white_amount" name="white_amount_qty[]" autocomplete="off" id="white_amount_qty${rowIdx}"  step="0.00001" >
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input" name="gst[]" autocomplete="off" id="gst${rowIdx}"  step="0.00001"  oninput="calculate(${rowIdx});" >
                                                      <input type="hidden" class="form-input gst" name="gst_qty[]" autocomplete="off" id="gst_qty${rowIdx}"  step="0.00001">
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input" name="black_amount[]" autocomplete="off" id="black_amount${rowIdx}"  step="0.00001" oninput="calculate(${rowIdx});">
                                                      <input type="hidden" class="form-input black_amount" name="black_amount_qty[]" autocomplete="off" id="black_amount_qty${rowIdx}"  step="0.00001"  >
                                                    </td>
                                                    <td style=" padding: 0.35rem 0.2rem !important;">
                                                      <input type="number" class="form-input amount" name="amount[]" id="amount${rowIdx}" autocomplete="off"  step="0.00001"  >
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
                  $('select').select2({
                   placeholder: "Select",
                   allowClear: true
                   });
		  

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
        rowIdx--;
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
    function calculate(rowid){
      var total = $('#total').val();
      qty = $('#qty'+rowid).val();
      white_amount = $('#white_amount'+rowid).val();
      gst = parseFloat(white_amount) * 18;
      total_gst = parseFloat(gst) / 100;
      $('#gst'+rowid).val(total_gst.toFixed(3));


      gst = $('#gst'+rowid).val();
      black_amount = $('#black_amount'+rowid).val();

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
       result = parseFloat(qty) *parseFloat(sum);

       $('#amount'+rowid).val(result.toFixed(3));

       waq = parseFloat(qty) * parseFloat(white_amount);
       gsq = parseFloat(qty) * parseFloat(gst);
       baq = parseFloat(qty) * parseFloat(black_amount);
       $('#white_amount_qty'+rowid).val(waq.toFixed(3));
       $('#gst_qty'+rowid).val(gsq.toFixed(3));
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
    <!--for get unit of item based on selection of item-->
  <script type="text/javascript">
    function get_unit_of_item(row_id){
      item_id = $("#itemid"+row_id).val();
      var rw = row_id;

      $.ajax({
				url: '{{route('get_unit_of_item')}}',
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
				url: '{{route('get_avilable_stock')}}',
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
				url: '{{route('list_of_products')}}',
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
				url: '{{route('list_of_products')}}',
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
  function check_fields() {
    // Get values of specific fields
    var p_i_no = $('#p_i_no').val();
    var p_date = $('#p_date').val();
    var supplier_id = $('#supplier_id').val();

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
    if (!isAnyRowEmpty && p_i_no.trim() !== "" && p_date.trim() !== "" && supplier_id.trim() !== "") {
      // All conditions are met, you can proceed with your logic here
      return true;
    } else {
      alert('Please fill in all fields.');
      return false; // Prevent the form submission
    }
  }
</script>

<script>
   $(document).ready(function () {
    $('#submitButton').click(function (e) {
        // Check if the table has any rows in its tbody
        var tbodyRowCount = $('#tbl_items tbody tr').length;

        if (tbodyRowCount === 0) {
            // If no rows, prevent form submission and provide feedback (e.g., alert)
            alert('Please add items to the table before submitting.');
            e.preventDefault(); // Prevent form submission
            // Alternatively, you can disable the submit button
            // $('#yourSubmitButtonId').prop('disabled', true);

            



        } else {
            // If there are rows, form submission is allowed
            // You can optionally enable the submit button if it was disabled
            // $('#yourSubmitButtonId').prop('disabled', false);
            // Proceed with your form submission logic here
        }
    });
});

</script>
@endsection