
@extends('executive.layouts.app')

@section('content')
<!-- start main content section -->
<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Measurement Form</h5>
<div x-data="" class="pX-5 panel w-full">
<form class="form-horizontal"  id="add_measurement_form" name="add_measurement_form" action="{{ url('measurement_form_executive') }}" method="POST" enctype="multipart/form-data" onsubmit="return disableSubmitButton()">
					@csrf
						<div class="form-body">
				
							<div class="row">
                            <div class="form-group col-sm-3">
									<label for="fitting_or_packing">Fitting / Packing<span style="color: #EB2D30">*</span> </label>
										<select id="fitting_or_packing" name="fitting_or_packing" class="form-input">
                                            <option value="">Select</option>
                                            <option value="Fitting" {{ old('fitting_or_packing') == 'Fitting' ? 'selected' : '' }}>Fitting</option>
                                            <option value="Packing" {{ old('fitting_or_packing') == 'Packing' ? 'selected' : '' }}>Packing</option>
                                        </select>
                                        @error('fitting_or_packing')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
								<div class="form-group col-sm-3">
									<label for="order_date">Order Date<span style="color: #EB2D30">*</span> </label>
										<input type="date" id="order_date" max='<?php echo date("Y-m-d"); ?>'  class="form-input" placeholder=" " value="{{ old('order_date') }}"  name="order_date" autocomplete="off">
                                        @error('order_date')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
                                <div class="form-group col-sm-3">
									<label for="delivery_date">Delivery Date<span style="color: #EB2D30">*</span> </label>
										<input type="date" id="delivery_date" min='<?php echo date("Y-m-d"); ?>'  class="form-input" value="{{ old('delivery_date') }}"  placeholder="" name="delivery_date" autocomplete="off">
                                        @error('delivery_date')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
                                <div class="form-group col-sm-3">
								<label for="order_no">Order No<span style="color: #EB2D30"></span> </label>
										<input type="text" id="order_no" readonly="readonly" class="form-input" placeholder=""value="{{ old('order_no') }}"  name="order_no" autocomplete="off">
								</div> 



                                
                                <div class="form-group col-sm-3">
									<label for="customer_id">Customer<span style="color: #EB2D30">*</span> </label>
										<select id="customer_id" name="customer_id" class="form-input">
                                           <option  value="" selected>Select</option>
                                            @foreach ($customer_lists as $row)
                                                <option value="{{ $row->id; }}" {{ old('customer_id') == $row->id ? 'selected' : '' }}>{{ $row->customer_name; }}</option>
                                            @endforeach
                                        </select>
                                        @error('customer_id')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
                                      	</div> 

                                        
                                <div class="form-group col-sm-3">
								<label for="brand">Brand<span style="color: #EB2D30">*</span> </label>
                                        <select id="brand" name="brand" class="form-input">
                                            <option value="">Select</option>
                                            @foreach ($brnd_lists as $row)
                                                <option value="{{ $row->id; }}" {{ old('brand') == $row->id ? 'selected' : '' }}>{{ $row->brand_name; }}</option>
                                            @endforeach
                                        </select>
                                        @error('brand')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
                               
                                <div class="form-group col-sm-6">
									<label for="customer_address">Customer Address<span style="color: #EB2D30"></span> </label>
										<textarea id="customer_address" name="customer_address" class="form-input" readonly="readonly" >{{old('customer_address')}}</textarea>
                                        @error('customer_address')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
                                <div class="form-group col-sm-3">
									<label for="root_id">Root<span style="color: #EB2D30">*</span> </label>
										<select id="root_id" name="root_id" class="form-input">
                                            <option value="">Select</option>
                                            @foreach ($root_lists as $row)
                                                <option value="{{ $row->id; }}" {{ old('root_id') == $row->id ? 'selected' : '' }}>{{ $row->root_name; }}</option>
                                            @endforeach
                                        </select>
                                        @error('root_id')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
                                <div class="form-group col-sm-3">
									<label for="executive">Executive<span style="color: #EB2D30"></span> </label>
                                    <select id="executive" name="executive" class="form-input">
    @foreach ($executive_lists as $row)
        <option value="{{ $row->id }}" {{ Auth::user()->id == $row->id ? 'selected' : '' }}>
            {{ $row->name }}
        </option>
    @endforeach
</select>

                                      
								</div> 
                                <div class="form-group col-sm-3">
									<label for="site_name">Site Name<span style="color: #EB2D30">*</span> </label>
                                    <input type="text" id="site_name" name="site_name" value="{{ old('site_name') }}"  class="form-input">
                                    @error('site_name')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div> 
                                <div class="form-group col-sm-3">
									<label for="site_address">Site Address<span style="color: #EB2D30">*</span> </label>
										<textarea id="site_address" name="site_address" class="form-input">{{ old('site_address') }}</textarea>
                                        @error('site_address')
											<small class='text-danger'>{{ $message }}</small>
										@enderror
								</div>
                                
                            </div>
                           
<div class="div_tbl">
                           
                            <table class="table_add_row" id="m_item_tbl">
                                            <thead>
                                            <tr>
                                            
                                                <th >No</th>
                                                <th>Order Type</th>
                                               
                                                <th>Model</th>
                                                <th class="text-center" colspan="3">Tight Measurement</th>
                                                <th rowspan=2>Actions</th>
