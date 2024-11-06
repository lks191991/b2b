@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher Details ( {{$voucher->code}})</h1>
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
		
			@if(!empty($voucherActivity))
				<div class="row p-2">
			 
			  <div class="col-md-12">
			  <form action="{{route('invoicePriceChangeSave',$voucher->id)}}" method="post" class="form" >
			  {{ csrf_field() }}
                <table class="table table-bordered">
                  <thead>
				  
                  <tr>
					<th>Tour Option</th>
                    <th>Transfer Option</th>
					<th width="10%">Tour Date</th>
					<th>Adult</th>
                    <th>Child</th>
                    <th>Infant</th>
					<th>Ticket Cost</th>
					<th>Transfer Cost</th>
					<th>Ticket Discount</th>
					<th>Transfer Discount</th>
					<th>Net Amount</th>
                  </tr>
				  @if(!empty($voucherActivity))
					  @foreach($voucherActivity as $kk => $ap)
					@php
					$priceT = $ap->totalprice - ($ap->discount_tkt + $ap->discount_sic_pvt_price);
					$allPrice = PriceHelper::getTicketAllTypeCost($ap->id)
					@endphp
					
				   <tr>
                    <td>{{$ap->activity_title}} - {{$ap->variant_name}} - {{$ap->variant_code}}</td>
					<td>{{$ap->transfer_option}}
					@if($ap->transfer_option == 'Shared Transfer')
						@php
					$zone = SiteHelpers::getZoneName($ap->transfer_zone);
					@endphp
						- <b>Zone :</b> {{@$zone->name}}
					@endif
					
					@if($ap->transfer_option == 'Shared Transfer')
					- <b>Pickup Location :</b> {{$ap->pickup_location}}
					@elseif($ap->transfer_option == 'Pvt Transfer')
					- <b>Pickup Location :</b> {{$ap->pickup_location}}
					@endif
					</td>
					<td>{{$ap->tour_date}}</td>
					<td>{{$ap->adult}}</td>
                    <td>{{$ap->child}}</td>
                    <td>{{$ap->infant}}</td>
					<td>{{ $allPrice['tkt_price'] }}</td>
					<td>{{ $allPrice['trns_price'] }}</td>
					<input type="hidden" id="totalprice{{$kk}}" value="{{$ap->totalprice}}"  data-inputnumber="{{$kk}}"   />
					<input type="hidden" id="discount_tkt_old{{$kk}}" value="{{($ap->discount_tkt>0)?$ap->discount_tkt:0}}"  data-inputnumber="{{$kk}}"   />
					<input type="hidden" id="discount_sic_pvt_price_old{{$kk}}" value="{{($ap->discount_sic_pvt_price>0)?$ap->discount_sic_pvt_price:0}}"  data-inputnumber="{{$kk}}"   />
					</td>
					<td><input type="text" id="discount_tkt{{$kk}}" name="discount_tkt[{{$ap->id}}]}" class="form-control priceChange" value="{{($ap->discount_tkt>0)?$ap->discount_tkt:0}}" data-inputnumber="{{$kk}}"   /></td>
					<td><input type="text" @if($ap->transfer_option=='Ticket Only') readonly="readonly" @endif id="discount_sic_pvt_price{{$kk}}" name="discount_sic_pvt_price[{{$ap->id}}]}" class="form-control priceChange" value="{{($ap->discount_sic_pvt_price>0)?$ap->discount_sic_pvt_price:0}}" data-inputnumber="{{$kk}}"   /></td>
					<td>
					<input type="hidden" id="newPrice{{$kk}}" value="" data-inputnumber="{{$kk}}"   />
					<span id="price{{$kk}}" style="font-weight:bold">{{ $allPrice['totalPriceAfDis'] }}</span>
					</td>
                  </tr>
				  @endforeach
				 @endif
				
				  </table>
				  <button type="submit" class="btn btn-primary float-right mr-2" onclick="return confirm('Are you sure change invoice price?')" name="save_and_continue">Save</button>
				  <button type="submit" class="btn btn-secondary mr-2"  name="save_and_continue">Cancel</button>
				  </form>
              </div>
			 </div>	
		@endif
			
</div>

      </div>


    </section>
    <!-- /.content -->
@endsection



@section('scripts')
<script type="text/javascript">
  $(function(){
	   $(document).on('change', '.priceChange', function(evt) {
	var inputnumber = $(this).data('inputnumber');
	var amt = parseFloat($("body #totalprice"+inputnumber).val());
	var discount1 = parseFloat($("body #discount_tkt"+inputnumber).val());
	var discount2 = parseFloat($("body #discount_sic_pvt_price"+inputnumber).val());
	var discount =  discount1+discount2;
	/* if(discount == null || isNaN(discount) || discount <0)
	{
		discount = 0;
		$(this).val(0);
		return true;
	} */
	
	if(discount > amt){
		alert("Discount not greater than total amount.");
		$("body #discount_tkt"+inputnumber).val($("#discount_tkt_old"+inputnumber).val());
		$("body #discount_sic_pvt_price"+inputnumber).val($("#discount_sic_pvt_price_old"+inputnumber).val());
		$("body #price"+inputnumber).text(amt);
		$("body #newPrice"+inputnumber).val(amt);
		return false;
	}
	var totalPrice =  amt - discount;
	$("body #price"+inputnumber).text(totalPrice);
	$("body #newPrice"+inputnumber).val(totalPrice);
	});
	
	
	
});
</script>
@endsection