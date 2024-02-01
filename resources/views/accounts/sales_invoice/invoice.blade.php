<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    </head>

<!-- Content Starts -->
<!-- <div class="container-fluid">
    <div class="row">
        <div class="col-sm-4"> -->
          <span style="font-size:31px">Invoice</span>

<div style="line-height: 1;">
<span style="font-size:12px">Invoice No #</span> :<span style="font-size:12px;font-weight:bold;">{{$result->s_i_no;}}</span> 
</div>
<div style="line-height: 0.8;">
<span style="font-size:12px">Invoice Date </span> :<span style="font-size:12px;font-weight:bold;">{{$result->s_date;}}</span>
</div>
<div style="line-height: 0.8;">
<span style="font-size:12px">Due Date</span> :   <span style="font-size:12px;font-weight:bold;">{{$result->due_date;}}</span>
</div>

        <!-- </div>
    </div> -->
    <div class=" mt-4">
        <!-- <div class="col-sm-4"> -->
          <span style="font-size:18px">Billed To</span>
           <table>
                <tr>
                    <td><span style="font-size:12px;font-weight:bold;">{{$result->customer_name}}</span></td>
                </tr>
                <tr>
                    <td><span style="font-size:12px;font-weight:bold;">{{$result->permenant_address;}}</span></td>
                </tr>
            </table>
         
         
        </div>
    </div>
</div>
<!-- <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-sm-12"> -->
      <div class="table-responsive">
            <table  border=1 width="100%" cellpadding=4 cellspacing=4>
                <thead>
                    <tr>
                        <th style="font-size:12px" width="10%">SL NO</th>
                        <th style="font-size:12px">ITEM</th>
                        <th style="font-size:12px;text-align:right;" width="10%">UNIT</th>
                        <th style="font-size:12px;text-align:right;" width="10%">QTY</th>
                        <th style="font-size:12px;text-align:right;" width="15%">RATE</th>
                        <th style="font-size:12px;text-align:right;" width="15%">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    // Assuming $totalRows is the total number of rows you want to display
                    $totalRows = 10;
                    $total_qty = 0;
                    
                    // Calculate the remaining rows
                    $remainingRows = $totalRows - count($s_items);
                @endphp
                @foreach($s_items as $s_item)
                @php
                $total_qty =  $total_qty + $s_item->qty;
                $unit = $s_item->unit_name;
                @endphp
                    <tr>
                        <td style="font-size:10px;">{{$no++}}</td>
                        <td style="font-size:10px;">{{$s_item->product_name;}}</td>
                        <td style="font-size:10px;text-align:right;">{{$s_item->unit_name;}}</td>
                        <td style="font-size:10px;text-align:right;">{{$s_item->qty;}}</td>
                        <td style="font-size:10px;text-align:right;">{{$s_item->unit_price;}}</td>
                        <td style="font-size:10px;text-align:right;">{{$s_item->amount;}}</td>
                    </tr>
                @endforeach

                {{-- Show additional blank rows based on the count of $s_items --}}
@for ($i = 0; $i < $remainingRows; $i++)
    <tr>
        <td style="font-size:10px;padding:2%;"></td>
        <td style="font-size:10px;padding:2%;"></td>
        <td style="font-size:10px;padding:2%;"></td>
        <td style="font-size:10px;padding:2%;"></td>
        <td style="font-size:10px;padding:2%;"></td>
        <td style="font-size:10px;padding:2%;"></td>
    </tr>
@endfor
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan=3><p style="font-size:10px;text-transform: uppercase;font-weight:bold">Grand Total</p></td>
                        <td><p style="text-align:right;font-size:14px;font-weight:bold;">{{$total_qty}}</p></td>
                        <td></td>
                      
                        <td><p style="text-align:right;font-size:14px;font-weight:bold;">{{$result->total}} </p></td>
                    </tr>
                    <tr>
                        <td colspan=6 ><p style="font-size:10px;text-transform: uppercase;"><b>Total(In Words) :</b>{{$wrds}} RUPPES ONLY</p></td>
                        
                        <!-- <td><p style="text-align:right;font-size:14px;font-weight:bold;">{{$result->total}} </p></td> -->
                    </tr>
                </tfoot>
            </table>
            <!-- </div>
        </div>
    </div> -->
    
    <!-- <table class="mt-4">
        <tr>
            <td><p style="font-size:10px;text-transform: uppercase;"><b>Total(In Words) :</b>{{$wrds}} RUPPES ONLY</p></td>
            <td><p  style="text-align:right;font-size:14px;font-weight:bold;">TOTAL(INR)</p></td>
            <td><p style="text-align:right;font-size:14px;font-weight:bold;">{{$result->total}} </p></td>
        </tr>
    </table> -->
    <p style="font-size:10px;text-align:right;margin-right:5%;margin-top:4%;">Authorised Signatory</p>
  
    <p class="text-center" style="font-size:8px">This is a Computer Generated Invoice</p>
    
<!-- </div> -->
<!-- Content Ends -->
	</body>

</html>

  