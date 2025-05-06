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
            <th>Hotel Name</th>
            <th>HCN</th>
            <th>Guest Name</th>
            <th>Guest Contact</th>
            <th>No of Rooms</th>
           
            <th>CheckIn Date</th>
            <th>CheckIn Out</th>
            <th>Canceled Date</th>					
            <th>SP</th>
            <th>Refund Amount</th>
          
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
            <td>{{($record->voucher)?$record->voucher->code:''}}</td>
            <td>{{($record->voucher->agent)?$record->voucher->agent->company_name:''}}</td>
                    
            <td>{{($record->hotel)?$record->hotel->name:''}}</td>
            <td>{{$record->confirmation_number}}</td>
            <td>{{($record->voucher)?$record->voucher->guest_name:''}}</td>
            
            <td>{{($record->voucher)?$record->voucher->guest_phone:''}}</td>
            <td>{{$room['number_of_rooms']}}</td>
           
            <td>{{$record->check_in_date}}</td>
           
            <td>{{$record->check_out_date}}</td>
            <td>{{$record->cancelled_on}}</td>
            <td>{{$record->total_price}}</td>
           
            
          
            <td>{{$record->refund_amount}}</td>
            
            
                    </tr>
                   
                    @endforeach
                  </tbody>
                </table>
				</body>
</html>