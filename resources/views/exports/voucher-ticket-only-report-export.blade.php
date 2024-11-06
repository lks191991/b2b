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
                    <th width="7%">Service Date</th>
					<th>Time Slot</th>
					<th>Service</th>
					<th>Variant</th>
					<th>Service Type</th>
					<th>Agency</th>
					<th>Guest Name</th>
					<th>Guest Contact No</th>
					<th>A</th>
                    <th>C</th>
                    <th>I</th>
					<th>TKT Supplier</th>
					<th>TKT Supplier Ref #</th>
					<th>TKT SP</th>
					<th>TKT Net Cost</th>
					<th>Remark</th>
                  </tr>
				  
                  </thead>
                  <tbody>
				  @foreach ($records as $record)
                  <tr>
					<td>{{($record->voucher)?$record->voucher->code:''}}</td>
                    <td>{{$record->tour_date}}</td>
					<td>{{$record->time_slot}}</td>
					<td>{{$record->activity_title}}</td>
					<td>{{($record->variant_name)?$record->variant_name:''}}</td>
					<td>{{$record->transfer_option}}</td>
					<td>{{($record->voucher->agent)?$record->voucher->agent->company_name:''}}</td>
					<td>{{($record->voucher)?$record->voucher->guest_name:''}}</td>
					<td>{{($record->voucher)?$record->voucher->guest_country_code	.' '.$record->voucher->guest_phone:''}}</td>
					 <td>
					 @if(($record->activity_entry_type == 'Yacht') || ($record->activity_entry_type == 'Limo'))
           {{$record->adult}}  Hour(s)
						    	@else
                  {{$record->adult}}
                  @endif 

					 </td>
                    <td>{{$record->child}}</td>
                    <td>{{$record->infant}}</td>
					<td>{{($record->supplierticket)?@$record->supplierticket->company_name:''}}</td>
					<td>{{$record->ticket_supp_ref_no}}</td>
					<td>{{ PriceHelper::getTotalCostTicketOnly($record->id) }}</td>
					<td>{{$record->actual_total_cost}}</td>
					
					
					<td>{{$record->remark}}</td>
					
					
                  </tr>
                 
                  @endforeach
                  </tbody>
                </table>
				</body>
</html>