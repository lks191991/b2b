@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Agent Ledger  Without Vat</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Agent Ledger  Without Vat</li>
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
				<!--<a href="{{ route('voucherReportExport', request()->input()) }}" class="btn btn-info mb-2">Export to CSV</a> -->
				   </div></div>
				   
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <div class="row">
            <form id="filterForm" class="form-inline" method="get" action="{{ route('agentLedgerReport') }}" style="width:100%" >
              <div class="form-row" style="width:100%">
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
                    <div class="input-group-prepend"><div class="input-group-text">From Date</div></div>
                    <input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control datepickerdmy" required placeholder="From Date" />
                  </div>
                </div>
				<div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">To Date</div></div>
                    <input type="text" name="to_date" autocomplete ="off" value="{{ request('to_date') }}" required class="form-control datepickerdmy"  placeholder="To Date" />
                  </div>
                </div>
               
                
               
              <div class="col-auto col-md-3">
                <button class="btn btn-info mb-2" type="submit">Filter</button>
                <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('agentLedgerReport') }}">Clear</a>
              </div>
            </form>
          </div>
        </div>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Agency Name</th>
					<th>Date</th>
					<th>Receipt No/ Inovice No.</th>
					<th>Transaction From</th>
					<th>Debit Amount</th>
					<th>Credit Amount</th>
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
					<td>{{ ($record->receipt_no)}}</td>
					<td>
					{{($record->transaction_from == '2')?'Vouchered':''}}
					{{($record->transaction_from == '3')?'Canceled':''}}
					</td>
					<td>
					@if($record->transaction_type == 'Debit')
					{{$record->amount}}
					@php
						$totalDebit += $record->amount;
						@endphp
					@endif
					
				</td>
					<td>@if($record->transaction_type == 'Credit')
						@php
						$totalCredit += $record->amount;
						@endphp
					
					{{$record->amount}}
					@endif</td>
					
					</tr>
                  </tbody>
                  @endforeach
				  <tr>
                    <th colspan="3"></th>
					<th>Total</th>
					<th>
					{{$totalDebit}}
					
				</th>
					<th>{{$totalCredit}}</th>
           
					</tr>
					<tr>
                    <th colspan="3"></th>
					<th>Balance</th>
					<th colspan="2">
					{{$totalCredit - $totalDebit}}
					
				</th>
					
           
					</tr>
                </table>
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