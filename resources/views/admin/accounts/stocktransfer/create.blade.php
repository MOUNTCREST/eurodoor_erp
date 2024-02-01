@extends('admin.layouts.app')

@section('content')
<div class="container">
<div class='row'>
			<div class='col-sm-1'></div>
			<div class='col-sm-10'>
			<div class="row">
		<div class="col-sm-3"><button class='btn cmn_btn'>Stock Transfer</button></div>
	</div>
	<div class="row pt-4">
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<a href="{{ route('stock_transfer_create')}}" class="nav-link active">Add New</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('stock_transfer_list')}}" class="nav-link">List</a>
				</li>
			</ul>
		</div>
	<div class="row pt-4">
	
		<div class="col-sm-12 tbl_div div_form cmn_div">
        <form class="form-horizontal"  id="add_stock_transfer" name="add_stock_transfer" action="{{ url('stock_transfer') }}" method="POST" enctype="multipart/form-data">
					@csrf
						<div class="form-body">
				
							<div class="row">
								<div class="form-group col-sm-6">
									<label for="ref_no">Reference No<span style="color: #EB2D30"></span> </label>
										<input type="text" id="ref_no" value="{{$r_no}}" class="form-control form_element" readonly="readonly" name="ref_no" autocomplete="off">
										
								</div> 
                                <div class="form-group col-sm-6">
									<label for="st_date">Date<span style="color: #EB2D30"></span> </label>
										<input type="date" id="st_date" value="{{date('Y-m-d')}}" class="form-control form_element" placeholder="" name="st_date" autocomplete="off">
										
								</div> 
                                <div class="form-group col-sm-3">
									<label for="item_id">Item<span style="color: #EB2D30"></span> </label>
										<select id="item_id" name="item_id" class="form-control form_element" >
                                        <option  value="" selected>Select</option>
                                            @foreach ($pt_lists as $row)
                                                <option value="{{ $row->id; }}">{{ $row->product_name; }}</option>
                                            @endforeach
                                        </select>
										
								</div> 
                                <div class="form-group col-sm-3">
									<label for="from_warehouse_id">From Warehouse<span style="color: #EB2D30"></span> </label>
										<select id="from_warehouse_id" name="from_warehouse_id" class="form-control form_element" onChange="return get_avilable_stock();"  >
                                        <option  value="" selected>Select</option>
                                          @foreach ($ws_lists as $row)
                                                <option value="{{ $row->id; }}">{{ $row->warehouse_name; }}</option>
                                            @endforeach
                                        </select>
										
								</div> 
                                <div class="form-group col-sm-3">
									<label for="to_warehouse_id">To Warehouse<span style="color: #EB2D30"></span> </label>
										<select id="to_warehouse_id" name="to_warehouse_id" class="form-control form_element" >
                                        <option  value="" selected>Select</option>
                                            @foreach ($ws_lists as $row)
                                                <option value="{{ $row->id; }}">{{ $row->warehouse_name; }}</option>
                                            @endforeach
                                        </select>
										
								</div> 
                                <div class="form-group col-sm-3">
									<label for="qty">Quantity<span style="color: #EB2D30"></span> </label>
										<input type="number" step="0.00001" id="qty" value="{{old('qty')}}" class="form-control form_element" placeholder="" name="qty"  oninput="check_qty();"  autocomplete="off">
									
                                        <span id="avl_stk"></span>
                                        <input type="hidden" name="item_unit_id" id="item_unit_id">
                                        <input type="hidden" name="item_category_id" id="item_category_id">
                                        <input type="hidden" name="a_st" id="a_st">
								</div> 
                                <div class="form-group col-sm-12">
                                    <label for="remarks">Narration<span style="color: #EB2D30"></span> </label>
									<textarea class="form-control form_element" name="remarks" id="remarks"></textarea>
										
								</div> 
                                
								<div class="form-group col-sm-6"  style="margin-top: 2%;">
									<button type="reset" onclick="myFunction()" class="btn btn_reset"><i class="fa fa-refresh" aria-hidden="true"></i> Reset </button>
									&nbsp;<button type="submit" name="sbt"  class="btn btn_sbt">Create <i class="fa fa-check-circle" aria-hidden="true"></i></button>
								</div>
								
								
							</div>

                        </div>
                </form> 
		
		</div>
	
	  
		
	</div>
			</div>
			<div class='col-sm-1'></div>
			</div>
	
</div>
@endsection
@section('scripts')
<script>
 function check_qty(){
	 qty = $('#qty').val();
	 a_qty = $('#a_st').val();
	  if(parseFloat(qty) > parseFloat(a_qty)){
		
		$(':input[type="submit"]').prop('disabled', true);
	  }
	 else{
		$(':input[type="submit"]').prop('disabled', false);
	 }
 }
</script>

<!--for get avilable stock by item id and warehouse id-->
<script>
	function get_avilable_stock(){
		item_id = $("#item_id").val();
		w_id = $("#from_warehouse_id").val();
		$('#avl_stk').text(' ');
		//var _token = $("input[name=_token]").val();
				$.ajax({
				url: '{{route('get_avilable_stock')}}',
				type: 'GET',
				data: {item_id: item_id,w_id:w_id},
				success: function(data) {
                    if(data != 0)
                {
                  
                    $('#avl_stk').text('Avilable Stock = '+data.toFixed(3));
					$('#a_st').val(data.toFixed(3));
                    $(':input[type="submit"]').prop('disabled', false);
                }
                else
                {
                    $('#avl_stk').text('Avilable Stock = '+data);
					$('#a_st').val(data);
                    $(':input[type="submit"]').prop('disabled', true);

//                    toastr.error("Error occured.please try again");

                }

				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
	}
</script>
@endsection