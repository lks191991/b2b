<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                     <tr>
					<th>Booking Date</th>
					<th>Booking No</th>
					<th>Invoice Edit Date</th>
					<th>Invoice Number</th>
					<th>Hotels</th>
                    <th>Service Date</th>
					<th>Agent Ref No.</th>
					<th>Agency</th>
          <th>Zone</th>
					<th>Pax Name</th>
					<th>A</th>
                    <th>C</th>
					<th>SIC/PVT</th>
					<th>Variant Name</th>
					<th>Total Cost</th>
					<th>Status</th>
					<th>Booking Status</th>
                  </tr>
				  
                  </thead>
                  <tbody>
				 @foreach ($records as $record)
                  <tr>
				  <td>{{@(!empty($record->voucher->booking_date))?$record->voucher->booking_date:''}} </td>
				  <td>{{@$record->voucher->code}} </td>
				   <td>{{(!empty($record->voucher->invoice_edit_date))?date("d-m-Y",strtotime($record->voucher->invoice_edit_date)):''}} </td>
				   <td>{{@$record->voucher->invoice_number}} </td>
				   <td> {{(SiteHelpers::voucherHotelCount(@$record->voucher->id) > 0)?'('.SiteHelpers::voucherHotelCount(@$record->voucher->id).')':''}}</td>
					
                    <td>{{$record->tour_date}}
					</td>
					<td>{{($record->voucher)?$record->voucher->agent_ref_no:''}}</td>
           
		   <td>{{($record->voucher->agent)?$record->voucher->agent->company_name:''}}</td>
 <td>{{($record->voucher)?$record->voucher->zone:''}}</td>
					<td>{{($record->voucher)?$record->voucher->guest_name:''}}</td>
					 <td>{{$record->adult}}</td>
                    <td>{{$record->child}}</td>
					<td>
					@if($record->transfer_option == "Shared Transfer")
					SIC
					@php
					$zone = SiteHelpers::getZoneName($record->transfer_zone);
					@endphp
						- <b>{{@$zone->name}} </b>
					
					@endif
					@if($record->transfer_option == 'Pvt Transfer')
					PVT
					@endif
					@if($record->transfer_option == 'Ticket Only')
					TKT Only
					@endif
				</td>
					<td>{{$record->variant_name}}</td>
					<td>{{ PriceHelper::getTotalTicketCostAllType($record->id) }}</td>
					<td>
					{!! SiteHelpers::voucherStatus($record->status) !!}
					</td>
					<td>
					{!! SiteHelpers::voucherStatus($record->voucher->status_main) !!}
					</td>
					
                  </tr>
                  @endforeach
                  </tbody>
                 
                </table>
				</body>
</html>