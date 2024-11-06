<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
					<tr>
					<th>Voucher Code</th>
					<th>Agency</th>
                    <th>Activty</th>
					<th>Service</th>
					<th>Guest Name</th>
					<th>Guest Contact</th>
                    <th>A</th>
                    <th>C</th>
                    <th>I</th>
					<th>Tour Date</th>
					<th>Canceled Date</th>					
					<th>Ticket Cost</th>
					<th>Transfer Cost</th>
					<th>Ticket Discount</th>
					<th>Transfer Discount</th>
					<th>Total</th>
					<th>Ticket Refund </th>
					<th>Transfer Refund </th>
                  </tr>
				  
                  </thead>
                  <tbody>
				   @foreach ($records as $record)
				    @php
						$allPrice = PriceHelper::getTicketAllTypeCost($record->id)
					@endphp
                  <tr>
					<td>{{($record->voucher)?$record->voucher->code:''}}</td>
					<td>{{($record->voucher->agent)?$record->voucher->agent->company_name:''}}</td>
                   
					<td>{{$record->activity_title}}</td>
					<td>{{$record->variant_name}}</td>
					<td>{{($record->voucher)?$record->voucher->guest_name:''}}</td>
					<td>{{($record->voucher)?$record->voucher->guest_phone:''}}</td>
                    <td>{{$record->adult}}</td>
                    <td>{{$record->child}}</td>
                    <td>{{$record->infant}}</td>
					<td>{{$record->tour_date}}</td>
					<td>{{$record->canceled_date}}</td>
					<td>{{ $allPrice['tkt_price'] }}</td>
					<td>{{ $allPrice['trns_price'] }}</td>
					<td>{{ $allPrice['discounTkt'] }}</td>
					<td>{{ $allPrice['discountTrns'] }}</td>
					<td>{{ $allPrice['totalPriceAfDis'] }}</td>
					<td>{{ $record->refund_amount_tkt }}</td>
					<td>{{ $record->refund_amount_trans }}</td>
					
                  </tr>
                 
                  @endforeach
                  </tbody>
                 
                </table>
				</body>
</html>