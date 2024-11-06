<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
                <table id="" class="table rounded-corners table-bordered">
                  <thead>
                  <tr>
				
					<th>Zone</th>
					<th>Total Agents</th>
					<th>Total Vouchers Agents</th>
					<th>Total Vouchers</th>
					<th >Total Ticket SP (After Discount)</th>
					<th>Total Tranfer SP (After Discount)</th>
					<th>Total Voucher Amount</th>
					<th>Total Ticket Cost</th>
					<th>Total Transfer Cost</th>
					<th>Total Cost</th>
					<th>Profit / Loss</th>
					<th>Total Hotel SP</th>
					<th>Net Cost</th>
					<th>Hotel - Profit / Loss</th>
				  </tr>
				  
                  </thead>
                  <tbody>
				  @foreach ($records as $k => $record)
				 
                  <tr class="">
					<td>{{$k}}</td>
					<td>{{$record['totalAgents']}}</td>
					<td>{{$record['totalVoucherAgents']}}</td>
					<td>{{$record['totalVouchers']}}</td>
					<td>{{$record['totalTicketSPAfterDiscount']}}</td>
					<td>{{$record['totalTransferSPAfterDiscount']}}</td>
					<td>{{$record['totalVoucherAmount']}}</td>
					<td>{{$record['totalTicketCost']}}</td>
					<td>{{$record['totalTransferCost']}}</td>
					<td>{{$record['totalCost']}}</td>
					<td>{{ @$record['PL']}}</td>
						<td>{{$record['totalHotelSP']}}</td>
					<td>{{$record['totalHotelCost']}}</td>
					<td>{{ @$record['PLHotel']}}</td>
                  @endforeach
                  </tbody>
                </table>
				</body>
</html>