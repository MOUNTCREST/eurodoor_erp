
@extends('admin.layouts.app')

@section('content')
<!-- start main content section -->
<!-- 
                        <ul class="flex space-x-2 rtl:space-x-reverse">
                            <li>
                                <a href="{{ route('attencence_list')}}" class="text-primary hover:underline">Attendance</a>
                            </li>
                            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                                <span><a href="{{ route('attendence_create')}}" class="text-primary hover:underline">Create</a></span>
                            </li>
                        </ul> -->
                        <h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Attendance</h5>
                        <div class="pX-5 panel w-full">
                        <form class="form-horizontal"  id="add_attendence" name="add_attendence" action="{{ url('attendence') }}" method="POST" enctype="multipart/form-data" onsubmit="return disableSubmitButton()">
					@csrf
						<div class="form-body">
				
							<div class="row">
								<div class="form-group col-sm-3">
									<label for="p_i_no">Date<span style="color: #EB2D30">*</span> </label>
										<input type="date" id="added_date" class="form-input" value="{{old('added_date');}}" required="required"  placeholder="" name="added_date" autocomplete="off">
                    @error('added_date')
                      <small class='text-danger'>{{ $message }}</small>
                    @enderror
								</div> 
                               
                            <div class="row">
                            <div class="table-responsive  px-3 pt-3">
                                           <table class="table table-bordered  table-striped text-center dataTables-example " id="tbl_items">
                                            <thead>
                                               <tr>
                                                <th colspan="2">Employee</th>
                                                <th colspan="2">Morning Shift</th>
                                                <th colspan="2">Afternoon Shift</th>
                                                <th colspan="2"></th>
                                                </tr>
                                                    <tr>
                                                      <th class="text-center" width="100">SL NO</th>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">In</th>
                                                        <th class="text-center">Out</th>
                                                        <th class="text-center">In</th>
                                                        <th class="text-center">Out</th>
                                                        <th class="text-center">Total</th>
                                                        <th class="text-center">ACTIONS</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody">
                                                  <tr id="R1">
                                                    <td><h6>1</h6></td>
                                                    <td width="200">
                                                      <select name="employee_id[]" class="form-input s2" id="employee_id1"  required="required" onchange="return get_employe_amnt(1);">
                                                              <option  value="" selected>Select</option>
                                                                @foreach ($ey_lists as $row): 
                                                                    <option value="{{ $row->id }}">{{ $row->e_name }}</option>
                                                                @endforeach
                                                     </select>
                                                    </td>
                                                    <td>
                                                      <input type="time" class="form-input shift-time m_s_in" name="m_s_in[]" autocomplete="off" id="m_s_in1" onchange="return get_dif(1);"  required="required">
                                                    </td>
                                                    
                                                    <td>
                                                      <input type="time" class="form-input shift-time m_s_out" name="m_s_out[]" autocomplete="off" id="m_s_out1" onchange="return get_dif(1);"   required="required">
                                                    </td>
                                                    <td>
                                                      <input type="time" class="form-input shift-time a_s_in" name="a_s_in[]" autocomplete="off" id="a_s_in1"  onchange="return get_dif(1);"  required="required">
                                                    </td>
                                                    <td>
                                                      <input type="time" class="form-input shift-time a_s_out" name="a_s_out[]" autocomplete="off" id="a_s_out1"  onchange="return get_dif(1);"  required="required">
                                                    </td>
                                                    <td>
                                                      <input type="text" class="form-input total" name="total[]" autocomplete="off" id="total1"  step="0.00001"   value="0" required="required">
                                                      <input type="hidden" class="form-input  p_h_amnt" name="p_h_amnt[]" autocomplete="off" id="p_h_amnt1"  step="0.00001"   value="0" required="required">
                                                      <input type="hidden" class="form-input  net_total_salary" name="net_total_salary[]" autocomplete="off" id="net_total_salary1"  step="0.00001"   value="0" required="required">
                                                    </td>
                                                    <td>
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
                                                </tbody>
                                                <tfoot>
                                                  <tr>
                                                    <td colspan="6" class="text-right">Total</td>
											
                                                    <td><input type="text" class="form-input"  name="total_h_m" id="total_h_m" step="0.00001" value="0"></td>
                                                    
                                                  </tr>
                                                </tfoot>
                                           </table>
                                         </div>
                                         <div class="mt-6 flex flex-col justify-between px-4 sm:flex-row">
                                         <div class="mb-6 sm:mb-0">
                                          <a href="#" ><button type="button" class="btn btn-primary" id="addBtn">Add New</button></a>
                                         </div>
                                         </div>
						        <div class="col-sm-4"></div>
							
								
								
							</div>
              

                        </div>
                        <button type="submit" id="submitButton" name="sbt" class="btn btn-primary !mt-6">Create&nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                </form> 
	
                        </div>

                    <!-- end main content section -->


