<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>SN.</th>
					<th>Code</th>
					<th>Company</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>City</th>
					<th>Credit Limit(AED)</th>
					<th>Ledger Balance(AED)</th>
				   <th>Balance(AED)</th>
                  </tr>
				  
                  </thead>
                  <tbody>
				  @foreach ($records as $k => $record)
				  
                  <tr>
					<td>{{ $k+1}}</td>
                    <td>{{ $record->code}}</td>
					 <td>{{ $record->company_name}}</td>
                    <td>{{ $record->name}}</td>
                    <td>{{ $record->mobile}}</td>
					<td>{{ $record->email}}</td>
                    <td>{{ ($record->city)?$record->city->name:''}}</td>
					<td>{{ number_format($record->agent_credit_limit,2)}}</td>
					<td>{{ number_format($record->agent_amount_balance,2)}}</td> 
					@php
					$balance = $record->agent_credit_limit - $record->agent_amount_balance;
					@endphp
				   <td>{{ number_format($balance,2)}}</td>
				   
                  </tr>
                  @endforeach
                  </tbody>
                 
                </table>
				</body>
</html>