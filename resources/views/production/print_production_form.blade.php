<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>EURODOOR</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/perfect-scrollbar.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/highlight.min.css') }}" />
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/style.css') }}" />
        <link defer rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/animate.css') }}" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        
        <script defer src="{{ asset('assets/js/popper.min.js') }}"></script>
        <
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

        <style media="print">
        @page {
    size: 4.0in 2.0in;
    margin: 0;
    transform: rotate(90deg);
    transform-origin: top left;
}
body {
            font-size: 12pt;
            margin: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
           
        }
        </style>


    </head>

<!-- Content Starts -->
<table>
		<tr>
            <td colspan=4 style="font-size:20px !important;"><span style="font-weight:bold !important">Date :</span>{{$result->assigned_date}}  </td>
       </tr>
       <tr>
        <td style="font-size:20px !important;"><span style="font-weight:bold !important">B.NO :</span> {{$result->batch_no}} </td>
        <td style="font-size:20px !important;"><span style="font-weight:bold !important">TYPE :</span> {{$result->order_type}} </td>
        <td style="font-size:20px !important;" colspan=2><span style="font-weight:bold !important">MODEL :</span> {{$result->model_name}} </td>
       </tr>
       <tr>
            <td colspan=2 align="center" style="font-size:20px !important; font-weight:bold !important;">WIDTH</td>
            <td align="center" colspan=2 style="font-size:20px !important; font-weight:bold !important;">HEIGHT</td>
            
       </tr>
       <tr>
        <td align="center" style="font-size:20px !important;">{{$result->measurement_with_clearance_top_width}}</td>
        <td align="center" style="font-size:20px !important;">{{$result->measurement_with_clearance_bottom_width}}</td>
        <td align="center" style="font-size:20px !important;" colspan=2>{{$result->measurement_with_clearance_height}}</td>
       
       </tr>
       <tr>
       <td colspan=2  style="font-size:20px !important; font-weight:bold !important;" align="center">HINGES</td>
       <td align="center" style="font-size:20px !important; font-weight:bold !important;"  colspan=2>HANDLE</td>
    </tr>
    <tr>
        <td align="center" style="font-size:20px !important;">{{$result->hinges}}</td>
        <td align="center" style="font-size:20px !important;">{{$result->hinges_measurement}}</td>
        <td align="center" style="font-size:20px !important;">{{$result->lock_name}}</td>
        <td align="center" style="font-size:20px !important;">{{$result->lock_measurement}}</td>
    </tr>
       <tr>
            <td align="center" style="font-size:20px !important; font-weight:bold !important;">DOOR COLOR</td>
            <td align="center" style="font-size:20px !important; font-weight:bold !important;">FRAME COLOR</td>
            <td align="center" style="font-size:20px !important; font-weight:bold !important;">FINISH FRONT</td>
            <td align="center" style="font-size:20px !important; font-weight:bold !important;">FINISH BACK</td>
       </tr>
       <tr>
        <td align="center" style="font-size:20px !important;">{{$result->door_color_name}}</td>
        <td align="center" style="font-size:20px !important;">{{$result->frame_color_name}}</td>
        <td align="center" style="font-size:20px !important;">{{$result->finish_work_front}}</td>
        <td align="center" style="font-size:20px !important;">{{$result->finish_work_back}}</td>
       </tr>
       <tr>
            <td align="center" style="font-size:20px !important; font-weight:bold !important;">STEEL BEEDING</td>
            <td align="center" style="font-size:20px !important; font-weight:bold !important;">TEXTURE FINISH</td>
            <td align="center" style="font-size:20px !important; font-weight:bold !important;">GLASS TYPE</td>
            <td align="center" style="font-size:20px !important; font-weight:bold !important;">THICKNESS</td>
       </tr>
       <tr>
        <td align="center" style="font-size:20px !important;">{{$result->steel_beeding}}</td>
        <td align="center" style="font-size:20px !important;">{{$result->texture_finish}}</td>
        <td align="center"  style="font-size:20px !important;">{{$result->glass_type_name}}</td>
        <td align="center"  style="font-size:20px !important;">{{$result->door_thickness}}</td>
       </tr>
       <tr>
        <td style="font-size:20px !important; font-weight:bold !important;">SETTING</td>
        <td style="font-size:20px !important;" colspan=4></td>
       </tr>
       <tr>
        <td style="font-size:20px !important; font-weight:bold !important;">COATING</td>
        <td  style="font-size:20px !important;" colspan=4></td>
       </tr>
       <tr>
        <td style="font-size:20px !important; font-weight:bold !important;">PUTTY WORK</td>
        <td colspan=4 style="font-size:20px !important;"></td>
       </tr>
       <tr>
        <td style="font-size:20px !important; font-weight:bold !important;">MOULDING</td>
        <td colspan=4 style="font-size:20px !important;"></td>
       </tr>
       <tr>
        <td colspan=5 style="font-size:20px !important; font-weight:bold !important;">REMARKS : <span style="color:red !important;">{{$result->item_remarks}}</span></td>
       </tr>
	</table>
	
<!-- Content Ends -->
	</body>
</html>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<script>
  $(document).ready(function() {
  var style = $('<style>').appendTo('head');
  var css = '@media print { @page { size: A5 landscape; } table { background-color: transparent !important;overflow-x: auto;  } }';
  style.text(css);

  
});
function printContent() {
    window.print();
    window.onafterprint = function() {
      var id = '{{ $result->id }}'; // Assuming $result->id is available in your Blade template
      window.location.href = '{{ route('production_print_all', ['id' => '__ID__']) }}'.replace('__ID__', id);
    };
  }

  window.onload = function() {
    printContent();
  };
</script>