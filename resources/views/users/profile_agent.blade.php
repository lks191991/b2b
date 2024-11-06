@extends('layouts.appLogin')
  
@section('content')



<div class="container">
            <div class="row g-lg-4 gy-5">
   <div class="col-lg-8 offset-md-2 ">
   <div class="login-form-area mb-5  mt-5">
                        <h3 class="col-md-12 text-center" >Profile</h3>
						@if ($record->profile_update=='0')
						 <div class="box no-border">
							<div class="box-tools">
								<p class="alert alert-danger alert-dismissible" style="line-height:6px;color:#000">
									Please update profile first for further process.
								</p>
							</div>
						</div>
					@endif
						
						@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
	@else
	@include('inc.errors-and-messages')
@endif
                        <form action="{{ route('profile-edit-post', $record->id) }}" method="post" class="form" enctype="multipart/form-data">
			{{ csrf_field() }}
                            <div class="row">
							<div class="col-lg-12 mb-10">
                                    <div class="form-inner">
							<hr/>
                                    </div>
									 </div>
							<div class="col-lg-12 mb-10 text-left">
								<h4 class="text-left" style=" font-weight:normal" >Profile Details</h4>
							</div>
                              
							   <div class="col-lg-6 mb-20">
                                    <div class="form-inner">
                                        <label>First Name*</label>
										<input type="text" id="first_name" name="first_name" value="{{ $record->name }}" class="form-control"  placeholder="First Name"  />
										@if ($errors->has('first_name'))
										<span class="text-danger">{{ $errors->first('first_name') }}</span>
										@endif
                                    </div>
                                </div>
								 <div class="col-lg-6 mb-20">
                                    <div class="form-inner">
                                        <label>Last Name*</label>
										<input type="text" id="last_name" name="last_name" value="{{ $record->lname }}" class="form-control"  placeholder="Last Name"  />
										@if ($errors->has('last_name'))
										<span class="text-danger">{{ $errors->first('last_name') }}</span>
										@endif
                                    </div>
                                </div>
								 <div class="col-lg-6 mb-20">
                                    <div class="form-inner">
                                        <label>Mobile No with Country Code*</label>
										<input type="text" id="mobile" name="mobile" value="{{ $record->mobile }}" class="form-control"  placeholder="Mobile No with Country Code"  />
										@if ($errors->has('mobile'))
										<span class="text-danger">{{ $errors->first('mobile') }}</span>
										@endif
                                    </div>
                                </div>
								 <div class="col-lg-6 mb-20">
                                    <div class="form-inner">
                                        <label>Email ID*</label>
										<input type="text" id="email" name="email" value="{{ $record->email }}" class="form-control"  placeholder="Email ID"  />
										@if ($errors->has('email'))
										<span class="text-danger">{{ $errors->first('email') }}</span>
										@endif
                                    </div>
                                </div>
								<div class="col-lg-6 mb-20">
                                    <div class="form-inner">
                                        <label>Profile Image </label>
										<input type="file" id="image" name="image" value="{{ old('image')}}" class="form-control"  placeholder=""  />
										
                                    </div>
                                </div>
								<div class="col-lg-6 mb-20 ">
								<div class="form-inner">
									
								@if($record->image)
									<label>Current Profile Image</label>
								<div class="form-group">
								<img src="{{ url('/uploads/users/thumb/'.$record->image) }}" width="100" alt="profile-image" />
								</div>
								@endif
								</div>
								</div>
								<div class="col-lg-12 mb-10">
                                    <div class="form-inner">
							<hr/>
                                    </div>
									 </div>
								
								<div class="col-lg-6 mb-20">
                                    <div class="form-inner">
                                        <label>Agency Name*</label>
										<input type="text" id="company_name" name="company_name" value="{{ $record->company_name}}" class="form-control"  placeholder="Agency Name"  />
										@if ($errors->has('company_name'))
										<span class="text-danger">{{ $errors->first('company_name') }}</span>
										@endif
                                    </div>
                                </div>
								<div class="col-lg-6 mb-20">
                                    <div class="form-inner">
                                        <label>Agency Mobile No with Country Code*</label>
										<input type="text" id="agency_mobile" name="agency_mobile" value="{{ $record->agency_mobile}}" class="form-control"  placeholder="Mobile No with Country Code"  />
										@if ($errors->has('agency_mobile'))
										<span class="text-danger">{{ $errors->first('agency_mobile') }}</span>
										@endif
                                    </div>
                                </div>
								 <div class="col-lg-6 mb-20">
                                    <div class="form-inner">
                                        <label>Agency Email ID*</label>
										<input type="text" id="agency_email" name="agency_email" value="{{ $record->agency_email}}" class="form-control"  placeholder="Agency Email ID"  />
										@if ($errors->has('agency_email'))
										<span class="text-danger">{{ $errors->first('agency_email') }}</span>
										@endif
                                    </div>
                                </div>
								<div class="col-lg-6 mb-20">
                                    <div class="form-inner">
                                        <label>Preferred Currency.</label>
										@php
										$currencyDD2 = SiteHelpers::getCurrencyAll();
										@endphp
										<select name="agent_currency_id" id="agent_currency_id" class="form-control">
										<option value="">Currency</option>
										@foreach($currencyDD2 as $currencyD)
										<option value="{{$currencyD->id}}" @if($record->currency_id == $currencyD->id) {{'selected="selected"'}} @endif>{{$currencyD->name}}</option>
										@endforeach
										</select>
										@if ($errors->has('agent_currency_id'))
										<span class="text-danger">{{ $errors->first('agent_currency_id') }}</span>
										@endif
                                    </div>
                                </div>
								<div class="col-lg-12 mb-10">
                                    <div class="form-inner">
							<hr/>
                                    </div>
									 </div>
								<div class="col-lg-12 mb-10 text-left">
								<h4 class="text-left" style=" font-weight:normal" >Agency Address</h4>
								
							</div>
								 <div class="col-lg-6 mb-20">
                                    <div class="form-inner">
                                        <label>Address</label>
										<input type="text" id="address" name="address" value="{{ old('address') ?: $record->address}}" class="form-control"  placeholder="Address"  />
										@if ($errors->has('address'))
										<span class="text-danger">{{ $errors->first('address') }}</span>
										@endif
                                    </div>
                                </div>
								<div class="col-lg-6 mb-20">
                                    <div class="form-inner">
                                        <label>Address Line Two</label>
										<input type="text" id="address_two" name="address_two" value="{{ old('address_two') ?: $record->address_two}}" class="form-control"  placeholder="Address"  />
										@if ($errors->has('address_two'))
										<span class="text-danger">{{ $errors->first('address_two') }}</span>
										@endif
                                    </div>
                                </div>
								<div class="col-lg-6 mb-20">
                                    <div class="form-inner">
                                        <label>Country</label>
									<select name="country_id" id="country_id_signup" class="form-control">
									<option value="">Country</option>
									@foreach($countries as $country)
									<option value="{{$country->id}}" @if($record->country_id == $country->id) {{'selected="selected"'}} @endif>{{$country->name}}</option>
									@endforeach
									</select>

									
                                    </div>
									@if ($errors->has('country_id'))
									<span class="text-danger">{{ $errors->first('country_id') }}</span>
									@endif
                                </div>
								<div class="col-lg-6 mb-20">
                                    <div class="form-inner">
                                        <label>State</label>
									<select name="state_id" id="state_id" class="form-control">
									<option value="">State</option>
									</select>
									
                                    </div>
									@if ($errors->has('state_id'))
									<span class="text-danger">{{ $errors->first('state_id') }}</span>
									@endif
                                </div>
								<div class="col-lg-6 mb-20">
                                    <div class="form-inner">
                                        <label>City</label>
										<select name="city_id" id="city_id" class="form-control">
										<option value="">City</option>
										</select>
									
                                    </div>
									@if ($errors->has('city_id'))
									<span class="text-danger">{{ $errors->first('city_id') }}</span>
									@endif
                                </div>
								
								<div class="col-lg-6 mb-20">
                                    <div class="form-inner">
                                        <label>Zip Code</label>
										 <input type="text" id="postcode" name="postcode" value="{{ old('postcode') ?: $record->postcode}}" class="form-control"  placeholder="Zip Code"  />
										@if ($errors->has('postcode'))
										<span class="text-danger">{{ $errors->first('postcode') }}</span>
										@endif
                                    </div>
                                </div>

								
								<div class="col-lg-12 mb-10 india">
                                    <div class="form-inner">
							<hr/>
                                    </div>
									 </div>
								<div class="col-lg-12 mb-10 text-left india">
								<h4 class="text-left" style=" font-weight:normal" >Agency Documents</h4>
								
							</div>
							<div class="col-lg-12 mb-10 uae">
                                    <div class="form-inner">
							<hr/>
                                    </div>
									 </div>
								<div class="col-lg-12 mb-10 text-left uae">
								<h4 class="text-left"  >Agency Documents</h4>
								
							</div>
							
								 <div class="col-lg-6 mb-20 india">
                                    <div class="form-inner">
                                        <label>Pan Card No</label>
										<input type="text" id="pan_no" name="pan_no" value="{{ old('pan_no') ?: $record->pan_no}}" class="form-control"  placeholder="Pan Card No"  />
										@if ($errors->has('pan_no'))
										<span class="text-danger">{{ $errors->first('pan_no') }}</span>
										@endif
                                    </div>
                                </div>
								<div class="col-lg-6 mb-20 india">
                                    <div class="form-inner">
                                        <label>Pan Card File</label>
										<input type="file" id="pan_no_file" name="pan_no_file" value="{{ old('pan_no_file')}}" class="form-control"  placeholder=""  />
										@if ($errors->has('pan_no_file'))
										<span class="text-danger">{{ $errors->first('pan_no_file') }}</span>
										@endif
                                    </div>
                                </div>
								<div class="col-lg-12 mb-20 india">
								<div class="form-inner">
									
								@if($record->pan_no_file)
									<label>Current Pan Card File</label>
								<div class="form-group">
								<img src="{{ url('/uploads/users/'.$record->pan_no_file) }}" width="100" alt="pan_no_file" />
								</div>
								@endif
								</div>
								</div>
						
								<div class="col-lg-6 mb-20 uae">
                                    <div class="form-inner">
                                        <label>Trade License No.</label>
										<input type="text" id="trade_license_no" name="trade_license_no" value="{{ old('trade_license_no') ?: $record->trade_license_no}}" class="form-control"  placeholder="Trade License No."  />
										@if ($errors->has('trade_license_no'))
										<span class="text-danger">{{ $errors->first('trade_license_no') }}</span>
										@endif
                                    </div>
                                </div>
								
								<div class="col-lg-6 mb-20 uae">
                                    <div class="form-inner">
                                        <label>TRN No.</label>
										<input type="text" id="trn_no" name="trn_no" value="{{ old('trn_no') ?: $record->trn_no}}" class="form-control"  placeholder="TRN No."  />
										@if ($errors->has('trn_no'))
										<span class="text-danger">{{ $errors->first('trn_no') }}</span>
										@endif
                                    </div>
                                </div>
								<div class="col-lg-6 mb-20 uae">
                                    <div class="form-inner">
                                        <label>Trade License </label>
										<input type="file" id="trade_license_no_file" name="trade_license_no_file" value="{{ old('trade_license_no_file')}}" class="form-control"  placeholder=""  />
										
                                    </div>
                                </div>
								<div class="col-lg-12 mb-20 uae">
                                    <div class="form-inner">
									@if($record->trade_license_no_file)
										<label>Current Trade License</label>
									<div class="form-group">
									<img src="{{ url('/uploads/users/'.$record->trade_license_no_file) }}" width="100"  alt="trade_license_no_file" />
									</div>
									@endif
                                    </div>
                                </div>
                              
<div class="col-lg-12 mb-10">
                                    <div class="form-inner">
							<hr/>
                                    </div>
									 </div>
									 <div class="col-lg-4 offset-md-4">
                                     <button type="submit" class="primary-btn1 btn-hover">Save <i class="icon-arrow-top-right ml-10"></i></button>
              </div>
								
									
                               
                            </div>
                        </form>
                    </div>
                </div> 
				  </div>
				  </div>

@endsection
@section('scripts')
@include('inc.citystatecountryjs')
 @endsection