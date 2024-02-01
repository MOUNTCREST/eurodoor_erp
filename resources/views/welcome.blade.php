@extends("layouts.includes")

@section('data_content')


<div class="container login_content" style="margin-top:5%;">
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			 <div class="card login_card" style="width:400px" >
			    <img src="{{ asset('images/as_logo.png') }}" class="img-responsive logo_login" alt="avatar">
                 <div class="card-body">
                    <form>
                    <div class="form-group">
					    <label for="email" style="color: #000000;">Username:</label>
                         <div class="input-group mb-3">
                          <input type="text" class="form-control form_element" placeholder="Enter Username" id="username" name="user_name" autocomplete="off" required="required">
                         </div>
					  </div>
                      <div class="form-group">
					    <label for="email" style="color: #000000;">Password:</label>
                         <div class="input-group mb-3">
                          <input type="password" class="form-control form_element" placeholder="Enter Password" id="password" name="password" autocomplete="off" required="required">
                         </div>
					  </div>
                      <button type="submit" class="btn btn_signin_m" style="width: 100%;" ><b>Login</b></button>
                    </form>
                 </div>
             </div>
        </div>
    </div>
</div>



@endsection