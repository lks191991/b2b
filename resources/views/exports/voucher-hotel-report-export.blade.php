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
					<th>Payment Date</th>
					<th>Booking #</th>
					<th>Check In</th>
					<th>Check Out</th>
					<th>Hotel Name</th>
					<th>NO. Of Nights</th>
					<th>NO. Of Rooms</th>
					<th>Total Selling Price</th>
					<th>Mark up</th>
					<th>Payment Due Date</th>
					<th>Confirmation No</th>
					<th>Supplier</th>
					<th>Payment Status</th>
					<th>Payment Status Updated by</th>
					<th>Mode Of Payment</th>
					<th>Amount Paid</th>
					<th>UTR Number</th>
					<th>Remark</th>
                  </tr>
				  
                  </thead>
                  <tbody>
				  @foreach ($records as $record)
				  @php
            $room = SiteHelpers::hotelRoomsDetails($record->hotel_other_details);
			 $night = SiteHelpers::numberOfNight($record->check_in_date,$record->check_out_date);
			 $markUp = @$room['markup_v_s']+@$room['markup_v_d']+@$room['markup_v_eb']+@$room['markup_v_cwb']+@$room['markup_v_cnb'];
            @endphp
                  <tr>

                    <td>{{($record->voucher)?$record->voucher->booking_date:''}}</td>
					<td>{{($record->voucher)?$record->voucher->payment_date:''}}</td>
					<td>{{($record->voucher)?$record->voucher->code:''}}</td>
					<td>{{$record->check_in_date}}</td>
					<td>{{$record->check_out_date}}</td>
					<td>{{($record->hotel)?$record->hotel->name:''}}</td>
					<td>{{$night }}</td>
					<td>{{$room['number_of_rooms']}}</td>

					<td>{{$room['price']}}</td>
					<td>{{$room['markup']}}</td>
					<td>{{$record->payment_due_date}}</td>
					<td>{{$record->confirmation_number}}</td>
					<td>{{($record->supplierhotel)?@$record->supplierhotel->company_name:''}}</td>
					 <td>{!! SiteHelpers::voucherStatus($record->voucher->status_main) !!}</td>
					<td>{{($record->voucher)?@$record->voucher->updatedBy->name:''}}</td>
					 <td>
					@if($record->mode_of_payment =='1') {{'WIO BANK A/C No - 962 222 3261'}} @endif
					@if($record->mode_of_payment =='2') {{'RAK BANK A/C No -0033488116001'}} @endif 
					@if($record->mode_of_payment =='3'){{'CBD BANK A/C No -1001303922'}} @endif
					@if($record->mode_of_payment =='4'){{'Cash'}} @endif
					@if($record->mode_of_payment =='5'){{'Cheque'}} @endif
                 </td>
				 <td> {{ $record->amount_paid }}</td>
				 <td> {{ $record->utr_number }}</td>
				 <td>{{ $record->remark }}</td>
				 
					</tr>
                 
                  @endforeach
                  </tbody>
                </table>
				</body>
</html>