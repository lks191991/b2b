@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Master Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Master Report</li>
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
				 @permission('list.masterreport.download') 
				<a href="{{ route('masterReportExport', request()->input()) }}" class="btn btn-info btn-sm mb-2 mr-4">Export to CSV</a>
        @endpermission
				   </div></div>
				   </div></div>
				   
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <div class="row">
            <form id="filterForm" class="form-inline" method="get" action="{{ route('masterReport') }}" >
              <div class="form-row align-items-center">
			   @if(Auth::user()->role_id !='3')
			   <div class="col-auto col-md-3">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Agency</div>
                  </div>
                <input type="text" id="agent_id" name="agent_id" value="{{ request('agent_id') ?: $agetName }}" class="form-control"  placeholder="Agency Name" />
					<input type="hidden" id="agent_id_select" name="agent_id_select" value="{{ request('agent_id_select') ?: $agetid }}"  />
                </div>
              </div>
			  @endif
			   <div class="col-auto col-md-3">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Search Result</div>
                  </div>
                 <select name="booking_type" id="booking_type" class="form-control">
                    <option value = "1" @if(request('booking_type')==1) selected="selected" @endif>Booking Date</option>
					<option value = "2" @if(request('booking_type')==2) selected="selected" @endif>Travel Date</option>
					<!--<option value = "3">Deadline Date</option>-->
                 </select>
                </div>
              </div>
			  
			  <div class="col-auto col-md-2">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">From Date</div></div>
                    <input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control datepicker"  placeholder="From Date" />
                  </div>
                </div>
				<div class="col-auto col-md-2">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">To Date</div></div>
                    <input type="text" name="to_date" value="{{ request('to_date') }}" class="form-control datepicker" autocomplete ="off"  placeholder="To Date" />
                  </div>
                </div>
                <div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Voucher Code</div></div>
                    <input type="text" name="vouchercode" value="{{ request('vouchercode') }}" class="form-control"  placeholder="Voucher Code" />
                  </div>
                </div>
                <div class="col-auto col-md-3" >
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Booking Status</div>
                  </div>
                 <select name="booking_status" id="booking_status" class="form-control">
						<option value = "">All</option>
						@foreach($voucherStatus as $vsk => $vs)
						<option value = "{{$vsk}}" @if(request('booking_status')==$vsk) selected="selected" @endif>{{$vs}}</option>
						@endforeach
                 </select>
                </div>
              </div>
               
              <div class="col-auto col-md-2">
                <button class="btn btn-info mb-2" type="submit">Filter</button>
                <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('masterReport') }}">Clear</a>
              </div>
            </form>
          </div>
        </div><div class="col-md-12" style="overflow-x:auto">
                <table id="" class="table rounded-corners table-bordered">
                  <thead>
                  <tr>
				
					<th>Booking #</th>
          <th>Invoice No #</th>
          <th>Booking Date</th>
          <th >Service Date</th>
          <th>Activty</th>
          <th>Varaint</th>
          <th>Service</th>
          <th>Agency</th>
          <th>Zone</th>
					<th>Guest Name</th>
          <th>A</th>
          <th>C</th>
          <th>I</th>
          <th>TKT Supplier</th>
					<th>TKT Supplier Ref #</th>
          <th>TKT Cost</th>
          <th>TKT SP</th>
          <th>TFR Supplier 1</th>
					<th>TFR Net Cost 1</th>
					<th>TFR Supplier 2</th>
					<th>TFR Net Cost 2</th>
          <th>TFR SP</th>
          <th>Remark</th>
          <th>Status</th>
          <th>Profit / loss</th>
		
				  </tr>
				  
                  </thead>
                  <tbody>
				  @foreach ($records as $record)
				  @php
				  $class = SiteHelpers::voucherActivityStatus($record->status);
				  @endphp
                  <tr class="">
				 
					<td>{{($record->voucher)?$record->voucher->code:''}}</td>
          <td>{{($record->voucher)?$record->voucher->invoice_number:''}}</td>
          <td>{{($record->voucher)?$record->voucher->booking_date:''}}</td>
          <td>{{($record->tour_date)?$record->tour_date:''}}</td>
          <td>{{$record->activity_title}}</td>
					<td>{{($record->variant_name)?$record->variant_name:''}}</td>
          <td>{{$record->activity_entry_type}}</td>
          <td>{{($record->voucher->agent)?$record->voucher->agent->company_name:''}}</td>
          <td>{{($record->voucher->zone)?$record->voucher->zone:''}}</td>
          <td>{{($record->voucher)?$record->voucher->guest_name:''}}</td>
          <td>{{$record->adult}}</td>
          <td>{{$record->child}}</td>
          <td>{{$record->infant}}</td>
					<td>@if($record->supplier_ticket > 0) {{ SiteHelpers::getSupplierName($record->supplier_ticket) }} @endif</td>
          <td>{{$record->ticket_supp_ref_no}}</td>
          <td>{{$record->actual_total_cost}}</td>
					<td>{{ PriceHelper::getTotalCostTicketOnly($record->id) }}</td>
          <td>@if($record->supplier_transfer > 0) {{ SiteHelpers::getSupplierName($record->supplier_transfer) }} @endif</td>
					<td>{{$record->actual_transfer_cost}}</td>
          <td>@if($record->supplier_transfer2 > 0) {{ SiteHelpers::getSupplierName($record->supplier_transfer2) }} @endif</td>
					<td>{{$record->actual_transfer_cost2}}</td>
          <td>{{$record->original_trans_rate-$record->discount_sic_pvt_price}}</td>
          <td>{{$record->remark}}</td>
          <td>@if($record->status == '1')
				Cancellation Requested
				@elseif($record->status == '2')
				Cancelled
				@elseif($record->status == '3')
				In Process
				@elseif($record->status == '4')
				Confirm
				@elseif($record->status == '5')
				Vouchered
				@endif </td>
          <td>
          @php
          $profile = 0;
          $profile = (PriceHelper::getTotalCostTicketOnly($record->id)+(float)$record->original_trans_rate)-((float)$record->actual_total_cost+(float)$record->actual_transfer_cost+(float)$record->actual_transfer_cost2+(float)$record->discount_sic_pvt_price)
          @endphp
          {{$profile}}</td>
                
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