</tr>
<tr>
    <td></td>
    
    <td></td>
    <td></td>
    <td>Top Width</td>
    <td>Bottom Width</td>
    <td>Height</td>
</tr>
                                                <!-- <th  style="display:none" rowspan=2 >Stain Work</th>
                                                <th style="display:none"class="text-center" colspan="2">Tight Measurement</th>
                                                <th style="display:none" class="text-center" colspan="2">Measurement With Clearance</th>
                                               
                                                
                                                <th style="display:none" rowspan=2 >Mat Finish</th>
                                                <th style="display:none" rowspan=2 >Steel Beeding</th>
                                                <th style="display:none" rowspan=2 >Texture Finish</th>
                                                <th style="display:none" rowspan=2 >Glass Type</th>
                                                <th style="display:none" rowspan=2 >Hinges</th>
                                                <th  style="display:none"rowspan=2>Lock</th>
                                                <th rowspan=2 width="100px">Actions</th>
                                            </tr>
                                            <tr>
                                                <th style="display:none"class="text-center" >Width</th>
                                                <th style="display:none"class="text-center">Height</th>
                                                <th style="display:none" class="text-center">Width</th>
                                                <th style="display:none" class="text-center" >Height</th>
                                            </tr> -->
                                            </thead>
                                                <tbody id="tbody">

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
						        
             <!-- extra large -->    
             <div x-data="modal" class="pt-4" >
                        <!-- button -->    
                        <button type="button" class="btn btn-warning" @click="check_fields();toggle();"  >Add</button>
                        
                        <!-- modal --> 
                        <div class="fixed inset-0 bg-[black]/60 z-[999]  hidden" id="m_pop_up" :class="open && '!block'" style="overflow-y: scroll !important;">
                            <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                                <div  x-show="open" x-transition x-transition.duration.300 class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-4xl my-8">
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
                                                <select id="type_pop_up" name="type_pop_up" class="form-input" onchange="return type_change();">
                                                        <option val="">Select</option>
                                                        <option val="Door With Frame">Door With Frame</option>
                                                        <option val="Door Only">Door Only</option>
                                                        <option val="Frame Only">Frame Only</option>
                                                </select>
                                            </div>
                                            <div id="model_div">
                                                <label for="model_pop_up">Model<span style="color: #EB2D30"></span> </label>
                                                <select id="model_pop_up" name="model_pop_up" class="form-input" onchange="return get_color_type_details();"  >
                                                        <option val="0">Select</option>
                                                    @foreach ($model_lists as $row)
                                                        <option value="{{ $row->id; }}">{{ $row->model_name; }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                               

                                            <div id="frame_div">
                                            <label for="frame_pop_up">Frame<span style="color: #EB2D30"></span> </label>
                                                <select id="frame_pop_up" name="frame_pop_up" class="form-input" onchange="return get_frame_size();">
                                                    <option val="">Select</option>
                                                    <option val="Concrete">Concrete</option>
                                                    <option val="Wooden">Wooden</option>
                                                    <option val="Fiber">Fiber</option>
                                                    <option val="Stainless Steel">Stainless Steel</option>
                                                    <option val="Door Only">Door Only</option>
                                                </select>
                                            </div>
                                            <div id="frame_size_div">
                                                <label for="frame_size_pop_up">Frame Name<span style="color: #EB2D30"></span> </label>
                                                <select id="frame_size_pop_up" name="frame_size_pop_up" class="form-input" onchange="return calculations();">
                                                    <option val="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                        <hr class="my-3" style="border: 1px solid #b0b0b0 !important;"/>
                                        <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 "><h4 style="font-weight:bold;    margin-bottom: 1%;">Tight Measurement</h4></div>
                                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                                          
                                          <div>
                                                <label for="t_m_w_pop_up">Top Width<span style="color: #EB2D30"></span> </label>
                                                <input type="number" step="any" id="t_m_w_pop_up" value="0" name="t_m_w_pop_up" class="form-input" oninput="return get_clearence_top_width();">
                                            </div>
                                            <div>
                                                <label for="t_m_b_w_pop_up">Bottom Width<span style="color: #EB2D30"></span> </label>
                                                <input type="number" step="any" id="t_m_b_w_pop_up" value="0" name="t_m_b_w_pop_up" class="form-input" oninput="return get_clearence_bottom_width();">
                                            </div>
                                            <div>
                                                <label for="t_m_h_pop_up">Height<span style="color: #EB2D30"></span> </label>
                                                <input type="number" step="any" id="t_m_h_pop_up" value="0" name="t_m_h_pop_up" class="form-input" oninput="return get_clearence_height();">
                                            </div>
                                            <div id="sqft_div">
                                                <label for="tm_sqft">Sq Ft<span style="color: #EB2D30"></span> </label>
                                                <input type="number" step="any" id="tm_sqft" value="0" name="tm_sqft" class="form-input">
                                            </div>
                                        </div>

                                        <hr class="my-3" style="border: 1px solid #b0b0b0 !important;" id="mwc_hr" />
                                        <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 " id="mwc_div_heading"><h4 style="font-weight:bold;    margin-bottom: 1%;">Measurement With Clearance</h4></div>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" id="mwc_div">
                                          
                                          <div>
                                                <label for="m_w_c_w_pop_up">Top Width<span style="color: #EB2D30"></span> </label>
                                                <input type="number" step="any" id="m_w_c_w_pop_up" value="0" name="m_w_c_w_pop_up" class="form-input" readonly="readonly">
                                            </div>
                                            <div>
                                                <label for="m_w_c_b_w_pop_up">Bottom Width<span style="color: #EB2D30"></span> </label>
                                                <input type="number" step="any" id="m_w_c_b_w_pop_up" value="0" name="m_w_c_b_w_pop_up" class="form-input" readonly="readonly">
                                            </div>
                                            <div>
                                                <label for="m_w_c_h_pop_up">Height<span style="color: #EB2D30"></span> </label>
                                                <input type="number" step="any" id="m_w_c_h_pop_up" value="0" name="m_w_c_h_pop_up" class="form-input" readonly="readonly">
                                            </div>
                                        </div>
                                        <hr class="my-3" style="border: 1px solid #b0b0b0 !important;"/>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" >
                                        <div id="door_color_type_div">
                                        <label for="color_type_pop_up">Door Color Type<span style="color: #EB2D30"></span> </label>
                                        <input type="text" name="color_type_pop_up" id="color_type_pop_up" readonly="readonly" class="form-input">
                                        </div>
                                        <div id="door_color_div">
                                                <label for="color_pop_up">Door Color<span style="color: #EB2D30"></span> </label>
                                                <select id="color_pop_up" name="color_pop_up" class="form-input" readonly="readonly">
                                                        <option val="">Select</option>
                                                        
                                                </select>
                                            </div>
                                            <div id="frame_color_div">
                                                <label for="frame_color_pop_up">Frame Color<span style="color: #EB2D30"></span> </label>
                                                <select id="frame_color_pop_up" name="frame_color_pop_up" class="form-input">
                                                        <option val="">Select</option>
                                                        @foreach ($single_color_list as $row)
                                                                          <option value="{{ $row->id; }}">{{ $row->s_c_p_name; }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                           
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" style="padding-top: 1%;">
                                        <div id="finish_work_div">
                                                <label for="finish_work_pop_up">Finish Work<span style="color: #EB2D30"></span> </label>
                                                <select id="finish_work_pop_up" name="finish_work_pop_up" class="form-input" onchange="return get_finsh_front_and_back();">
                                                    <option val=" ">Nill</option>
                                                    <option  val="Front">Front</option>
                                                    <option  val="Front&Back">Front & Back</option>
                                                </select>
                                            </div>
                                            <div id="f_w_f_div">
                                                <label for="finish_work_front_pop_up">Finish Work Front<span style="color: #EB2D30"></span> </label>
                                                <select id="finish_work_front_pop_up" name="finish_work_front_pop_up" class="form-input">
                                                    <option val="">Select</option>
                                                    <option  val="Glossy">Glossy</option>
                                                    <option  val="Leather">Leather</option>
                                                    <option  val="Mat">Mat</option>
                                                    <option  val="Stain">Stain</option>
                                                </select>
                                            </div>
                                            <div id="f_w_b_div">
                                                <label for="finish_work_back_pop_up">Finish Work Back<span style="color: #EB2D30"></span> </label>
                                                <select id="finish_work_back_pop_up" name="finish_work_back_pop_up" class="form-input">
                                                    <option val="">Select</option>
                                                    <option  val="Glossy">Glossy</option>
                                                    <option  val="Leather">Leather</option>
                                                    <option  val="Mat">Mat</option>
                                                    <option  val="Stain">Stain</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" style="padding-top: 1%;">

                                             <!-- <div>
                                                <label for="mat_finish_pop_up">Mat Finish<span style="color: #EB2D30"></span> </label>
                                                <input type="text" id="mat_finish_pop_up" name="mat_finish_pop_up" class="form-input">
                                            </div> -->

                                            <div id="steel_beeding_div">
                                                <label for="steel_beeding_pop_up">Steel Beeding<span style="color: #EB2D30"></span> </label>
                                                <select id="steel_beeding_pop_up" name="steel_beeding_pop_up" class="form-input">
                                                    <option val="">Select</option>
                                                    <option val="Yes">Yes</option>
                                                    <option val="No">No</option>
                                                </select>
                                            </div>
                                     
                                                
                                            <div id="texture_finish_div">
                                                <label for="texture_finish_pop_up">Texture Finish<span style="color: #EB2D30"></span> </label>
                                                <select id="texture_finish_pop_up" name="texture_finish_pop_up" class="form-input">
                                                    <option val="">Select</option>
                                                    <option val="Yes">Yes</option>
                                                    <option val="No">No</option>
                                                </select>
                                            </div>

                                            <div id="glass_type_div">
                                                <label for="glass_type_pop_up">Glass Type<span style="color: #EB2D30"></span> </label>
                                                <select id="glass_type_pop_up" name="glass_type_pop_up" class="form-input">
                                                        <option val="">Nill</option>
                                                    @foreach ($gt_lists as $row)
                                                        <option value="{{ $row->id; }}">
                                                      
                                                            {{$row->glass_type_name}}

                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" style="padding-top: 1%;">
                                                
                                            <div>
                                                <label for="hinges_pop_up">Hinges<span style="color: #EB2D30"></span> </label>
                                                <select id="hinges_pop_up" name="hinges_pop_up" class="form-input">
                                                    <option val="">Select</option>
                                                    <option val="3 - Left">3 - Left</option>
                                                    <option val="3 - Right">3 - Right</option>
                                                    <option val="4 - Left">4 - Left</option>
                                                    <option val="4 - Right">4 - Right</option>
                                                </select>
                                            </div>
                                            <div id="h_m_div">
                                                <label for="hinges_m_pop_up">Hinges Measurement<span style="color: #EB2D30"></span> </label>
                                               <input type="text" id="hinges_m_pop_up" name="hinges_m_pop_up" class="form-input">
                                            </div>

                                            <div id="lock_div">
                                                <label for="lock_pop_up">Lock<span style="color: #EB2D30"></span> </label>
                                                <select id="lock_pop_up" name="lock_pop_up" class="form-input">
                                                        <option val="">Select</option>
                                                    @foreach ($lk_lists as $row)
                                                        <option value="{{ $row->id; }}">
                                                      
                                                            {{$row->lock_name}}

                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" style="padding-top: 1%;">
                                        <div id="lock_measurement_div">
                                                <label for="lock_measurement_pop_up">Lock Measurement<span style="color: #EB2D30"></span> </label>
                                                <input type="text" name="lock_measurement_pop_up" id="lock_measurement_pop_up" class="form-input">
                                            </div>
                                            <div class="flex justify-end items-center mt-3">
                                            <button type="button" class="btn btn-outline-danger" @click="toggle">Discard</button>
                                            <button type="button" class="btn btn-primary ltr:ml-4 rtl:mr-4" @click="toggle" id="addBtn">Add</button>
                                        </div>  
                                        </div> 
                                          
                                        </div>
                                        
                                    </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                                
                 
</div>    
          



								
								
						
                            <div class="row" style="margin-top: 2%;">
                            <div class="col-sm-12">
                                <label for="remarks">Remarks<span style="color: #EB2D30"></span> </label>
										<textarea id="remarks" name="remarks" class="form-input">{{old('remarks')}}</textarea>
                                </div> 
</div>
              <div class="row" style="margin-top: 1%;">
						
									<div class="form-group col-sm-2">
                                    <button type="submit" id="submitButton" name="sbt" class="btn btn-primary !mt-6">Create&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
									</div>
								
								
							</div>

                        </div>
                </form> 


             
 <!-- end main content section -->
@endsection
@section('scripts')

<script>

 function type_change(){
    type_pop_up = $("#type_pop_up").val();
    $("#lock_measurement_div").show();
    if((type_pop_up == 'Door Only') || (type_pop_up == 'Door Only Without Clearence')){
      
       $('#frame_div').hide();
       $('#frame_color_div').hide();
       $('#frame_size_div').hide();
       $('#model_div').show();
       $('#mwc_hr').show();
       $('#mwc_div_heading').show();
       $('#mwc_div').show();
       $('#sqft_div').show();
       $('#door_color_type_div').show();
       $('#door_color_div').show();
       $('#finish_work_div').show();
       $('#steel_beeding_div').show();
       $('#glass_type_div').show();
       $('#texture_finish_div').show();
       $('#lock_div').show();
       $('#lock_measurement_div').show();
       $('#f_w_f_div').hide();
       $('#f_w_b_div').hide();
       
     }
     else if(type_pop_up == 'Frame Only'){
      
       $('#frame_div').show();
       $('#frame_color_div').show();
       $('#frame_size_div').hide();
       $('#model_div').hide();
       $('#mwc_hr').hide();
       $('#mwc_div_heading').hide();
       $('#mwc_div').hide();
       $('#sqft_div').hide();
       $('#door_color_type_div').hide();
       $('#door_color_div').hide();
       $('#finish_work_div').hide();
       $('#steel_beeding_div').hide();
       $('#glass_type_div').hide();
       $('#texture_finish_div').hide();
       $('#lock_div').hide();
       $('#lock_measurement_div').hide();
       $('#f_w_f_div').show();
       $('#f_w_b_div').hide();

       $('#frame_pop_up').empty();
       $('#frame_pop_up').append('<option value=" ">Select</option>');
       $('#frame_pop_up').append('<option value="Fiber">Fiber</option>');
             

     }
    else{
        
       $('#frame_div').show();
       $('#frame_color_div').show();
       $('#frame_size_div').hide();
       $('#model_div').show();
       $('#mwc_hr').show();
       $('#mwc_div_heading').show();
       $('#mwc_div').show();
       $('#sqft_div').show();
       $('#door_color_type_div').show();
       $('#door_color_div').show();
       $('#finish_work_div').show();
       $('#steel_beeding_div').show();
       $('#glass_type_div').show();
       $('#texture_finish_div').show();
       $('#lock_div').show();
       $('#lock_measurement_div').show();
       $('#frame_pop_up').empty();
       $('#frame_pop_up').append('<option value=" ">Select</option>');
       $('#frame_pop_up').append('<option value="Concrete">Concrete</option>');
       $('#frame_pop_up').append('<option value="Wooden">Wooden</option>');
       $('#frame_pop_up').append('<option value="Fiber">Fiber</option>');
       $('#frame_pop_up').append('<option value="Stainless Steel">Stainless Steel</option>');
       $('#f_w_f_div').hide();
       $('#f_w_b_div').hide();
    }
 }
</script>
<script>
    function get_color_type_and_color_by_model(){
        model_id = $("#model_pop_up").val();
        $.ajax({
				url: '{{route('get_color_type_and_color_name_executive')}}',
                data: {model_id: model_id},
				type: 'GET',
				success: function(data) {
                   $('#color_type_pop_up').val(data.details.color_type);
                   $('#color_pop_up').val(data.details.color_id);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});

    }
</script>
<script>
    function calculations(){
        get_clearence_top_width();
        get_clearence_bottom_width();
        get_clearence_height();
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

            $('#m_w_c_w_pop_up').val(t_m_w_pop_up.toFixed(3));
            $('#m_w_c_b_w_pop_up').val(t_m_b_w_pop_up.toFixed(3));
            $('#m_w_c_h_pop_up').val(t_m_h_pop_up.toFixed(3));

            var largerValue = Math.max(t_m_w_pop_up, t_m_b_w_pop_up);

        // Perform the calculations
        var result = (largerValue * t_m_h_pop_up) / 929;
        $("#tm_sqft").val(result.toFixed(3));

         }
         else if(type_pop_up == 'Frame Only'){
            $('#m_w_c_w_pop_up').val(0);
            $('#m_w_c_b_w_pop_up').val(0);
            $('#m_w_c_h_pop_up').val(0);
        }  
        else if(type_pop_up == 'Door Only Without Clearence'){
            var largerValue = Math.max(t_m_w_pop_up, t_m_b_w_pop_up);

            // Perform the calculations
            var result = (largerValue * t_m_h_pop_up) / 929;
            $("#tm_sqft").val(result.toFixed(3));

            $('#m_w_c_w_pop_up').val(t_m_w_pop_up);
            $('#m_w_c_b_w_pop_up').val(t_m_b_w_pop_up);
            $('#m_w_c_h_pop_up').val(t_m_h_pop_up);

            
        } 
        else{
            // Check which one is larger
                var largerValue = Math.max(t_m_w_pop_up, t_m_b_w_pop_up);

        // Perform the calculations
        var result = (largerValue * t_m_h_pop_up) / 929;
        $("#tm_sqft").val(result.toFixed(3));
        $('#m_w_c_w_pop_up').val("0");

        $.ajax({
                url: '{{route('get_top_width_clearence_executive')}}',
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

$('#m_w_c_w_pop_up').val(t_m_w_pop_up.toFixed(3));
$('#m_w_c_b_w_pop_up').val(t_m_b_w_pop_up.toFixed(3));
$('#m_w_c_h_pop_up').val(t_m_h_pop_up.toFixed(3));

}
else if(type_pop_up == 'Door Only Without Clearence'){
            var largerValue = Math.max(t_m_w_pop_up, t_m_b_w_pop_up);

            // Perform the calculations
            var result = (largerValue * t_m_h_pop_up) / 929;
            $("#tm_sqft").val(result.toFixed(3));

            $('#m_w_c_w_pop_up').val(t_m_w_pop_up);
            $('#m_w_c_b_w_pop_up').val(t_m_b_w_pop_up);
            $('#m_w_c_h_pop_up').val(t_m_h_pop_up);

            
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
				url: '{{route('get_top_width_clearence_executive')}}',
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
$('#m_w_c_w_pop_up').val(t_m_w_pop_up.toFixed(3));
$('#m_w_c_b_w_pop_up').val(t_m_b_w_pop_up.toFixed(3));
$('#m_w_c_h_pop_up').val(t_m_h_pop_up.toFixed(3));

}
else if(type_pop_up == 'Door Only Without Clearence'){
            var largerValue = Math.max(t_m_w_pop_up, t_m_b_w_pop_up);

            // Perform the calculations
            var result = (largerValue * t_m_h_pop_up) / 929;
            $("#tm_sqft").val(result.toFixed(3));

            $('#m_w_c_w_pop_up').val(t_m_w_pop_up);
            $('#m_w_c_b_w_pop_up').val(t_m_b_w_pop_up);
            $('#m_w_c_h_pop_up').val(t_m_h_pop_up);

            
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
				url: '{{route('get_top_width_clearence_executive')}}',
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
    $(document).ready(function() {
        $('#add_measurement_form').keypress(function(e) {
            // Check if Enter key is pressed (key code 13)
            if (e.which === 13) {
                e.preventDefault(); // Prevent form submission
                // You can add additional logic here if needed
            }
        });

       
    });
</script>
<script>
    $("#color_type_pop_up").change(function(){
		
		color_type = $("#color_type_pop_up").val();

		$.ajax({
				url: '{{route('get_color_list_executive')}}',
				type: 'GET',
				data: {color_type: color_type},
				success: function(data) {
                    clr_list = data.color_list;
                    $('#color_pop_up').empty();

                    $('#color_pop_up').append('<option value=" ">Select</option>');
					
                    $.each(clr_list, function(key, value) {
    var comboColor = value.combo_color_name;
    var tripleColor = value.triple_color_name;
    var optionText;

    if (value.color_type == "Single") {
        optionText = value.color_name;
    } else if (value.color_type == "Combo") {
        optionText = value.color_name + (comboColor ? ' & ' + comboColor : '');
    } else if (value.color_type == "Triple") {
        optionText = value.color_name + ' & ' + comboColor + ' & ' + tripleColor;
    }

    $('#color_pop_up').append('<option value="' + value.id + '">' + optionText + '</option>');
});


				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
	});
    function get_door_color(){
        color_type = $("#color_type_pop_up").val();

		$.ajax({
				url: '{{route('get_color_list_executive')}}',
				type: 'GET',
				data: {color_type: color_type},
				success: function(data) {
                    clr_list = data.color_list;
                    $('#color_pop_up').empty();

                    $('#color_pop_up').append('<option value=" ">Select</option>');
					
                    $.each(clr_list, function(key, value) {
    var comboColor = value.combo_color_name;
    var tripleColor = value.triple_color_name;
    var optionText;

    if (value.color_type == "Single") {
        optionText = value.color_name;
    } else if (value.color_type == "Combo") {
        optionText = value.color_name + (comboColor ? ' & ' + comboColor : '');
    } else if (value.color_type == "Triple") {
        optionText = value.color_name + ' & ' + comboColor + ' & ' + tripleColor;
    }

    $('#color_pop_up').append('<option value="' + value.id + '">' + optionText + '</option>');
});


				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
    }
function get_frame_size(){
    
$("#t_m_w_pop_up").val("0");
$("#t_m_b_w_pop_up").val("0");
$("#t_m_h_pop_up").val("0");
$("#m_w_c_w_pop_up").val("0");
$("#m_w_c_b_w_pop_up").val("0");
$("#m_w_c_h_pop_up").val("0");
    frame_pop_up = $("#frame_pop_up").val();
    if(frame_pop_up == 'Fiber'){
        $("#frame_size_div").show();
        $("#lock_measurement_div").show();
        // $("#h_m_div").hide();
        $.ajax({
				url: '{{route('get_frame_size_deatils_executive')}}',
				type: 'GET',
				success: function(data) {
                    fs_list = data.frame_sizes;
                    $('#frame_size_pop_up').empty();
                    $('#frame_size_pop_up').append('<option value=" ">Select</option>');
                        $.each(fs_list, function(key, value) {
                            $('#frame_size_pop_up').append('<option value="'+ value.id +'">'+ value.frame_name  +'</option>');
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
        $("#lock_measurement_div").show();
        $('#frame_size_pop_up').empty();
        $('#frame_size_pop_up').append('<option value=" ">Select</option>');
    }
}

function get_sub_models(){
		
    model_id = $("#model_pop_up").val();

		$.ajax({
				url: '{{route('get_sub_models_executive')}}',
				type: 'GET',
				data: {model_id: model_id},
				success: function(data) {
                    sub_mdls = data.sub_models;
                    $('#sub_model_pop_up').empty();

                    $('#sub_model_pop_up').append('<option value=" ">Select</option>');
					
                    $.each(sub_mdls, function(key, value) {
    

    $('#sub_model_pop_up').append('<option value="' + value.id + '">' + value.item_name + '</option>');
});


				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
            }

function get_details_of_sub_model(){
    sub_model_id = $("#sub_model_pop_up").val();

		$.ajax({
				url: '{{route('get_details_of_sub_model_executive')}}',
				type: 'GET',
				data: {sub_model_id: sub_model_id},
				success: function(data) {

                   $("#color_type_pop_up").val(data.details.color_type);
                   $("#color_pop_up").val(data.details.color_id);

				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
            }
            function get_color_type_details(){
                model_id = $("#model_pop_up").val();

                $.ajax({
                        url: '{{route('get_color_type_details_executive')}}',
                        type: 'GET',
                        data: {model_id: model_id},
                        success: function(data) {

                        $("#color_type_pop_up").val(data.details.color_type);
                        get_door_color();

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // Your logic to handle the error
                        }
                        });
            }
            function get_color_type_details_edit(){
                model_id = $("#model_pop_up_edit").val();

                $.ajax({
                        url: '{{route('get_color_type_details_executive')}}',
                        type: 'GET',
                        data: {model_id: model_id},
                        success: function(data) {

                        $("#color_type_pop_up_edit").val(data.details.color_type);
                        

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // Your logic to handle the error
                        }
                        });  
            }
            function get_sub_models_edit(){
		
        model_id = $("#model_pop_up_edit").val();
    
            $.ajax({
                    url: '{{route('get_sub_models_executive')}}',
                    type: 'GET',
                    data: {model_id: model_id},
                    success: function(data) {
                        sub_mdls = data.sub_models;
                        $('#sub_model_pop_up_edit').empty();
    
                        $('#sub_model_pop_up_edit').append('<option value=" ">Select</option>');
                        
                        $.each(sub_mdls, function(key, value) {
        
    
        $('#sub_model_pop_up_edit').append('<option value="' + value.id + '">' + value.item_name + '</option>');
    });
    
    
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Your logic to handle the error
                    }
                    });
                }
    
    function get_details_of_sub_model_edit(){
        sub_model_id = $("#sub_model_pop_up_edit").val();
    
            $.ajax({
                    url: '{{route('get_details_of_sub_model_executive')}}',
                    type: 'GET',
                    data: {sub_model_id: sub_model_id},
                    success: function(data) {
    
                       $("#color_type_pop_up_edit").val(data.details.color_type);
                       $("#color_pop_up_edit").val(data.details.color_id);
    
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Your logic to handle the error
                    }
                    });
                }
    
</script>
<script>
    function get_finsh_front_and_back(){
        finish_work = $("#finish_work_pop_up").val();
            if(finish_work == 'Front'){
                $("#f_w_f_div").show();
                $("#f_w_b_div").hide();
            }
            else if(finish_work == 'Front & Back'){
                $("#f_w_f_div").show();
                $("#f_w_b_div").show(); 
            }
            else{
           
                $("#f_w_f_div").hide();
                $("#f_w_b_div").hide();
            }
    }
</script>
<!-- <script>
    function get_customise_lock(){
        lock_pop_up = $("#lock_pop_up").val();
        frame_pop_up = $("#frame_pop_up").val();
            if((lock_pop_up == '1') && (frame_pop_up == 'Fiber')){
                $("#lock_measurement_div").show();
            }
            else{
                $("#lock_measurement_div").show();
            }
    }
</script> -->
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
<!--for item grid-->
<script>
    $(document).ready(function () {
       
     $("#frame_size_div").hide();
     $("#f_w_f_div").hide();
     $("#f_w_b_div").hide();
     $("#lock_measurement_div").show();






       $('#frame_color_div').show();
       $('#model_div').show();
       $('#mwc_hr').show();
       $('#mwc_div_heading').show();
       $('#mwc_div').show();
       $('#sqft_div').show();
       $('#door_color_type_div').show();
       $('#door_color_div').show();
       $('#finish_work_div').show();
       $('#steel_beeding_div').show();
       $('#glass_type_div').show();
       $('#texture_finish_div').show();
       $('#lock_div').show();
       $('#frame_pop_up').empty();
       $('#frame_pop_up').append('<option value=" ">Select</option>');
       $('#frame_pop_up').append('<option value="Concrete">Concrete</option>');
       $('#frame_pop_up').append('<option value="Wooden">Wooden</option>');
       $('#frame_pop_up').append('<option value="Fiber">Fiber</option>');
       $('#frame_pop_up').append('<option value="Stainless Steel">Stainless Steel</option>');
       $('#frame_pop_up').append('<option value="Door Only">Door Only</option>');







    });
  </script> 
    <script>
$(document).ready(function(){
  $("#customer_id").change(function(){
    customer_id = $("#customer_id").val();
    $.ajax({
				url: '{{route('get_customer_deatils_executive')}}',
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
</script>
<script>
$(document).ready(function(){
  $("#fitting_or_packing").change(function(){
    fitting_or_packing = $("#fitting_or_packing").val();
    $.ajax({
				url: '{{route('generate_order_no_executive')}}',
				type: 'GET',
				data: {fitting_or_packing: fitting_or_packing},
				success: function(data) {
                    $('#order_no').val(data.r_no);
                    check_items(data.r_no);
                    
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
  });
});
</script>
<script>
    function check_items(order_no){
        $.ajax({
				url: '{{route('check_in_measurement_items_executive')}}',
				type: 'GET',
				data: {order_no: order_no},
				success: function(data) {
                    
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
         $('#addBtn').click(function() {
            
        order_no =$("#order_no").val();
        type = $("#type_pop_up").val();
        model_id = $("#model_pop_up").val();
        frame_id = $("#frame_pop_up").val();
        t_m_w = $("#t_m_w_pop_up").val();
        t_m_b_w = $("#t_m_b_w_pop_up").val();
        t_m_h = $("#t_m_h_pop_up").val();
        tm_sqft = $('#tm_sqft').val();
        m_w_c_w = $("#m_w_c_w_pop_up").val();
        m_w_c_b_w = $("#m_w_c_b_w_pop_up").val();
        m_w_c_h = $("#m_w_c_h_pop_up").val();
        frame_size_id = $("#frame_size_pop_up").val();
        color_id = $("#color_pop_up").val();
        finish_work = $("#finish_work_pop_up").val();
        steel_beeding = $("#steel_beeding_pop_up").val();
        texture_finish = $("#texture_finish_pop_up").val();
        glass_type_id = $("#glass_type_pop_up").val();
        hinges = $("#hinges_pop_up").val();
        lock_id = $("#lock_pop_up").val();
        finish_work_front = $("#finish_work_front_pop_up").val();
        finish_work_back = $("#finish_work_back_pop_up").val();
        lock_measurement = $("#lock_measurement_pop_up").val();
        hinges_m = $("#hinges_m_pop_up").val();
        color_type = $("#color_type_pop_up").val();
        frame_color_id = $("#frame_color_pop_up").val();
        

        $.ajax({
				url: '{{route('save_as_tem_data_m_items_executive')}}',
				type: 'GET',
				data: {order_no:order_no,type: type,model_id:model_id,frame_id:frame_id,t_m_w:t_m_w,t_m_b_w:t_m_b_w,t_m_h:t_m_h,tm_sqft:tm_sqft,m_w_c_w:m_w_c_w,m_w_c_b_w:m_w_c_b_w,m_w_c_h:m_w_c_h,frame_size_id:frame_size_id,color_id:color_id,finish_work:finish_work,steel_beeding:steel_beeding,texture_finish:texture_finish,glass_type_id:glass_type_id,hinges:hinges,lock_id:lock_id,finish_work_front:finish_work_front,finish_work_back:finish_work_back,lock_measurement:lock_measurement,hinges_m:hinges_m,color_type:color_type,frame_color_id:frame_color_id},
				success: function(data) {


                    $("#model_pop_up").val('').trigger('change');
                    $("#frame_pop_up").val('').trigger('change');
                    $("#t_m_w_pop_up").val("0");
                    $("#t_m_b_w_pop_up").val("0");
                    $("#t_m_h_pop_up").val("0");
                    $("#m_w_c_w_pop_up").val("0");
                    $("#m_w_c_b_w_pop_up").val("0");
                    $("#m_w_c_h_pop_up").val("0");
                    $("#frame_size_pop_up").val('').trigger('change');
                    $("#color_pop_up").val('').trigger('change');
                    $("#finish_work_pop_up").val('').trigger('change');
                    // $("#mat_finish_pop_up").val(" ");
                    $("#steel_beeding_pop_up").val('').trigger('change');
                    $("#texture_finish_pop_up").val('').trigger('change');
                    $("#glass_type_pop_up").val('').trigger('change');
                    $("#hinges_pop_up").val('').trigger('change');
                    $("#lock_pop_up").val('').trigger('change');
                    $("#finish_work_front_pop_up").val('').trigger('change');
                    $("#finish_work_back_pop_up").val('').trigger('change');
                    $("#lock_measurement_pop_up").val(" ");
                    $("#hinges_m_pop_up").val(" ");
                    $("#color_type_pop_up").val('').trigger('change');
                    $("#frame_color_pop_up").val('').trigger('change');
                    $("#type_pop_up").val('').trigger('change');
                    $('#tm_sqft').val("0");
                   
                    $('#m_item_tbl tbody').empty();
                    var m_temp_data = data.mt_lists;

                    $.each(m_temp_data, function(index, item) {
                        // Assuming 'order_type', 'batch_no', and 'model_name' are properties in your item object

                        if(item.model_name == null){
                            mdl_nm = "-";
                        }
                        else{
                            mdl_nm = item.model_name;
                        }
                        var newRow = '<tr id="tr' + item.id + '">' +
                                    '<td>' + (index + 1) + '</td>' +
                                    '<td>' + item.order_type + '</td>' +
                                    '<td>' + mdl_nm + '</td>' +
                                    '<td>' + item.tight_measurement_top_width + '</td>' +
                                    '<td>' + item.tight_measurement_bottom_width + '</td>' +
                                    '<td>' + item.tight_measurement_height + '</td>' +
                                    '<td>' +
                                    '<button type="button" class="btn btn-danger delete-btn" data-id="' + item.id + '">Delete</button>' +
                                    '</td>' +
                                    '</tr>';


                        $('#m_item_tbl tbody').append(newRow);
                    });


				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});

               // Delete button click event
$('#m_item_tbl tbody').on('click', '.delete-btn', function() {
    var itemId = $(this).data('id');
    $.ajax({
				url: '{{route('delete_m_temp_item_executive')}}',
				type: 'GET',
				data: {itemId: itemId},
				success: function(response) {
                    // Remove the row from the table if the deletion was successful
                    if (response.success) {
                        $('#tr'+itemId).css('background','tomato');
                        $('#tr'+itemId).fadeOut(800,function(){
                        $(this).remove();
                        
                        });
                        
                    } else {
                        // Handle deletion failure if needed
                        console.error('Deletion failed');
                    }
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
<script>
   $(document).ready(function () {
    $('#submitButton').click(function (e) {
        // Check if the table has any rows in its tbody
        var tbodyRowCount = $('#m_item_tbl tbody tr').length;

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
<script>
    function get_m_items_tbl(){
        var order_no = $('#order_no').val();
    $.ajax({
				url: '{{route('get_list_of_m_items_executive')}}',
				type: 'GET',
				data: {order_no: order_no},
				success: function(response) {
                    // Remove the row from the table if the deletion was successful
                    $('#m_item_tbl tbody').empty();
                    var m_temp_data = response.mt_lists;

                    $.each(m_temp_data, function(index, item) {
                        // Assuming 'order_type', 'batch_no', and 'model_name' are properties in your item object

                        if(item.model_name == null){
                            mdl_nm = "-";
                        }
                        else{
                            mdl_nm = item.model_name;
                        }
                        var newRow = '<tr id="tr' + item.id + '">' +
                                    '<td>' + (index + 1) + '</td>' +
                                    '<td>' + item.order_type + '</td>' +
                                    '<td>' + item.batch_no + '</td>' +
                                    '<td>' + mdl_nm + '</td>' +
                                    '<td>' + item.tight_measurement_top_width + '</td>' +
                                    '<td>' + item.tight_measurement_bottom_width + '</td>' +
                                    '<td>' + item.tight_measurement_height + '</td>' +
                                    '<td>' +
                                    '<button type="button" class="btn btn-danger delete-btn" data-id="' + item.id + '">Delete</button>' +
                                    '</td>' +
                                    '</tr>';


                        $('#m_item_tbl tbody').append(newRow);
                    });
                },
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
  
    
    }
    </script>
    <script>
       document.addEventListener('DOMContentLoaded', function () {
        // Get the form element
        const myForm = document.getElementById('add_measurement_form');

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