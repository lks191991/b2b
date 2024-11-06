@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Invoice Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Invoice Report</li>
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
 @if ($errors->has('pdf_file'))
	  <div class="box no-border">
        <div class="box-tools">
            <p class="alert alert-danger alert-dismissible">
			{{$errors->first('pdf_file')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </p>
        </div>
    </div>
                @endif
            <div class="card">
              <div class="card-header">
				<div class="card-tools">
				 <div class="row">
         @permission('list.invoicereport.download') 
				<a href="{{ route('voucherActivityReportExcelReport', request()->input()) }}" class="btn btn-info btn-sm mb-2 mr-4">Export to CSV</a>
        @endpermission	   
      </div></div>
				   
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  
			  <div class="row">
			  
            <form id="filterForm" class="form-inline" method="get" action="{{ route('voucherActivityReport') }}" >
              <div class="form-row align-items-center">
			   <div class="col-auto col-md-4">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Search Result</div>
                  </div>
                 <select name="booking_type" id="booking_type" class="form-control">
                    <option value = "1" @if(request('booking_type')==1) selected="selected" @endif>Booking Date</option>
					<option value = "2" @if(request('booking_type')==2) selected="selected" @endif>Travel Date</option>
          <option value = "3" @if(request('booking_type')==3) selected="selected" @endif>Created Date</option>
					<!--<option value = "3">Deadline Date</option>-->
                 </select>
                </div>
              </div>
			  <div class="col-auto col-md-4">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">From Date</div></div>
                    <input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control datepicker"  placeholder="From Date" />
                  </div>
                </div>
				<div class="col-auto col-md-4">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">To Date</div></div>
                    <input type="text" name="to_date" value="{{ request('to_date') }}" class="form-control datepicker" autocomplete ="off"  placeholder="To Date" />
                  </div>
                </div>
                <div class="col-auto col-md-4">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Booking No</div></div>
                    <input type="text" name="vouchercode" value="{{ request('vouchercode') }}" class="form-control"  placeholder="Booking No" />
                  </div>
                </div>
                <div class="col-auto col-md-4">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Invoice No</div></div>
                    <input type="text" name="invoicecode" value="{{ request('invoicecode') }}" class="form-control"  placeholder="Invoice No" />
                  </div>
                </div>
                <div class="col-auto col-md-4">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Booking Status</div>
                  </div>
                
					<select name="booking_status[]" id="booking_status" class="form-control select2" multiple>
					@foreach($voucherStatus as $vsk => $vs)
					<option value="{{ $vsk }}" @if(in_array($vsk, (array)request('booking_status'))) selected="selected" @endif>{{ $vs }}</option>
					@endforeach
					</select>
                </div>
              </div>
              <div class="col-auto col-md-4">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Acitivty Status</div>
                  </div>
                
					<select name="activity_status[]" id="activity_status" class="form-control select2" multiple>
					@foreach($voucherAStatus as $vsk => $vs)
					<option value="{{ $vsk }}" @if(in_array($vsk, (array)request('activity_status'))) selected="selected" @endif>{{ $vs }}</option>
					@endforeach
					</select>
                </div>
              </div>
			  <div class="col-auto col-md-3">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Agency/Supplier</div>
                  </div>
                <input type="text" id="agent_id" name="agent_id" value="{{ request('agent_id') ?: $agetName }}" class="form-control"  placeholder="Agency/Supplier Name" />
					<input type="hidden" id="agent_id_select" name="agent_id_select" value="{{ request('agent_id_select') ?: $agetid }}"  />
                </div>
              </div>
			  
               
              <div class="col-auto col-md-2">
                <button class="btn btn-info mb-2" type="submit">Filter</button>
                <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('voucherActivityReport') }}">Clear</a>
              </div>
            </form>
          </div>
        </div><div class="col-md-12" style="overflow-x:auto">
                <table id="example11" class="table rounded-corners">
                  <thead>
                  <tr>
					<th>Booking Date</th>
					<th>Booking No</th>
					<th>Invoice Edit Date</th>
					<th>Invoice Number</th>
					<th>Hotel</th>
          <th>Service Date</th>
					<th>Agent Ref No.</th>
					<th>Agency</th>
          <th>Zone</th>
					<th>Pax Name</th>
					<th>A</th>
                    <th>C</th>
					<th>SIC/PVT</th>
					<th>Variant Name</th>
					<th>Total Cost</th>
					<th>Status</th>
					<th>Booking Status</th>
          <th>Vouchered By</th>
                  </tr>
				  
                  </thead>
                  <tbody>
				  @foreach ($records as $record)
                  <tr>
				  <td>{{(!empty($record->voucher->booking_date))?date("d-m-Y",strtotime($record->voucher->booking_date)):''}} </td>
				<td><a class="" style="color:#007bff!important" href="{{route('voucherView',$record->voucher->id)}}">{{ ($record->voucher->code)}}</a></td>
				 <td>{{(!empty($record->voucher->invoice_edit_date))?date("d-m-Y",strtotime($record->voucher->invoice_edit_date)):''}} </td>
				   <td>
           <a class="" target="_blank" href="{{route('voucherInvoicePdf',$record->voucher->id)}}" >
           {{@$record->voucher->invoice_number}} </a> </td>
                  
          <td> {{(SiteHelpers::voucherHotelCount(@$record->voucher->id) > 0)?'('.SiteHelpers::voucherHotelCount(@$record->voucher->id).')':''}}</td>
					
          <td>{{date("d-m-Y",strtotime($record->tour_date))}}
					</td>
          <td>{{($record->voucher)?$record->voucher->agent_ref_no:''}}</td>
           
					<td>{{($record->voucher->agent)?$record->voucher->agent->company_name:''}}</td>
          <td>{{($record->voucher)?$record->voucher->zone:''}}</td>
					<td>{{($record->voucher)?$record->voucher->guest_name:''}}</td>
					 <td>{{$record->adult}}</td>
                    <td>{{$record->child}}</td>
					<td>
					@if($record->transfer_option == "Shared Transfer")
					SIC
					@php
					$zone = SiteHelpers::getZoneName($record->transfer_zone);
					@endphp
						- <b>{{@$zone->name}} </b>
					
					@endif
					@if($record->transfer_option == 'Pvt Transfer')
					PVT
					@endif
					@if($record->transfer_option == 'Ticket Only')
					TKT Only
					@endif
				</td>
					<td>{{$record->variant_name}}</td>
					<td>{{ PriceHelper::getTotalTicketCostAllType($record->id) }}</td>
          <td>
					{!! SiteHelpers::voucherActivityStatusName($record->status) !!}
					</td>
					<td>
					{!! SiteHelpers::voucherStatus($record->voucher->status_main) !!}
					</td>
          <td>{{($record->voucher)?$record->voucher->agent_ref_no:''}}</td>
					
                  </tr>
                  </tbody>
                  @endforeach
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
	
	<div class="modal fade" id="ticketUploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	 <form id="ticketUploadForm" method="post" action="{{route('uploadTicketFromReport')}}" enctype="multipart/form-data">
	 @csrf
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Ticket Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="file"  class="form-control" name="ticketFile" accept=".pdf" />
		 <input type="hidden"  id="vaid" name="vaid"   value="" />
	  <input type="hidden"  id="vid" name="vid"   value="" />
      </div>
	  
	 
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
    </div>
  </div>
</div>

    <!-- /.content -->
@endsection
@section('scripts')
 <!-- Script -->
 <script type="text/javascript">
    $(function () {
        $(".uploadTicketbtn").click(function () {
            $("#ticketUploadModal").modal("show");
			var vid= $(this).data('vid');
			var vaid= $(this).data('vaid');
			$("#vaid").val(vaid);
			$("#vid").val(vid);
        });
    });
</script>

 <script type="text/javascript">
$(document).ready(function() {
	
	$(document).on('change', '.inputsave', function(evt) {
		$("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).data('id'),
			   inputname: $(this).data('name'),
			   val: $(this).val()
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
	 });	
	 
	 $(document).on('change', '.inputsaveSp', function(evt) {
		$("#loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: $(this).find(':selected').data('id'),
			   inputname: $(this).find(':selected').data('name'),
			   val: $(this).val()
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
	 });
});
var path = "{{ route('auto.agent.supp') }}";
  
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
  </script> 
  @endsection
