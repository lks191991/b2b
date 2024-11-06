<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
                <table id="example1" class="table rounded-corners">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Created</th>
                    <th>Booking #</th>
                    <th>Invoice No</th>
                    <th>Agency</th>
                    <th>Guest Name</th>
					<th>Ticket No.</th>
					<th>Serial Number</th>
					<th>Valid From</th>
					<th>Valid Till</th>
					<th>Variant</th>
					<th>Ticket For</th>
					<th>Type Of Ticket</th>
					<th>Net Rate</th>
					<th>TKT Supplier</th>
				
                   
                  </tr>
				 
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  
                  <tr>
                  <td>{{ $loop->index + 1 }}</td>
                  <td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
                  <td> {{ ($record->voucher)?$record->voucher->code:''}}</td>
                  <td> {{ ($record->voucher)?$record->voucher->invoice_number:''}}</td>
                  <td>{{ ($record->voucher)?$record->voucher->agent->company_name:''}}</td>
                  <td>{{ $record->voucher->guest_name}}</td>
					<td>{{ $record->ticket_no}}</td>
					<td>{{ $record->serial_number}}</td>
					<td>{{ $record->valid_from ? date(config('app.date_format'),strtotime($record->valid_from)) : null }}</td>
                    <td>{{ $record->valid_till ? date(config('app.date_format'),strtotime($record->valid_till)) : null }}</td>
                    <td>{{ @$record->variant->title}}</td>
					<td>{{ $record->ticket_for}}</td>
                    <td>{{ $record->type_of_ticket}}</td>
				
                  <td>{{ $record->net_cost}}</td>
                    <td>{{ @$record->supplier->name}}</td>
                  
                   
                    
                  </tr>
				 
                  @endforeach
                  </tbody>
                 
                </table>
                </body>
                </html>