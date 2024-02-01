
@extends('fitting.layouts.app')

@section('content')
<!-- start main content section -->
<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Measurement Form</h5>
<div x-data="" class="pX-5 panel w-full">
<form class="form-horizontal"  id="edit_measurement_form" name="edit_measurement_form" action="{{ route('measurement_form_update_fitting',$result->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
						<div class="form-body">
				
							<div class="row">
                                <input type="hidden" name="main_id" id="main_id" value="{{$result->id}}">
                            <div class="form-group col-sm-3">
                            <label for="fitting_or_packing">Fitting<span style="color: #EB2D30">*</span> </label>
										<select id="fitting_or_packing" name="fitting_or_packing" class="form-input">
                                           
                                            <option value="Fitting" {{ $result->fitting_or_packing == 'Fitting' ? 'selected' : '' }}>Fitting</option>
                                        </select>
									<input type="hidden" name="m_id" id="m_id" value="{{$result->id;}}">	
								</div> 
								<div class="form-group col-sm-3">
									<label for="order_date">Order Date<span style="color: #EB2D30">*</span> </label>
										<input type="date" id="order_date" max='<?php echo date("Y-m-d"); ?>' value="{{ $result->order_date;}}"  class="form-input" placeholder="" name="order_date" autocomplete="off">
										
								</div> 
                                <div class="form-group col-sm-3">
									<label for="delivery_date">Delivery Date<span style="color: #EB2D30">*</span> </label>
										<input type="date" id="delivery_date" min='<?php echo date("Y-m-d"); ?>' value="{{ $result->delivery_date;}}"  class="form-input" placeholder="" name="delivery_date" autocomplete="off">
										
								</div> 
                                <div class="form-group col-sm-3">
								<label for="order_no">Order No<span style="color: #EB2D30">*</span> </label>
										<input type="text" id="order_no" readonly="readonly" class="form-input" placeholder="" name="order_no" value="{{ $result->order_no;}}" autocomplete="off">
                                        @error('order_no')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
                                    </div> 



                                
                                <div class="form-group col-sm-3">
									<label for="customer_id">Customer<span style="color: #EB2D30">*</span> </label>
										<select id="customer_id" name="customer_id" class="form-input">
                                           <option  value="" selected>Select</option>
                                            @foreach ($customer_lists as $row)
                                                <option value="{{ $row->id; }}" {{ $row->id == $result->customer_id ? 'selected' : '' }}>{{ $row->customer_name; }}</option>
                                            @endforeach
                                        </select>

                                        <!-- large -->
 <div x-data="modal" >
                        <!-- button -->
                        <button type="button"  @click="toggle">

                   <span style="color:#1d7d1d;font-size:12px;">Add Customer</span>
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
							<label for="remarks_popup">Remarks</label>
                            <textarea
                                            id="remarks_popup"
                                            name="remarks_popup"
                                            class="form-textarea min-h-[80px]"
                                            placeholder=""
                                           
                                        >{{old('remarks_popup')}}</textarea>
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

                                        
                                <div class="form-group col-sm-3">
								<label for="brand">Brand<span style="color: #EB2D30">*</span> </label>
                                <select id="brand" name="brand" class="form-input">
                                            <option value="">Select</option>
                                            @foreach ($brnd_lists as $row)
                                                <option value="{{ $row->id; }}" {{ $row->id == $result->brand_id ? 'selected' : '' }}>{{ $row->brand_name; }}</option>
                                            @endforeach
                                        </select>
								</div> 
                               
                                <div class="form-group col-sm-6">
									<label for="customer_address">Customer Address<span style="color: #EB2D30"></span> </label>
										<textarea id="customer_address" name="customer_address" class="form-input" readonly="readonly">{{$result->permenant_address}}</textarea>
								</div> 
                                <div class="form-group col-sm-3">
									<label for="root_id">Root<span style="color: #EB2D30">*</span> </label>
										<select id="root_id" name="root_id" class="form-input">
                                            <option value="">Select</option>
                                            @foreach ($root_lists as $row)
                                                <option value="{{ $row->id; }}" {{ $row->id == $result->root_id ? 'selected' : '' }}>{{ $row->root_name; }}</option>
                                            @endforeach
                                        </select>
								</div> 
                                <div class="form-group col-sm-3">
									<label for="executive">Executive<span style="color: #EB2D30"></span> </label>
										<select id="executive" name="executive" class="form-input">
                                            <option value="">Select</option>
                                            @foreach ($executive_lists as $row)
                                                <option value="{{ $row->id; }}" {{ $row->id == $result->executive_id ? 'selected' : '' }}>{{ $row->name; }}</option>
                                            @endforeach
                                        </select>
								</div> 
                                <div class="form-group col-sm-3">
									<label for="site_name">Site Name<span style="color: #EB2D30">*</span> </label>
                                    <input type="text" id="site_name" name="site_name" value="{{old('site_name') ? old('site_name') : $result->site_name }}" class="form-input">
		
								</div> 
                                <div class="form-group col-sm-3">
									<label for="site_address">Site Address<span style="color: #EB2D30">*</span> </label>
										<textarea id="site_address" name="site_address" class="form-input">{{old('site_address') ? old('site_address') : $result->site_address }}</textarea>
								</div>
                                
                            </div>
                           
