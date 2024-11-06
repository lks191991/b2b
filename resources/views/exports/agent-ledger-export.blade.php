<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
       <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Agency Name</th>
					<th>Date</th>
					<th>Receipt No/ Inovice No.</th>
					<th>Transaction From</th>
					<th>Payment</th>
					<th>Receipt</th>
					<th>Guest Name</th>
					<th>Remark</th>
                  </tr>
				  
                  </thead>
                  <tbody>
				  @php
				  $totalCredit = 0;
				  $totalDebit = 0;
				  @endphp
				  @foreach ($records as $record)
                  <tr>
                    <td>{{($record->agent)?$record->agent->company_name:''}}</td>
					<td>{{ $record->date_of_receipt ? date(config('app.date_format'),strtotime($record->date_of_receipt)) : null }}</td>
					<td>
					@if(isset($record->voucher))
						 {{ ($record->receipt_no)}}
					
					@else
						{{ ($record->receipt_no)}}
					@endif
				</td>
					<td>
					{{($record->transaction_from == '2')?'Vouchered':''}}
					{{($record->transaction_from == '3')?'Canceled':''}}
					{{($record->transaction_from == '4')?'Refund':''}}
					{{($record->transaction_from == '5')?'Invoice Edit':''}}
					{{($record->transaction_from == '6')?'Credit Given':''}}
					</td>
					<td>
					@if($record->transaction_type == 'Payment')
					{{$record->amount}}
					@php
						$totalDebit += $record->amount;
						@endphp
					@endif
					
				</td>
					<td>@if($record->transaction_type == 'Receipt')
						@php
						$totalCredit += $record->amount;
						@endphp
					
					{{$record->amount}}
					@endif</td>
					<td>{{$record->remark}}</td>
					<td>{{@$record->voucher->guest_name}}</td>
					</tr>
                 
                  @endforeach
				<tr>
                    <th colspan="3"></th>
					<th >Total</th>
					<th >
					{{$totalDebit}}
					
				</th>
					<th>{{$totalCredit}}</th>
					<th colspan="2"></th>
					</tr>
					<tr>
                    <th colspan="3"></th>
					<th>Closing</th>
					<th colspan="3">
					@php
					$closing = $totalCredit - $totalDebit;
					@endphp
					{{$closing}}
					
				</th>
					
           
					</tr>
					<tr>
                    <th colspan="3"></th>
					<th>Opening Balance</th>
					<th colspan="3">
					{{$openingBalance}}
					
				</th>
					
           
					</tr>
					<tr>
                    <th colspan="3"></th>
					<th>Closing Balance</th>
					<th colspan="3">
					@php
					$closing = (float)str_replace(',', '', $closing);
					$openingBalance = (float)str_replace(',', '', $openingBalance);
					@endphp
					{{$openingBalance+$closing}}
					
				</th>
					
           
					</tr>
					 </tbody>
                </table>
				</body>
</html>