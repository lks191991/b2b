@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher Hotel Refunded Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Voucher Hotel Refunded Report</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
				<div class="card-tools">
				 <div class="row">
				<a href="{{ route('voucherHotelRefundedReportExport', request()->input()) }}" class="btn btn-info btn-sm mb-2 mr-4">Export to CSV</a>
				   </div></div>
				   
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <div class="row">
            <form id="filterForm" class="form-inline" method="get" action="{{ route('voucherHotelRefundedReport') }}" >
              <div class="form-row align-items-center">
			   <div class="col-auto col-md-3">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Search Result</div>
                  </div>
                  <select name="booking_type" id="booking_type" class="form-control">
                    <option value="1" {{ request('booking_type') == '1' ? 'selected' : '' }}>Canceled Date</option>
                    <option value="2" {{ request('booking_type') == '2' ? 'selected' : '' }}>Check In Date</option>
                </select>
                
                </div>
              </div>
			  <div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">From Date</div></div>
                    <input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control datepicker"  placeholder="From Date" />
                  </div>
                </div>
				<div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">To Date</div></div>
                    <input type="text" name="to_date" value="{{ request('to_date') }}" class="form-control datepicker" autocomplete ="off"  placeholder="To Date" />
                  </div>
                </div>
                <div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Voucher Code</div></div>
                    <input type="text" name="reference" value="{{ request('reference') }}" class="form-control"  placeholder="Voucher Code" />
                  </div>
                </div>
                
               
              <div class="col-auto col-md-2">
                <button class="btn btn-info mb-2" type="submit">Filter</button>
                <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('voucherHotelRefundedReport') }}">Clear</a>
              </div>
            </form>
          </div>
        </div><div class="col-md-12" style="overflow-x:auto">
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
					
							
                        
				</td>
					
                  </tr>
                 
                  @endforeach
				   </tbody>
                </table></div>
				<div class="pagination pull-right mt-3"> 
				{!! $records->appends(request()->query())->links() !!}
				</div> 
				
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
 <!-- Script -->
 <script type="text/javascript">
$(document).ready(function() {
	$(document).on('keypress', '.onlynumbrf', function(evt) {
	var charCode = (evt.which) ? evt.which : evt.keyCode
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
  return true;

});
	$(document).on('change', '.inputsave', function(evt) {
	
    var id= $(this).data('id');
    var txt_name =  $(this).data('name');
    var txt_var =  $(this).val();
    if((txt_name == 'refund_amount_tkt'))
    {
      var txt_new_var =  $("body #org_refund_amount_tkt"+id).val();
      if(txt_new_var < txt_var)
      {
        alert("Refund Amount can't be more than SP");
         $("body #refund_amount_tkt"+id).val("0");
        return false;
        
      }
    }
    else if((txt_name == 'refund_amount_trans'))
    {
      var txt_new_var =  $("body #org_refund_amount_trans"+id).val();
      if(txt_new_var < txt_var)
      {
        alert("Refund Amount can't be more than SP");
         $("body #refund_amount_trans"+id).val("0");
        return false;
        
      }
    }
    $("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('activityRefundSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).data('id'),
			   inputname: $(this).data('inputname'),
			   val: txt_var
            },
            success: function( data ) {
              //alert( data );
			  $("#loader-overlay").hide();
			  if(data[0].status==2){
				  alert("Amount Already Refunded.");
				 //location.reload(true);
			  }
			  if(data[0].status==3){
				  alert("Agent not found.");
				 //location.reload(true);
			  }
			  if(data[0].status==4){
				  alert("The refund price cannot be greater than the refund eligible price.");
				 //location.reload(true);
			  }
			  
			  location.reload(true);
            }
          });
	 });	
	
});

  </script> 
  @endsection