<div class="div_tbl">
                           
                            <table class="table_add_row" id="tbl_items">
                                            <thead>
                                            <tr>
                                            
                                                <th rowspan=2 >No</th>
                                                <th rowspan=2 >Batch No</th>
                                                <th rowspan=2 width="350px">Model</th>
                                                <th width="150px">Frame</th>
                                                <th  rowspan=2  style="display:none" >Frame Size</th>
                                                <th rowspan=2  style="display:none">Color</th>
                                                
                                                <th  style="display:none" rowspan=2 >Stain Work</th>
                                                <th style="display:none"class="text-center" colspan="2">Tight Measurement</th>
                                                <th style="display:none" class="text-center" colspan="2">Measurement With Clearance</th>
                                               
                                                
                                                <th style="display:none" rowspan=2 >Mat Finish</th>
                                                <th style="display:none" rowspan=2 >Steel Beeding</th>
                                                <th style="display:none" rowspan=2 >Texture Finish</th>
                                                <th style="display:none" rowspan=2 >Glass Type</th>
                                                <th style="display:none" rowspan=2 >Hinges</th>
                                                <th  style="display:none"rowspan=2>Lock</th>
                                                <th rowspan=2 >Actions</th>
                                            </tr>
                                            <tr>
                                                <th style="display:none"class="text-center" >Width</th>
                                                <th style="display:none"class="text-center">Height</th>
                                                <th style="display:none" class="text-center">Width</th>
                                                <th style="display:none" class="text-center" >Height</th>
                                            </tr>
                                            </thead>
                                                <tbody id="tbody">
                                                @foreach($m_items as $m_item)
                                                <tr id="R{{$no++}}"><td>{{$no}}</td>
                                                <td><input type="text" id="batch_no{{$no}}" value="{{$m_item->batch_no}}" class="form-input" name="batch_no[]" readonly="readonly"></td>
                                                <td><input type="text" class="form-input" value="{{$m_item->model_name}}" name="mdl_txt" id="mdl_txt{{$no}}" readonly="readonly"></td>
                                                <td><input type="text" id="frame{{$no}}" value="{{$m_item->frame}}" class="form-input" name="frame[]" readonly="readonly">
                                             <input type="hidden" class="form-input" value="{{$m_item->color_id}}" name="clr_txt" id="clr_txt{{$no}}" readonly="readonly">


                                                <input type="hidden" class="form-input " value="{{$m_item->finish_work}}" name="finish_work[]" autocomplete="off" id="finish_work{{$no}}">
                                                <input type="hidden" class="form-input " value="{{$m_item->finish_work_front}}" name="finish_work_front[]" autocomplete="off" id="finish_work_front{{$no}}">
                                                <input type="hidden" class="form-input " value="{{$m_item->finish_work_back}}" name="finish_work_back[]" autocomplete="off" id="finish_work_back{{$no}}">
                                                <input type="hidden" class="form-input " name="frame_size[]" value="{{$m_item->frame_size}}" autocomplete="off" id="frame_size{{$no}}">
                                                 <input type="hidden" class="form-input " name="color[]" value="{{$m_item->color_id}}" autocomplete="off" id="color{{$no}}">
                                                 <input type="hidden" name="model[]" id="model{{$no}}" value="{{$m_item->model_id}}" class="form-input" >
                                                 <input type="hidden" class="form-input " value="{{$m_item->tight_measurement_top_width}}" name="tight_measurement_top_width[]" autocomplete="off" id="tight_measurement_top_width{{$no}}"  >
                                                 <input type="hidden" class="form-input " value="{{$m_item->tight_measurement_bottom_width}}" name="tight_measurement_bottom_width[]" autocomplete="off" id="tight_measurement_bottom_width{{$no}}"  >
                                                 <input type="hidden" class="form-input " value="{{$m_item->tight_measurement_height}}" name="tight_measurement_height[]" autocomplete="off" id="tight_measurement_height{{$no}}" >
                                                 <input type="hidden" class="form-input " value="{{$m_item->measurement_with_clearance_top_width}}" name="measurement_with_clearance_top_width[]" autocomplete="off" id="measurement_with_clearance_top_width{{$no}}" >
                                                 <input type="hidden" class="form-input " value="{{$m_item->measurement_with_clearance_bottom_width}}" name="measurement_with_clearance_bottom_width[]" autocomplete="off" id="measurement_with_clearance_bottom_width{{$no}}" >
                                                 <input type="hidden" class="form-input " value="{{$m_item->measurement_with_clearance_height}}" name="measurement_with_clearance_height[]" autocomplete="off" id="measurement_with_clearance_height{{$no}}"  >
                                                 <input type="hidden" class="form-input " value="{{$m_item->steel_beeding}}" name="steel_beeding[]" autocomplete="off" id="steel_beeding{{$no}}" >
                                                 <input type="hidden" class="form-input " value="{{$m_item->texture_finish}}" name="texture_finish[]" autocomplete="off" id="texture_finish{{$no}}" >
                                                 <input type="hidden" class="form-input " value="{{$m_item->glass_type}}" name="glass_type[]" autocomplete="off" id="glass_type{{$no}}" >
                                                 <input type="hidden" class="form-input " value="{{$m_item->hinges}}" name="hinges[]" autocomplete="off" id="hinges{{$no}}" >
                                                 <input type="hidden" class="form-input " value="{{$m_item->lock_id}}" name="lock[]" autocomplete="off" id="lock{{$no}}" >
                                                 <input type="hidden" class="form-input " value="{{$m_item->lock_measurement}}" name="lock_measurement[]" autocomplete="off" id="lock_measurement{{$no}}" >
                                                 <input type="hidden" class="form-input" value="{{$m_item->hinges_measurement}}" name="hinges_measurement[]" autocomplete="off" id="hinges_measurement{{$no}}">
                                                 <input type="hidden" class="form-input" value="{{$m_item->color_type}}" name="color_type[]" autocomplete="off" id="color_type{{$no}}">
                                                 <input type="hidden" id="fs_txt{{$no}}" value="{{$m_item->frame_size}}" class="form-input" name="fs_txt[]">


                                                </td>
                                                
                                                <td>


                                                @if($m_item->status == '0')


  <!-- extra large -->    
  <div x-data="modal">
                        <!-- button -->    
                        <button type="button" class="btn btn-warning" @click="type_change({{$no}});toggle();">Confirm</button>
                        
                        <!-- modal --> 
                        <div class="fixed inset-0 bg-[black]/60 z-[999]  hidden" :class="open && '!block'" style="overflow-y: scroll !important;">
                            <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                                <div x-show="open" x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-4xl my-8">
                                <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-4 py-1">
                                        <h5 class="font-bold text-lg text-center" style="font-weight:700; padding:2%; font-size:xx-large;">Measurement Form</h5>
                                    </div>
                                    <div class="p-4">
                                       <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]">
                                        
                                       <!-- <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                            <div>
                                                <label for="t_m_b_w_pop_up">Batch No<span style="color: #EB2D30"></span> </label>
                                                <input type="text" id="batch_no_pop_up" name="batch_no_pop_up" class="form-input" readonly="readonly">
                                            </div>
                                        </div>
                                                 -->

                                       <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                                       <div>
                                                <label for="type_pop_up">Type<span style="color: #EB2D30"></span> </label>
                                                <input type="text" value="{{$m_item->order_type}}" readonly="readonly" id="type_pop_up_{{$no}}" name="type_pop_up" class="form-input">
                                                <input type="hidden" id="c_id_{{$no}}" name="c_id" value="{{$m_item->color_id}}">
                                            </div>
                                            
                                            <div id="model_div_{{$no}}">
                                                <label for="model_pop_up">Model<span style="color: #EB2D30"></span> </label>
                                                <select id="model_pop_up_{{$no}}" name="model_pop_up" class="form-input" onchange="return get_color_type_details({{$no}});">
                                                        <option val="">Select</option>
                                                    @foreach ($model_lists as $row)
                                                        <option value="{{ $row->id; }}" {{ $row->id == $m_item->model_id ? 'selected' : '' }}>{{ $row->model_name; }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="frame_div_{{$no}}">
                                            <label for="frame_pop_up">Frame<span style="color: #EB2D30"></span> </label>


<select id="frame_pop_up_{{$no}}" name="frame_pop_up" class="form-input" onchange="return get_frame_size();">
                                                        <option val="">Select</option>
                                                        <option val="Concrete" {{ $m_item->frame == 'Concrete' ? 'selected' : '' }}>Concrete</option>
                                                        <option val="Wood" {{ $m_item->frame == 'Wood' ? 'selected' : '' }}>Wood</option>
                                                        <option val="Fiber" {{ $m_item->frame == 'Fiber' ? 'selected' : '' }}>Fiber</option>
                                                        <option val="Stainless Steel" {{ $m_item->frame == 'Stainless Steel' ? 'selected' : '' }}>Stainless Steel</option>
                                                        <option val="Door Only" {{ $m_item->frame == 'Door Only' ? 'selected' : '' }}>Door Only</option>
                                                </select>

                                            </div>
                                            <div id="frame_size_div_{{$no}}">
                                                <label for="frame_size_pop_up">Frame Size<span style="color: #EB2D30"></span> </label>
                                                <select id="frame_size_pop_up_{{$no}}" name="frame_size_pop_up" class="form-input" onchange="return calculations({{$no}});">
                                                    <option value="">Select</option>
                                                    @foreach ($fs_lists as $row)
                                                        <option value="{{ $row->id; }}" {{ $row->id == $m_item->frame_size ? 'selected' : '' }}>{{ $row->frame_name; }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <hr class="my-3" style="border: 1px solid #b0b0b0 !important;"/>
                                        <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 "><h4 style="font-weight:bold;    margin-bottom: 1%;">Tight Measurement</h4></div>
                                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                                          
                                          <div>
                                                <label for="t_m_w_pop_up">Top Width<span style="color: #EB2D30"></span> </label>
                                                <input type="number" step="any" id="t_m_w_pop_up_{{$no}}" name="t_m_w_pop_up" value="{{$m_item->tight_measurement_top_width;}}" class="form-input" oninput="return get_clearence_top_width({{$no}});">
                                            </div>
                                            <div>
                                                <label for="t_m_b_w_pop_up">Bottom Width<span style="color: #EB2D30"></span> </label>
                                                <input type="number" step="any" id="t_m_b_w_pop_up_{{$no}}" name="t_m_b_w_pop_up" value="{{$m_item->tight_measurement_bottom_width;}}" class="form-input" oninput="return get_clearence_bottom_width({{$no}});">
                                            </div>
                                            <div>
                                                <label for="t_m_h_pop_up">Height<span style="color: #EB2D30"></span> </label>
                                                <input type="number" step="any" id="t_m_h_pop_up_{{$no}}" name="t_m_h_pop_up" value="{{$m_item->tight_measurement_height;}}" class="form-input" oninput="return get_clearence_height({{$no}});">
                                            </div>
                                            <div id="sqft_div">
                                                <label for="tm_sqft">Sq Ft<span style="color: #EB2D30"></span> </label>
                                                <input type="number" step="any" id="tm_sqft_{{$no}}" name="tm_sqft" value="{{$m_item->tight_measurement_square_feet;}}" class="form-input" readonly="readonly">
                                            </div>
                                        </div>

                                        <hr class="my-3" style="border: 1px solid #b0b0b0 !important;" id="mwc_hr_{{$no}}" />
                                        <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 " id="mwc_div_heading_{{$no}}"><h4 style="font-weight:bold;    margin-bottom: 1%;">Measurement With Clearance</h4></div>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" id="mwc_div_{{$no}}">
                                          
                                          <div>
                                                <label for="m_w_c_w_pop_up">Top Width<span style="color: #EB2D30"></span> </label>
                                                <input type="number" step="any" id="m_w_c_w_pop_up_{{$no}}" name="m_w_c_w_pop_up" value="{{$m_item->measurement_with_clearance_top_width;}}" class="form-input">
                                            </div>
                                            <div>
                                                <label for="m_w_c_b_w_pop_up">Bottom Width<span style="color: #EB2D30"></span> </label>
                                                <input type="number" step="any" id="m_w_c_b_w_pop_up_{{$no}}" name="m_w_c_b_w_pop_up" value="{{$m_item->measurement_with_clearance_bottom_width;}}" class="form-input">
                                            </div>
                                            <div>
                                                <label for="m_w_c_h_pop_up">Height<span style="color: #EB2D30"></span> </label>
                                                <input type="number" step="any" id="m_w_c_h_pop_up_{{$no}}" name="m_w_c_h_pop_up" value="{{$m_item->measurement_with_clearance_height;}}" class="form-input">
                                            </div>
                                        </div>
                                        <hr class="my-3" style="border: 1px solid #b0b0b0 !important;"/>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" >
                                        <div id="door_color_type_div_{{$no}}">
                                        <label for="color_type_pop_up">Door Color Type<span style="color: #EB2D30"></span> </label>
                                        <input type="text" name="color_type_pop_up" id="color_type_pop_up_{{$no}}" readonly="readonly" class="form-input" value="{{$m_item->color_type}}"> 
                                        </div>
                                        <div id="door_color_div_{{$no}}">
                                                <label for="color_pop_up">Door Color<span style="color: #EB2D30"></span> </label>
                                                <select id="color_pop_up_{{$no}}" name="color_pop_up" class="form-input">
                                                        <option val="">Select</option>
                                                       
                                                          </option>
                                                  
                                                   
                                                </select>
                                            </div>
                                            <div id="frame_color_div_{{$no}}">
                                                <label for="frame_color_pop_up">Frame Color<span style="color: #EB2D30"></span> </label>
                                                <select id="frame_color_pop_up_{{$no}}" name="frame_color_pop_up" class="form-input">
                                                        <option val="">Select</option>
                                                        @foreach ($single_color_list as $row)
                                                                          <option value="{{ $row->id; }}" {{ $m_item->frame_color_id == $row->id ? 'selected' : '' }}>{{ $row->s_c_p_name; }}</option>
                                                        @endforeach
                                                </select>
                                            </div>

                                            
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" style="padding-top: 1%;">
                                        <div id="finish_work_div_{{$no}}">
                                                <label for="finish_work_pop_up">Finish Work<span style="color: #EB2D30"></span> </label>
                                                <select id="finish_work_pop_up_{{$no}}" name="finish_work_pop_up" class="form-input" onchange="return get_finsh_front_and_back({{$no}});">
                                                    <option val="">Select</option>
                                                    <option  val="Front" {{ $m_item->finish_work == 'Front' ? 'selected' : '' }}>Front</option>
                                                    <option  val="Front&Back" {{ $m_item->finish_work == 'Front & Back' ? 'selected' : '' }}>Front & Back</option>
                                                </select>
                                            </div>
                                            <div id="f_w_f_div_{{$no}}">
                                                <label for="finish_work_front_pop_up">Finish Work Front<span style="color: #EB2D30"></span> </label>
                                                <select id="finish_work_front_pop_up_{{$no}}" name="finish_work_front_pop_up" class="form-input">
                                                    <option val="">Select</option>
                                                    <option  val="Glossy" {{ $m_item->finish_work_front == 'Glossy' ? 'selected' : '' }}>Glossy</option>
                                                    <option  val="Leather" {{ $m_item->finish_work_front == 'Leather' ? 'selected' : '' }}>Leather</option>
                                                    <option  val="Mat" {{ $m_item->finish_work_front == 'Mat' ? 'selected' : '' }}>Mat</option>
                                                    <option  val="Stain" {{ $m_item->finish_work_front == 'Stain' ? 'selected' : '' }}>Stain</option>
                                                </select>
                                            </div>
                                            <div id="f_w_b_div_{{$no}}">
                                                <label for="finish_work_back_pop_up">Finish Work Back<span style="color: #EB2D30"></span> </label>
                                                <select id="finish_work_back_pop_up_{{$no}}" name="finish_work_back_pop_up" class="form-input">
                                                    <option val="">Select</option>
                                                    <option  val="Glossy" {{ $m_item->finish_work_back == 'Glossy' ? 'selected' : '' }}>Glossy</option>
                                                    <option  val="Leather" {{ $m_item->finish_work_back == 'Leather' ? 'selected' : '' }}>Leather</option>
                                                    <option  val="Mat" {{ $m_item->finish_work_back == 'Mat' ? 'selected' : '' }}>Mat</option>
                                                    <option  val="Stain" {{ $m_item->finish_work_back == 'Stain' ? 'selected' : '' }}>Stain</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" style="padding-top: 1%;">

                                             <!-- <div>
                                                <label for="mat_finish_pop_up">Mat Finish<span style="color: #EB2D30"></span> </label>
                                                <input type="text" id="mat_finish_pop_up" name="mat_finish_pop_up" class="form-input">
                                            </div> -->

                                            <div id="steel_beeding_div_{{$no}}">
                                                <label for="steel_beeding_pop_up">Steel Beeding<span style="color: #EB2D30"></span> </label>
                                                <select id="steel_beeding_pop_up_{{$no}}" name="steel_beeding_pop_up" class="form-input">
                                                    <option val="">Select</option>
                                                    <option val="Yes" {{ $m_item->steel_beeding == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option val="No" {{ $m_item->steel_beeding == 'No' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                     
                                                
                                            <div id="texture_finish_div_{{$no}}">
                                                <label for="texture_finish_pop_up">Texture Finish<span style="color: #EB2D30"></span> </label>
                                                <select id="texture_finish_pop_up_{{$no}}" name="texture_finish_pop_up" class="form-input">
                                                    <option val="">Select</option>
                                                    <option val="Yes" {{ $m_item->texture_finish == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option val="No" {{ $m_item->texture_finish == 'No' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>

                                            <div id="glass_type_div_{{$no}}">
                                                <label for="glass_type_pop_up">Glass Type<span style="color: #EB2D30"></span> </label>
                                                <select id="glass_type_pop_up_{{$no}}" name="glass_type_pop_up" class="form-input">
                                                        <option val="">Select</option>
                                                    @foreach ($gt_lists as $row)
                                                        <option value="{{ $row->id; }}" {{ $row->id == $m_item->glass_type ? 'selected' : '' }}>
                                                      
                                                            {{$row->glass_type_name}}

                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4" style="padding-top: 1%;">
                                        <div id="door_thickness_div_{{$no}}">
                                                <label for="door_thickness_popup">Thickness<span style="color: #EB2D30"></span> </label>
                                                <select id="door_thickness_popup_{{$no}}" name="door_thickness_popup" class="form-input">
                                                        <option val="">Select</option>
                                                    @foreach ($door_thickness_lists as $row)
                                                        <option value="{{ $row->id; }}" {{ $row->id == $m_item->door_thickness_id ? 'selected' : '' }}>
                                                      
                                                            {{$row->door_thickness}}

                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>  
                                            <div>
                                                <label for="hinges_pop_up">Hinges<span style="color: #EB2D30"></span> </label>
                                                <select id="hinges_pop_up_{{$no}}" name="hinges_pop_up" class="form-input">
                                                    <option val="">Select</option>
                                                    <option val="3 - Left" {{ $m_item->hinges == '3 - Left' ? 'selected' : '' }}>3 - Left</option>
                                                    <option val="3 - Right" {{ $m_item->hinges == '3 - Right' ? 'selected' : '' }}>3 - Right</option>
                                                    <option val="4 - Left" {{ $m_item->hinges == '4 - Left' ? 'selected' : '' }}>4 - Left</option>
                                                    <option val="4 - Right" {{ $m_item->hinges == '4 - Right' ? 'selected' : '' }}>4 - Right</option>
                                                </select>
                                            </div>
                                            <div id="h_m_div_{{$no}}">
                                                <label for="hinges_m_pop_up">Hinges Measurement<span style="color: #EB2D30"></span> </label>
                                               <input type="text" id="hinges_m_pop_up_{{$no}}" value="{{$m_item->hinges_measurement}}" name="hinges_m_pop_up" class="form-input">
                                            </div>

                                            <div id="lock_div_{{$no}}">
                                                <label for="lock_pop_up">Lock<span style="color: #EB2D30"></span> </label>
                                                <select id="lock_pop_up_{{$no}}" name="lock_pop_up" class="form-input">
                                                        <option val="">Select</option>
                                                    @foreach ($lk_lists as $row)
                                                        <option value="{{ $row->id; }}" {{ $row->id == $m_item->lock_id ? 'selected' : '' }}>
                                                      
                                                            {{$row->lock_name}}

                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" style="padding-top: 1%;">
                                        <div id="lock_measurement_div_{{$no}}">
                                                <label for="lock_measurement_pop_up">Lock Measurement<span style="color: #EB2D30"></span> </label>
                                                <input type="text" name="lock_measurement_pop_up" value="{{$m_item->lock_measurement}}" id="lock_measurement_pop_up_{{$no}}" class="form-input">
                                            </div>
                                            <div id="item_remarks_div_{{$no}}">
                                                <label for="item_remarks_pop_up">Remarks<span style="color: #EB2D30"></span> </label>
                                                <input type="text" name="item_remarks_pop_up" value="{{$m_item->item_remarks}}" id="item_remarks_pop_up_{{$no}}" class="form-input">
                                            </div>
                                            <div class="flex justify-end items-center mt-3">
                                            <button type="button" class="btn btn-warning " @click="toggle">Discard</button>
                                            <button type="button" class="btn btn-danger ltr:ml-4 rtl:mr-4"  @click="showAlert({{$m_item->id}})">Delete</button>
                                            <button type="button" id="c_n_btn" class="btn btn-success ltr:ml-4 rtl:mr-4" @click="showAlert_confirm('{{ $m_item->id }}', '{{ $no }}')">Confirm</button>

                                        </div>  
                                        </div> 
                                          
                                        </div>
                                        
                                    </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                    @else
                    <button type="button" class="btn btn-success">Confirmed</button>
                    @endif




                                                </td>
                                                </tr>
                                                @endforeach
                                                </tbody>
                                                <!-- <tfoot>
                                                  <tr>
                                                    <td colspan="3" class="text-right">Total</td>
													   <td><input type="number" class="form-input"  name="total_q" id="total_q" step="0.00001" value="0"></td>
													  <td><input type="number" class="form-input"  name="total_w" id="total_w" step="0.00001" value="0"></td>
                            <td><input type="number" class="form-input"  name="total_g" id="total_g" step="0.00001" value="0"></td>
                            <td><input type="number" class="form-input"  name="total_b" id="total_b" step="0.00001" value="0"></td>
                                                    <td><input type="number" class="form-input"  name="total" id="total" step="0.00001" value="0"></td>
                                                    
                                                  </tr>
                                                </tfoot> -->
                                           </table>
</div>
                                         <!-- <a href="#" class="pt-3 px-3"><button type="button" id="addBtn" class="btn btn_sbt remove">Add New</button></a> -->
						        
                           
                                
                 
</div>    
          



								
								
						
                            <div class="row" style="margin-top: 2%;">
                            <div class="col-sm-12">
                                <label for="remarks">Remarks<span style="color: #EB2D30"></span> </label>
										<textarea id="remarks" name="remarks" class="form-input"> {{ $result->remarks;}}</textarea>
                                </div> 
</div>
              <div class="row" style="margin-top: 1%;">
						
									<div class="form-group col-sm-2">
                                    <button type="submit" name="sbt" class="btn btn-primary !mt-6">Confirm&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
									</div>
								
								
							</div>

                        </div>
                </form> 
</div>
 <!-- end main content section -->
@endsection
@section('scripts')
<script>
  
  function check_fields() {
    var fitting_or_packing = $('#fitting_or_packing').val();
    var customer_id = $('#customer_id').val();
    var root_id = $('#root_id').val();
    var brand_id = $('#brand').val();
    var site_name = $('#site_name').val();
    var site_address = $('#site_address').val();
    var order_date = $('#order_date').val();
    var delivery_date = $('#delivery_date').val();

    if (
    fitting_or_packing.trim() !== "" &&
    order_date.trim() !== "" &&
    delivery_date.trim() !== "" &&
    customer_id.trim() !== "" &&
    root_id.trim() !== "" &&
    brand_id.trim() !== "" &&
    site_name.trim() !== "" &&
    site_address.trim() !== ""
) {
    // All fields are filled, you can proceed with your logic here
    return true;
} else {
    alert('Please fill in all fields.');
    e.preventDefault();
    return false; // Prevent the button click event from proceeding
}
}

</script>
<script>
    function calculations(no){
        get_clearence_top_width(no);
        get_clearence_bottom_width(no);
        get_clearence_height(no);
    }
</script>
<script>
    function get_clearence_top_width(){
        frame_pop_up = $("#frame_pop_up").val();
        frame_size_pop_up = $("#frame_size_pop_up").val();
       // Get the values
        var t_m_w_pop_up = parseFloat($("#t_m_w_pop_up").val());
        var t_m_b_w_pop_up = parseFloat($("#t_m_b_w_pop_up").val());
        var t_m_h_pop_up = parseFloat($("#t_m_h_pop_up").val());

        type_pop_up = $('#type_pop_up').val();

         if(type_pop_up == 'Door Only'){

        
            var largerValue = Math.max(t_m_w_pop_up, t_m_b_w_pop_up);

// Perform the calculations
var result = (largerValue * t_m_h_pop_up) / 929;
$("#tm_sqft").val(result.toFixed(3));




$.ajax({
        url: '{{route('get_top_width_clearence_door_only_fitting')}}',
        type: 'GET',
        success: function(data) {

            wd = data.details.width;
            total_width = parseFloat(t_m_w_pop_up) - parseFloat(wd);

            $('#m_w_c_w_pop_up').val(total_width.toFixed(3));
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Your logic to handle the error
        }
        });

         }
         else if(type_pop_up == 'Door Only Without Clearence'){
            var largerValue = Math.max(t_m_w_pop_up, t_m_b_w_pop_up);

            // Perform the calculations
            var result = (largerValue * t_m_h_pop_up) / 929;
            $("#tm_sqft_"+no).val(result.toFixed(3));

            $('#m_w_c_w_pop_up_'+no).val(t_m_w_pop_up);
            $('#m_w_c_b_w_pop_up_'+no).val(t_m_b_w_pop_up);
            $('#m_w_c_h_pop_up_'+no).val(t_m_h_pop_up);

            
        }
         else if(type_pop_up == 'Frame Only'){
            $('#m_w_c_w_pop_up').val(0);
            $('#m_w_c_b_w_pop_up').val(0);
            $('#m_w_c_h_pop_up').val(0);
        }   
        else{
            // Check which one is larger
                var largerValue = Math.max(t_m_w_pop_up, t_m_b_w_pop_up);

        // Perform the calculations
        var result = (largerValue * t_m_h_pop_up) / 929;
        $("#tm_sqft").val(result.toFixed(3));
        $('#m_w_c_w_pop_up').val("0");

        $.ajax({
                url: '{{route('get_top_width_clearence_fitting')}}',
                type: 'GET',
                data: {frame_size_pop_up: frame_size_pop_up,frame_pop_up:frame_pop_up},
                success: function(data) {

                    wd = data.details.width;
                    total_width = parseFloat(t_m_w_pop_up) - parseFloat(wd);

                    $('#m_w_c_w_pop_up').val(total_width.toFixed(3));
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Your logic to handle the error
                }
                });
        }
    }
</script>
<script>
    function get_clearence_bottom_width(){
        frame_pop_up = $("#frame_pop_up").val();
        frame_size_pop_up = $("#frame_size_pop_up").val();
        // Get the values
        var t_m_w_pop_up = parseFloat($("#t_m_w_pop_up").val());
        var t_m_b_w_pop_up = parseFloat($("#t_m_b_w_pop_up").val());
        var t_m_h_pop_up = parseFloat($("#t_m_h_pop_up").val());
        
        type_pop_up = $('#type_pop_up').val();

        if(type_pop_up == 'Door Only'){

            var largerValue = Math.max(t_m_w_pop_up, t_m_b_w_pop_up);

        // Perform the calculations
        var result = (largerValue * t_m_h_pop_up) / 929;
        $("#tm_sqft").val(result.toFixed(3));




        $.ajax({
				url: '{{route('get_top_width_clearence_door_only_fitting')}}',
				type: 'GET',
				success: function(data) {

                    wd = data.details.width;
                    total_width = parseFloat(t_m_b_w_pop_up) - parseFloat(wd);

                    $('#m_w_c_b_w_pop_up').val(total_width.toFixed(3));
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});







}
else if(type_pop_up == 'Door Only Without Clearence'){
            var largerValue = Math.max(t_m_w_pop_up, t_m_b_w_pop_up);

            // Perform the calculations
            var result = (largerValue * t_m_h_pop_up) / 929;
            $("#tm_sqft_"+no).val(result.toFixed(3));

            $('#m_w_c_w_pop_up_'+no).val(t_m_w_pop_up);
            $('#m_w_c_b_w_pop_up_'+no).val(t_m_b_w_pop_up);
            $('#m_w_c_h_pop_up_'+no).val(t_m_h_pop_up);

            
        }
else if(type_pop_up == 'Frame Only'){
$('#m_w_c_w_pop_up').val(0);
$('#m_w_c_b_w_pop_up').val(0);
$('#m_w_c_h_pop_up').val(0);
}   
else{

        // Check which one is larger
        var largerValue = Math.max(t_m_w_pop_up, t_m_b_w_pop_up);

        // Perform the calculations
        var result = (largerValue * t_m_h_pop_up) / 929;
        $("#tm_sqft").val(result.toFixed(3));
        $('#m_w_c_b_w_pop_up').val("0");
        
     $.ajax({
				url: '{{route('get_top_width_clearence_fitting')}}',
				type: 'GET',
				data: {frame_size_pop_up: frame_size_pop_up,frame_pop_up:frame_pop_up},
				success: function(data) {

                    wd = data.details.width;
                    total_width = parseFloat(t_m_b_w_pop_up) - parseFloat(wd);

                    $('#m_w_c_b_w_pop_up').val(total_width.toFixed(3));
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
            }
    }
</script>
<script>
    function get_clearence_height(){
        frame_pop_up = $("#frame_pop_up").val();
        frame_size_pop_up = $("#frame_size_pop_up").val();
       // Get the values
        var t_m_w_pop_up = parseFloat($("#t_m_w_pop_up").val());
        var t_m_b_w_pop_up = parseFloat($("#t_m_b_w_pop_up").val());
        var t_m_h_pop_up = parseFloat($("#t_m_h_pop_up").val());

        type_pop_up = $('#type_pop_up').val();

        if(type_pop_up == 'Door Only'){


            var largerValue = Math.max(t_m_w_pop_up, t_m_b_w_pop_up);

        // Perform the calculations
        var result = (largerValue * t_m_h_pop_up) / 929;
        $("#tm_sqft").val(result.toFixed(3));
        $.ajax({
        url: '{{route('get_top_width_clearence_door_only_fitting')}}',
        type: 'GET',
        success: function(data) {

            wd = data.details.height;
            total_width = parseFloat(t_m_h_pop_up) - parseFloat(wd);

            $('#m_w_c_h_pop_up').val(total_width.toFixed(3));
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Your logic to handle the error
        }
        });

}
else if(type_pop_up == 'Door Only Without Clearence'){
            var largerValue = Math.max(t_m_w_pop_up, t_m_b_w_pop_up);

            // Perform the calculations
            var result = (largerValue * t_m_h_pop_up) / 929;
            $("#tm_sqft_"+no).val(result.toFixed(3));

            $('#m_w_c_w_pop_up_'+no).val(t_m_w_pop_up);
            $('#m_w_c_b_w_pop_up_'+no).val(t_m_b_w_pop_up);
            $('#m_w_c_h_pop_up_'+no).val(t_m_h_pop_up);

            
        }
else if(type_pop_up == 'Frame Only'){
$('#m_w_c_w_pop_up').val(0);
$('#m_w_c_b_w_pop_up').val(0);
$('#m_w_c_h_pop_up').val(0);
}   
else{

        // Check which one is larger
        var largerValue = Math.max(t_m_w_pop_up, t_m_b_w_pop_up);

        // Perform the calculations
        var result = (largerValue * t_m_h_pop_up) / 929;
        $("#tm_sqft").val(result.toFixed(3));
        $('#m_w_c_h_pop_up').val("0");
     $.ajax({
				url: '{{route('get_top_width_clearence_fitting')}}',
				type: 'GET',
				data: {frame_size_pop_up: frame_size_pop_up,frame_pop_up:frame_pop_up},
				success: function(data) {

                    wd = data.details.height;
                    total_width = parseFloat(t_m_h_pop_up) - parseFloat(wd);

                    $('#m_w_c_h_pop_up').val(total_width.toFixed(3));
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
            }

    }
</script>
<script>
     function reloadPage() {
        location.reload(true); // Passing 'true' as an argument forces a hard reload from the server, ignoring the cache.
    }
    async function showAlert(mt_id) {
        const swalWithBootstrapButtons = window.Swal.mixin({
            confirmButtonClass: 'btn btn-secondary',
            cancelButtonClass: 'btn btn-dark ltr:mr-3 rtl:ml-3',
            buttonsStyling: false,
        });
        swalWithBootstrapButtons
        .fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true,
            padding: '2em',
        })
        .then((result) => {
            if (result.value) {


                $.ajax({
				url: '{{route('remove_measurement_item')}}',
				type: 'GET',
				data: {mt_id: mt_id},
				success: function(data) {
                    swalWithBootstrapButtons.fire('Deleted!', 'Your file has been deleted.', 'success').then(() => {
                    // This will be executed after the user clicks the "OK" button on the success message
                 //   reloadPage(); // Reload the page

                        if(data.success == 'full'){
                            window.location.href = '{{ route('pending_order_list') }}';
                        }
                        else{
                            reloadPage(); 
                        }
                });
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});


               
            } else if (result.dismiss === window.Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire('Cancelled', 'Your imaginary file is safe :)', 'error');
            }
        });
    }


    async function showAlert_confirm(mt_id,no) {
        const swalWithBootstrapButtons = window.Swal.mixin({
            confirmButtonClass: 'btn btn-secondary',
            cancelButtonClass: 'btn btn-dark ltr:mr-3 rtl:ml-3',
            buttonsStyling: false,
        });
        swalWithBootstrapButtons
        .fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Confirm it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true,
            padding: '2em',
        })
        .then((result) => {
            if (result.value) {


    var fitting_or_packing = $('#fitting_or_packing').val();
    var customer_id = $('#customer_id').val();
    var root_id = $('#root_id').val();
    var brand_id = $('#brand').val();
    var executive_id = $('#executive').val();
    var site_name = $('#site_name').val();
    var site_address = $('#site_address').val();
    var order_date = $('#order_date').val();
    var delivery_date = $('#delivery_date').val();
    var remarks = $('#remarks').val();
    var main_id = $('#main_id').val();

    
    
        type = $("#type_pop_up_"+no).val();
        model_id = $("#model_pop_up_"+no).val();
        frame_id = $("#frame_pop_up_"+no).val();
        t_m_w = $("#t_m_w_pop_up_"+no).val();
        t_m_b_w = $("#t_m_b_w_pop_up_"+no).val();
        t_m_h = $("#t_m_h_pop_up_"+no).val();
        tm_sqft = $("#tm_sqft_"+no).val();
        m_w_c_w = $("#m_w_c_w_pop_up_"+no).val();
        m_w_c_b_w = $("#m_w_c_b_w_pop_up_"+no).val();
        m_w_c_h = $("#m_w_c_h_pop_up_"+no).val();
        frame_size_id = $("#frame_size_pop_up_"+no).val();
        color_id = $("#color_pop_up_"+no).val();
        finish_work = $("#finish_work_pop_up_"+no).val();
        steel_beeding = $("#steel_beeding_pop_up_"+no).val();
        texture_finish = $("#texture_finish_pop_up_"+no).val();
        glass_type_id = $("#glass_type_pop_up_"+no).val();
        hinges = $("#hinges_pop_up_"+no).val();
        lock_id = $("#lock_pop_up_"+no).val();
        finish_work_front = $("#finish_work_front_pop_up_"+no).val();
        finish_work_back = $("#finish_work_back_pop_up_"+no).val();
        lock_measurement = $("#lock_measurement_pop_up_"+no).val();
        hinges_m = $("#hinges_m_pop_up_"+no).val();
        color_type = $("#color_type_pop_up_"+no).val();
        frame_color_id = $("#frame_color_pop_up_"+no).val();
        order_date = $("#order_date").val();
        main_id = $("#main_id").val();
        item_remarks = $("#item_remarks_pop_up_"+no).val();
        door_thickness_id = $("#door_thickness_popup_"+no).val();
       

        

        if(type == 'Door With Frame'){
            if (model_id.trim() !== "" && frame_id.trim() !== "" && t_m_w.trim() !== "" && t_m_b_w.trim() !== "" && t_m_h.trim() !== "" && color_type.trim() !== "" && color_id.trim() !== "" && frame_color_id.trim() !== "") {
                $.ajax({
				url: '{{route('confirm_pending_order_fitting')}}',
				type: 'GET',
				data: {main_id:main_id,mt_id: mt_id,type:type,model_id:model_id,frame_id:frame_id,t_m_w:t_m_w,t_m_b_w:t_m_b_w,t_m_h:t_m_h,tm_sqft:tm_sqft,m_w_c_w:m_w_c_w,m_w_c_b_w:m_w_c_b_w,m_w_c_h:m_w_c_h,frame_size_id:frame_size_id,color_id:color_id,finish_work:finish_work,steel_beeding:steel_beeding,texture_finish:texture_finish,glass_type_id:glass_type_id,hinges:hinges,lock_id:lock_id,finish_work_front:finish_work_front,finish_work_back:finish_work_back,lock_measurement:lock_measurement,hinges_m:hinges_m,color_type:color_type,frame_color_id:frame_color_id,order_date:order_date,fitting_or_packing:fitting_or_packing,customer_id:customer_id, root_id:root_id,brand_id:brand_id,executive_id:executive_id,site_name:site_name,site_address:site_address,delivery_date:delivery_date,remarks:remarks,item_remarks:item_remarks,door_thickness_id:door_thickness_id},
				success: function(data) {
                    swalWithBootstrapButtons.fire('Order Confirmed!', 'success').then(() => {
                    // This will be executed after the user clicks the "OK" button on the success message
                    reloadPage(); // Reload the page
                });
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
                } 
                else {
                alert('Please fill in all fields.');
                //  e.preventDefault();
                return false; // Prevent the button click event from proceeding
                }
        }
        else if((type == 'Door Only') || (type == 'Door Only Without Clearence')){
            if (model_id.trim() !== ""  && t_m_w.trim() !== "" && t_m_b_w.trim() !== "" && t_m_h.trim() !== "" && color_type.trim() !== "" && color_id.trim() !== "") {
                $.ajax({
				url: '{{route('confirm_pending_order_fitting')}}',
				type: 'GET',
				data: {main_id:main_id,mt_id: mt_id,type:type,model_id:model_id,frame_id:frame_id,t_m_w:t_m_w,t_m_b_w:t_m_b_w,t_m_h:t_m_h,tm_sqft:tm_sqft,m_w_c_w:m_w_c_w,m_w_c_b_w:m_w_c_b_w,m_w_c_h:m_w_c_h,frame_size_id:frame_size_id,color_id:color_id,finish_work:finish_work,steel_beeding:steel_beeding,texture_finish:texture_finish,glass_type_id:glass_type_id,hinges:hinges,lock_id:lock_id,finish_work_front:finish_work_front,finish_work_back:finish_work_back,lock_measurement:lock_measurement,hinges_m:hinges_m,color_type:color_type,frame_color_id:frame_color_id,order_date:order_date,fitting_or_packing:fitting_or_packing,customer_id:customer_id, root_id:root_id,brand_id:brand_id,executive_id:executive_id,site_name:site_name,site_address:site_address,delivery_date:delivery_date,remarks:remarks,item_remarks:item_remarks,door_thickness_id:door_thickness_id},
				success: function(data) {
                    swalWithBootstrapButtons.fire('Order Confirmed!', 'success').then(() => {
                    // This will be executed after the user clicks the "OK" button on the success message
                    reloadPage(); // Reload the page
                });
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
                } 
                else {
                alert('Please fill in all fields.');
                //  e.preventDefault();
                return false; // Prevent the button click event from proceeding
                }
        }
        else if(type == 'Frame Only'){
            if (frame_id.trim() !== "" && t_m_w.trim() !== "" && t_m_b_w.trim() !== "" && t_m_h.trim() !== ""  && frame_color_id.trim() !== "") {
                $.ajax({
				url: '{{route('confirm_pending_order_fitting')}}',
				type: 'GET',
				data: {main_id:main_id,mt_id: mt_id,type:type,model_id:model_id,frame_id:frame_id,t_m_w:t_m_w,t_m_b_w:t_m_b_w,t_m_h:t_m_h,tm_sqft:tm_sqft,m_w_c_w:m_w_c_w,m_w_c_b_w:m_w_c_b_w,m_w_c_h:m_w_c_h,frame_size_id:frame_size_id,color_id:color_id,finish_work:finish_work,steel_beeding:steel_beeding,texture_finish:texture_finish,glass_type_id:glass_type_id,hinges:hinges,lock_id:lock_id,finish_work_front:finish_work_front,finish_work_back:finish_work_back,lock_measurement:lock_measurement,hinges_m:hinges_m,color_type:color_type,frame_color_id:frame_color_id,order_date:order_date,fitting_or_packing:fitting_or_packing,customer_id:customer_id, root_id:root_id,brand_id:brand_id,executive_id:executive_id,site_name:site_name,site_address:site_address,delivery_date:delivery_date,remarks:remarks,item_remarks:item_remarks,door_thickness_id:door_thickness_id},
				success: function(data) {
                    swalWithBootstrapButtons.fire('Order Confirmed!', 'success').then(() => {
                    // This will be executed after the user clicks the "OK" button on the success message
                    reloadPage(); // Reload the page
                });
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
                } 
                else {
                alert('Please fill in all fields.');
                //  e.preventDefault();
                return false; // Prevent the button click event from proceeding
                } 
        }
        else{

        }


               
            } else if (result.dismiss === window.Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire('Cancelled', 'Your order file is safe :)', 'error');
            }
        });
    }

  
    

</script>
<script>
    function get_door_color(no){
    color_type = $("#color_type_pop_up_"+no).val();

		$.ajax({
				url: '{{route('get_color_list_fitting')}}',
				type: 'GET',
				data: {color_type: color_type},
				success: function(data) {
                    clr_list = data.color_list;
                    $('#color_pop_up_'+no).empty();

                    $('#color_pop_up_'+no).append('<option value="Select">Select</option>');
					$.each(clr_list, function(key, value) {
						if (value.combo_color_name == "") {
							$('#color_pop_up_'+no).append('<option value="' + value.id + '">' + value.color_name + '</option>');
						} else {
							var comboColor = value.combo_color_name;
							$('#color_pop_up_'+no).append('<option value="' + value.id + '">' + value.color_name + (comboColor ? ' & ' + comboColor : '') + '</option>');
						}
					});
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
  }
   
function get_frame_size(){
    

    frame_pop_up = $("#frame_pop_up").val();
    if(frame_pop_up == 'Fiber'){
        $("#frame_size_div").show();
        // $("#h_m_div").hide();
        $.ajax({
				url: '{{route('get_frame_size_deatils_fitting')}}',
				type: 'GET',
				success: function(data) {
                    fs_list = data.frame_sizes;
                    $('#frame_size_pop_up').empty();
                    $('#frame_size_pop_up').append('<option value=" ">Select</option>');
                        $.each(fs_list, function(key, value) {
                            $('#frame_size_pop_up').append('<option value="'+ value.id +'">'+ value.frame_size  +'</option>');
                        });
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
    }
    else{
        $("#frame_size_div").hide();
        // $("#h_m_div").show();
        $('#frame_size_pop_up').empty();
        $('#frame_size_pop_up').append('<option value=" ">Select</option>');
    }
}
</script>
<script>
    function get_finsh_front_and_back(no){
       
        finish_work = $("#finish_work_pop_up_"+no).val();
        
            if(finish_work == 'Front'){
                $("#f_w_f_div_"+no).show();
                $("#f_w_b_div_"+no).hide();
            }
            else if(finish_work == 'Front & Back'){
                $("#f_w_f_div_"+no).show();
                $("#f_w_b_div_"+no).show();
            }
            else{
                $("#f_w_f_div_"+no).hide();
                $("#f_w_b_div_"+no).hide();
            }
    }
</script>

<!--for item grid-->
<script>
    $(document).ready(function () {


        m_id = $('#m_id').val();
        $.ajax({
				url: '{{route('check_measurement_items_status_fitting')}}',
				type: 'GET',
                data: {m_id: m_id},
				success: function(data) {
                    if(data.val == 0){
                        $(':input[type="submit"]').prop('disabled', false);
                    }
                    else{
                        $(':input[type="submit"]').prop('disabled', true);
                    }
				},
				error: function(jqXHR, textStatus, errorThrown) {
					$(':input[type="submit"]').prop('disabled', true);
				}
				});

    //  $("#h_m_div").hide();
     //get_finsh_front_and_back();
     



    customer_id = $("#customer_id").val();
    $.ajax({
				url: '{{route('get_customer_deatils_fitting')}}',
				type: 'GET',
				data: {customer_id: customer_id},
				success: function(data) {
                  
                    $('#customer_address').text(data.customer_address);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
  $("#fitting_or_packing").change(function(){
    fitting_or_packing = $("#fitting_or_packing").val();
    $.ajax({
				url: '{{route('generate_order_no_fitting')}}',
				type: 'GET',
				data: {fitting_or_packing: fitting_or_packing},
				success: function(data) {
                    $('#order_no').val(data.r_no);
                    
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
  });
     


    });
  </script> 
  <script>

function type_change(no) {
    get_finsh_front_and_back(no);
    type_pop_up = $("#type_pop_up_" + no).val();

    if((type_pop_up == 'Door Only') || (type_pop_up == 'Door Only Without Clearence')){
     $('#frame_div_'+no).hide();
     $('#frame_color_div_'+no).hide();
     $('#frame_size_div_'+no).hide();
     $('#model_div_'+no).show();
     $('#mwc_hr_'+no).show();
     $('#mwc_div_heading_'+no).show();
     $('#mwc_div_'+no).show();
     $('#sqft_div_'+no).show();
     $('#door_color_type_div_'+no).show();
     $('#door_color_div_'+no).show();
     $('#finish_work_div_'+no).show();
     $('#steel_beeding_div_'+no).show();
     $('#glass_type_div_'+no).show();
     $('#texture_finish_div_'+no).show();
     $('#lock_div_'+no).show();
     $('#door_thickness_div_'+no).show();
     $("#lock_measurement_div_"+no).show();

     door_color_get(no);

    } else if (type_pop_up == 'Frame Only') {
        $('#frame_div_'+no).show();
        $('#frame_color_div_'+no).show();
        $('#frame_size_div_'+no).hide();
        $('#model_div_'+no).hide();
        $('#mwc_hr_'+no).hide();
        $('#mwc_div_heading_'+no).hide();
        $('#mwc_div_'+no).hide();
        $('#sqft_div_'+no).hide();
        $('#door_color_type_div_'+no).hide();
        $('#door_color_div_'+no).hide();
        $('#finish_work_div_'+no).hide();
        $('#f_w_f_div_'+no).show();
        $('#f_w_b_div_'+no).hide();
        $('#steel_beeding_div_'+no).hide();
        $('#glass_type_div_'+no).hide();
        $('#texture_finish_div_'+no).hide();
        $('#lock_div_'+no).hide();
        $('#door_thickness_div_'+no).hide();
    frame_pop_up = $("#frame_pop_up_"+no).val();
     $("#lock_measurement_div_"+no).show();  
     if(frame_pop_up == 'Fiber'){
        $("#frame_size_div_"+no).show();
     }
     else{
        $("#frame_size_div_"+no).hide();
     }           
    } else if (type_pop_up == 'Door With Frame') {
     $('#frame_div_'+no).show();
     $('#frame_color_div_'+no).show();
     $('#frame_size_div_'+no).show();
     $('#model_div_'+no).show();
     $('#mwc_hr_'+no).show();
     $('#mwc_div_heading_'+no).show();
     $('#mwc_div_'+no).show();
     $('#sqft_div_'+no).show();
     $('#door_color_type_div_'+no).show();
     $('#door_color_div_'+no).show();
     $('#finish_work_div_'+no).show();
     $('#steel_beeding_div_'+no).show();
     $('#glass_type_div_'+no).show();
     $('#texture_finish_div_'+no).show();
     $('#lock_div_'+no).show();
     $('#door_thickness_div_'+no).show();
     $("#lock_measurement_div_"+no).show();
     frame_pop_up = $("#frame_pop_up_"+no).val();
     if(frame_pop_up == 'Fiber'){
        $("#frame_size_div_"+no).show();
     }
     else{
        $("#frame_size_div_"+no).hide();
     }
     door_color_get(no);
   
     
    }
    check_fields();
    // Add more conditions as needed
}

function door_color_get(no){
    color_type = $("#color_type_pop_up_"+no).val();
    c_id = $("#c_id_"+no).val();

$.ajax({
        url: '{{route('get_color_list_fitting')}}',
        type: 'GET',
        data: {color_type: color_type},
        success: function(data) {
            clr_list = data.color_list;
            $('#color_pop_up_'+no).empty();

            $('#color_pop_up_'+no).append('<option value="Select">Select</option>');
            $.each(clr_list, function(key, value) {
                if (value.combo_color_name == "") {
                    $('#color_pop_up_'+no).append('<option value="' + value.id + '">' + value.color_name + '</option>');
                    $('#color_pop_up_'+no).val(c_id);
                } else {
                    var comboColor = value.combo_color_name;
                    $('#color_pop_up_'+no).append('<option value="' + value.id + '">' + value.color_name + (comboColor ? ' & ' + comboColor : '') + '</option>');
                    $('#color_pop_up_'+no).val(c_id);
                }
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Your logic to handle the error
        }
        });
}
</script>
    <script>
$(document).ready(function(){
  $("#customer_id").change(function(){
    customer_id = $("#customer_id").val();
    $.ajax({
				url: '{{route('get_customer_deatils_fitting')}}',
				type: 'GET',
				data: {customer_id: customer_id},
				success: function(data) {
                   // $('#brand').val(data.brand);
                    $('#customer_address').text(data.customer_address);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
  });
});

function get_color_type_details(no){
                model_id = $("#model_pop_up_"+no).val();

                $.ajax({
                        url: '{{route('get_color_type_details_fitting')}}',
                        type: 'GET',
                        data: {model_id: model_id},
                        success: function(data) {

                        $("#color_type_pop_up_"+no).val(data.details.color_type);
                        get_door_color(no);

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
    function check_popup_fields(no){
      
        type_pop_up = $("#type_pop_up_" + no).val();
   
      if(type_pop_up === ''){
        alert('null value')
        document.getElementById('c_n_btn').disabled = true;
      }
      else{
        document.getElementById('c_n_btn').disabled = false;
      }
    }
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
				url: '{{route('save_customer_details_fitting')}}',
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
				url: '{{route('get_customer_list_dynamic_fitting')}}',
				success: function(data) {
         cs_list = data.customer_lists;
         console.log(data)
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
@endsection