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
					<th>Active Agents</th>
					<th>No. of Bkgs.</th>
					<th>No. of  Services</th>
          <th>Accounted Sells</th>
          <th>UnAccounted Sells</th>
          <th>Total Sales</th>
          <th>Total Cost</th>         
          <th>Accounted Profit</th>
					<th>Accounted Transfer Sales</th>
					<th>UnAccounted Transfer Sales</th>
					<th>Total Transfer Sales</th>
					<th>Total Transfer Cost</th>         
					<th>Accounted Transfer Profit</th>
					<th>Hotel Sales</th>
					<th>Hotel  Cost</th>
					<th>Hotel - Profit</th>
				  </tr>
				  
                  </thead>
                  <tbody>
				  @foreach ($records as $k => $record)
				 
                  <tr class="">
					<td>{{$k}}</td>
					<td>{{$record['activeAgents']}}</td>
					<td>{{$record['no_ofBkgs']}}</td>
					<td>{{$record['no_ofServices']}}</td>
					<td>{{$record['totalAccountedSell']}}</td>
					<td>{{$record['totalUnAccountedSell']}}</td>
					<td>{{$record['totalSells']}}</td>
					<td>{{$record['totalCost']}}</td>
          			<td>{{ @$record['totalAccountedProfit']}}</td>
					
					<td>{{$record['totalAccountedTransSell']}}</td>
					<td>{{$record['totalUnAccountedTransSell']}}</td>
					<td>{{$record['totalTransSells']}}</td>
					<td>{{$record['totalTransCost']}}</td>
					<td>{{ @$record['totalAccountedTransProfit']}}</td>

					<td>{{$record['totalHotelSP']}}</td>
					<td>{{$record['totalHotelCost']}}</td>
					<td>@if($record['PLHotel'] > 0) <span style="color: white;font-weight:bold;background-color: green;padding: 8px;display: inline-block;width: 100%;">{{ @$record['PLHotel']}}</span> @elseif($record['PLHotel'] < 0) <span style="color: white;font-weight:bold;background-color: red;padding: 8px;display: inline-block;width: 100%;">{{ @$record['PLHotel']}} </span>@else 0 @endif</td>
                  @endforeach
                  </tbody>
                </table>
				</body>
</html>