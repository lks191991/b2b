@extends('layouts.appLogin')
  
@section('content')



<div class="container">
            <div class="row g-lg-4 gy-5">
   <div class="col-lg-8 offset-md-2 ">
   <div class="login-form-area mb-5  mt-5">
                        <h3 class="col-md-12 text-center" >Payment Update</h3>
						
                        @include('inc.errors-and-messages')
                        <form action="{{ route('receipts-post', $user->id) }}" method="post" class="form" enctype="multipart/form-data">
			{{ csrf_field() }}
                            <div class="row">
							<div class="col-lg-12 mb-10">
                                    <div class="form-inner">
							<hr/>
                                    </div>
									 </div>
							
							<div class="form-group col-md-2 mb-20">
                <label for="inputName">Currency: <span class="red">*</span></label>
				@php
										$currencyDD2 = SiteHelpers::getCurrencyAll();
										@endphp
										<select name="currency" id="currency" required class="form-control inputsave">
										<option value="">Currency</option>
										@foreach($currencyDD2 as $currencyD)
										<option value="{{$currencyD->id}}" @if( $user->currency_id  == $currencyD->id) {{'selected="selected"'}} @endif>{{$currencyD->code}}</option>
										@endforeach
										</select>
										@if ($errors->has('agent_currency_id'))
										<span class="text-danger">{{ $errors->first('agent_currency_id') }}</span>
										@endif
              </div>
			  <div class="form-group col-md-4 mb-20">
                <label for="inputName">Amount Paid : <span class="red">*</span></label>
                 <input type="text" id="amount_cur"  name="amount_cur" value="{{ old('amount_cur') }}" class="form-control inputsave"  placeholder="Amount" />
				  @if ($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
              </div>
							<div class="form-group col-md-6 mb-20">
                <label for="inputName">Amount Paid (AED): <span class="red">*</span></label>
                 <input type="text" id="amount" readonly='readonly' name="amount" value="{{ old('amount') }}" class="form-control"  placeholder="Amount" />
				  @if ($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-6 mb-20">
                <label for="inputName">Date of Payment: <span class="red">*</span></label>
				<div class="select-input">
                                                         
					<input type="text" name="date_of_receipt" class="form-control"  readonly value="{{ old('date_of_receipt', date('Y-m-d')) }}">
				
				</div>
                 @if ($errors->has('travel_from_date'))
                    <span class="text-danger">{{ $errors->first('travel_from_date') }}</span>
                @endif
              </div>
			  
			  
			  <div class="form-group col-md-6 mb-20">
                <label for="inputName">Attachment:</label>
                <input type="file" name="image" id="image" class="form-control" /> 
                 @if ($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
                <p>Allowed File Extension : .jpg,.jpeg,.png</p>
              </div>
           
             
			  <div class="form-group col-md-6 mb-20">
                <label for="inputName">Mode of Payment: <span class="red">*</span></label>
                <select name="mode_of_payment" id="mode_of_payment" required='required' class="form-control">
                  
                    <option value="1" @if(old('mode_of_payment') =='1') {{'selected="selected"'}} @endif>WIO BANK A/C No - 962 222 3261</option>
					          <option value="2" @if(old('mode_of_payment') =='2') {{'selected="selected"'}} @endif >RAK BANK A/C No -0033488116001</option>
                    <option value="3" @if(old('mode_of_payment') =='3'){{'selected="selected"'}} @endif >CBD BANK A/C No -1001303922</option>
                    <option value="4" @if(old('mode_of_payment') =='4'){{'selected="selected"'}} @endif >Cash</option>
                    <option value="5" @if(old('mode_of_payment') =='5'){{'selected="selected"'}} @endif >Cheque</option>
                 </select>
              </div>
			  <div class="form-group col-md-12 mb-20">
                <label for="inputName">Remark:</label>
                <textarea id="remark" name="remark" value="{{ old('remark') }}" class="form-control" style="resize:none;"  placeholder="Remark" rows="5" ></textarea>
				  @if ($errors->has('remark'))
                    <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
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
<script type="text/javascript">
$(document).ready(function() {
	
	$(document).on('change', '.inputsave', function(evt) {

		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('getCurrencyRate')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id:  $("#currency").val(),
			   amt:  $("#amount_cur").val(),
			   val: $(this).val(),
			   type: "Receipt",
			   report_type: "Receipt"
            },
            success: function( data ) {
              $("#amount").val(data[0].amt);
			  
            }
          });
	 });	
   });
   </script>
 @endsection