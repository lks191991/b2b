@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher Details</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

  

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
  
<div class="row multistep">
        <div class="col-md-2 multistep-step complete">
            <div class="text-center multistep-stepname" style="font-size: 16px;">Add to Cart</div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a href="#" class="multistep-dot"></a>
        </div>

        <div class="col-md-3 multistep-step current">
            <div class="text-center multistep-stepname" style="font-size: 16px;">Payment</div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a href="#" class="multistep-dot"></a>
        </div>

        <div class="col-md-3 multistep-step next">
            <div class="text-center multistep-stepname" style="font-size: 16px;">Voucher</div>
            <div class="progress"><div class="progress-bar"></div></div>
            <a href="#" class="multistep-dot"></a>
        </div>
		 <div class="col-md-3">
		  @if($voucher->is_activity == 1)
								 @if($voucher->status_main < 5)
					 <a class="btn btn-info btn-sm float-left" style=" margin-top: 20px;margin-left: 10px;" href="{{route('voucher.add.activity',$voucher->id)}}" >+ Activity</a>
           @if($voucher->is_hotel == 1)
           <a class="btn btn-success btn-sm float-left" style=" margin-top: 20px;margin-left: 10px;" href="{{route('voucher.add.hotels',$voucher->id)}}" >+ Hotel</a>
           @endif
					@endif
								  @endif
								  
					<a class="btn btn-info btn-sm float-left" style=" margin-top: 20px;margin-left: 5px;" href="{{ route('voucher.add.discount',$voucher->id) }}" >Add/Edit Discount</a>
				
				</div>
        
        
    </div>
	
        <div class="row" style="margin-top: 30px;">
		
          <!-- left column -->
          <div class="offset-md-1 col-md-6">
		   <form id="cusDetails" method="post" action="{{route('voucher.status.change',$voucher->id)}}" >
			 {{ csrf_field() }}
            <!-- general form elements -->
            <div class="card card-default">
              <div class="card-header">
                 <h3 class="card-title"><i class="nav-icon fas fa-user" style="color:black"></i> Passenger Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-2">
                      <select class="form-control" name="salutation">
                        <option @if(old('service_type') =='Mr.') {{'selected="selected"'}} @endif>Mr.</option>
                        <option @if(old('service_type') =='Mrs.') {{'selected="selected"'}} @endif>Mrs.</option>
                        <option @if(old('service_type') =='Miss') {{'selected="selected"'}} @endif>Miss</option>
                      </select>
                    </div>
                    <div class="col-4">
                      <input type="text" name="fname" value="{{old('fname') ?: $fname}}" class="form-control" placeholder="First Name*" required>
                    </div>
                    <div class="col-6">
                      <input type="text" name="lname" value="{{old('lname') ?: $lname}}" class="form-control" placeholder="Last Name*" required>
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-6">
                      <input type="text" name="customer_email" value="{{(!empty($voucher->guest_email))?$voucher->guest_email:$voucher->agent->email}}" class="form-control" placeholder="Email ID">
                    </div>
                    <div class="col-2">
                    <select name="country_code" id="country_code" required class="form-control">
									@foreach($countriesCode as $country)
									@if($country->code != '')
									<option value="{{$country->code}}" @if(old('country_code') == $country->code) {{'selected="selected"'}} @endif>{{$country->code}}</option>
									@endif
									@endforeach
									</select>
                    </div>
                    <div class="col-4">
                     <input type="text" name="customer_mobile" value="{{old('customer_mobile')}}" required='required' class="form-control" placeholder="Mobile No.">
                    </div>
                    
					
                  </div>
				  <div class="row" style="margin-bottom: 15px;">
				  <div class="col-6">
                      <input type="text" required name="file_handling_by" value="{{ old('file_handling_by') ?: $voucher->file_handling_by}}" class="form-control" placeholder="File Handling By*">
                    </div>
				  <div class="col-6">
                      <input type="text" name="agent_ref_no" value="{{old('agent_ref_no') ?: $voucher->agent_ref_no}}" class="form-control" placeholder="Agent Reference No.">
                    </div>
				  </div>
                  <div class="row" style="margin-bottom: 5px;">
				  
                    <div class="col-12">
                      <textarea type="text" class="form-control" style="resize:none;" name="remark" placeholder="Remark" rows="2">{{old('remark') ?: $voucher->remark}}</textarea>
                    </div>
                   
                  </div>
                </div>
                <!-- /.card-body -->
				
               
            </div>
            <!-- /.card -->
			@php
					$ii = 0;
					@endphp
			@if(!empty($voucherActivity) && $voucher->is_activity == 1)
				@foreach($voucherActivity as $ap)
				  @if(($ap->transfer_option == 'Shared Transfer') || ($ap->transfer_option == 'Pvt Transfer') || ($ap->transfer_option == 'Ticket Only'))
				  @php
					$ii = 1;
					@endphp
				@endif
					@endforeach
			
            <div class="card card-default {{($ii=='0')?'hide':''}}">
              <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-book" style="color:black"></i> Additional Information</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
				
					@if(!empty($voucherActivity))
						 @php
					$c=0;
					$tkt=0;
					@endphp
					 @foreach($voucherActivity as $ap)
						@if(($ap->transfer_option != 'Ticket Only'))
							@php $tkt++; @endphp
						@endif
					  @endforeach
					<div class="row @if($tkt == 0) hide @endif" style="margin-bottom: 15px;" >
          <div class="form-group col-md-6">
						 <label>Default Pickup Location</label>
						 <input type="text" class="form-control" id="defaut_pickup_location" />
						</div>
					
					<div class="form-group col-md-6">
						 <label>Default Dropoff Location</label>
						<input type="text" class="form-control" id="defaut_dropoff_location" />
						
						</div>
            </div>
					 @foreach($voucherActivity as $ap)
					  @if(($ap->transfer_option == 'Shared Transfer') || ($ap->transfer_option == 'Pvt Transfer') || ($ap->transfer_option == 'Ticket Only'))
				  @php
					$c++;
          
					@endphp
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-12"><p><strong>{{$c}}. {{$ap->variant_name}} : {{$ap->transfer_option}}@if($ap->transfer_option == 'Shared Transfer')
					@php
					$zone = SiteHelpers::getZoneName($ap->transfer_zone);
					@endphp
					- Zone :{{(isset($zone->name))?$zone->name:''}}
					@endif</strong></p></div>
           
			      <div class="form-group col-md-6 ">
                <label>Tour Date</label>
                 <input type="text" id="tour_date{{$ap->id}}" value="{{$ap->tour_date}}" readonly='readonly' required="required" class="form-control datepicker inputsave"  placeholder="Tour Date*" required data-id="{{$ap->id}}" data-name="tour_date" />
				
              </div>
              <div class="form-group col-md-6 ">
              <label>Tour Sequence</label>
                 <input type="text" id="serial_no{{$ap->id}}" value="{{$ap->serial_no}}"  required="required" class="form-control inputsave"  placeholder="Tour Sequence" required data-id="{{$ap->id}}" data-name="serial_no" />
				
              </div>
			  
              @permission('list.voucher.selectsupplier') 
			  @if(($ap->transfer_option == 'Ticket Only'))

			  <div class="form-group col-md-6 ">
              <label>TKT Supplier</label>
			  <select name="supplier_ticket{{$ap->id}}" id="supplier_ticket{{$ap->id}}" class="form-control inputsaveSp">
						<option data-name="supplier_ticket"  data-id="{{$ap->id}}" value="">All</option>
						@foreach($supplier_ticket as  $stv)
						
						<option data-name="supplier_ticket"  data-id="{{$ap->id}}" value = "{{$stv->id}}" @if($ap->supplier_ticket==$stv->id) selected="selected" @endif >{{$stv->company_name}}</option>
						@endforeach
                 </select>
				 
              </div>
			  <div class="form-group col-md-6 ">
              <label>TKT Net Cost</label>
			  <input type="text" class="form-control inputsave" id="actual_total_cost{{$ap->id}}" data-name="actual_total_cost"  data-id="{{$ap->id}}" value="{{$ap->actual_total_cost}}" />
				 
              </div>
			  
			  @endif
			  
        @endpermission
			  
					@if($ap->activity_entry_type=='Arrival')
						<div class="form-group col-md-6">
						 
						<input type="text" class="form-control inputsave autodropoff_location" id="dropoff_location{{$ap->id}}" name="dropoff_location{{$ap->id}}" data-name="dropoff_location"  data-id="{{$ap->id}}" value="{{$ap->dropoff_location}}" required data-zone="{{$ap->transfer_zone}}"  placeholder="Dropoff Location*" />
						
						<label for="inputName" style="width: 100%;"> <span class="float-left"><input type="checkbox" data-idinput="dropoff_location{{$ap->id}}" class="chk_other " data-name="dropoff_other"  data-id="{{$ap->id}}" value="1"  /> Other<span></label>
						</div>
					
					
					<div class="form-group col-md-6 ">
				<input type="text" class="form-control inputsave" id="passenger_name{{$ap->id}}" data-name="passenger_name"  data-id="{{$ap->id}}" required value="{{$ap->passenger_name}}"  placeholder="Passenger Name*" />
				
              </div>
			 
			   <div class="form-group col-md-6 ">
                 <input type="text" id="actual_pickup_time{{$ap->id}}" name="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control timepicker inputsave" required placeholder="Arrival Time*" data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
			 
			  
			  <div class="form-group col-md-6 ">
                 <input type="text" id="flight_no{{$ap->id}}" name="flight_no{{$ap->id}}" value="{{$ap->flight_no}}" class="form-control inputsave"  placeholder="Arrival Flight Details*" required data-id="{{$ap->id}}" data-name="flight_no" />
				
              </div>
                    
					<div class="form-group col-md-12">
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
					
					@elseif(($ap->activity_entry_type=='Interhotel') || ($ap->activity_entry_type=='Limo'))
		  
                    <div class="form-group col-md-6">
						
					<input type="text" class="form-control inputsave autocom" id="pickup_location{{$ap->id}}"  name="pickup_location{{$ap->id}}" data-name="pickup_location"  data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}"  placeholder="Pickup Location*" required />
										 <label for="inputName" style="width: 100%;"><span class="float-left"><input type="checkbox" data-idinput="pickup_location{{$ap->id}}" class="chk_other " data-name="pickup_other"  data-id="{{$ap->id}}" value="1"  /> Other<span></label>

                     
                    </div>
					 <div class="form-group col-md-6">
					
					 
					
					<input type="text" class="form-control inputsave autodropoff_location" id="dropoff_location{{$ap->id}}" name="dropoff_location{{$ap->id}}" data-name="dropoff_location"  data-id="{{$ap->id}}" value="{{$ap->dropoff_location}}" data-zone="{{$ap->transfer_zone}}"  required placeholder="Dropoff Location*" />
					 <label for="inputName" style="width: 100%;"><span class="float-left"><input type="checkbox" data-idinput="dropoff_location{{$ap->id}}" class="chk_other " data-name="dropoff_other"  data-id="{{$ap->id}}" value="1"  /> Other<span></label>
                    </div>
                    @if(($ap->activity_entry_type=='Interhotel'))
					 <div class="form-group col-md-6 ">
               
                 <input type="text" id="actual_pickup_time{{$ap->id}}" name="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control timepicker inputsave"  placeholder="Pickup Time*" required data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
              @endif
                    <div class="form-group col-md-6">
					
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}" required placeholder="Remark" />
                    </div>
					@elseif($ap->activity_entry_type=='Departure')
		  
                    <div class="form-group col-md-6">
					
					
					<input type="text" class="form-control inputsave autocom" id="pickup_location{{$ap->id}}" name="pickup_location{{$ap->id}}" data-name="pickup_location"  data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}" placeholder="Pickup Location*" required />
					 <label for="inputName" style="width: 100%;"><span class="float-left"><input type="checkbox" data-idinput="pickup_location{{$ap->id}}" class="chk_other " data-name="pickup_other"  data-id="{{$ap->id}}" value="1"  /> Other<span></label>
                     
                    </div>
					
					 <div class="form-group col-md-6 ">
                
                 <input type="text" id="actual_pickup_time{{$ap->id}}" name="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control timepicker inputsave"  placeholder="Pickup Time*" required data-id="{{$ap->id}}" data-name="actual_pickup_time" />
				 
              </div>
			  <div class="form-group col-md-6 ">
               
                 <input type="text" id="flight_no{{$ap->id}}" name="flight_no{{$ap->id}}" value="{{$ap->flight_no}}" class="form-control inputsave"  placeholder="Departure Flight Details*" required data-id="{{$ap->id}}" data-name="flight_no" />
				
              </div>
                    <div class="form-group col-md-6">
					
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
					@elseif($ap->transfer_option != 'Ticket Only')
						<div class="form-group col-md-6">
					
					 
						
					<input type="text" class="form-control inputsave autocom" id="pickup_location{{$ap->id}}"  data-name="pickup_location"  data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}" required placeholder="Pickup Location*" required name="pickup_location{{$ap->id}}"/>
					 <label for="inputName" style="width: 100%;"><span class="float-left"><input type="checkbox" data-idinput="pickup_location{{$ap->id}}" class="chk_other " data-name="pickup_other"  data-id="{{$ap->id}}" value="1"   /> Other<span></label>
					  </div>
					
                     @if(($ap->variant_pick_up_required=='1'))
					<div class="form-group col-md-6 ">
                
                 <input type="text" id="actual_pickup_time{{$ap->id}}" value="{{$ap->actual_pickup_time}}" class="form-control timepicker inputsave" required placeholder="Pickup Time*" data-id="{{$ap->id}}" data-name="actual_pickup_time" name="actual_pickup_time{{$ap->id}}" />
				 
              </div>
                    @endif
					
			  
			 
					<div class="form-group col-md-12">
					
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
					
					@endif
          <div class="form-group col-md-12">
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
					
          @if($ap->transfer_option == 'Pvt Transfer')
          <div class="form-group col-md-6">
					<label>Select Vechile Type</label>
			  <select name="vehicle_type{{$ap->id}}" id="vehicle_type{{$ap->id}}" class="form-control inputsaveSp">
						<option data-name="vehicle_type"  data-id="{{$ap->id}}" value="">Select</option>
						@foreach($vehicle_type as  $stv)
						<option data-name="vehicle_type"  data-id="{{$ap->id}}" value = "{{$stv->name}}" @if($ap->vehicle_type==$stv->name) selected="selected" @endif >{{$stv->name}}</option>
						@endforeach
                 </select>
                    </div>
          @endif
                  </div>
				   @endif
				  @endforeach
                 @endif
				  
                </div>
                </div>
				@endif
                <!-- /.card-body -->

               
           
			
            <!-- /.card -->
            
        @if(!empty($voucherHotel) && $voucher->is_hotel == 1)

         @if($voucherHotel->count() > 0)
              <div class="card card-default ">
                <div class="card-header">
                  <h3 class="card-title"><i class="nav-icon fas fa-book" style="color:black"></i> Additional Information Hotel</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
              
                  <div class="card-body">
           
              @foreach($voucherHotel as $vah)
           
                    <div class="row" style="margin-bottom: 15px;">
                      <div class="col-12"><p>{{$vah->hotel->name}} - {{$vah->hotel->hotelcategory->name}}</p></div>
                      <div class="col-6">
            <input type="text" class="form-control inputsavehotel" id="confirmation_number{{$vah->id}}" name="confirmation_number[]" data-name="confirmation_number"  data-id="{{$vah->id}}" value="{{$vah->confirmation_number}}" placeholder="Confirmation number" required />
                       
                      </div>
                      <div class="form-group col-md-6 ">
               
                 <input type="text" id="payment_due_date{{$vah->id}}" value="{{$vah->payment_due_date}}" readonly='readonly' required="required" class="form-control datepicker inputsavehotel"  placeholder="Payment Due Date*" required data-id="{{$vah->id}}" data-name="payment_due_date" />
				
              </div>
                      <div class="col-12">
            <input type="text" class="form-control inputsavehotel" id="remark{{$vah->id}}{{$vah->voucher_id}}"  data-name="remark"  data-id="{{$vah->id}}" value="{{$vah->remark}}" placeholder="Remark"  />
                       
                      </div>
                    </div>
            
            @endforeach
                   
            
                  </div>
         
                  <!-- /.card-body -->
  
                 
              </div>
			  @endif
              @endif
              <!-- /.card -->
            <div class="card card-default">
              <div class="card-header">
               <h3 class="card-title"><i class="nav-icon fas fa-credit-card" style="color:black"></i>  Payment Options</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-12">
					@php
					$balance  = $voucher->agent->agent_amount_balance - $voucher->agent->agent_credit_limit;
					@endphp
                      <input type="radio" checked name="payment"  /> Credit Limit (Wallet Balance AED {{($balance > 0)?$balance:0}})  / (Credit Limit AED {{$voucher->agent->agent_amount_balance}})
                    </div>
                   
                  </div>
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-12">
                      <input type="radio" disabled name="payment"  /> Credit Card / Debit Card
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

               
            </div>
            <!-- /.card -->
 <!-- general form elements -->
 <div class="card card-default">
  
   

    <div class="card-footer">
      <div class="row" style="margin-bottom: 5px;">
        <div class="col-md-12 text-left">
          <input type="checkbox" name="tearmcsk" checked required id="tearmcsk" /> By clicking Pay Now you agree that you have read ad understood our Terms and Conditions
		  <br><label id="tearmcsk_message" for="tearmcsk" class="error hide" >This field is required.</label>
        </div>
        <div class="col-12 text-right">
          @if($voucher->status_main < 2)
            <button type="submit" name="btn_quotation" class="btn btn-primary">Pending for Invoice</button>
            @endif
            @if($voucher->status_main < 3)
            <button type="submit" name="btn_process" class="btn btn-info">In Process</button>
            @endif
            @if($voucher->status_main < 4)
            <button type="submit" name="btn_hold" class="btn btn-primary">Hold</button>
            @endif
            @if($voucher->status_main < 5 )
            <button type="submit" name="btn_paynow" class="btn btn-success">Pay Now</button>
            @endif
        </div>
      </div>
    </div>

