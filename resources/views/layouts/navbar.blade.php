
<nav class="navbar navbar-expand-md bg-info navbar-dark">
  <a class="navbar-brand" href="{{ url('superadmin') }}"><img style="margin-top: 8%;" src="{{ asset('images/iit_logo.png') }}" alt="" height="22"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="{{ url('superadmin') }}">DASHBOARD</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('users') }}">USERS</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('iffkyearmanage') }}">MANAGE IFFK YEAR</a>
      </li>    
		 <li class="nav-item">
        <a class="nav-link" href="{{ url('theaters') }}">THEATERS</a>
      </li> 
		 <li class="nav-item">
        <a class="nav-link" href="{{ url('/') }}">LOGOUT</a>
      </li> 
    </ul>
  </div>  
</nav>
