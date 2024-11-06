@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Agent/Supplier Ledger</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Agent/Supplier Ledger</li>
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
				
				   </div></div>
				   
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form id="filterForm" class="form-inline" method="get" action="{{ route('agentLedgerReportWithVat') }}" style="width:100%" >
              <div class="row">
                  @if(Auth::user()->role_id !='3')
               
                    <div class="col-auto col-md-12 mb-3">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Agency/Supplier</div>
                        </div>
                        <input type="text" id="agent_id" name="agent_id" value="{{ request('agent_id') ?: $agetName }}" class="form-control"  placeholder="Agency/Supplier Name" />
                        <input type="hidden" id="agent_id_select" name="agent_id_select" value="{{ request('agent_id_select') ?: $agetid }}"  />
                      </div>
                    </div>
                
                  @endif
                  
                    <div class="col-auto col-md-3">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text">Date Type</div>
                        </div>
                        <select name="booking_type" id="booking_type" class="form-control">
                          <option value = "1" @if(request('booking_type')==1) selected="selected" @endif>Receipt/Payment Date</option>
                          <option value = "2" @if(request('booking_type')==2) selected="selected" @endif>Service Date</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-auto col-md-3">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text">From Date</div>
                      
                      </div>
                      <input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control datepickerdmy"  required  placeholder="From Date" />
                    </div>
                    </div>
                    <div class="col-auto col-md-3">
                        <div class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">To Date</div>
                         
                        </div>
                        <input type="text" name="to_date" required autocomplete ="off" value="{{ request('to_date') }}"  class="form-control datepickerdmy"  placeholder="To Date" />
                        </div>
                    </div>
                    <div class="col-auto col-md-3">
                      <button class="btn btn-info mb-2" type="submit">Filter</button>
                      <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('agentLedgerReportWithVat') }}">Clear</a>
					  @if(!empty(request('to_date')))
					  <a href="{{ route('agentLedgerReportWithVatExportExcel', request()->input()) }}" class="btn btn-info mb-2 mr-4">Export to CSV</a>
					@endif
					
                    </div>
                  </div>
              </form>
        </div>
       
        <h3 style="text-align:center;margin-top: 30px;">{{($agetName) ? $agetName:''}}</h3>
        <h5 style="text-align:center;">{{ request('from_date') }} - {{ request('to_date') }}</h5>

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                  
					<th>Date</th>
          <th>Booking Ref No.</th>
					<th>Receipt No/ Invoice No.</th>
          @php
            $colspan = "5";
          @endphp
          @if($agent_role_id == '9')
          @php
            $colspan = "7";
          @endphp
          <th>Service Date</th>
          <th>Service Name</th>
          @endif
					<th>Transaction From</th>
          <th>Guest Name</th>
					<th>Remark</th>
					<th>Payment</th>
					<th>Receipt</th>
				
                  </tr>
				  
                  </thead>
                  <tbody>
				  @php
				  $totalCredit = 0;
				  $totalDebit = 0;
				  @endphp
				  @foreach ($records as $k => $record)
                  <tr>
				  
                   
					<td>{{ $record->date_of_receipt ? date(config('app.date_format'),strtotime($record->date_of_receipt)) : null }}</td>
          <td>
          @if(isset($record->voucher))
          <a class="" style="color:#007bff!important" target="_blank" href="{{route('voucherView',$record->voucher->id)}}"> {{@$record->voucher->code}}</a>  
          @endif
					<td>
					@if(isset($record->voucher))
						 <a class="" style="color:#007bff!important" target="_blank" href="{{route('voucherView',$record->voucher->id)}}">{{ ($record->receipt_no)}}</a>
					
					@else
          <a class="" style="color:#007bff!important" target="_blank" href="{{route('agentamountview',$record->id)}}">{{ ($record->receipt_no)}}</a>
					@endif
				</td>
        @if($agent_role_id == '9')
         
          
        <td>{{ $record->service_date ? date(config('app.date_format'),strtotime($record->service_date)) : null  }}</td>
        <td>{{ $record->service_name ? $record->service_name : null }}</td>
        @endif
					<td>
					{{($record->transaction_from == '2')?'Vouchered':''}}
					{{($record->transaction_from == '3')?'Canceled':''}}
					{{($record->transaction_from == '4')?'Refund':''}}
					{{($record->transaction_from == '5')?'Invoice Edit':''}}
					{{($record->transaction_from == '6')?'Credit Given':''}}
					</td>
          <td>{{$record->guest_name ? $record->guest_name : @$record->voucher->guest_name}}</td>
					<td>{{$record->remark}}</td>
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
				
					
					</tr>
                  </tbody>
                  @endforeach
				  <tr>
          <th colspan="{{ $colspan }}"></th>
                    <th align="right">Total</th>
					<th >
					{{$totalDebit}}
					
				</th>
					<th>{{$totalCredit}}</th>
				
					</tr>
					<tr>
                     <th colspan="{{ $colspan }}"></th>
					<th>Closing</th>
					<th colspan="4">
					@php
					$closing = $totalCredit - $totalDebit;
					@endphp
					{{$closing}}
					
				</th>
					
           
					</tr>
					<tr>
                     <th colspan="{{ $colspan }}"></th>
					<th>Opening Balance</th>
					<th colspan="4">
					{{$openingBalance}}
					
				</th>
					
           
					</tr>
					<tr>
                     <th colspan="{{ $colspan }}"></th>
					<th>Closing Balance</th>
					<th colspan="4">
					@php
					$closing = (float)str_replace(',', '', $closing);
					$openingBalance = (float)str_replace(',', '', $openingBalance);
					@endphp
					{{$openingBalance+$closing}}
					
				</th>
					
           
					</tr>
                </table>

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
@endsection
@section('scripts')
 <!-- Script -->
 <script type="text/javascript">
$(document).ready(function() {
	
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
	  
});

  </script> 
  @endsection
