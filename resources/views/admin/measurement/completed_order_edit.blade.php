
@extends('admin.layouts.app')

@section('content')
<!-- start main content section -->
<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Completed Order</h5>
<div x-data="invoiceAdd" class="pX-5 panel w-full">
<form class="form-horizontal"  id="add_measurement_form" name="add_measurement_form" action="{{ route('completed_order_update',$result->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
						<div class="form-body">
				
							<div class="row">
                            <div class="form-group col-sm-3">
									<label for="fitting_or_packing">Fitting / Packing<span style="color: #EB2D30"></span> </label>
										<select id="fitting_or_packing" name="fitting_or_packing" class="form-input">
                                            <option value="">Select</option>
                                            <option value="Fitting" {{ $result->fitting_or_packing == 'Fitting' ? 'selected' : '' }}>Fitting</option>
                                            <option value="Packing" {{ $result->fitting_or_packing == 'Packing' ? 'selected' : '' }}>Packing</option>
                                        </select>
										
								</div> 
								<div class="form-group col-sm-3">
									<label for="order_date">Order Date<span style="color: #EB2D30"></span> </label>
										<input type="date" id="order_date" max='<?php echo date("Y-m-d"); ?>' value="{{ $result->order_date;}}"  class="form-input" placeholder="" name="order_date" autocomplete="off">
										
								</div> 
                                <div class="form-group col-sm-3">
									<label for="delivery_date">Delivery Date<span style="color: #EB2D30"></span> </label>
										<input type="date" id="delivery_date" min='<?php echo date("Y-m-d"); ?>' value="{{ $result->delivery_date;}}"  class="form-input" placeholder="" name="delivery_date" autocomplete="off">
										
								</div> 
                                <div class="form-group col-sm-3">
								<label for="order_no">Order No<span style="color: #EB2D30"></span> </label>
										<input type="text" id="order_no" readonly="readonly" class="form-input" placeholder="" name="order_no" value="{{ $result->order_no;}}" autocomplete="off">
								</div> 



                                
                                <div class="form-group col-sm-3">
									<label for="customer_id">Customer<span style="color: #EB2D30"></span> </label>
										<select id="customer_id" name="customer_id" class="form-input">
                                           <option  value="" selected>Select</option>
                                            @foreach ($customer_lists as $row)
                                                <option value="{{ $row->id; }}" {{ $row->id == $result->customer_id ? 'selected' : '' }}>{{ $row->customer_name; }}</option>
                                            @endforeach
                                        </select>
                                      	</div> 

                                        
                                <div class="form-group col-sm-3">
								<label for="brand">Brand<span style="color: #EB2D30"></span> </label>
										<input type="text" id="brand"  class="form-input" placeholder="" name="brand" autocomplete="off">
								</div> 
                               
                                <div class="form-group col-sm-6">
									<label for="customer_address">Customer Address<span style="color: #EB2D30"></span> </label>
										<textarea id="customer_address" name="customer_address" class="form-input"></textarea>
								</div> 
                                <div class="form-group col-sm-3">
									<label for="root_id">Root<span style="color: #EB2D30"></span> </label>
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
									<label for="site_name">Site Name<span style="color: #EB2D30"></span> </label>
                                    <input type="text" id="site_name" name="site_name" value="{{ $result->site_name;}}" class="form-input">
		
								</div> 
                                <div class="form-group col-sm-3">
									<label for="site_address">Site Address<span style="color: #EB2D30"></span> </label>
										<textarea id="site_address" name="site_address" class="form-input">{{ $result->site_address;}}</textarea>
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
                                                <th rowspan=2>Color</th>
                                                
                                                <th  style="display:none" rowspan=2 >Stain Work</th>
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
                                            </tr>
                                            </thead>
                                                <tbody id="tbody">
                                                @foreach($m_items as $m_item)
                                                <tr id="R{{$no++}}"><td>{{$no}}</td>
                                                <td><input type="text" id="batch_no{{$no}}" value="{{$m_item->batch_no}}" class="form-input" name="batch_no[]" readonly="readonly"></td>
                                                <td><input type="text" class="form-input" value="{{$m_item->model_name}}" name="mdl_txt" id="mdl_txt{{$no}}"></td>
                                                <td><input type="text" id="frame{{$no}}" value="{{$m_item->frame}}" class="form-input" name="frame[]"></td>
                                                <td><input type="text" class="form-input" value="{{$m_item->color_name}}" name="clr_txt" id="clr_txt{{$no}}">


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


                                              


  <!-- extra large -->    
  <div x-data="modal">
                        <!-- button -->    
                        <button type="button" class="btn btn-warning" @click="toggle">Edit</button>
                        
                        <!-- modal --> 
                        <div class="fixed inset-0 bg-[black]/60 z-[999]  hidden" :class="open && '!block'">
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

                                       <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                            <div>
                                                <label for="model_pop_up">Model<span style="color: #EB2D30"></span> </label>
                                                <select id="model_pop_up" name="model_pop_up" class="form-input">
                                                        <option val="">Select</option>
                                                    @foreach ($model_lists as $row)
                                                        <option value="{{ $row->id; }}" {{ $row->id == $m_item->model_id ? 'selected' : '' }}>{{ $row->model_name; }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                            <label for="frame_pop_up">Frame<span style="color: #EB2D30"></span> </label>
                                                <select id="frame_pop_up" name="frame_pop_up" class="form-input" onchange="return get_frame_size();">
                                                    <option val="">Select</option>
                                                    <option val="Concrete" {{ $m_item->frame == 'Concrete' ? 'selected' : '' }}>Concrete</option>
                                                    <option val="Wooden" {{ $m_item->frame == 'Wooden' ? 'selected' : '' }}>Wooden</option>
                                                    <option val="Fiber" {{ $m_item->frame == 'Fiber' ? 'selected' : '' }}>Fiber</option>
                                                    <option val="Stainless Steel" {{  $m_item->frame == 'Stainless Steel' ? 'selected' : '' }}>Stainless Steel</option>
                                                </select>
                                            </div>
                                            <div id="frame_size_div">
                                                <label for="frame_size_pop_up">Frame Size<span style="color: #EB2D30"></span> </label>
                                                <select id="frame_size_pop_up" name="frame_size_pop_up" class="form-input">
                                                    <option val="">Select</option>
                                                    @foreach ($fs_lists as $row)
                                                        <option value="{{ $row->id; }}" {{ $row->id == $m_item->frame_size ? 'selected' : '' }}>{{ $row->frame_size; }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <hr class="my-3" style="border: 1px solid #b0b0b0 !important;"/>
                                        <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 "><h4 style="font-weight:bold;    margin-bottom: 1%;">Tight Measurement</h4></div>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                          
                                          <div>
                                                <label for="t_m_w_pop_up">Top Width<span style="color: #EB2D30"></span> </label>
                                                <input type="text" id="t_m_w_pop_up" name="t_m_w_pop_up" value="{{$m_item->tight_measurement_top_width;}}" class="form-input">
                                            </div>
                                            <div>
                                                <label for="t_m_b_w_pop_up">Bottom Width<span style="color: #EB2D30"></span> </label>
                                                <input type="text" id="t_m_b_w_pop_up" name="t_m_b_w_pop_up" value="{{$m_item->tight_measurement_bottom_width;}}" class="form-input">
                                            </div>
                                            <div>
                                                <label for="t_m_h_pop_up">Height<span style="color: #EB2D30"></span> </label>
                                                <input type="text" id="t_m_h_pop_up" name="t_m_h_pop_up" value="{{$m_item->tight_measurement_height;}}" class="form-input">
                                            </div>
                                        </div>

                                        <hr class="my-3" style="border: 1px solid #b0b0b0 !important;" />
                                        <div class="grid grid-cols-1 sm:grid-cols-6 gap-4 "><h4 style="font-weight:bold;    margin-bottom: 1%;">Measurement With Clearance</h4></div>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                          
                                          <div>
                                                <label for="m_w_c_w_pop_up">Top Width<span style="color: #EB2D30"></span> </label>
                                                <input type="text" id="m_w_c_w_pop_up" name="m_w_c_w_pop_up" value="{{$m_item->measurement_with_clearance_top_width;}}" class="form-input">
                                            </div>
                                            <div>
                                                <label for="m_w_c_b_w_pop_up">Bottom Width<span style="color: #EB2D30"></span> </label>
                                                <input type="text" id="m_w_c_b_w_pop_up" name="m_w_c_b_w_pop_up" value="{{$m_item->measurement_with_clearance_bottom_width;}}" class="form-input">
                                            </div>
                                            <div>
                                                <label for="m_w_c_h_pop_up">Height<span style="color: #EB2D30"></span> </label>
                                                <input type="text" id="m_w_c_h_pop_up" name="m_w_c_h_pop_up" value="{{$m_item->measurement_with_clearance_height;}}" class="form-input">
                                            </div>
                                        </div>
                                        <hr class="my-3" style="border: 1px solid #b0b0b0 !important;"/>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" >
                                        <div>
                                        <label for="color_type_pop_up">Color Type<span style="color: #EB2D30"></span> </label>
                                        <select id="color_type_pop_up" name="color_type_pop_up" class="form-input">
                                            <option val="">Select</option>
                                            <option val="Single" {{ $m_item->color_type == 'Single' ? 'selected' : '' }}>Single</option>
                                            <option val="Combo" {{ $m_item->color_type == 'Combo' ? 'selected' : '' }}>Combo</option>
                                        </select>
                                        </div>
                                        <div>
                                                <label for="color_pop_up">Color<span style="color: #EB2D30"></span> </label>
                                                <select id="color_pop_up" name="color_pop_up" class="form-input">
                                                        <option val="">Select</option>
                                                    @foreach ($color_lists as $row)
                                                        <option value="{{ $row->id; }}" {{ $row->id == $m_item->color_id ? 'selected' : '' }}>
                                                        @if(!$row->combo_color_name)
                                                            {{$row->color_name}}
                                                        @else
                                                            {{$row->color_name}} & {{$row->combo_color_name}}
                                                        @endif 
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div>
                                                <label for="finish_work_pop_up">Finish Work<span style="color: #EB2D30"></span> </label>
                                                <select id="finish_work_pop_up" name="finish_work_pop_up" class="form-input" onchange="return get_finsh_front_and_back();">
                                                    <option val="">Select</option>
                                                    <option  val="Front" {{ $m_item->finish_work == 'Front' ? 'selected' : '' }}>Front</option>
                                                    <option  val="Front&Back" {{ $m_item->finish_work == 'Front&Back' ? 'selected' : '' }}>Front & Back</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" style="padding-top: 1%;">
                                            <div id="f_w_f_div">
                                                <label for="finish_work_front_pop_up">Finsh Work Front<span style="color: #EB2D30"></span> </label>
                                                <select id="finish_work_front_pop_up" name="finish_work_front_pop_up" class="form-input">
                                                    <option val="">Select</option>
                                                    <option  val="Glossy" {{ $m_item->finish_work_front == 'Glossy' ? 'selected' : '' }}>Glossy</option>
                                                    <option  val="Leather" {{ $m_item->finish_work_front == 'Leather' ? 'selected' : '' }}>Leather</option>
                                                    <option  val="Mat" {{ $m_item->finish_work_front == 'Mat' ? 'selected' : '' }}>Mat</option>
                                                    <option  val="Stain" {{ $m_item->finish_work_front == 'Stain' ? 'selected' : '' }}>Stain</option>
                                                </select>
                                            </div>
                                            <div id="f_w_b_div">
                                                <label for="finish_work_back_pop_up">Finsh Work Back<span style="color: #EB2D30"></span> </label>
                                                <select id="finish_work_back_pop_up" name="finish_work_back_pop_up" class="form-input">
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

                                            <div>
                                                <label for="steel_beeding_pop_up">Steel Beeding<span style="color: #EB2D30"></span> </label>
                                                <select id="steel_beeding_pop_up" name="steel_beeding_pop_up" class="form-input">
                                                    <option val="">Select</option>
                                                    <option val="Yes" {{ $m_item->steel_beeding == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option val="No" {{ $m_item->steel_beeding == 'No' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                     
                                                
                                            <div>
                                                <label for="texture_finish_pop_up">Texture Finish<span style="color: #EB2D30"></span> </label>
                                                <select id="texture_finish_pop_up" name="texture_finish_pop_up" class="form-input">
                                                    <option val="">Select</option>
                                                    <option val="Yes" {{ $m_item->texture_finish == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option val="No" {{ $m_item->texture_finish == 'No' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>

                                            <div>
                                                <label for="glass_type_pop_up">Glass Type<span style="color: #EB2D30"></span> </label>
                                                <select id="glass_type_pop_up" name="glass_type_pop_up" class="form-input">
                                                        <option val="">Select</option>
                                                    @foreach ($gt_lists as $row)
                                                        <option value="{{ $row->id; }}" {{ $row->id == $m_item->glass_type ? 'selected' : '' }}>
                                                      
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
                                                    <option val="3 - Left" {{ $m_item->hinges == '3 - Left' ? 'selected' : '' }}>3 - Left</option>
                                                    <option val="3 - Right" {{ $m_item->hinges == '3 - Right' ? 'selected' : '' }}>3 - Right</option>
                                                    <option val="4 - Left" {{ $m_item->hinges == '4 - Left' ? 'selected' : '' }}>4 - Left</option>
                                                    <option val="4 - Right" {{ $m_item->hinges == '4 - Right' ? 'selected' : '' }}>4 - Right</option>
                                                </select>
                                            </div>
                                            <div id="h_m_div">
                                                <label for="hinges_m_pop_up">Hinges Measurement<span style="color: #EB2D30"></span> </label>
                                               <input type="text" id="hinges_m_pop_up" value="{{$m_item->hinges_measurement}}" name="hinges_m_pop_up" class="form-input">
                                            </div>

                                            <div>
                                                <label for="lock_pop_up">Lock<span style="color: #EB2D30"></span> </label>
                                                <select id="lock_pop_up" name="lock_pop_up" class="form-input" onchange="return get_customise_lock();">
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
                                        <div id="lock_measurement_div">
                                                <label for="lock_measurement_pop_up">Lock Measurement<span style="color: #EB2D30"></span> </label>
                                                <input type="text" name="lock_measurement_pop_up" value="{{$m_item->lock_measurement}}" id="lock_measurement_pop_up" class="form-input">
                                            </div>
                                            <div class="flex justify-end items-center mt-3">
                                            <button type="button" class="btn btn-warning " @click="toggle">Discard</button>
                                            <button type="button" class="btn btn-danger ltr:ml-4 rtl:mr-4"  @click="showAlert({{$m_item->id}})">Delete</button>
                                            <button type="button" class="btn btn-success ltr:ml-4 rtl:mr-4" @click="showAlert_confirm({{$m_item->id}})">Update</button>
                                        </div>  
                                        </div> 
                                          
                                        </div>
                                        
                                    </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                   




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
                                    <button type="submit" name="sbt" class="btn btn-primary !mt-6">Update&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
									</div>
								
								
							</div>

                        </div>
                </form> 
</div>
 <!-- end main content section -->
@endsection
@section('scripts')
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
                    reloadPage(); // Reload the page
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


    async function showAlert_confirm(mt_id) {
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



                model_pop_up = $("#model_pop_up").val();
                frame_pop_up = $("#frame_pop_up").val();
                t_m_w_pop_up = $("#t_m_w_pop_up").val();
                t_m_b_w_pop_up = $("#t_m_b_w_pop_up").val();
                t_m_h_pop_up = $("#t_m_h_pop_up").val();
                m_w_c_w_pop_up = $("#m_w_c_w_pop_up").val();
                m_w_c_b_w_pop_up = $("#m_w_c_b_w_pop_up").val();
                m_w_c_h_pop_up = $("#m_w_c_h_pop_up").val();
                frame_size_pop_up = $("#frame_size_pop_up").val();
                color_pop_up = $("#color_pop_up").val();
                finish_work_pop_up = $("#finish_work_pop_up").val();
            // mat_finish_pop_up = $("#mat_finish_pop_up").val();
                steel_beeding_pop_up = $("#steel_beeding_pop_up").val();
                texture_finish_pop_up = $("#texture_finish_pop_up").val();
                glass_type_pop_up = $("#glass_type_pop_up").val();
                hinges_pop_up = $("#hinges_pop_up").val();
                lock_pop_up = $("#lock_pop_up").val();
                finish_work_front_pop_up = $("#finish_work_front_pop_up").val();
                finish_work_back_pop_up = $("#finish_work_back_pop_up").val();
                lock_measurement_pop_up = $("#lock_measurement_pop_up").val();
                hinges_m_pop_up = $("#hinges_m_pop_up").val();
                color_type_pop_up = $("#color_type_pop_up").val();

                                         

                $.ajax({
				url: '{{route('completed_order_items_update')}}',
				type: 'GET',
				data: {mt_id: mt_id,model_pop_up:model_pop_up,frame_pop_up:frame_pop_up,t_m_w_pop_up:t_m_w_pop_up,t_m_b_w_pop_up:t_m_b_w_pop_up,t_m_h_pop_up:t_m_h_pop_up,m_w_c_w_pop_up:m_w_c_w_pop_up,m_w_c_b_w_pop_up:m_w_c_b_w_pop_up,m_w_c_h_pop_up:m_w_c_h_pop_up,frame_size_pop_up:frame_size_pop_up,color_pop_up:color_pop_up,finish_work_pop_up:finish_work_pop_up,steel_beeding_pop_up:steel_beeding_pop_up,texture_finish_pop_up:texture_finish_pop_up,glass_type_pop_up:glass_type_pop_up,hinges_pop_up:hinges_pop_up,lock_pop_up:lock_pop_up,finish_work_front_pop_up:finish_work_front_pop_up,finish_work_back_pop_up:finish_work_back_pop_up,lock_measurement_pop_up:lock_measurement_pop_up,hinges_m_pop_up:hinges_m_pop_up,color_type_pop_up:color_type_pop_up},
				success: function(data) {
                    swalWithBootstrapButtons.fire('Order Updated!', 'success').then(() => {
                    // This will be executed after the user clicks the "OK" button on the success message
                    reloadPage(); // Reload the page
                });
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});


               
            } else if (result.dismiss === window.Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire('Cancelled', 'Your order file is safe :)', 'error');
            }
        });
    }

  
    

</script>
<script>
    $("#color_type_pop_up").change(function(){
		
		color_type = $("#color_type_pop_up").val();

		$.ajax({
				url: '{{route('get_color_list')}}',
				type: 'GET',
				data: {color_type: color_type},
				success: function(data) {
                    clr_list = data.color_list;
                    $('#color_pop_up').empty();

                    $('#color_pop_up').append('<option value=" ">Select</option>');
					$.each(clr_list, function(key, value) {
						if (value.combo_color_name == "") {
							$('#color_pop_up').append('<option value="' + value.id + '">' + value.color_name + '</option>');
						} else {
							var comboColor = value.combo_color_name;
							$('#color_pop_up').append('<option value="' + value.id + '">' + value.color_name + (comboColor ? ' & ' + comboColor : '') + '</option>');
						}
					});
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
	});
function get_frame_size(){
    

    frame_pop_up = $("#frame_pop_up").val();
    if(frame_pop_up == 'Fiber'){
        $("#frame_size_div").show();
        $("#h_m_div").hide();
        $.ajax({
				url: '{{route('get_frame_size_deatils')}}',
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
        $("#h_m_div").show();
        $('#frame_size_pop_up').empty();
        $('#frame_size_pop_up').append('<option value=" ">Select</option>');
    }
}
</script>
<script>
    function get_finsh_front_and_back(){
        finish_work = $("#finish_work_pop_up").val();
            if(finish_work == 'Front'){
                $("#f_w_f_div").show();
                $("#f_w_b_div").hide();
            }
            else{
                $("#f_w_f_div").show();
                $("#f_w_b_div").show();
            }
    }
</script>
<script>
    function get_customise_lock(){
        lock_pop_up = $("#lock_pop_up").val();
        
            if(lock_pop_up == '1'){
                $("#lock_measurement_div").show();
            }
            else{
                $("#lock_measurement_div").hide();
            }
    }
</script>
<!--for item grid-->
<script>
    $(document).ready(function () {



        $.ajax({
				url: '{{route('check_measurement_items_status')}}',
				type: 'GET',
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

       
     $("#frame_size_div").hide();
     $("#f_w_f_div").hide();
     $("#f_w_b_div").hide();
     $("#lock_measurement_div").hide();
     $("#h_m_div").hide();
     get_finsh_front_and_back();
     get_customise_lock();


     frame_pop_up = $("#frame_pop_up").val();
    if(frame_pop_up == 'Fiber'){
        $("#frame_size_div").show();
        $("#h_m_div").hide();
       
    }
    else{
        $("#frame_size_div").hide();
        $("#h_m_div").show();
        $('#frame_size_pop_up').empty();
        $('#frame_size_pop_up').append('<option value=" ">Select</option>');
    }

    customer_id = $("#customer_id").val();
    $.ajax({
				url: '{{route('get_customer_deatils')}}',
				type: 'GET',
				data: {customer_id: customer_id},
				success: function(data) {
                    $('#brand').val(data.brand);
                    $('#customer_address').text(data.customer_address);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
  $("#fitting_or_packing").change(function(){
    fitting_or_packing = $("#fitting_or_packing").val();
    $.ajax({
				url: '{{route('generate_order_no')}}',
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
$(document).ready(function(){
  $("#customer_id").change(function(){
    customer_id = $("#customer_id").val();
    $.ajax({
				url: '{{route('get_customer_deatils')}}',
				type: 'GET',
				data: {customer_id: customer_id},
				success: function(data) {
                    $('#brand').val(data.brand);
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
                        document.addEventListener("alpine:init", () => {
                            Alpine.data("modal", (initialOpenState = false) => ({
                                open: initialOpenState,
                    
                                toggle() {
                                    this.open = !this.open;
                                },
                            }));
                        });
                    </script>
@endsection