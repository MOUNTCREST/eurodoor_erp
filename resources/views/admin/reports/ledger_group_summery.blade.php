
@extends('admin.layouts.app')

@section('content')


<div x-data="">
<h5 class="mb-3 text-lg font-semibold dark:text-white-light md:top-[15px] md:mb-0">Ledger Group Summery</h5>
                        <div class="panel">
						

								<div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                  <label>From Date</label>
                  <input type="date" id="from_date" name="from_date" class="form-input" autofocus='autofocus' value='<?php echo date('2020-01-01'); ?>'>
									</div>
							
                  <div>
                  <label>To Date</label>
   <input type="date" id="to_date" name="to_date" class="form-input" autofocus='autofocus' value='<?php echo date("Y-m-d"); ?>' max='<?php echo date("Y-m-d"); ?>'>
									</div>
								
                 
									<div>
									<label for="ledger_id">Ledger<span style="color: #EB2D30"></span> </label>
                  <select id="account_group_id" name="account_group_id" class="form-input" >
                      <option  value="" selected>Select Account Group</option>
                        @foreach($lg_lists as $row)
                            <option value="{{$row->id}}">{{$row->account_group_name}}</option>
                        @endforeach
                  </select>
									</div>
									<div>
									
									<button type="button" id="btn_search" name="search"   class="btn btn-primary mt-4">Search <i class="fa fa-search position-right"></i></button>
</div>
								</div>
                            




                <div x-data="">
                        <div class="panel">
                            <div class="md:absolute md:top-5 ltr:md:left-5 rtl:md:right-5">
                                <div class="mb-5 flex flex-wrap items-center">
                                   
                                    
                                </div>
                            </div>
                            <table id="myTable" class="table-hover whitespace-nowrap">
                            <thead>
                            <tr>
                            <th>Sl No</th>
                            <th>Ledger</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Balance</th>
                            
                            </tr>
                            </thead>
                            <tbody>
                                            
                            </tbody>
                            <tfoot align="center">
    <tr><th></th><th class=''>Total</th><th class="dbt "></th><th class="cdt "></th><th class="blnc "></th></tr>
  </tfoot>
                            </table>
                        </div>
                    </div>



                        </div>
 </div>






