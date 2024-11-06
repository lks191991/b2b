@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Vouchers</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Vouchers</li>
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
                <h3 class="card-title">Vouchers</h3>
				<div class="card-tools">
				 <a href="{{ route('agent-vouchers.create') }}" class="btn btn-sm btn-info">
                      <i class="fas fa-plus"></i>
                      Create
                  </a> 
				   </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>Code</th>
					
                    <th>Agency</th>
					<th>Customer</th>
					<th>Country</th>
				
					<th>Activity</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Updated</th>
					
					<th width="7%">Activities</th>
					<th>Invoice</th>
					<th>Itinerary</th>
                    <th width="12%"></th>
                  </tr>
				  
                  </thead>
                  <tbody>
				   <form id="filterForm" method="get" action="{{route('agent-vouchers.index')}}" >
				   <tr>
					<th><input type="text" name="code" value="{{request('code')}}" autocomplete="off" class="form-control"  placeholder="Code" /></th>
                    <th>
					 @if(Auth::user()->role_id !='3')
					<input type="text" id="agent_id" name="agent_id" value="{{ request('agent_id') ?: $agetName }}" class="form-control"  placeholder="Agency Name" />
					<input type="hidden" id="agent_id_select" name="agent_id_select" value="{{ request('agent_id_select') ?: $agetid }}"  />@endif</th>
					<th>Customer</th>
					<th>Country</th>
				
				
					<th><select name="is_activity" id="is_activity" class="form-control">
                    <option value="" @if(request('is_activity') =='') {{'selected="selected"'}} @endif>Select</option>
                    <option value="1" @if(request('is_activity') ==1) {{'selected="selected"'}} @endif>Yes</option>
					          <option value="2" @if(request('is_activity') ==2) {{'selected="selected"'}} @endif >No</option>
                 </select></th>
                    <th><select name="status" id="status" class="form-control">
                    <option value="" @if(request('status') =='') {{'selected="selected"'}} @endif>Select</option>
                    <option value="1" @if(request('status') ==1) {{'selected="selected"'}} @endif>Draft</option>
					          <option value="2" @if(request('status') ==2) {{'selected="selected"'}} @endif >Create Quotation</option>
					 <option value="3" @if(request('status') ==3) {{'selected="selected"'}} @endif >In Process</option>
					 <option value="4" @if(request('status') ==4) {{'selected="selected"'}} @endif >Confirmed</option>
					 <option value="5" @if(request('status') ==5) {{'selected="selected"'}} @endif >Vouchered</option>
					 <option value="6" @if(request('status') ==6) {{'selected="selected"'}} @endif >Canceled</option>
					
                 </select></th>
                    <th></th>
                   
					<th></th>
					
					<th ></th>
					<th></th>
					<th></th>
                    <th width="12%"><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('vouchers.index')}}">Clear</a></th>
					 </form>
                  </tr>
                  @foreach ($records as $record)
				  
                  <tr>
				  <td>{{ ($record->code)}}</td>
                    <td>{{ ($record->agent)?$record->agent->company_name:''}}</td>
					<td>{{ ($record->guest_name)?$record->guest_name:''}}</td>
					<td>{{ ($record->countr)?$record->country->name:''}}</td>
					
					   <td>{!! SiteHelpers::statusColorYesNo($record->is_activity) !!}</td>
                     <td>{!! SiteHelpers::voucherStatus($record->status_main) !!}</td>
                    <td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
                    <td>{{ $record->updated_at ? date(config('app.date_format'),strtotime($record->updated_at)) : null }}</td>

					
					 <td>
					 @if($record->is_activity == 1)
						 @if($record->status_main < 4)
					 <a class="btn btn-info btn-sm" href="{{route('agent-vouchers.add.activity',$record->id)}}">
                              <i class="fas fa-plus">
                              </i>
                             
                          </a>
						  @endif
						  @endif
						  </td>
						  <td>
						   @if($record->status_main == 5)
					 <a class="btn btn-info btn-sm" href="{{route('voucherInvoicePdf',$record->id)}}" >
                              <i class="fas fa-download">
                              </i>
                             
                          </a>
						  @endif
						  </td>
						   <td>
					 @if($record->is_activity == 1)
					 <a class="btn btn-info btn-sm" href="{{route('voucherActivityItineraryPdf',$record->id)}}">
                              <i class="fas fa-download">
                              </i>
                             
                          </a>
						  @endif
						  </td>
                     <td>
					 @if($record->status_main > 3)
					 
					 <a class="btn btn-info btn-sm" href="{{route('agentVoucherView',$record->id)}}">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a>
					@endif
					 <a class="btn btn-info btn-sm" href="{{route('agent-vouchers.edit',$record->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a>
						   <form id="delete-form-{{$record->id}}" method="post" action="{{route('agent-vouchers.destroy',$record->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn btn-danger btn-sm hide" href="javascript:void(0)" onclick="
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
				
				<div class="pagination pull-right mt-3"> {!! $records->links() !!} </div> 
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
  
</script>
@endsection