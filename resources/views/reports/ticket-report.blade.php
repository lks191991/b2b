@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ticket Stock Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Ticket Stock Report</li>
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
				<a href="{{ route('ticketStockReportExportExcel', request()->input()) }}" class="btn btn-info btn-sm mb-2 mr-4">Export to CSV</a>
				   </div></div>
				   
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <div class="">
            <form id="filterForm" class="form-inline" method="get" action="{{ route('ticketStockReport') }}" style="width:100%" >
              <div class="form-row" style="width:100%">
			 
				 <div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Variant</div></div>
                  <select name="activity_variant"  id="activity_variant" class="form-control">
				<option value="">--select--</option>
				@foreach($variants as $variant)
                    <option value="{{$variant->ucode}}" @if(request('activity_variant') == $variant->ucode) {{'selected="selected"'}} @endif>{{$variant->title}}</option>
				@endforeach
				</select>
                  </div>
                </div>
			  <div class="col-auto col-md-2">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Expiry From</div></div>
                    <input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control datepickerdmy"    placeholder="From Date" />
                  </div>
                </div>
				<div class="col-auto col-md-2">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Expiry To</div></div>
                    <input type="text" name="to_date"  autocomplete ="off" value="{{ request('to_date') }}"  class="form-control datepickerdmy"  placeholder="To Date" />
                  </div>
                </div>
               
                
               
              <div class="col-auto col-md-2">
                <button class="btn btn-info mb-2" type="submit">Filter</button>
                <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('ticketStockReport') }}">Clear</a>
              </div>
            </form>
          </div>
        </div>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th colspan="3"></th>
					<th colspan="3">Stock Uploaded</th>
					<th colspan="3">Stock Allotted</th>
					<th colspan="3">Stock Left</th>
					<th colspan="2">Stock Pending for Allotment</th>
                  </tr>
				  
				   <tr>
					<th>Variant Name</th>
					<th>Expiry Date</th>
					<th>LOT</th>
					<th>Adult</th>
					<th>Child</th>
					<th>Both</th>
					<th>Adult</th>
					<th>Child</th>
					<th>Both</th>
					<th>Adult</th>
					<th>Child</th>
					<th>Both</th>
					<th>Adult</th>
					<th>Child</th>
			
         
                  </tr>
				  
                  </thead>
                  <tbody>
				 
				  @foreach ($records as $record)
                  <tr>
					<td>{{ @$record->variant->title}}</td>
					<td>{{ $record->valid_till ? date(config('app.date_format'),strtotime($record->valid_till)) : null }}</td>
					<td></td>
					
					<td>{{ @$record->stock_uploaded_adult}}</td>
					<td>{{ @$record->stock_uploaded_child}}</td>
					<td>{{ @$record->stock_uploaded_both}}</td>
					<td>@if($record->stock_allotted_adult > 0) <span style="color: white;font-weight:bold;background-color: red;padding: 8px;display: inline-block;width: 100%;">{{ @$record->stock_allotted_adult}}</span> @else 0 @endif</td>
					<td>@if($record->stock_allotted_child > 0) <span style="color: white;font-weight:bold;background-color: red;padding: 8px;display: inline-block;width: 100%;">{{ @$record->stock_allotted_child}}</span> @else 0 @endif</td>
					<td>@if($record->stock_allotted_both > 0) <span style="color: white;font-weight:bold;background-color: red;padding: 8px;display: inline-block;width: 100%;">{{ @$record->stock_allotted_both}}</span> @else 0 @endif</td>
					<td>@if($record->stock_left_adult > 0) <span style="color: white;font-weight:bold;background-color: green;padding: 8px;display: inline-block;width: 100%;">{{ @$record->stock_left_adult}}</span> @else 0 @endif</td>
					<td>@if($record->stock_left_child > 0) <span style="color: white;font-weight:bold;background-color: green;padding: 8px;display: inline-block;width: 100%;">{{ @$record->stock_left_child}}</span> @else 0 @endif</td>
					<td>@if($record->stock_left_both > 0) <span style="color: white;font-weight:bold;background-color: green;padding: 8px;display: inline-block;width: 100%;">{{ @$record->stock_left_both}}</span> @else 0 @endif</td>
					<td>0</td>
					<td>0</td>
				
         
					</tr>
                 
                  @endforeach
				 </tbody>
					
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
	<script type="text/javascript">
 $(document).ready(function(){
	//var activity_id = "{{request('activity_id')}}";
	var oldactivity_variant = "{{request('activity_variant')}}";
	
	$("body #activity_id").on("change", function () {
            var activity_id = $(this).val();
			$("#activity_variant").prop("disabled",true);
            $.ajax({
                type: "POST",
                url: '{{ route("variantByActivity") }}',
                data: {'activity_id': activity_id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
					 $('#activity_variant').html('<option value="">--select--</option>');
					$.each(data, function (key, value) {
                            $("#activity_variant").append('<option value="' + value
                                .u_code + '">' + value.variant_name + '</option>');
                        });
					$('#activity_variant').val(oldactivity_variant).prop('selected', true);
					$("#activity_variant").prop("disabled",false);
					
					
                }
            });
        });
		
					
		if(oldactivity_variant){
					$("body #activity_id").trigger("change");
					}
		});
			</script>  
@endsection