</div>
<!-- /.card -->

            <!-- Horizontal Form -->
            
            <!-- /.card -->
</form>
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-4" >
		 
            <!-- Form Element sizes -->
			@php
				$totalGrand =0; 
				$totalGrandDiscount =0; 
        $caid = 0;
$ty=0;
$aid = 0;
			  @endphp
			  @if(!empty($voucherActivity) && $voucher->is_activity == 1)
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
            @php
            $delKey = $ap->id;
            $totalDiscount = 0;
					@endphp
          @if(($ap->activity_product_type == 'Bundle_Same') || ($ap->activity_product_type == 'Bundle_Diff'))
          @php
          $aid = $ap->activity_id;
          $delKey = $ap->voucher_id;
          $total_sp  = 0;
          
		  $total_sp = PriceHelper::getTotalActivitySP($ap->voucher_id,$ap->activity_id);


					@endphp
          @endif
          @if(($ap->activity_product_type == 'Bundle_Same') && ($caid != $ap->activity_id))
          @php
          $dis = 1;
          @endphp
          @elseif(($ap->activity_product_type != 'Bundle_Same'))
          @php
          $dis = 1;
          @endphp
          @else
          @php
          $dis = 0;
          @endphp
          @endif
          
          @if( $dis == 1)
				  
            <div class="card card-default">
			
              <div class="card-header">
                <div class="row">
				<div class="col-md-8 text-left">
                    <h3 class="card-title">
                      <strong> {{$ap->activity_title}}</strong></h3>
                  </div>
				<div class="col-md-4 text-right">
        @if(($ap->activity_product_type != 'Bundle_Same') && ($ap->activity_product_type != 'Bundle_Diff'))
           
         
           <form id="delete-form-{{$delKey}}" method="post" action="{{route('voucher.activity.delete',$delKey.'/0')}}" style="display:none;">
                             {{csrf_field()}}
                             {{method_field('DELETE')}}
                         </form>
                         <small>
                         <a class="btn btn-xs btn-danger border-round" title="delete" href="javascript:void(0)" onclick="
                             if(confirm('Are you sure, You want to delete this?'))
                             {
                                 event.preventDefault();
                                 document.getElementById('delete-form-{{$delKey}}').submit();
                             }
                             else
                             {
                                 event.preventDefault();
                             }
                         
                         ">
                         
                         <small><i class="fas fa-trash-alt "></i></small></a></small>

                         <a class="btn-info btn-sm" href="{{route('voucher.activity.view',[$ap->activity_id,$voucher->id,$ap->tour_date,$ap->adult,$ap->child,$ap->infant,$ap->transfer_option])}}"><i class="fas fa-edit"></i></a>
                    
              @elseif($caid != $ap->activity_id)
             
              <form id="delete-form-{{$delKey}}-{{$ap->activity_id}}" method="post" action="{{route('voucher.activity.delete',$delKey.'/'.$ap->activity_id)}}" style="display:none;">
                             {{csrf_field()}}
                             {{method_field('DELETE')}}
                         </form>
                         <small>
                         <a class="btn btn-xs btn-danger border-round" title="delete" href="javascript:void(0)" onclick="
                             if(confirm('Are you sure, You want to delete this?'))
                             {
                                 event.preventDefault();
                                 document.getElementById('delete-form-{{$delKey}}-{{$ap->activity_id}}').submit();
                             }
                             else
                             {
                                 event.preventDefault();
                             }
                         
                         ">
                         
                         <small><i class="fas fa-trash-alt "></i></small></a></small>
               @endif
                           
                  </div>
				   </div>
              </div>
              <div class="card-body">
			  
			  <div class="">
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Tour Option</strong>
                    </div>
                    <div class="col-md-7 text-right">
                      {{$ap->variant_name}}
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Date</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{ $ap->tour_date ? date(config('app.date_format'),strtotime($ap->tour_date)) : null }}   {{ $ap->time_slot ? ' : '.$ap->time_slot: null }}
                   
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Transfer Type</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->transfer_option}}
                  </div>
                </div>
				@if($ap->transfer_option == 'Shared Transfer')
					@php
					$pickup_time = SiteHelpers::getPickupTimeByZone($ap->variant_zones,$ap->transfer_zone);
					@endphp
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pickup Timing</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$pickup_time}}
                  </div>
                </div>
				@endif
				@if(($ap->transfer_option == 'Pvt Transfer') && ($ap->variant_pick_up_required == '1')  && ($ap->variant_pvt_TFRS == '1'))
					@php
					$pickup_time = SiteHelpers::getPickupTimeByZone($ap->variant_zones,$ap->transfer_zone);
					@endphp
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pickup Timing</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->variant_pvt_TFRS_text}}
                  </div>
                </div>
				@endif
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pax</strong>
                  </div>
                  <div class="col-md-7 text-right">
                  @if(($ap->activity_entry_type == 'Yacht') || ($ap->activity_entry_type == 'Limo'))
							        {{$ap->adult}}  Hour(s)
						    	@else
                   {{$ap->adult}} Adult {{$ap->child}} Child
                   @endif
                  </div>
                </div>
                
                @if(($ap->activity_product_type != 'Bundle_Same') && ($ap->activity_product_type != 'Bundle_Diff'))
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Amount</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   AED {{$ap->totalprice}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Ticket Discount</strong>
                  </div>
                  <div class="col-md-7 text-right">
				  
                   AED {{($ap->discount_tkt>0)?$ap->discount_tkt:0}}
                  </div>
                </div>
				<div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Transfer Discount</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   AED {{($ap->discount_sic_pvt_price>0)?$ap->discount_sic_pvt_price:0}}
                  </div>
                </div>
               
				<div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Net Total</strong>
                  </div>
                  <div class="col-md-7 text-right">
				  @php
				  $totalDiscount = $ap->discount_tkt+ $ap->discount_sic_pvt_price;
				  @endphp
                   AED {{$ap->totalprice - $totalDiscount}}
                  </div>
                  </div>
                  @else
                  @if($caid != $ap->activity_id)
                  <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Net Total</strong>
                  </div>
                  <div class="col-md-7 text-right">
				 
                   AED {{$total_sp}}
                  </div>
                  </div>
                  @endif
                  @endif
        
        
			
              </div>
              </div>
              <!-- /.card-body -->
               @endif
            </div>
            <!-- /.card -->
@php
					$totalGrand += $ap->totalprice; 
					$totalGrandDiscount += $totalDiscount; 
				 
      $caid = $ap->activity_id;
      @endphp
				 @endforeach
                 @endif
				  @endif
         <!-- /.startteldiv-->
          @if(!empty($voucherHotel) && $voucher->is_hotel == 1)
					@if(!empty($voucherHotel))
					  @foreach($voucherHotel as $vh)
            @php
            $room = SiteHelpers::hotelRoomsDetails($vh->hotel_other_details)
            @endphp
            <div class="card card-default">
              <div class="card-header">
                <div class="row">
				<div class="col-md-8 text-left">
                    <h3 class="card-title">
                      <strong> {{$vh->hotel->name}}</strong></h3>
                  </div>
				<div class="col-md-4 text-right">
                    <form id="delete-form-hotel-{{$vh->id}}" method="post" action="{{route('voucher.hotel.delete',$vh->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn-danger btn-sm" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-hotel-{{$vh->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i></a>
                    
                  </div>
				   </div>
              </div>
              <div class="card-body">
			  
			  <div class="">
          <div class="row" style="margin-bottom: 5px;">
            <div class="col-md-5 text-left">
              <strong>Hotel Category</strong>
            </div>
            <div class="col-md-7 text-right">
              {{$vh->hotel->hotelcategory->name}}
            </div>
        </div>
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Check In</strong>
                    </div>
                    <div class="col-md-7 text-right">
                      {{$vh->check_in_date}}
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Check Out</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$vh->check_out_date}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Room Type</strong>
                  </div>
                  <div class="col-md-7 text-right">
                    {{$room['room_type']}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Number of Rooms</strong>
                  </div>
                  <div class="col-md-7 text-right">
                    {{$room['number_of_rooms']}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Occupancy</strong>
                  </div>
                  <div class="col-md-7 text-right">
                    {{$room['occupancy']}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Meal Plan</strong>
                  </div>
                  <div class="col-md-7 text-right">
                    {{$room['mealplan']}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Amount Incl. VAT</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   AED {{$room['price']}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Total</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   AED {{$room['price']}}
                  </div>
                </div>
				</div>
				
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
@php
					$totalGrand += $room['price']; 
				  @endphp
				 @endforeach
                 @endif
				  @endif
           <!-- /.endhoteldiv-->
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title"><strong>Total Payment</strong></h3>
              </div>
              <div class="card-body">
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-6 text-left">
                    <strong>Amount Incl. VAT</strong>
                  </div>
                  <div class="col-md-6 text-right">
                   AED {{$totalGrand - $totalGrandDiscount}}
                  </div>
                </div>
				 <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-6 text-left">
                    <strong>Discount</strong>
                  </div>
                  <div class="col-md-6 text-right">
                   AED {{$totalGrandDiscount}}
                  </div>
                </div>
               <!-- <div class="row" style="margin-bottom: 15px;">
                  <div class="col-md-6 text-left">
                    <strong>Handling charges (2%)</strong>
                  </div>
                  <div class="col-md-6 text-right">
                   AED 2.30
                  </div>
                </div> -->
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-6 text-left">
                    <h5>Final Amount</h5>
                  </div>
                  <div class="col-md-6 text-right">
                   <h5>AED {{$totalGrand - $totalGrandDiscount}}</h5>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  
    <!-- /.content -->
@endsection



@section('scripts')
<script  src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js
"></script>




<script type="text/javascript">
 
  $(function(){
	 $('.chk_other').each(function() {
        var inputid = $(this).data('idinput');
        var isChecked = $(this).is(':checked');

        // Handle checkbox change
        $(this).on('change', function() {
            if ($(this).is(':checked')) {
                $("body #" + inputid).autocomplete("option", "disabled", true);
            } else {
                $("body #" + inputid).autocomplete("option", "disabled", false);
            }
        });
    });
	 

$('#cusDetails').validate({});

	 $(document).on('blur', '.inputsave', function(evt) {
		
		$("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).data('id'),
			   inputname: $(this).data('name'),
			   val: $(this).val()
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
	 }); 

   $(document).on('change', '.inputsavehotel', function(evt) {
		
		$("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherHotelInputSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).data('id'),
			   inputname: $(this).data('name'),
			   val: $(this).val()
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
	 }); 

	 var path = "{{ route('auto.hotel') }}";
	 var inputElement = $(this); // Store reference to the input element

	 $(".autocom").each(function() {
    var inputElement = $(this);
    inputElement.autocomplete({
        source: function(request, response) {
            $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term,
                    //zone: inputElement.attr('data-zone')
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
			
            $(this).val(ui.item.label);
            return false;
        },
        change: function(event, ui) {
            if (ui.item == null) {
                $(this).val('');
            }
        }
    });
});

 $(".autodropoff_location").each(function() {
    var inputElement = $(this);
    inputElement.autocomplete({
        source: function(request, response) {
            $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term,
                    //zone: inputElement.attr('data-zone')
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            $(this).val(ui.item.label);
            return false;
        },
        change: function(event, ui) {
            if (ui.item == null) {
               $(this).val('');
            }
        }
    });
});


	
    $("#defaut_dropoff_location").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term,
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            $(this).val(ui.item.label);
			var selectBox = $('.autodropoff_location'); // Adjust selector as per your HTML structure
			selectBox.val(ui.item.label);
			savedropoff_location(ui.item.label);
            return false;
        },
        change: function(event, ui) {
            if (ui.item == null) {
               $(this).val('');
            }
        }
    });

 $("#defaut_pickup_location").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term,
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            $(this).val(ui.item.label);
			var selectBox = $('.autocom'); // Adjust selector as per your HTML structure
			selectBox.val(ui.item.label);
			savepickup_location(ui.item.label);
            return false;
        },
        change: function(event, ui) {
            if (ui.item == null) {
               $(this).val('');
            }
        }
    });

 $(document).on('change', '.inputsaveSp', function(evt) {
		$("#loader-overlay").show();
		var id = $(this).find(':selected').data('id');
		var inputname = $(this).find(':selected').data('name');
		//alert(inputname);
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
			
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: id,
			   inputname: inputname,
			   val: $(this).val(),
            },
            success: function( data ) {
			   if(inputname == 'supplier_ticket'){
          
				   $("#actual_total_cost"+id).val(data[0].cost);
			   }
			  $("#loader-overlay").hide();
            }
          });
	 });
	 
	/*  $(document).on('change', '.inputsaveDis', function(evt) {
		$("#loader-overlay").show();
		var id = $(this).data('id');
		var inputname = $(this).data('name');
		//alert(id);
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
			
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: id,
			   inputname: inputname,
			   val: $(this).val(),
            },
            success: function( data ) {
			   if(inputname == 'supplier_ticket'){
          
				   $("#actual_total_cost"+id).val(data[0].cost);
			   }
			  $("#loader-overlay").hide();
            }
          });
	 }); */
	 
	

	});
	
	function savepickup_location(v){
		
		if(v!=''){
		$(".autocom.inputsave").each(function() {
			$("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).data('id'),
			   inputname: $(this).data('name'),
			   val: $(this).val()
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
    });
		}
	}
	
	function savedropoff_location(v){
		
		if(v!=''){
		$(".autodropoff_location.inputsave").each(function() {
			$("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).data('id'),
			   inputname: $(this).data('name'),
			   val: $(this).val()
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
    });
		}
	}


</script>
@endsection
