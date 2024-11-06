@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Vouchers</a></li>
              <li class="breadcrumb-item active">Voucher Details</li>
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
		
       
	   <div class="card-body">
		<div class="tab-content" id="custom-tabs-three-tabContent">
			<div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
			<header class="profile-header">
				
				<div class="profile-content">
					<div class="row">
					<div class="col-lg-12">
				<h5>Voucher Details</h5>
				</div>
				
               <div class="col-lg-6 mb-3">
                <label for="inputName">Agency Name:</label>
				@if(isset($voucher->agent))
               {{ $voucher->agent->company_name }} </br>
			   <b>Code:</b>{{$voucher->agent->code}} <b> Email:</b>{{$voucher->agent->email}} <b>Mobile No:</b>{{$voucher->agent->mobile}} <b>Address:</b>{{$voucher->agent->address. " ".$voucher->agent->postcode;}}
			   
			   @endif
              </div>
			 
			      <div class="col-lg-6 mb-3">
                <label for="inputName">Customer Name:</label>
				@if(isset($voucher->customer))
                {{ $voucher->name }} </br>
				<b>Email:</b>{{$voucher->customer->email}} <b>Mobile No:</b>{{$voucher->customer->mobile}} <b>Address:</b>{{$voucher->customer->address. " ".$voucher->customer->zip_code;}}
				@endif
              </div>
			  
			  <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Guest Name:</label>
                {{ $voucher->guest_name }}
              </div>
			   <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Voucher Code:</label>
                {{ $voucher->code }}
              </div>
			  <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Country:</label>
                {{($voucher->country)?$voucher->country->name:''}}
              </div>
			  
			  
			    <div class="form-group col-lg-6 mb-3">
			        <label for="inputName">Voucher Status:</label>
					{!! SiteHelpers::voucherStatus($voucher->status_main) !!}
              </div>
			  
              <div class="col-lg-4 mb-3">
                <label for="inputName">Travel Date From:</label>
				{{ $voucher->travel_from_date ? date(config('app.date_format'),strtotime($voucher->travel_from_date)) : null }}
              </div>
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Number Of Night:</label>
				{{ $voucher->nof_night  }}
              </div>
			   <div class="col-lg-4 mb-3">
                <label for="inputName">Travel Date To:</label>
				{{ $voucher->travel_to_date ? date(config('app.date_format'),strtotime($voucher->travel_to_date)) : null }}
              </div>
            
            
          </div>
		  
				
				</div>
         
				</header>
			
				@php
				$totalGrand =0; 
			  @endphp
			@if(!empty($voucherActivity) && $voucher->is_activity == 1)
				<div class="row p-2">
			 
			  <div class="col-md-12">
                <table class="table table-bordered">
                  <thead>
				  
                  <tr>
					<th>Tour Option</th>
                    <th>Transfer Option</th>
					<th>Tour Date</th>
					<th>Adult</th>
                    <th>Child</th>
                    <th>Infant</th>
					<th>Net Discount</th>
					<th>Total Amount</th>
					<th></th>
                  </tr>
				
				  @if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
					@php
					$activity = SiteHelpers::getActivity($ap->activity_id);
					@endphp
				   <tr>
                    <td>{{$activity->title}} - {{$ap->variant_name}} - {{$ap->variant_code}}</td>
					<td>{{$ap->transfer_option}}
					@if($ap->transfer_option == 'Shared Transfer')
						@php
					$zone = SiteHelpers::getZoneName($ap->transfer_zone);
					@endphp
						- <b>Zone :</b> {{$zone->name}}
					@endif
					
					@if($ap->transfer_option == 'Shared Transfer')
					- <b>Pickup Location :</b> <input type="text" class="form-control inputsave autocom" id="pickup_location{{$ap->id}}" data-name="pickup_location"  data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}" />
					@elseif($ap->transfer_option == 'Pvt Transfer')
					- <b>Pickup Location :</b> <input type="text" class="form-control inputsave autocom" id="pickup_location{{$ap->id}}" data-name="pickup_location" data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}" />
					@endif
					</td>
					<td>{{$ap->tour_date}}</td>
					<td>{{$ap->adult}}</td>
                    <td>{{$ap->child}}</td>
                    <td>{{$ap->infant}}</td>
					<td>{{$ap->discountPrice}}</td>
					<td>{{$ap->totalprice}}</td>
					<td>
					
						   <form id="delete-form-{{$ap->id}}" method="post" action="{{route('agent.voucher.activity.delete',$ap->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$ap->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i></a>
                         </td>
                  </tr>
				  @php
					$totalGrand += $ap->totalprice; 
				  @endphp
				  @endforeach
					<tr>
					<td colspan="7" class="text-right"><b>Total<b/></td>
					<td colspan="2"><b>{{$totalGrand}}<b/></td>
					</tr>
				 @endif

				  </table>
              </div>
			 </div>	
		@endif
			</div>

		</div>
</div>

      </div>
  
    </section>
    <!-- /.content -->
@endsection



@section('scripts')
<script type="text/javascript">
  $(function(){
	 $(document).on('change', '.inputsave', function(evt) {
		
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
                    zone: inputElement.attr('data-zone')
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            $('#pickup_location' + inputElement.data('id')).val(ui.item.label);
            return false;
        },
        change: function(event, ui) {
            if (ui.item == null) {
                $('#pickup_location' + inputElement.data('id')).val('');
            }
        }
    });
});


	});
</script>
@endsection