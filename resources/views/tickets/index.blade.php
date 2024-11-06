@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tickets</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Tickets</li>
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
                <h3 class="card-title">Tickets</h3>
				<div class="card-tools">
				 <a href="{{ route('tickets.create') }}" class="btn btn-sm btn-info hide">
                      <i class="fas fa-plus"></i>
                      Create
                  </a> 
                  
				  <a href="{{ route('tickets.csv.upload.form') }}" class="btn btn-sm btn-info">
                      <i class="fas fa-upload"></i>
                      Upload Data From CSV
                  </a> 
                  
				   </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
					<th>Ticket No.</th>
					<th>Serial Number</th>
					<th>Valid From</th>
					<th>Valid Till</th>
					
                    <th>Variant</th>
					<th>Ticket For</th>
					<th>Type Of Ticket</th>
					<th>Supplier</th>
					<th>Net Cost</th>
                    <th width="17%">Created</th>
                    <th></th>
                  </tr>
				  <tr>
                    <form id="filterForm" method="get" action="{{route('tickets.index')}}" >
					 <th></th>
                    <th><input type="text" name="ticket_no" value="{{request('ticket_no')}}" class="form-control"  placeholder="Ticket Number" autocomplete="off" /></th>
                     <th><input type="text" name="serial_number" value="{{request('serial_number')}}" class="form-control"  placeholder="Serial Number" autocomplete="off" /></th>
                    <th><input type="text" name="valid_from" value="{{request('valid_from')}}" class="form-control datepicker"  placeholder="Valid From" autocomplete="off" /></th>
					 <th><input type="text" name="valid_till" value="{{request('valid_till')}}" class="form-control datepicker"  placeholder="Valid Till" autocomplete="off" /></th>
                    <th> <select name="activity_variant"  id="activity_variant" class="form-control">
				<option value="">--select--</option>
				@foreach($variants as $variant)
                    <option value="{{$variant->ucode}}" @if(request('activity_variant') == $variant->ucode) {{'selected="selected"'}} @endif>{{$variant->title}}</option>
				@endforeach
				</select></th>
					 <th> <select name="ticket_for"  id="ticket_for" class="form-control">
				<option value="">--select--</option>
				<option value="Adult" @if(request('ticket_for') == 'Adult') {{'selected="selected"'}} @endif>Adult</option>
				<option value="Child" @if(request('ticket_for') == 'Child') {{'selected="selected"'}} @endif>Child</option>
				<option value="Both" @if(request('ticket_for') == 'Both') {{'selected="selected"'}} @endif>Both</option>
				</select></th>
                   <th></th>
				   <th></th>
				   <th></th>
                    <th width="10%"><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('tickets.index')}}">Clear</a></th>
                   <th ></th>
                  </form>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  
                  <tr>
					<td>{{ $loop->index + 1 }}</td>
					<td>{{ $record->ticket_no}}</td>
					<td>{{ $record->serial_number}}</td>
					<td>{{ $record->valid_from ? date(config('app.date_format'),strtotime($record->valid_from)) : null }}</td>
                    <td>{{ $record->valid_till ? date(config('app.date_format'),strtotime($record->valid_till)) : null }}</td>
                    <td>{{ ($record->variant)?$record->variant->title:''}}</td>
					<td>{{ $record->ticket_for}}</td>
                    <td>{{ $record->type_of_ticket}}</td>
					<td>{{ @$record->supplier->name}}</td>
					<td>{{ $record->net_cost}}</td>
                    <td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
                   
                     <td > <form id="delete-form-{{$record->id}}" method="post" action="{{route('tickets.destroy',$record->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn btn-danger btn-sm " href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$record->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i></a>
                         </td>
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
<script type="text/javascript">
 $(document).ready(function(){
	var activity_id = "{{request('activity_id')}}";
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
                                .variant_code + '">' + value.variant_name + '</option>');
                        });
					$('#activity_variant').val(oldactivity_variant).prop('selected', true);
					$("#activity_variant").prop("disabled",false);
					
					
                }
            });
        });
		if(activity_id){
					$("body #activity_id").trigger("change");
					}
					
		if(oldactivity_variant){
					$("body #activity_id").trigger("change");
					}
		});
			</script>  
@endsection
