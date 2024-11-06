@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Accounts Receivables Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Accounts Receivables Report</li>
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
				<a href="{{ route('accountsReceivablesReportExcel', request()->input()) }}" class="btn btn-info btn-sm mb-2 mr-4">Export to CSV</a>
				   </div></div>
				   
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="" class="table table-bordered table-striped example3">
                  <thead>
                  <tr>
					<th>SN.</th>
					<th>Code</th>
					<th>Company</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>City</th>
                    <th>Status</th>
					<th width="10%">Credit Limit(AED)</th>
                   <th width="10%">Ledger Balance(AED)</th>
				   <th width="12%">Balance(AED)</th>
                  </tr>
				  <!--<tr>
                    <form id="filterForm" method="get" action="{{route('accountsReceivablesReport')}}" >
					<th><input type="text" name="code" value="{{request('code')}}" class="form-control"  placeholder="Code" /></th>
                    <th><input type="text" name="name" value="{{request('name')}}" class="form-control"  placeholder="Name" /></th>
                   <th><input type="text" name="mobile" value="{{request('mobile')}}" class="form-control"  placeholder="Mobile" /></th>
                   <th><input type="text" name="email" value="{{request('email')}}" class="form-control"  placeholder="Email" /></th>
                   <th><input type="text" name="cname" value="{{request('cname')}}" class="form-control"  placeholder="Company Name" /></th>
                  
                 <th><select name="city_id" id="city_id" class="form-control">
				<option value="">--select--</option>
				@foreach($cities as $city)
                    <option value="{{$city->id}}" @if(request('city_id') == $city->id) {{'selected="selected"'}} @endif>{{$city->name}}</option>
				@endforeach
                 </select></th>
                
					 <th><select name="status" id="status" class="form-control">
                    <option value="" @if(request('status') =='') {{'selected="selected"'}} @endif>Select</option>
                    <option value="1" @if(request('status') ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="2" @if(request('status') ==2) {{'selected="selected"'}} @endif >Inactive</option>
                 </select></th>
				 <th></th>
                     <th></th>
					
                  
                    <th><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('accountsReceivablesReport')}}">Clear</a></th>
                    
                  </form>
                  </tr>-->
                  </thead>
                  <tbody>
                 @foreach ($records as $k => $record)
				  
                  <tr>
					<td>{{ $k+1}}</td>
                    <td>{{ $record->code}}</td>
					 <td>{{ $record->company_name}}</td>
                    <td>{{ $record->name}}</td>
                    <td>{{ $record->mobile}}</td>
					<td>{{ $record->email}}</td>
                    <td>{{ ($record->city)?$record->city->name:''}}</td>
                   
                    <td>{!! SiteHelpers::statusColor($record->is_active) !!}</td>
					<td>{{ number_format($record->agent_credit_limit,2)}}</td>
					<td>{{ number_format($record->agent_amount_balance,2)}}</td> 
					@php
					$balance = $record->agent_credit_limit - $record->agent_amount_balance;
					@endphp
					
                  
				   <td>@if($balance > 0) <span style="color: white;font-weight:bold;background-color: green;padding: 8px;display: inline-block;width: 70%;">{{ number_format($balance,2)}}</span> @else <span style="color: white;font-weight:bold;background-color: red;padding: 8px;display: inline-block;width: 70%;">{{ number_format($balance,2)}}</span> @endif</td>
				   
                  </tr>
				 
                  @endforeach
                  </tbody>
                 
                </table>
				<div class="pagination pull-right mt-3"> {!! $records->appends(request()->query())->links() !!} </div> 
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

$('.example3').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "ordering": true, // Enable sorting
    "info": true,
    "autoWidth": false,
    "responsive": true,
    "bFilter": true, // Show search input
    "columnDefs": [
      {
        "targets": [10], // Column index (0-indexed) for which to customize sorting and width
        "orderable": false, // Set to false to disable sorting for this column
      },
      // You can add more objects to customize sorting and width for other columns
    ],
  });	 
});

  </script> 
  
  <script>


	</script>
  @endsection