@endsection
@section('scripts')
<script>
        $(document).ready(function() {
            var sum_cr = 0;
            var sum_dr = 0;
            var sum_balance = 0;
  $(".dr_amnt").each(function(){
    sum_dr += parseFloat($(this).text());
  });
  $(".cr_amnt").each(function(){
    sum_cr += parseFloat($(this).text());
  });
  if(sum_dr > sum_cr){
    sum_balance = parseFloat(sum_dr) - parseFloat(sum_cr);
    s_b = sum_balance+" Dr";
  }
  else{
    sum_balance = parseFloat(sum_cr) - parseFloat(sum_dr);
    s_b = sum_balance+" Cr";
  }
  $('#total_dr_amnt').text(sum_dr);
  $('#total_cr_amnt').text(sum_cr);
  $('#total_balance').text(s_b);
        });

        
    </script>
   <!-- for load list of ledger transactions in datatable --> 
    <script type="text/javascript">
        $(document).ready(function()
{
  var dt = new Date();
	var strDate = dt.getFullYear() + "/" + (dt.getMonth()+1) + "/" + dt.getDate();
    var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();

  var t = $('#myTable').DataTable( {
        dom: 'Blfrtip',
//	 "columnDefs": [{
//            "targets": 3,   // target column
//            "className": "text-left",
//           
//        }],
        buttons: [
       {
           extend: 'pdf',
           footer: true,
           title: 'Ledger Group Summery - '+$('#ledger_id :selected').text(),
            titleAttr: 'Ledger Group Summery',
            className: 'btn btn-success',
		  filename: 'Ledger Group Summery-'+strDate+'-'+time,
		   orientation: 'landscape', //portrait
					pageSize: 'A4', //A3 , A5 , A6 , legal , letter
		    customize: function (doc) {
//				doc.content[1].table.widths = 
//        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
			doc.content[1].table.widths = [25,50,75,300,75,75,90];
				doc.styles['tableHeader'] = {
                            bold: true,
                            fontSize: 11,
                            color: 'black',
                            fillColor: 'white',
                            alignment: 'left'

                        };	
				doc.styles['tableFooter'] = {
                            bold: true,
                            fontSize: 11,
                            color: 'black',
                            fillColor: 'white',
                            alignment: 'left'

                        };
				//Remove the title created by datatTables
						doc.content.splice(0,1);
						//Create a date string that we use in the footer. Format is dd-mm-yyyy
						var now = new Date();
						var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
						
						// A documentation reference can be found at
						// https://github.com/bpampuch/pdfmake#getting-started
						// Set page margins [left,top,right,bottom] or [horizontal,vertical]
						// or one number for equal spread
						// It's important to create enough space at the top for a header !!!
						doc.pageMargins = [30,70,30,40];
						// Set the font size fot the entire document
						doc.defaultStyle.fontSize = 10;
						// Set the fontsize for the table header
						doc.styles.tableHeader.fontSize = 10;
						// Create a header object with 3 columns
						// Left side: Logo
						// Middle: brandname
						// Right side: A document title
				
						doc['header']=(function() {
							return {
								columns: [
//									{
//										image: logo,
//										width: 70
//									},
									{
										alignment: 'left',
										//italics: true,
										text: 'Ledger Group Summery - '+$('#ledger_id :selected').text(),
										fontSize: 16,
										margin: [10,0]
									},
									
								],
								margin: 20
							}
						});
						// Create a footer object with 2 columns
						// Left side: report creation date
						// Right side: current page and total pages
						doc['footer']=(function(page, pages) {
							return {
								columns: [
									{
										alignment: 'left',
										text: ['Created on: ', { text: jsDate.toString() }]
									},
									{
										alignment: 'right',
										text: ['page ', { text: page.toString() },	' of ',	{ text: pages.toString() }]
									}
								],
								margin: 20
							}
						});
						// Change dataTable layout (Table styling)
						// To use predefined layouts uncomment the line below and comment the custom lines below
						// doc.content[0].layout = 'lightHorizontalLines'; // noBorders , headerLineOnly
						var objLayout = {};
						objLayout['hLineWidth'] = function(i) { return .5; };
						objLayout['vLineWidth'] = function(i) { return .5; };
						objLayout['hLineColor'] = function(i) { return '#aaa'; };
						objLayout['vLineColor'] = function(i) { return '#aaa'; };
						objLayout['paddingLeft'] = function(i) { return 4; };
						objLayout['paddingRight'] = function(i) { return 4; };
						doc.content[0].layout = 'lightHorizontalLines';
				
				
				},
           exportOptions: {
                columns: [0,1,2,3,4,5,6]
            }
       },
        {
           extend: 'excelHtml5',
           footer: true,
            title: 'Ledger Group Summery',
            titleAttr: 'Ledger Group Summery',
			filename: 'Ledger Group Summery-'+strDate+'-'+time,
            className: 'btn btn-success',
           exportOptions: {
                columns: [0,1,2,3,4,5,6]
            }
          },
          {
           extend: 'print',
           footer: true,
            title: 'Ledger Group Summery',
            titleAttr: 'Ledger Group Summery',
			  filename: 'Ledger Group Summery-'+strDate+'-'+time,
            className: 'btn btn-success',
			  orientation: 'landscape',
           exportOptions: {
                columns: [0,1,2,3,4,5,6]
            }
          }        
    ]  
    } );

    $("#btn_search").click(function(){
        from_date = $("#from_date").val();
        to_date = $("#to_date").val();
        account_group_id = $("#account_group_id").val();
        //currency_id = $("#currency_id").val();
        $(".dbt").text("");
        $(".cdt").text("");
        $(".blnc").text("");
        var sl_no =1;
        sumcr =0;
      sumdr =0;
      sumbalance=0;
var prev_balance = 0;
     
     t
    .clear()
    .draw();
    $.ajax({
        url: '{{route('get_ledger_group_summery')}}',
        data: {from_date:from_date,to_date:to_date,account_group_id:account_group_id},
        type: "GET",    
        dataType:"json",   
        success: function (response) 
        {
          
            
     
			
			var user_arr = response;
            $.each(user_arr, function (key, value) {
    var balance = parseFloat(value.balance);
    var cr_sum = parseFloat(value.cr_sum);
    var dr_sum = parseFloat(value.dr_sum);
    var ledger = value.ledger;

    // Your logic with these values
    sumcr += cr_sum;
    sumdr += dr_sum;
    sumbalance = sumdr - sumcr;

    prev_balance = (dr_sum - cr_sum) + prev_balance;
    var blnz_with_type = prev_balance.toFixed(3);

    t.row.add([
        sl_no, ledger, dr_sum, cr_sum, blnz_with_type
    ]).draw(false);
    sl_no++;
});
          $(".dbt").text(sumdr.toFixed(3));
          $(".cdt").text(sumcr.toFixed(3));
          $(".blnc").text(sumbalance.toFixed(3));
        },
        error: function(errorThrown){
             
         
    }   
    });
    });
});
    </script>
    <script type="text/javascript">
      function get_balance(){



          $('#cbtn-selectors tr').each(function(){
                var cr = Number(parseFloat($('.cr', this).text()));
                var dr = Number(parseFloat($('.dr', this).text()));
                var type = $(this).closest('tr').prev('tr').find('.total_type', this).text();
                var sum = $(this).closest('tr').prev('tr').find('.total', this).text();
               
                var total;
                if (cr !== 0) {
                    sum=Number(sum);

                    if(type == '')
                    {
                    total = parseFloat(sum) + parseFloat(cr);
                    type = 'Cr';
                    }
                    else if(type == 'Cr')
                    {
                    total = parseFloat(sum) + parseFloat(cr);
                    type = 'Cr';
                    }
                    else{
                      if(parseFloat(cr) > parseFloat(sum)){
                        total = parseFloat(cr) - parseFloat(sum);
                      }
                      else{
                        total = parseFloat(sum) - parseFloat(cr);
                      }
                    
                    type = 'Dr';
                    }
                    

                } 

                else if(dr !==0){
                  sum=Number(sum);
                    if(type == '')
                    {
                    total = parseFloat(sum) + parseFloat(dr);
                    type = 'Dr';
                    }
                    else if(type == 'Dr')
                    {
                    total = parseFloat(sum) + parseFloat(dr);
                    type = 'Dr';
                    }
                    else{
                    if(parseFloat(dr) > parseFloat(sum)){
                        total = parseFloat(dr) - parseFloat(sum);
                      }
                      else{
                        total = parseFloat(sum) - parseFloat(dr);
                      }
                    type = 'Cr';
                    }
                }

                else {
                
                    //console.log(total);
                }
                tl = total.toFixed(3);
                $('.total', this).html(tl);
                 $('.tl', this).html(tl+' '+type+'.');
                $('.total_type', this).html(type);
            });

    

      }
    </script>
@endsection