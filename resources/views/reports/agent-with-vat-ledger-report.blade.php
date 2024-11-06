
@extends('layouts.appLogin')
@section('content')






<div class="breadcrumb-section" style="background-image: linear-gradient(270deg, rgba(0, 0, 0, .3), rgba(0, 0, 0, 0.3) 101.02%),url({{asset('front/assets/img/innerpage/inner-banner-bg.png')}});">  
        <div class="container">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-center">
                    <div class="banner-content">
                        <h1>My Ledger</h1>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Start Checkout section -->
    <div class="checkout-page pt-120 mb-120">
        <div class="container">
          <div class="row g-lg-4 gy-5 mb-30">
            <div class="col-md-12">
              <div class="inquiry-form ">
              <form id="filterForm" class="form-inline" method="get" action="{{ route('agentLedgerReportWithVat') }}" style="width:100%" >
              <div class="row">
              
                <input type="hidden" id="agent_id" name="agent_id" value="{{ request('agent_id') ?: $agetName }}" class="form-control"  placeholder="Agency/Supplier Name" />
					<input type="hidden" id="agent_id_select" name="agent_id_select" value="{{ request('agent_id_select') ?: $agetid }}"  />

                <div class="col-md-3">
                <div class="form-inner mb-30">
                   

                <input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control datepickerdmy"  required  placeholder="From Date" />
                   

                    </div>
</div>
                <div class="col-md-3">
                <div class="form-inner mb-30">
                <input type="text" name="to_date" required autocomplete ="off" value="{{ request('to_date') }}"  class="form-control datepickerdmy"  placeholder="To Date" />
                    </div>
                    </div>
                
                <div class="col-md-3">
                <div class="form-inner mb-30">
                <button class="secondary-btn2" type="submit">Filter</button>
                <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('agent-vouchers.index') }}">Clear</a>
                </div>
                </div>
              </div>
            </form>
              </div>
            </div>
          </div>
            <div class="row g-lg-4 gy-5">
                <div class="col-lg-12">
                    
                <table class="table table-condensed table-striped">
                <thead class="bg-light-1 rounded-12">
                      <tr>
                    <th>Agency/Supplier Name</th>
					<th>Date</th>
					<th>Receipt No/ Invoice No.</th>
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
				  
                    <td>{{($record->agent)?$record->agent->company_name:''}}</td>
					<td>{{ $record->date_of_receipt ? date(config('app.date_format'),strtotime($record->date_of_receipt)) : null }}</td>
					<td>
					@if(isset($record->voucher))
						 <a class="" style="color:#007bff!important" href="{{route('agentVoucherView',$record->voucher->id)}}">{{ ($record->receipt_no)}}</a>
					
					@else
						{{ ($record->receipt_no)}}
					@endif
				</td>
					<td>
					{{($record->transaction_from == '2')?'Vouchered':''}}
					{{($record->transaction_from == '3')?'Canceled':''}}
					{{($record->transaction_from == '4')?'Refund':''}}
					{{($record->transaction_from == '5')?'Invoice Edit':''}}
					{{($record->transaction_from == '6')?'Credit Given':''}}
					</td>
          <td>{{@$record->voucher->guest_name}}</td>
					<td>{{$record->remark}}</td>
					<td style="text-align: right">
					@if($record->transaction_type == 'Payment')
					{{$record->amount}}
					@php
						$totalDebit += $record->amount;
						@endphp
					@endif
					
				</td>
					<td style="text-align: right">@if($record->transaction_type == 'Receipt')
						@php
						$totalCredit += $record->amount;
						@endphp
					
					{{$record->amount}}
					@endif</td>
					
					
					</tr>
                 
                  @endforeach
                  </tbody>
				  <tr>
                 
					<th colspan="6"  style="text-right">Total</th>
					<th style="text-align: right">
					{{$totalDebit}}
					
				</th>
					<th style="text-align: right">{{$totalCredit}}</th>
					
					</tr>
					<tr>
                    <th colspan="6"  style="text-right">Closing</th>
					<th colspan="2" style="text-align: right">
					@php
					$closing = $totalCredit - $totalDebit;
					@endphp
					{{$closing}}
					
				</th>
					
           
					</tr>
					<tr>
          <th colspan="6"  style="text-right">Opening Balance</th>
					<th colspan="2" style="text-align: right">
					{{$openingBalance}}
					
				</th>
					
           
					</tr>
					<tr>
          <th colspan="6" style="text-right">Closing Balance</th>
					<th colspan="2" style="text-align: right">
					@php
					$closing = (float)str_replace(',', '', $closing);
					$openingBalance = (float)str_replace(',', '', $openingBalance);
					@endphp
					{{$openingBalance+$closing}}
					
				</th>
					
           
					</tr>
                      </tbody>
                    </table>
                   


                </div>
                
            </div>
        </div>
    </div>
    <!-- End Checkout section -->
 

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
