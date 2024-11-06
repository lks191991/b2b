@extends('layouts.appLogin')
  
@section('content')

<div class="container">
            <div class="row g-lg-4 gy-5">
          
   <div class="col-lg-5 offset-md-4 text-center">
                    <div class="login-form-area mb-5  mt-5">
                        <h6>You forgot your password? Here you can easily retrieve a new password.</h6>
						@include('inc.errors-and-messages')
                       <form method="POST" action="{{ route('password.email') }}">
						{{ csrf_field() }}   
                            <div class="row">
                                <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label></label>
										 <input type="text" id="email_address" class="form-control" name="email" placeholder="Email" required autofocus>
										@if ($errors->has('email'))
										<span class="text-danger">{{ $errors->first('email') }}</span>
										@endif
                                    </div>
                                </div>
                            
                              
                                <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
									<button type="submit" class="login-btn mb-10">Request new password <i class="icon-arrow-top-right ml-10"></i></button>
									
                                       <a class="btn btn-link col-md-12" href="{{route('login')}}" style="text-align:right"> Login</a>
                                    </div>
									 </div>
									
				
                               
                            </div>
                        </form>
                    </div>
                </div> 
				  </div>
                </div> 
                </div> 
@endsection