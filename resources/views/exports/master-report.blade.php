<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
                <table id="example1" class="table table-bordered table-striped">
				<thead>
                  <tr>
					<th>Booking #</th>
          <th>Invoice No #</th>
          <th>Booking Date</th>
          <th >Service Date</th>
          <th>Activty</th>
          <th>Varaint</th>
          <th>Service</th>
          <th>Agency</th>
          <th>Zone</th>
					<th>Guest Name</th>
          <th>A</th>
          <th>C</th>
          <th>I</th>
          <th>TKT Supplier</th>
					<th>TKT Supplier Ref #</th>
          <th>TKT Cost</th>
          <th>TKT SP</th>
          <th>TFR Supplier 1</th>
					<th>TFR Net Cost 1</th>
					<th>TFR Supplier 2</th>
					<th>TFR Net Cost 2</th>
          <th>TFR SP</th>
          <th>Remark</th>
          <th>Status</th>
          <th>Profit / loss</th>
		
				  </tr>
				  
                  </thead>
                  <tbody>
				  @foreach ($records as $record)
				  @php
				  $class = SiteHelpers::voucherActivityStatus($record->status);
				  @endphp
                  <tr class="">
				 
					<td>{{($record->voucher)?$record->voucher->code:''}}</td>
          <td>{{($record->voucher)?$record->voucher->invoice_number:''}}</td>
          <td>{{($record->voucher)?$record->voucher->booking_date:''}}</td>
          <td>{{($record->tour_date)?$record->tour_date:''}}</td>
          <td>{{$record->activity_title}}</td>
					<td>{{($record->variant_name)?$record->variant_name:''}}</td>
          <td>{{$record->activity_entry_type}}</td>
          <td>{{($record->voucher->agent)?$record->voucher->agent->company_name:''}}</td>
          <td>{{($record->voucher->zone)?$record->voucher->zone:''}}</td>
          <td>{{($record->voucher)?$record->voucher->guest_name:''}}</td>
          <td>{{$record->adult}}</td>
          <td>{{$record->child}}</td>
          <td>{{$record->infant}}</td>
					<td>@if($record->supplier_ticket > 0) {{ SiteHelpers::getSupplierName($record->supplier_ticket) }} @endif</td>
          <td>{{$record->ticket_supp_ref_no}}</td>
          <td>{{$record->actual_total_cost}}</td>
					<td>{{ PriceHelper::getTotalCostTicketOnly($record->id) }}</td>
          <td>@if($record->supplier_transfer > 0) {{ SiteHelpers::getSupplierName($record->supplier_transfer) }} @endif</td>
					<td>{{$record->actual_transfer_cost}}</td>
          <td>@if($record->supplier_transfer2 > 0) {{ SiteHelpers::getSupplierName($record->supplier_transfer2) }} @endif</td>
					<td>{{$record->actual_transfer_cost2}}</td>
          <td>{{$record->original_trans_rate-$record->discount_sic_pvt_price}}</td>
          <td>{{$record->remark}}</td>
          <td>@if($record->status == '1')
				Cancellation Requested
				@elseif($record->status == '2')
				Cancelled
				@elseif($record->status == '3')
				In Process
				@elseif($record->status == '4')
				Confirm
				@elseif($record->status == '5')
				Vouchered
				@endif </td>
          <td>
          @php
          $profile = 0;
          $profile = (PriceHelper::getTotalCostTicketOnly($record->id)+(float)$record->original_trans_rate)-((float)$record->actual_total_cost+(float)$record->actual_transfer_cost+(float)$record->actual_transfer_cost2+(float)$record->discount_sic_pvt_price)
          @endphp
          {{$profile}}</td>
                
                  @endforeach
                  </tbody>
                </table>
				</body>
</html>