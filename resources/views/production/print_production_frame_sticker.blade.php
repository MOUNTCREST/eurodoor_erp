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
    
     
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <script defer src="{{ asset('assets/js/popper.min.js') }}"></script>
   
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <style>
        /* Define your sticker size using CSS */
        .sticker {
            width: 100mm; /* Adjust as needed */
            height: 50mm; /* Adjust as needed */
            border: 1px solid black; /* Just for demonstration */
            /* Add any other styles you need for your sticker */
        }
    </style>
        <style media="print">
        @page {
            size: A5 landscape;
        }
        table{
          font-size : 20px !important;
          height:100mm;
        }
        </style>


    </head>

<!-- Content Starts -->
<body>
<!-- <div class="sticker"> -->
	<table border=1 width=100% cellpadding=5 cellspacing=5>
       <tr>
            <td align="center"><b>BATCH NO : </b>{{$result->batch_no}}</td>
            <td align="center" colspan=2 ><b>MODEL :</b> {{$result->model_name}}</td>
       </tr>
      
       <tr>
       <td align="center"><b>FRAME COLOR : </b>{{$result->frame_color_name}}</td>
       <td align="center" colspan=2><b>FINISH WORK :</b> {{$result->finish_work_front}}</td>
    </tr>
     <tr>
        <td align="center"><b>WIDTH</b></td>
        <td align="center"><b>HEIGHT</b></td>
    </tr>
    <tr>
        <td align="center">
            
        @if(($result->tight_measurement_top_width) > ($result->tight_measurement_bottom_width))
          {{$result->tight_measurement_top_width}}
        @else
          {{$result->tight_measurement_bottom_width}}
        @endif
        
        
        </td>
        <td align="center">{{$result->tight_measurement_height}}</td>
    </tr>
    
    <td align="center" colspan=2><b>REMARKS :</b> {{$result->remarks}}</td>
        </tr>
	</table>
      <!-- </div> -->
<!-- Content Ends -->
	</body>
</html>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<script>
$(document).ready(function() {
  var style = $('<style>').appendTo('head');
  

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