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

        <script src="{{ asset('assets/js/perfect-scrollbar.min.js') }}"></script>
        <script defer src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script defer src="{{ asset('assets/js/tippy-bundle.umd.min.js') }}"></script>
        <script defer src="{{ asset('assets/js/sweetalert.min.js') }}"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

        <style media="print">
        @page {
            size: A4 landscape;
        }
        </style>


    </head>

<!-- Content Starts -->
<h4 align="center">{{ $porf }} - {{ $d_date }}</h4>
	<table width="100%" cellpadding=5 cellspacing=5>
	
    <thead>
    <tr>
        <th>SL NO</th>
        <th>Party Name</th>
        <th>Root Name</th>
        <th>Batch No</th>
        <th>Door No</th>
        <th>Frame No</th>
        <th>Finish Front</th>
        <th>Finish Back</th>
        <th>Lock</th>
        <th>Delivery Date</th>
    </tr>
    </thead>

    <tbody>
        @foreach($result as $data)
        @php
        $sl_no = 1;
            $order_type = $data->order_type;
            if($order_type == 'Door Only'){
                $dr_no = 1;
                $fm_no = 0;
            }
            else if($order_type == 'Frame Only'){
                $dr_no = 0;
                $fm_no = 1;
            }
            else{
                $dr_no = 1;
                $fm_no = 1;
            }
        @endphp
        <tr>
            <td>{{$sl_no}}</td>
            <td>{{$data->customer_name}}</td>
            <td>{{$data->root_name}}</td>
            <td>{{$data->batch_no}}</td>
            <td>{{$dr_no}}</td>
            <td>{{$fm_no}}</td>
            <td>{{$data->finish_work_front}}</td>
            <td>{{$data->finish_work_back}}</td>
            <td>{{$data->lock_name}}</td>
            <td>{{$data->delivery_date}}</td>
        </tr>
        @php
        $sl_no++;
        @endphp
        @endforeach
    </tbody>
      
	</table>
	
<!-- Content Ends -->
	</body>
</html>
<script src="{{ asset('assets/js/highlight.min.js') }}"></script>
        <script src="{{ asset('assets/js/alpine-collaspe.min.js') }}"></script>
        <script src="{{ asset('assets/js/alpine-persist.min.js') }}"></script>
        <script defer src="{{ asset('assets/js/alpine-ui.min.js') }}"></script>
        <script defer src="{{ asset('assets/js/alpine-focus.min.js') }}"></script>
        <script defer src="{{ asset('assets/js/alpine.min.js') }}"></script>
        <script src="{{ asset('assets/js/custom.js') }}"></script>
        <script src="{{ asset('assets/js/simple-datatables.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<script>
  $(document).ready(function() {
  var style = $('<style>').appendTo('head');
  var css = '@media print { @page { size: A4 landscape; } table { background-color: transparent !important;overflow-x: auto;  } }';
  style.text(css);

  function printContent() {
    window.print();
    window.onafterprint = function() {
    window.location.href = '{{ route('packing_list_report') }}';
    };
  }

  window.onload = function() {
    printContent();
  };
});

</script>