@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Variant : {{ $variant->title }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('activities.index') }}">Variants</a></li>
              <li class="breadcrumb-item active">Variant Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    
        <div class="col-md-12">
		<div class="card card-primary card-outline card-tabs">
		<div class="card card-primary card-outline card-tabs">
			<div class="card-header p-0 pt-1 border-bottom-0">
			<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
			<li class="nav-item">
			<a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Variant</a>
			</li>
			@if($variant->sic_TFRS)
			<li class="nav-item">
			<a class="nav-link" id="custom-tabs-three-settings-tab" data-toggle="pill" href="#custom-tabs-three-settings" role="tab" aria-controls="custom-tabs-three-settings" aria-selected="false">Transfer Plan</a>
			</li>
			@endif
			
			<li class="nav-item">
			<a class="nav-link" id="custom-tabs-three-messages-tab1" data-toggle="pill" href="#custom-tabs-three-settings1" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">Slot And Canellation</a>
			</li>
		
			</ul>
			</div>
		 </div>
       
	   
	   <div class="card-body">
		<div class="tab-content" id="custom-tabs-three-tabContent">
			<div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
				<header class="profile-header">
         
				<div class="profile-content">
				
					<div class="row">
              <div class="col-lg-12 mb-3">
				<h4>Variant Details</h4>
				 </div>
			     <div class="col-lg-6 mb-3">
                <label for="inputName">Title:</label>
                {{ $variant->title }}
              </div>
			
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Code:</label>
                {{ $variant->code }}
              </div>
			
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Advance Booking:</label>
				{!! SiteHelpers::statusColorYesNo($variant->advance_booking) !!}
              </div>
			 
			 <div class="col-lg-6 mb-3">
                <label for="inputName">Days for Advance Booking:</label>
               {{ $variant->days_for_advance_booking }}
              </div>
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Booking Window Value (In Hours):</label>
               {{ $variant->booking_window }}
              </div>
			  
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Cancellation Value (In Hours):</label>
               {{ $variant->cancellation_value }}
              </div>
			  
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Is Open Dated:</label>
               {!! SiteHelpers::statusColorYesNo($variant->is_opendated) !!}
              </div>
			   @if($variant->is_opendated)
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Valid Till (in Days from Date of Booking):</label>
               {{ $variant->valid_till }}
              </div>
			  @endif
			  
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Pvt TFRS:</label>
               {!! SiteHelpers::statusColorYesNo($variant->pvt_TFRS) !!}
              </div>
			  @if($variant->pvt_TFRS)
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Transfer Plan:</label>
               {{ (!empty($variant->transfer))?$variant->transfer->name:'' }}
              </div>
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Pick Up Time Required ?:</label>
				{!! SiteHelpers::statusColor($variant->pick_up_required) !!}
              </div>
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Pvt TFRS Text:</label>
				{!! $variant->pvt_TFRS_text !!}
              </div>
			  @endif
			  
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Slot Type:</label>
               {!! SiteHelpers::slotType($variant->slot_type) !!}
              </div>
			  
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Available Slots:</label>
               {{ $variant->available_slots }}
              </div>
			  
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Slot Duration(In minutes):</label>
               {{ $variant->slot_duration }}
              </div>
			  
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Activity Duration(In minutes):</label>
				{{ $variant->activity_duration }}
				
              </div>
			  
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Start Time (In 24 hrs):</label>
               {{ $variant->start_time }}
              </div>
			   <div class="col-lg-6 mb-3">
                <label for="inputName">End Time (In 24 hrs):</label>
               {{ $variant->end_time }}
              </div>
			  
			    <div class="col-lg-6 mb-3">
                <label for="inputName">Black Out Date:</label>
               {{ $variant->black_out }}
              </div>
			  
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Sold Out Date:</label>
               {{ $variant->sold_out }}
              </div>
			  
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Operational Days:</label>
               @if($variant->availability=='All')
				   All Days
			   @else
			   {{$variant->availability}}
			   @endif
              </div>
			    <div class="col-lg-6 mb-3">
                <label for="inputName">SIC TFRS:</label>
               {!! SiteHelpers::statusColorYesNo($variant->sic_TFRS) !!}
              </div>
			  
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Brand Logo:</label>
                @if(!empty($variant->brand_logo))
               
                  <img src="{{asset('uploads/variants/thumb/'.$variant->brand_logo)}}"  class="cimage" style="width:100px" />
                
				@endif
              </div>
			  
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Ticket Banner Image:</label>
                @if(!empty($variant->ticket_banner_image))
               
                  <img src="{{asset('uploads/variants/thumb/'.$variant->ticket_banner_image)}}"  class="cimage" style="width:100px" />
                
				@endif
              </div>
			  
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Ticket Footer Image:</label>
                @if(!empty($variant->ticket_footer_image))
               
                  <img src="{{asset('uploads/variants/thumb/'.$variant->ticket_footer_image)}}"  class="cimage" style="width:100px" />
                
				@endif
              </div>
			  
              <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Description:</label>
                {!!$variant->description!!}
              </div>
             
			  <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Inclusion:</label>
                {!!$variant->inclusion!!}
              </div>
			  
			   <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Important Information:</label>
                {!!$variant->important_information!!}
              </div>
			  <div class="form-group col-lg-12 mb-3">
                <label for="inputName">High Light:</label>
                {!!$variant->booking_policy!!}
              </div>
			    <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Booking Cut off & Cancellation:</label>
                {!!$variant->booking_cut_off!!}
              </div>
			   <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Notes:</label>
                {!!$variant->cancellation_policy!!}
              </div>
			    <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Terms & Conditions:</label>
                {!!$variant->terms_conditions!!}
              </div>
              <div class="form-group col-lg-6 mb-3">
			        <label for="inputName">Status:</label>
					{!! SiteHelpers::statusColor($variant->status) !!}
              </div>
			  
			 
            
          </div>	
				</div>
          
			
				</header>
			</div>
			@if($variant->sic_TFRS)
				 
			<div class="tab-pane fade" id="custom-tabs-three-settings" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
			 <div class="col-lg-12 mb-3">
			 
				
				<h4>Transfer Plan</h4>
				 </div>
			  <div class="col-lg-12 mb-3">
               <table id="myTable" class="table">
					  <tr>
						<th>Zone</th>
						<th>Value</th>
						<th>Pick Up Time</th>
						<th>Drop Up Time</th>
					  </tr>
					  @if(!empty($zoneArray))
						  @foreach($zoneArray as $k => $z)
					  <tr>
						<td>{{$z['zone']}} </td>
						<td>{{$z['zoneValue']}}</td>
						<td>{{$z['pickup_time']}} </td>
						<td>{{$z['dropup_time']}}</td>
					  </tr>
					  @endforeach
					@endif
					
					</table>
              </div>
			 
			</div>
			 @endif
			
			<div class="tab-pane fade" id="custom-tabs-three-settings1" role="tabpanel" aria-labelledby="custom-tabs-three-settings-tab">
			 <div class="col-lg-12 mb-3">
				<h4>Available Slots</h4>
				 </div>
			  <div class="col-lg-12 mb-3">
               <table id="myTable1" class="table">
					  <tr>
						<th>Slot Timing</th>
						<th>Ticket Only</th>
						<th>SIC Transfer</th>
						<th>PVT Transfer</th>
					  </tr>
					  @if(!empty($slots))
						  @foreach($slots as $slot)
					  <tr>
						<td> {!! $slot->slot_timing  !!} </td>
						<td> {!! SiteHelpers::statusColorYesNo($slot->ticket_only) !!} </td>
						<td>{!! SiteHelpers::statusColorYesNo($slot->sic) !!}</td>
						<td>{!! SiteHelpers::statusColorYesNo($slot->pvt) !!}</td>
						
					  </tr>
					  @endforeach
					@endif
					
					</table>
              </div>
			  <div class="col-lg-12 mb-3">
				<h4>Canellation Chart</h4>
				 </div>
			  <div class="col-lg-12 mb-3">
               <table id="myTable1" class="table">
					  <tr>
						<th>Duration (Hours)</th>
						<th>Ticket (Refund Value)</th>
						<th>Transfer (Refund Value)</th>
					  </tr>
					  @if(!empty($canellations))
						  @foreach($canellations as $canellation)
					  <tr>
						<td> {!! $canellation->duration  !!} </td>
						<td> {!! $canellation->ticket_refund_value  !!}% </td>
						<td> {!! $canellation->transfer_refund_value  !!}% </td>
					  </tr>
					  @endforeach
					@endif
					
					</table>
              </div>
			</div>
			

		</div>
</div>

      </div>
  
    </section>
    <!-- /.content -->
@endsection



@section('scripts')
<script type="text/javascript">
$(window).on('load', function(){
 var owl = $('.owl-carousel');
owl.owlCarousel({
    loop:true,
    nav:true,
	dots:false,
    margin:10,
	items:1
  
});

  
  
});


</script>
@endsection