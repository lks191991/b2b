@extends('layouts.appLogin')
@section('content')







<div class="breadcrumb-section" style="background-image: linear-gradient(270deg, rgba(0, 0, 0, .3), rgba(0, 0, 0, 0.3) 101.02%), url({{asset('front/assets/img/innerpage/inner-banner-bg.png')}});"> 
        <div class="container">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-center">
                    <div class="banner-content">
                        <h1>My Bookings</h1>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Start Checkout section -->
    <div class="checkout-page pt-120 mb-120">
        <div class="container">
          <div class="row g-lg-4 gy-5 mb-30">
            <div class="col-md-12">
              <div class="inquiry-form ">
              <form id="filterForm" class="form-inline" method="get" action="{{ route('agent-vouchers.index') }}" >
              <div class="row">
              <div class="col-md-3">
              <div class="form-inner mb-30">
                 <select name="booking_type" id="booking_type" class="form-control">
                   <option value="1" {{ (request('booking_type') == 1) ? 'selected' : '' }}>Booking Date</option>
					<option value="2" {{ (request('booking_type') == 2) ? 'selected' : '' }}>Travel Date</option>
					<!--<option value = "3">Deadline Date</option>-->
                 </select>
</div>
                </div>
                <div class="col-md-3">
                <div class="form-inner mb-30">
                    <input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control  datepicker"  placeholder="From Date" />
</div>
                    </div>
                <div class="col-md-3">
                <div class="form-inner mb-30">
                    <input type="text" name="to_date" value="{{ request('to_date') }}" class="form-control datepicker" autocomplete ="off"  placeholder="To Date" />
                    </div>
</div>
                <div class="col-md-3">
                <div class="form-inner mb-30">
                    <input type="text" name="reference" value="{{ request('reference') }}" class="form-control"  placeholder="Agent Reference Number" />
                    </div>
                    </div>
                <div class="col-md-3">
                <div class="form-inner mb-30">
                    <input type="text" name="vcode" value="{{ request('vcode') }}" class="form-control"  placeholder="Booking Number" />
                    </div>
                    </div>
                <div class="col-md-3">
                <div class="form-inner mb-30">
                    <input type="text" name="activity_name" value="{{ request('activity_name') }}" class="form-control"  placeholder="Service Name" />
                    </div>
                    </div>
                <div class="col-md-3">
                <div class="form-inner mb-30">
                    <input type="text" name="customer" value="{{ request('customer') }}" class="form-control"  placeholder="Customer" />
                    </div>
                    </div>
                <div class="col-md-3">
                <div class="form-inner mb-30">
                <button class="secondary-btn2" type="submit">Filter</button>
                <a class="btn btn-default mx-sm-2" href="{{ route('agent-vouchers.index') }}">Clear</a>
                </div>
                </div>
              </div>
            </form>
              </div>
            </div>
          </div>
            <div class="row g-lg-4 gy-5">
                <div class="col-lg-12">
                    
                <table class="table table-condensed table-striped">
                      <tdead class="bg-light-1 rounded-12">
                        <tr>
                  <td>Booking Number</td>
                  <td>Booking Date</td>
                  <td>Service Type</td>
					
					<td>Service Name</td>
          <td>Travel Date</td>
					<td>Agent Ref. No.</td>
					<td>Customer</td>
					<td>Adult</td>
					<td>Child</td>
					<td>Infant</td>
					<td>Invoice</td>
					<td>Itinerary</td>
				
					
                    <td>Status</td>
                  
				
                    <td></td>
                  </tr>
                      </tdead>

                      <tbody>
 @foreach ($records as $record)
                  <tr>
                  <td>{{ ($record->voucher->code)}}</td>
                  <td>
					{{ $record->voucher->booking_date ? date(config('app.date_format'),strtotime($record->voucher->booking_date)) : null }}
</td>
				  <td>{{ ($record->activity->entry_type)}}</td>
				  
				   <td>{{ ($record->activity->title)}}</td>
           <td>
					{{ $record->tour_date ? date(config('app.date_format'),strtotime($record->tour_date)) : null }}
					</td>
				   <td>{{ ($record->voucher->agent_ref_no)}}</td>
					<td>{{ ($record->voucher->guest_name)?$record->voucher->guest_name:''}}</td>
					<td>{{ ($record->adult)}}</td>
					<td>{{ ($record->child)}}</td>
					<td>{{ ($record->infant)}}</td>
					 <td>
						   @if($record->voucher->status_main > 4)
					 <a class="btn btn-success btn-sm" href="{{route('voucherInvoicePdf',$record->voucher->id)}}" >
           <i class="fas fa-file">
                              </i>
                             
                          </a>
						  @endif
						  </td>
						   <td>
					 
						 @if($record->voucher->status_main > 1)
					 <a class="btn btn-info btn-sm" href="{{route('voucherActivityItineraryPdf',$record->voucher->id)}}">
                              <i class="fas fa-download">
                              </i>
                             
                          </a>
						  @endif
						
						  </td>
				
					
                    <td>{!! SiteHelpers::voucherStatus($record->voucher->status_main) !!}</td>
                

                     <td>
					 @if((($record->voucher->status_main == '4') || ($record->voucher->status_main == '3')) && (strtotime($record->tour_date)) > time())
					 
					 <a class="button -dark-1 size-35 bg-light-1 rounded-full flex-center" alt="View Details" href="{{route('agent-vouchers.show',$record->voucher->id)}}">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a>
					@endif
          @if($record->voucher->status_main > 4)
					 
          <a class="button -dark-1 size-35 bg-light-1 rounded-full flex-center" alt="View Details" href="{{route('agentVoucherView',$record->voucher->id)}}">
                             <i class="fas fa-eye">
                             </i>
                             
                         </a>
         @endif
					
						  
                         </td>
                  </tr>
				 
                  @endforeach
                      </tbody>
                    </table>
                    <div class="pagination justify-center">
    <div class="pagination pull-right mt-3"> {!! $records->appends(request()->query())->links() !!} </div> 
</div>



                </div>
                
            </div>
        </div>
    </div>
    <!-- End Checkout section -->
 
@endsection
@section('scripts')
<script type="text/javascript">
    var path = "{{ route('auto.agent') }}";
  
    $( "#agent_id" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term,
            },
            success: function( data ) {
               response( data );
            }
          });
        },
		
        select: function (event, ui) {
           $('#agent_id').val(ui.item.label);
           //console.log(ui.item); 
		   $('#agent_id_select').val(ui.item.value);
		    $('#agent_details').html(ui.item.agentDetails);
           return false;
        },
        change: function(event, ui){
            // Clear the input field if the user doesn't select an option
            if (ui.item == null){
                $('#agent_id').val('');
				 $('#agent_id_select').val('');
				 $('#agent_details').html('');
            }
        }
      });
  
</script>
@endsection