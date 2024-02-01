
@extends('fitting.layouts.app')

@section('content')
<!-- start main content section -->
<div x-data="">
  
                        <div class="mb-6 flex flex-wrap items-center justify-center gap-4 lg:justify-end">
                            <button type="button" class="btn btn-info gap-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                                    <path
                                        d="M17.4975 18.4851L20.6281 9.09373C21.8764 5.34874 22.5006 3.47624 21.5122 2.48782C20.5237 1.49939 18.6511 2.12356 14.906 3.37189L5.57477 6.48218C3.49295 7.1761 2.45203 7.52305 2.13608 8.28637C2.06182 8.46577 2.01692 8.65596 2.00311 8.84963C1.94433 9.67365 2.72018 10.4495 4.27188 12.0011L4.55451 12.2837C4.80921 12.5384 4.93655 12.6658 5.03282 12.8075C5.22269 13.0871 5.33046 13.4143 5.34393 13.7519C5.35076 13.9232 5.32403 14.1013 5.27057 14.4574C5.07488 15.7612 4.97703 16.4131 5.0923 16.9147C5.32205 17.9146 6.09599 18.6995 7.09257 18.9433C7.59255 19.0656 8.24576 18.977 9.5522 18.7997L9.62363 18.79C9.99191 18.74 10.1761 18.715 10.3529 18.7257C10.6738 18.745 10.9838 18.8496 11.251 19.0285C11.3981 19.1271 11.5295 19.2585 11.7923 19.5213L12.0436 19.7725C13.5539 21.2828 14.309 22.0379 15.1101 21.9985C15.3309 21.9877 15.5479 21.9365 15.7503 21.8474C16.4844 21.5244 16.8221 20.5113 17.4975 18.4851Z"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    />
                                    <path opacity="0.5" d="M6 18L21 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                Send 
                            </button>

                            <button type="button" class="btn btn-primary gap-2" @click="print">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                                    <path
                                        d="M6 17.9827C4.44655 17.9359 3.51998 17.7626 2.87868 17.1213C2 16.2426 2 14.8284 2 12C2 9.17157 2 7.75736 2.87868 6.87868C3.75736 6 5.17157 6 8 6H16C18.8284 6 20.2426 6 21.1213 6.87868C22 7.75736 22 9.17157 22 12C22 14.8284 22 16.2426 21.1213 17.1213C20.48 17.7626 19.5535 17.9359 18 17.9827"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    />
                                    <path opacity="0.5" d="M9 10H6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M19 14L5 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path
                                        d="M18 14V16C18 18.8284 18 20.2426 17.1213 21.1213C16.2426 22 14.8284 22 12 22C9.17157 22 7.75736 22 6.87868 21.1213C6 20.2426 6 18.8284 6 16V14"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                    />
                                    <path
                                        opacity="0.5"
                                        d="M17.9827 6C17.9359 4.44655 17.7626 3.51998 17.1213 2.87868C16.2427 2 14.8284 2 12 2C9.17158 2 7.75737 2 6.87869 2.87868C6.23739 3.51998 6.06414 4.44655 6.01733 6"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    />
                                    <circle opacity="0.5" cx="17" cy="10" r="1" fill="currentColor" />
                                    <path opacity="0.5" d="M15 16.5H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path opacity="0.5" d="M13 19H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                                Print
                            </button>

                            <button type="button" class="btn btn-success gap-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                                    <path
                                        opacity="0.5"
                                        d="M17 9.00195C19.175 9.01406 20.3529 9.11051 21.1213 9.8789C22 10.7576 22 12.1718 22 15.0002V16.0002C22 18.8286 22 20.2429 21.1213 21.1215C20.2426 22.0002 18.8284 22.0002 16 22.0002H8C5.17157 22.0002 3.75736 22.0002 2.87868 21.1215C2 20.2429 2 18.8286 2 16.0002L2 15.0002C2 12.1718 2 10.7576 2.87868 9.87889C3.64706 9.11051 4.82497 9.01406 7 9.00195"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                    ></path>
                                    <path
                                        d="M12 2L12 15M12 15L9 11.5M12 15L15 11.5"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    ></path>
                                </svg>
                                Download
                            </button>

                           
                            <a href="{{ route('measurement_form_edit_fitting',$result->id) }}" class="btn btn-warning gap-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5">
                                    <path
                                        opacity="0.5"
                                        d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round"
                                    ></path>
                                    <path
                                        d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    ></path>
                                    <path
                                        opacity="0.5"
                                        d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                    ></path>
                                </svg>
                                Edit
                            </a>
                        </div>
                        <div class="panel">
                        

                        <table style="width:100%" class="table-bordered ">
                            <tr>
                                <td colspan="3" class="text-center"><div class="text-2xl font-semibold uppercase">Measurement Form</div></td>
                                <td>Order Date : {{$result->order_date;}} </td>
                            </tr>
                            <tr>
                                <td>Shop Name & Address : {{$result->site_name}} </br>  {{$result->site_address}}  </td>
                                <td>Customer Name & Address : {{$result->customer_name}} </br> {{$result->brand_name}} </br> {{$result->permenant_address}}</td>
                                <td>No : {{$result->order_no;}}</td>
                                <td>Delivery Date : {{$result->delivery_date;}}</td>
                            </tr>
                            
                            </table>
                            <div class="table-responsive mt-6">
                                <table style="width:100%" class="table-bordered ">
                                    <thead>
                                   
                                        <tr>
                                            
                                            <th rowspan=2 >No</th>
                                            <th rowspan=2 >Batch No</th>
                                            <th rowspan=2 width="350px">Model</th>
                                            <th  rowspan=2 width="150px">Frame</th>
                                            <th  rowspan=2 >Frame Size</th>
                                            
                                            <th class="text-center" colspan="3">Tight Measurement</th>
                                         
                                           <th rowspan=2 class="text-center">Actions</th>
                                           
                                          
                                        </tr>
                                        <tr>
                                            <th class="text-center" >Top Width</th>
                                            <th class="text-center">Bottom Width</th>
                                            <th class="text-center">Height</th>
                                            
                                        </tr>
                                       
                                    </thead>
                                    <tbody>
                                    @foreach($m_items as $m_item)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$m_item->batch_no;}}</td>
                                        <td>{{$m_item->model_name;}}</td>
                                        <td>{{$m_item->frame;}}</td>
                                        <td>{{$m_item->frame_size;}}</td>
                                        <td>{{$m_item->tight_measurement_top_width;}}</td>
                                        <td>{{$m_item->tight_measurement_bottom_width;}}</td>
                                        <td>{{$m_item->tight_measurement_height;}}</td>
                                        
                                        <td>
                                        <div x-data="modal" class="pt-4" >
                        <!-- button -->    
                        <button type="button" class="btn btn-warning" @click="type_change({{$no}});toggle();"  ><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
    <path
        opacity="0.5"
        d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"
        stroke="currentColor"
        stroke-width="1.5"
    ></path>
    <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="1.5"></path>
