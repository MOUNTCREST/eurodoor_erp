<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Spectrum</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/w_styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script> 
    
</head>
<body>
    <div id="app">

        <div class="container-fluid ts">
      <div class="row">
        <div class="col-sm-3">
          <a href="{{ url('home') }}"><img src="{{ asset('images/as_logo.png') }}" class="img-responsive logo_header" alt="avatar"></a>
        </div>
        <div class="col-sm-2"></div>
        <div class="col-sm-6">
          <nav class="navbar navbar_header navbar-expand-md ">
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            
            <ul class="navbar-nav ml-auto">
                
          <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <img src="{{ asset('images/user.png') }}" alt="avatar" class="rounded-circle user_img"><span style="color: #000000;">
            {{ Auth::user()->name }}
        </span>
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ url('/') }}"><i class="fa fa-lock"></i> Change Password</a>
          <a class="dropdown-item" href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Logout</a>
          
          </div>
        </li>
            </ul>
        </div>
    </nav>
        </div>
        <div class="col-sm-1"></div>
        </div>
      </div>
      <div class="container-fluid na px-0">
  <div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-10">
      <nav class="navbar navbar-expand-md ">
  <!-- Brand -->
 

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ">
      <li class="nav-item">
        <a class="nav-link" href="{{ url('home') }}"><i class="fa fa-dashboard"></i> Home</a>
      </li>
     
     <!-- Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
      <i class="fa fa-money"></i>  Finance Masters
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('opening_balance_list')}}"><i class="fa fa-money"></i> Opening Balance</a>
        <a class="dropdown-item" href="{{ route('ledger_group_list') }}"><i class="fa fa-money"></i> Ledger Groups</a>
        <a class="dropdown-item" href="{{ route('ledger_list')}}"><i class="fa fa-money"></i> Ledgers</a>
       
      </div>
    </li>
   
   <!-- Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
       <i class="fa fa-check"></i> Inventory Masters
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('product_category_list') }}"><i class="fa fa-check"></i> Product Category</a>
        <a class="dropdown-item" href="{{ route('unit_list') }}"><i class="fa fa-check"></i> Units</a>
        <a class="dropdown-item" href="{{ route('product_list') }}"><i class="fa fa-check"></i> Products</a>
    
		 
      </div>
    </li>
		
		
		<li class="nav-item">
      <a class="nav-link" href="{{ route('purchase_invoice_list')}}" id="navbardrop" >
      <i class="fa fa-shopping-cart"></i>  Purchase
      </a>
      
     
    </li>
		
		
    <li class="nav-item">
      <a class="nav-link" href="{{ route('sales_invoice_list')}}" id="navbardrop" >
      <i class="fa fa-truck"></i> Sales
      </a>
      
     
    </li>


       <!-- Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
      <i class="fa fa-money"></i>  Accounts
      </a>
      <div class="dropdown-menu">
        
        <a class="dropdown-item" href="{{ route('payment_list')}}"><i class="fa fa-money"></i> Payment</a>
        <a class="dropdown-item" href="{{ route('receipt_list')}}"><i class="fa fa-money"></i> Receipt</a>
        <a class="dropdown-item" href="{{ route('journal_list')}}"><i class="fa fa-money"></i> Journal</a>
        <a class="dropdown-item" href="{{ route('contra_list')}}"><i class="fa fa-money"></i> Contra</a>
      
      </div>
    </li>

    

 <li class="nav-item">
      <a class="nav-link" href="{{ route('multi_currency_list')}}" id="navbardrop" >
      <i class="fa fa-money"></i> Multi Currency Transfer
      </a>
    </li>

    <!-- Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
       <i class="fa fa-bar-chart"></i> Daily Wages
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="{{route('employee_list')}}"><i class="fa fa-bar-chart"></i> Employee</a>
        <a class="dropdown-item" href="{{route('attencence_list')}}"><i class="fa fa-bar-chart"></i> Attendance</a>
        <a class="dropdown-item" href="#"><i class="fa fa-bar-chart"></i> Payment</a>
      </div>
    </li>

     <!-- Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
       <i class="fa fa-line-chart"></i> Reports
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="{{route('purchase_report')}}"><i class="fa fa-line-chart"></i> Purchase Report</a>
        <a class="dropdown-item" href="{{route('sales_report')}}"><i class="fa fa-line-chart"></i> Sales Report</a>
 
        <a class="dropdown-item" href="{{ route('ledger_report')}}"><i class="fa fa-line-chart"></i> Ledger Report</a>
		  <a class="dropdown-item" href="{{ route('ledger_group_summery')}}"><i class="fa fa-line-chart"></i> Ledger Group Summery</a>
		  <a class="dropdown-item" href="{{ route('currency_balance')}}"><i class="fa fa-line-chart"></i> Currency Balance</a>
       
      </div>
    </li>
		 <!-- <li class="nav-item">
      <a class="nav-link" href="#" id="navbardrop" >
      <i class="fa fa-download"></i> Backup
      </a>
      
     
    </li> -->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}" id="navbardrop" >
      <i class="fa fa-sign-out"></i> Logout
      </a>
      
     
    </li>
    </ul>
     
  </div>
</nav>
    </div>
  </div>
</div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
  <script type="text/javascript">
    $(function () {
      
      var table = $('.data-table').DataTable();
      
    });
</script>
@yield('scripts')
</body>
</html>
