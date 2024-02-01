
@extends('admin.layouts.app')

@section('content')
<!-- start main content section -->

						<!-- <ul class="flex space-x-2 rtl:space-x-reverse">
                            <li>
                                <a href="{{ route('product_list')}}" class="text-primary hover:underline">Products</a>
                            </li>
                            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                                <span><a href="{{ route('product_create')}}" class="text-primary hover:underline">Create</a></span>
                            </li>
                        </ul> -->

						<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Products</h5>
                        <div class="pX-5 panel w-full">
						   
						<form class="space-y-5"  id="add_product" name="add_product" action="{{ url('product') }}" method="POST" enctype="multipart/form-data" onsubmit="return disableSubmitButton()">
					@csrf
					<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
						<div>
						<label for="product_name">Name<span style="color: #EB2D30">*</span> </label>
						<input type="text" id="product_name" value="{{old('product_name')}}" class="form-input" placeholder="" name="product_name" autocomplete="off">
						@error('product_name')
							<small class='text-danger'>{{ $message }}</small>
						@enderror
						</div>
						<div>
						<label for="barcode">Bar Code<span style="color: #EB2D30"></span> </label>
						<input type="text" id="barcode" value="{{old('barcode')}}" class="form-input" placeholder="" name="barcode" autocomplete="off">
						</div>
						<div>
						<label for="unit_id">Unit<span style="color: #EB2D30">*</span> </label>
						<select id="unit_id" name="unit_id" class="form-input" >
						<option  value="" selected>Select</option>
							@foreach ($ut_lists as $row)
								<option value="{{ $row->id; }}" {{ old('unit_id') == $row->id ? 'selected' : '' }}>{{ $row->unit_name; }}</option>
							@endforeach
						</select>
						@error('unit_id')
							<small class='text-danger'>{{ $message }}</small>
						@enderror
						</div>
						<div>
						<label for="category_id">Category<span style="color: #EB2D30">*</span> </label>
						<select id="category_id" name="category_id" class="form-input" >
						<option  value="" selected>Select</option>
							@foreach ($pc_lists as $row)
								<option value="{{ $row->id; }}" {{ old('category_id') == $row->id ? 'selected' : '' }}>{{ $row->category_name; }}</option>
							@endforeach
						</select>
						@error('category_id')
							<small class='text-danger'>{{ $message }}</small>
						@enderror
						</div>
						
						<div>
						<label for="qty">Quantity<span style="color: #EB2D30"></span> </label>
									<input type="number" step="0.00001" id="qty" value="{{ old('qty', 0) }}" class="form-control form_element" placeholder="" name="qty" autocomplete="off">
						</div>
					</div>
					

   

					<button type="submit" id="submitButton" name="sbt" class="btn btn-primary !mt-6">Create&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
						
                </form> 
	
                        </div>

                    <!-- end main content section -->


@endsection
@section('scripts')
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
        const myForm = document.getElementById('add_product');

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