</svg>&nbsp;View</button>
                        
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
                                                <input type="text" class="form-input" id="type_pop_up_{{$no}}" name="type_pop_up" value="{{$m_item->order_type;}}" disabled="disabled">
                                            </div>
                                            <div id="model_div_{{$no}}">
                                                <label for="model_pop_up">Model<span style="color: #EB2D30"></span> </label>
                                                <input type="text" id="model_pop_up_{{$no}}" class="form-input" value="{{$m_item->model_name;}}" disabled="disabled">
                                            </div>
                               

                                            <div id="frame_div_{{$no}}">
                                            <label for="frame_pop_up">Frame<span style="color: #EB2D30"></span> </label>
                                            <input type="text" id="frame_pop_up_{{$no}}" class="form-input" value="{{$m_item->frame;}}" disabled="disabled">
                                            </div>
                                            <div id="frame_size_div_{{$no}}">
                                                <label for="frame_size_pop_up">Frame Name<span style="color: #EB2D30"></span> </label>
                                                <input type="text" class="form-input" value="{{$m_item->frame_size;}}" disabled="disabled" id="frame_size_pop_up_{{$no}}" >
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
                                                <input type="text" class="form-input" id="color_pop_up_{{$no}}" value="{{$m_item->door_color_name;}}" disabled="disabled">
                                            </div>
                                            <div id="frame_color_div">
                                                <label for="frame_color_pop_up">Frame Color<span style="color: #EB2D30"></span> </label>
                                                <input type="text" class="form-input" id="frame_color_pop_up_{{$no}}" value="{{$m_item->frame_color_name;}}" disabled="disabled">
                                            </div>
                                           
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" style="padding-top: 1%;">
                                        <div id="finish_work_div_{{$no}}">
                                                <label for="finish_work_pop_up">Finish Work<span style="color: #EB2D30"></span> </label>
                                                <input type="text" class="form-input" id="finish_work_pop_up_{{$no}}" value="{{$m_item->finish_work;}}" disabled="disabled">
                                            </div>
                                            <div id="f_w_f_div_{{$no}}">
                                                <label for="finish_work_front_pop_up">Finsh Work Front<span style="color: #EB2D30"></span> </label>
                                                <input type="text" class="form-input" id="finish_work_front_pop_up_{{$no}}"  value="{{$m_item->finish_work_front;}}" disabled="disabled">
                                            </div>
                                            <div id="f_w_b_div_{{$no}}">
                                                <label for="finish_work_back_pop_up">Finsh Work Back<span style="color: #EB2D30"></span> </label>
                                                <input type="text" class="form-input" id="finish_work_back_pop_up_{{$no}}"  value="{{$m_item->finish_work_back;}}" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" style="padding-top: 1%;">

                                             <!-- <div>
                                                <label for="mat_finish_pop_up">Mat Finish<span style="color: #EB2D30"></span> </label>
                                                <input type="text" id="mat_finish_pop_up" name="mat_finish_pop_up" class="form-input">
                                            </div> -->

                                            <div id="steel_beeding_div_{{$no}}">
                                                <label for="steel_beeding_pop_up">Steel Beeding<span style="color: #EB2D30"></span> </label>
                                                <input type="text" class="form-input" id="steel_beeding_pop_up_{{$no}}"  value="{{$m_item->steel_beeding;}}" disabled="disabled">
                                            </div>
                                     
                                                
                                            <div id="texture_finish_div_{{$no}}">
                                                <label for="texture_finish_pop_up">Texture Finish<span style="color: #EB2D30"></span> </label>
                                                <input type="text" class="form-input" id="texture_finish_pop_up_{{$no}}" value="{{$m_item->texture_finish;}}" disabled="disabled">
                                            </div>

                                            <div id="glass_type_div_{{$no}}">
                                                <label for="glass_type_pop_up">Glass Type<span style="color: #EB2D30"></span> </label>
                                                <input type="text" class="form-input" id="glass_type_pop_up_{{$no}}" value="{{$m_item->glass_type_name;}}" disabled="disabled">
                                            </div>

                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4" style="padding-top: 1%;">
                                        <div id="door_thickness_div_{{$no}}">
                                                <label for="door_thickness_popup">Thickness<span style="color: #EB2D30"></span> </label>
                                                <input type="text" id="door_thickness_popup_{{$no}}" class="form-input" value="{{$m_item->door_thickness;}}" disabled="disabled">
                                            </div>  
                                                
                                            <div>
                                                <label for="hinges_pop_up">Hinges<span style="color: #EB2D30"></span> </label>
                                                <input type="text" id="hinges_pop_up_{{$no}}" class="form-input" value="{{$m_item->hinges;}}" disabled="disabled">
                                            </div>
                                            <div id="h_m_div_{{$no}}">
                                                <label for="hinges_m_pop_up">Hinges Measurement<span style="color: #EB2D30"></span> </label>
                                                <input type="text" id="hinges_m_pop_up_{{$no}}"  class="form-input" value="{{$m_item->hinges_measurement;}}" disabled="disabled">
                                            </div>

                                            <div id="lock_div_{{$no}}">
                                                <label for="lock_pop_up">Lock<span style="color: #EB2D30"></span> </label>
                                                <input type="text" class="form-input" id="lock_pop_up_{{$no}}" value="{{$m_item->lock_name;}}" disabled="disabled">
                                            </div>
                                          
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" style="padding-top: 1%;">
                                        <div id="lock_measurement_div_{{$no}}">
                                                <label for="lock_measurement_pop_up">Lock Measurement<span style="color: #EB2D30"></span> </label>
                                                <input type="text" class="form-input" value="{{$m_item->lock_measurement;}}" id="lock_measurement_pop_up_{{$no}}"  disabled="disabled">
                                            </div>
                                            <div id="item_remarks_div_{{$no}}">
                                                <label for="item_remarks_pop_up">Remarks<span style="color: #EB2D30"></span> </label>
                                                <input type="text" name="item_remarks_pop_up" value="{{$m_item->item_remarks}}" id="item_remarks_pop_up_{{$no}}" class="form-input">
                                            </div>
                                            <div class="flex justify-end items-center mt-3">
                                            <button type="button" class="btn btn-outline-danger" @click="toggle">CLOSE</button>
                                          
                                        </div>  
                                        </div> 
                                          
                                        </div>
                                        
                                    </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>           </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <table style="width:100%" class="table-bordered ">
                                <tr>
                                <td width="1000">Remarks : {{$result->remarks}}</td>
                                <td>Executive Name : {{$result->name}}<br>
                                Executive Signature :</td>
                                </tr>
                            </table>
                           
                            </div>
                            
                            
                        </div>
                    </div>
<!-- end main content section -->
@endsection
@section('scripts')
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
     $("#lock_measurement_div_"+no).show();
     $('#door_thickness_div_'+no).show();

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
     $('#f_w_f_div_'+no).show();
     $('#f_w_b_div_'+no).hide();
     $("#lock_measurement_div_"+no).show();
     $('#door_thickness_div_'+no).show();
     frame_pop_up = $("#frame_pop_up_"+no).val();
     if(frame_pop_up == 'Fiber'){
        $("#frame_size_div_"+no).show();
     }
     else{
        $("#frame_size_div_"+no).hide();
     }
     
     
    }
    // Add more conditions as needed
}
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
@endsection