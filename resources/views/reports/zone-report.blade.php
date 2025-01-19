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
                    <th>Active Agents</th>
                    <th>No. of Bkgs.</th>
                    <th>No. of Services</th>
                    <th>Accounted Sells</th>
                    <th>UnAccounted Sells</th>
                    <th>Total Sales</th>
                    <th>Total Cost</th>
                    <th>Accounted Profit</th>
                    <th>Accounted Transfer Sales</th>
                    <th>UnAccounted Transfer Sales</th>
                    <th>Total Transfer Sales</th>
                    <th>Total Transfer Cost</th>
                    <th>Accounted Transfer Profit</th>
                    <th>Hotel Sales</th>
                    <th>Hotel Cost</th>
                    <th>Hotel - Profit</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Initialize totals
                    $totals = [
                        'activeAgents' => 0,
                        'no_ofBkgs' => 0,
                        'no_ofServices' => 0,
                        'totalAccountedSell' => 0,
                        'totalUnAccountedSell' => 0,
                        'totalSells' => 0,
                        'totalCost' => 0,
                        'totalAccountedProfit' => 0,
                        'totalAccountedTransSell' => 0,
                        'totalUnAccountedTransSell' => 0,
                        'totalTransSells' => 0,
                        'totalTransCost' => 0,
                        'totalAccountedTransProfit' => 0,
                        'totalHotelSP' => 0,
                        'totalHotelCost' => 0,
                        'PLHotel' => 0,
                    ];
                @endphp
        
                @foreach ($data as $k => $record)
                    <tr>
                        <td>{{$k}}</td>
                        <td>{{$record['activeAgents']}}</td>
                        <td>{{$record['no_ofBkgs']}}</td>
                        <td>{{$record['no_ofServices']}}</td>
                        <td>{{$record['totalAccountedSell']}}</td>
                        <td>{{$record['totalUnAccountedSell']}}</td>
                        <td>{{$record['totalSells']}}</td>
                        <td>{{$record['totalCost']}}</td>
                        <td>
                            @if($record['totalAccountedProfit'] > 0)
                                <span style="color: white;font-weight:bold;background-color: green;padding: 8px;display: inline-block;width: 100%;">{{ @$record['totalAccountedProfit']}}</span>
                            @elseif($record['totalAccountedProfit'] < 0)
                                <span style="color: white;font-weight:bold;background-color: red;padding: 8px;display: inline-block;width: 100%;">{{ @$record['totalAccountedProfit']}}</span>
                            @else
                                0
                            @endif
                        </td>
                        <td>{{$record['totalAccountedTransSell']}}</td>
                        <td>{{$record['totalUnAccountedTransSell']}}</td>
                        <td>{{$record['totalTransSells']}}</td>
                        <td>{{$record['totalTransCost']}}</td>
                        <td>
                            @if($record['totalAccountedTransProfit'] > 0)
                                <span style="color: white;font-weight:bold;background-color: green;padding: 8px;display: inline-block;width: 100%;">{{ @$record['totalAccountedTransProfit']}}</span>
                            @elseif($record['totalAccountedTransProfit'] < 0)
                                <span style="color: white;font-weight:bold;background-color: red;padding: 8px;display: inline-block;width: 100%;">{{ @$record['totalAccountedTransProfit']}}</span>
                            @else
                                0
                            @endif
                        </td>
                        <td>{{$record['totalHotelSP']}}</td>
                        <td>{{$record['totalHotelCost']}}</td>
                        <td>
                            @if($record['PLHotel'] > 0)
                                <span style="color: white;font-weight:bold;background-color: green;padding: 8px;display: inline-block;width: 100%;">{{ @$record['PLHotel']}}</span>
                            @elseif($record['PLHotel'] < 0)
                                <span style="color: white;font-weight:bold;background-color: red;padding: 8px;display: inline-block;width: 100%;">{{ @$record['PLHotel']}}</span>
                            @else
                                0
                            @endif
                        </td>
                    </tr>
        
                    @php
                        // Add values to totals with validation
                        foreach ($totals as $key => $value) {
        $totals[$key] += (float)str_replace(',', '', $record[$key]); // String ko numeric me convert karen
    }
                    @endphp
                @endforeach
        
                <!-- Grand Total Row -->
                <tr style="font-weight: bold; background-color: #f1f1f1;">
                  <td>Grand Total</td>
                  <td>{{ number_format($totals['activeAgents'], 0) }}</td> <!-- Agents ke liye integer format -->
                  <td>{{ number_format($totals['no_ofBkgs'], 2) }}</td>
                  <td>{{ number_format($totals['no_ofServices'], 2) }}</td>
                  <td>{{ number_format($totals['totalAccountedSell'], 2) }}</td>
                  <td>{{ number_format($totals['totalUnAccountedSell'], 2) }}</td>
                  <td>{{ number_format($totals['totalSells'], 2) }}</td>
                  <td>{{ number_format($totals['totalCost'], 2) }}</td>
                  <td>{{ number_format($totals['totalAccountedProfit'], 2) }}</td>
                  <td>{{ number_format($totals['totalAccountedTransSell'], 2) }}</td>
                  <td>{{ number_format($totals['totalUnAccountedTransSell'], 2) }}</td>
                  <td>{{ number_format($totals['totalTransSells'], 2) }}</td>
                  <td>{{ number_format($totals['totalTransCost'], 2) }}</td>
                  <td>{{ number_format($totals['totalAccountedTransProfit'], 2) }}</td>
                  <td>{{ number_format($totals['totalHotelSP'], 2) }}</td>
                  <td>{{ number_format($totals['totalHotelCost'], 2) }}</td>
                  <td>{{ number_format($totals['PLHotel'], 2) }}</td>
              </tr>
              
            </tbody>
        </table>
        
        </div>
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
