@extends('layouts.appLogin')
  
@section('content')

<div class="container">
            <div class="row g-lg-4 gy-5">
          
   <div class="col-lg-5 offset-md-4 text-center">
                    <div class="login-form-area mb-5  mt-5">
                        <h3>Change Password</h3>
						@include('inc.errors-and-messages')
                      <form action="{{ route('reset-password') }}" method="post" autocomplete="off">
        @csrf
        @method('PUT')  
		<input type="hidden" name="email" value="{{ $email }} "/>
                            <div class="row">
                                <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label></label>
										 <input type="password" id="password" class="form-control" name="password" placeholder="Password" required autofocus>
										@if ($errors->has('password'))
										<span class="text-danger">{{ $errors->first('password') }}</span>
										@endif
                                    </div>
                                </div>
                            <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label></label>
										 <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="Confirm Password" required autofocus>
										@if ($errors->has('confirm_password'))
										<span class="text-danger">{{ $errors->first('confirm_password') }}</span>
										@endif
                                    </div>
                                </div>
                              
                                <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
									<button type="submit" class="login-btn mb-10">Change Password <i class="icon-arrow-top-right ml-10"></i></button>
									
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