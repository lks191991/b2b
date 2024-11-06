<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>Receipt No.</th>
					<th>Agency/Supplier Name</th>
					<th>Amount</th>
					<th>Date of Receipt</th>
          <th>Bank</th>
					<th>Transaction Type</th>
          <th>Status</th>
					<th>Remark</th>
					<th>Created</th>
        
                  </tr>
				   
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  
                  <tr>
				  <td>{{ ($record->receipt_no)}}</td>
                    <td>{{ ($record->agent)?$record->agent->company_name:''}}</td>
					<td>AED {{ $record->amount}}</td>
					<td>
					{{ $record->date_of_receipt ? date(config('app.date_format'),strtotime($record->date_of_receipt)) : null }}
					</td>
          <td>@if($record->mode_of_payment =='1') {{'WIO BANK A/C No - 962 222 3261'}} @elseif($record->mode_of_payment =='2') {{'RAK BANK A/C No -0033488116001'}} @elseif($record->mode_of_payment =='3'){{'CBD BANK A/C No -1001303922'}} @elseif ($record->mode_of_payment =='4'){{'Cash'}} @elseif($record->mode_of_payment =='5'){{'Cheque'}} @endif </td>
					<td>{{ ($record->transaction_type)}}</td>
          <td>
          @if($record->status == '1')
 Pending
  @elseif($record->status == '2')
  Approved
   @elseif($record->status == '3')
    Rejected
  
     @endif 

          </td>
					<td>{{ ($record->remark)}}</td>
					<td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
         
                  </tr>
				 
                  @endforeach
                  </tbody>
                 
                </table>
				</body>
</html>