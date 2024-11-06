@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Zone Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Zone Report</li>
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
				 @if(auth()->user()->role_id == '1' && count($data)>0)
				<a href="{{ route('zoneReportExport', request()->input()) }}" class="btn btn-info btn-sm mb-2 mr-4">Export to CSV</a>
				@endif
				   </div></div>
				   
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <div class="row">
            <form id="filterForm" class="form-inline" method="get" action="{{ route('zoneReport') }}" >
              <div class="form-row align-items-center">
			  
			   <div class="col-md-2">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Zone</div>
                  </div>
                 <select name="zone" id="zone" class="form-control">
				 <option value = "" @if(request('zone')=='') selected="selected" @endif>Select</option>
				 @foreach($zones as $zone)
                    <option value = "{{$zone}}" @if(request('zone')==$zone) selected="selected" @endif>{{$zone}}</option>
					@endforeach
                 </select>
                </div>
              </div>
			  <div class="col-md-2">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Date</div>
                  </div>
                 <select name="booking_type" id="booking_type" class="form-control">
                    <option value = "1" @if(request('booking_type')==1) selected="selected" @endif>Booking Date</option>
					<option value = "2" @if(request('booking_type')==2) selected="selected" @endif>Travel Date</option>
					<!--<option value = "3">Deadline Date</option>-->
                 </select>
                </div>
              </div>
			  <div class="col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">From Date</div></div>
                    <input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control datepicker"  placeholder="From Date" />
                  </div>
                </div>
				<div class="col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">To Date</div></div>
                    <input type="text" name="to_date" value="{{ request('to_date') }}" class="form-control datepicker" autocomplete ="off"  placeholder="To Date" />
                  </div>
                </div>
              
               
              <div class="col-md-2">
                <button class="btn btn-info mb-2" type="submit">Filter</button>
                <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('zoneReport') }}">Clear</a>
              </div>
            </form>
          </div>
        </div><div class="col-md-12" style="overflow-x:auto">
                <table id="" class="table rounded-corners table-bordered">
                  <thead>
                  <tr>
				
					<th>Zone</th>
					<th>Total Agents</th>
					<th>Total Vouchers Agents</th>
					<th>Total Vouchers</th>
          <th>Total Entries</th>
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
				  @foreach ($data as $k => $record)
				 
                  <tr class="">
					<td>{{$k}}</td>
					<td>{{$record['totalAgents']}}</td>
					<td>{{$record['totalVoucherAgents']}}</td>
					<td>{{$record['totalVoucherCs']}}</td>
          <td>{{$record['totalVouchers']}}</td>
					<td>{{$record['totalTicketSPAfterDiscount']}}</td>
					<td>{{$record['totalTransferSPAfterDiscount']}}</td>
					<td>{{$record['totalVoucherAmount']}}</td>
					<td>{{$record['totalTicketCost']}}</td>
					<td>{{$record['totalTransferCost']}}</td>
					<td>{{$record['totalCost']}}</td>
					<td>@if($record['PL'] > 0) <span style="color: white;font-weight:bold;background-color: green;padding: 8px;display: inline-block;width: 100%;">{{ @$record['PL']}}</span> @elseif($record['PL'] < 0) <span style="color: white;font-weight:bold;background-color: red;padding: 8px;display: inline-block;width: 100%;">{{ @$record['PL']}} </span>@else 0 @endif</td>
					<td>{{$record['totalHotelSP']}}</td>
					<td>{{$record['totalHotelCost']}}</td>
					<td>@if($record['PLHotel'] > 0) <span style="color: white;font-weight:bold;background-color: green;padding: 8px;display: inline-block;width: 100%;">{{ @$record['PLHotel']}}</span> @elseif($record['PLHotel'] < 0) <span style="color: white;font-weight:bold;background-color: red;padding: 8px;display: inline-block;width: 100%;">{{ @$record['PLHotel']}} </span>@else 0 @endif</td>
                  @endforeach
                  </tbody>
                </table></div>
				<div class="pagination pull-right mt-3"> 
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
	
	<div class="modal fade" id="sendEmailModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Send Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Test
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary-flip btn-sm" >Send</button>
                <!-- You can add a button here for further actions if needed -->
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
 <script type="text/javascript">
$(document).ready(function() {
	
var path = "{{ route('auto.agent') }}";
  
    $( "#agent_id" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term,
            },
            success: function( data ) {
               response( data );
            }
          });
        },
		
        select: function (event, ui) {
           $('#agent_id').val(ui.item.label);
           //console.log(ui.item); 
		   $('#agent_id_select').val(ui.item.value);
		    $('#agent_details').html(ui.item.agentDetails);
           return false;
        },
        change: function(event, ui){
            // Clear the input field if the user doesn't select an option
            if (ui.item == null){
                $('#agent_id').val('');
				 $('#agent_id_select').val('');
				 $('#agent_details').html('');
            }
        }
      });
	  
});

  </script> 
  @endsection
