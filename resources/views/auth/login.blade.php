@extends('layouts.app')

@section('content')
<div class="container" style='margin-top:11%;'>
    <div class="row">
        <div class='col-md-4'></div>
        <div class='col-md-4'></div>
        <div class="col-md-4">
            <div class=" login_card">
                <!-- <div class="card-header">{{ __('Login') }}</div> -->
                <img src="{{ asset('assets/images/logo.png') }}" class="img-responsive logo_login" alt="avatar">
                <h5>Sign In</h5>
                <!-- <h6>Enter your email and password to login</h6> -->
                <div class="card-body pt-2">
                
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="form-group">
					    <label for="email" style="color: #000000;">{{ __('Email') }}:</label>
                         <div class="input-group mb-3">
                         <input id="email" type="email" class="form-control form_element form_login @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="new-email" autofocus placeholder='Enter Email'>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                         </div>
					  </div>
                      <div class="form-group">
					    <label for="password" style="color: #000000;">{{ __('Password') }}:</label>
                         <div class="input-group mb-3">
                         <input id="password" type="password" class="form-control form_element form_login @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"   placeholder='Enter Password'>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                         </div>
					  </div>
                     
                           
                <div class="form-group" id="div_company" style="display: none;">
				<label for="pwd" style="color: #000000;">Company:</label>
                   <div class="input-group mb-3">
                   <select id="company_id" name="company_id" class="form-control form_element" >
                     <option value="">Select Company</option>
                   </select>
                  </div>
					   	
					  </div>
                          
                        <!-- <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->

                        <button type="submit" name="sbt"  class="btn btn-primary btn_signin_m mt-6">
                                    {{ __('Login') }}
                                    </button>
                        <!-- <div class="row mb-0">
                            <div class="col-md-8 offset-md-4"> -->
                               

                                <!-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif -->
                            <!-- </div>
                        </div> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    $(':input[type="submit"]').prop('disabled', false);
  });
</script>
<!-- <script>
 $(document).ready(function() {
    $('#password').on('input', function() {
            var email = $('#email').val();
            var password = $('#password').val();
            $.ajax({
            url: '{{route('check_values')}}',
            type: 'GET',
            data: {email: email,password:password},
            success: function(data) {
                if(data == 'superadmin'){
                    $(':input[type="submit"]').prop('disabled', false);
                    $('#div_company').css('display','none');
                }
                else if(data =='Invalid'){
                    $(':input[type="submit"]').prop('disabled', true);
                    $('#div_company').css('display','none');
                }
                else{
                    $('#div_company').css('display','block');
                    $('#company_id').empty();
                     $('#company_id').append('<option value="">'+ 'Select Company'  +'</option>');
                        $.each(data, function(key, value) {
                            $('#company_id').append('<option value="'+ value.id +'">'+ value.company_name  +'</option>');
                        });
                        $(':input[type="submit"]').prop('disabled', true);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
            });
        });
 });
</script> -->
<!-- while change company submit button activated-->
<script type="text/javascript">
$(document).ready(function(){
  $("#company_id").change(function(){
     $(':input[type="submit"]').prop('disabled', false);
    });
  });
</script>
@endsection
