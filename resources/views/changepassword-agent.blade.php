@extends('layouts.appLogin')
  
@section('content')
<div class="container">
            <div class="row g-lg-4 gy-5">

   <div class="col-lg-6 offset-md-3 text-center">
                    <div class="contact-form-area mb-5  mt-5">
                        <h3>Change Password</h3>
						@include('inc.errors-and-messages')
                        <form role="form" action="{{route('profile.save')}}" method="post">
            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>Old Password *</label>
										 <input type="password" class="" id="OldPassword" name="OldPassword" placeholder="Old Password" required />
										 @if ($errors->has('OldPassword'))
                <span class="text-danger">{{ $errors->first('OldPassword') }}</span>
            @endif
                                    </div>
                                </div>
                               <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>New Password</label>
                                        <input type="password" id="password" class="" name="password" placeholder="8 characters, 1 upper case & 1 number." required>
									@if ($errors->has('password'))
									<span class="text-danger">{{ $errors->first('password') }}</span>
									@endif
                                    </div>
                                </div>
                               <div class="col-lg-12 mb-20">
                                    <div class="form-inner">
                                        <label>Confirm New Password</label>
                                         <input type="password" class="" id="confirmPassword" name="confirmPassword" placeholder="Confirm New Password" required />
									@if ($errors->has('confirmPassword'))
									<span class="text-danger">{{ $errors->first('confirmPassword') }}</span>
									@endif
                                    </div>
                                </div>
                              
                                <div class="col-lg-12">
                                    <div class="form-inner">
									<button type="submit" class="primary-btn1 btn-hover">Update <i class="icon-arrow-top-right ml-10"></i></button>
									
                                      
                                    </div>
									
                                </div>
                            </div>
                        </form>
                    </div>
                </div> 
				  </div>
                </div> 
@endsection