@endsection
@section('scripts')
<!--for item grid-->
<script>
    $(document).ready(function () {
     
      // Denotes total number of rows
      var rowIdx = 1;
  
      // jQuery button click event to add a row
      $('#addBtn').on('click', function () {
  		
        // Adding a row inside the tbody.
        $('#tbody').append(`<tr id="R${++rowIdx}"><td>${rowIdx}</td>
        <td width="200">
                                                      <select name="employee_id[]" class="form-input s2" id="employee_id${rowIdx}"  required="required"  onchange="return get_employe_amnt(${rowIdx});">
                                                              <option  value="" selected>Select</option>
                                                                @foreach ($ey_lists as $row): 
                                                                    <option value="{{ $row->id }}">{{ $row->e_name }}</option>
                                                                @endforeach
                                                     </select>
                                                    </td>
                                                    <td>
                                                      <input type="time" class="form-input shift-time m_s_in" name="m_s_in[]" autocomplete="off"  onchange="return get_dif(${rowIdx});" id="m_s_in${rowIdx}" required="required">
                                                    </td>
                                                    
                                                    <td>
                                                      <input type="time" class="form-input shift-time m_s_out" name="m_s_out[]" autocomplete="off" id="m_s_out${rowIdx}"  onchange="return get_dif(${rowIdx});"   required="required">
                                                    </td>
                                                    <td>
                                                      <input type="time" class="form-input shift-time a_s_in" name="a_s_in[]" autocomplete="off" id="a_s_in${rowIdx}" onchange="return get_dif(${rowIdx});"  required="required">
                                                    </td>
                                                    <td>
                                                      <input type="time" class="form-input shift-time a_s_out" name="a_s_out[]" autocomplete="off" id="a_s_out${rowIdx}" onchange="return get_dif(${rowIdx});"  required="required">
                                                    </td>
                                                    <td>
                                                      <input type="text" class="form-input  total" name="total[]" autocomplete="off" id="total${rowIdx}"  step="0.00001"   value="0" required="required">
                                                      <input type="hidden" class="form-input  p_h_amnt" name="p_h_amnt[]" autocomplete="off" id="p_h_amnt${rowIdx}"  step="0.00001"   value="0" required="required">
                                                      <input type="hidden" class="form-input  net_total_salary" name="net_total_salary[]" autocomplete="off" id="net_total_salary${rowIdx}"  step="0.00001"   value="0" required="required">
                                                    </td>
                                                    <td>
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
        rowIdx--;
      });
    });
  </script> 
  
  <script>
    function get_employe_amnt(rowId){
      em_id = $('#employee_id'+rowId).val();
      $.ajax({
				url: '{{route('get_employee_details')}}',
				type: 'GET',
				data: {em_id: em_id},
				success: function(data) {
					$('#p_h_amnt'+rowId).val(data.per_hour_amount);

				},
				error: function(jqXHR, textStatus, errorThrown) {
					// Your logic to handle the error
				}
				});
    }
    function get_dif(row_id){
        var startTimeStr = $('#m_s_in'+row_id).val();
        var endTimeStr = $('#m_s_out'+row_id).val();

        var startTimeStr_as = $('#a_s_in'+row_id).val();
        var endTimeStr_as = $('#a_s_out'+row_id).val();



        // Convert the time strings to Date instances
        var startTime = new Date('1970-01-01T' + startTimeStr + ':00');
        var endTime = new Date('1970-01-01T' + endTimeStr + ':00');


        // Convert the time strings to Date instances
        var startTime_as = new Date('1970-01-01T' + startTimeStr_as + ':00');
        var endTime_as = new Date('1970-01-01T' + endTimeStr_as + ':00');



        if(startTime_as < endTime){
          alert('Please Select Time');
          $('#a_s_in'+row_id).val(" ");
          $(':input[type="submit"]').prop('disabled', true);

        }
        else{
          $(':input[type="submit"]').prop('disabled', false);
        }

        if(endTime_as < endTime){
          alert('Please Select Time');
          $('#a_s_out'+row_id).val(" ");
          $(':input[type="submit"]').prop('disabled', true);

        }
        else{
          $(':input[type="submit"]').prop('disabled', false);
        }


        // If the end time is earlier than the start time, add one day to the end time
        if (endTime < startTime) {
        endTime.setDate(endTime.getDate() + 1);
        }

        // Get the time difference in milliseconds
        var timeDiff = endTime - startTime;

        // Convert milliseconds to minutes
        var minutesDiff = timeDiff / 1000 / 60;

       


        
        

        // If the end time is earlier than the start time, add one day to the end time
        if (endTime_as < startTime_as) {
        endTime_as.setDate(endTime_as.getDate() + 1);
        }

        // Get the time difference in milliseconds
        var timeDiff_as = endTime_as - startTime_as;

        // Convert milliseconds to minutes
        var minutesDiff_as = timeDiff_as / 1000 / 60;

    
    



        // Add two times (in minutes) together
            var time1 = minutesDiff;
            var time2 = minutesDiff_as;
            var totalTime = time1 + time2;

            // Convert minutes to hours
            var hours = Math.floor(totalTime / 60);
            var minutes = totalTime % 60;

            // Output the total time in hours and minutes


            if (isNaN(hours)) {
              $("#total"+row_id).val("0 Hrs and 0 Min")
            } else {
              $("#total"+row_id).val(hours + " Hrs and " + minutes + " Min")
            }

          


            if(parseFloat(minutes) >= 30){
              t_hour = parseFloat(hours) + 1;
            }
            else{
              t_hour = parseFloat(hours)
            }

            p_h_amnt = $('#p_h_amnt'+row_id).val();
            var net_total_salary = parseFloat(p_h_amnt) * t_hour;
            $('#net_total_salary'+row_id).val(net_total_salary);



            var totalMinutes = 0;
            $(".total").each(function(){
              
              // Retrieve the values from the current input field using regular expressions
              var regex = /(\d+) Hrs and (\d+) Min/;
                  var match = $(this).val().match(regex);

                  // Convert the matched values to integers or 0 if not matched
                  var hours = parseInt(match[1]) || 0;
                  var minutes = parseInt(match[2]) || 0;

                  // Add the current time to the total time in minutes
                  totalMinutes += hours * 60 + minutes;
            });
                // Convert the total minutes to hours and minutes
          var hours = Math.floor(totalMinutes / 60);
          var minutes = totalMinutes % 60;

          // Output the result to the #totalTime field
          $("#total_h_m").val(hours + " Hrs and " + minutes + " Min");
         
            
    }
  </script>
  <script>
    function calculate_remove(){
      var totalMinutes = 0;
            $(".total").each(function(){
              
              // Retrieve the values from the current input field using regular expressions
              var regex = /(\d+) Hrs and (\d+) Min/;
                  var match = $(this).val().match(regex);

                  // Convert the matched values to integers or 0 if not matched
                  var hours = parseInt(match[1]) || 0;
                  var minutes = parseInt(match[2]) || 0;

                  // Add the current time to the total time in minutes
                  totalMinutes += hours * 60 + minutes;
            });
                // Convert the total minutes to hours and minutes
          var hours = Math.floor(totalMinutes / 60);
          var minutes = totalMinutes % 60;

          // Output the result to the #totalTime field
          $("#total_h_m").val(hours + " Hrs and " + minutes + " Min");
    }
  </script>
  <script>
    function disableSubmitButton() {
        // Disable the submit button to prevent multiple submissions
        document.getElementById('submitButton').disabled = true;
        return true; // Allow the form to be submitted
    }
</script>
@endsection