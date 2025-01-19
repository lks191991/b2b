@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Quotations</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Quotation</li>
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
                <h3 class="card-title">Quotation</h3>
				<div class="card-tools">
				 <a href="{{ route('quotations.create') }}" class="btn btn-sm btn-info">
                      <i class="fas fa-plus"></i>
                      Create
                  </a> 
				   </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table rounded-corners">
                  <thead>
                  <tr>
                  <th>Created On</th>
					<th>Code</th>
                    <th>Agency</th>
                    <th>Zone</th>
                    <th>Travel Date</th>
                    <th>Created By</th>
					
					<th>Total</th>
				
					<th>Quotation</th>
                    <th width="12%"></th>
                  </tr>
				  
                  </thead>
                  <tbody>
				   <form id="filterForm" method="get" action="{{route('quotations.index')}}" >
				   <tr>
            <th></th>
					<th><input type="text" name="code" value="{{request('code')}}" autocomplete="off" class="form-control"  placeholder="Code" /></th>
        
                    <th><input type="text" id="agent_id" name="agent_id" value="{{ request('agent_id') ?: $agetName }}" class="form-control"  placeholder="Agency Name" />
                    <th>
                    @php
				$zones = config("constants.agentZone");
			  @endphp
              
                <select name="zone" id="zone" class="form-control">
				<option value="">--select--</option>
				@foreach($zones as $zone)
                    <option value="{{$zone}}" @if(request('zone') == $zone) {{'selected="selected"'}} @endif>{{$zone}}</option>
				@endforeach
                 </select>

                    </th>
                   
					<input type="hidden" id="agent_id_select" name="agent_id_select" value="{{ request('agent_id_select') ?: $agetid }}"  /></th>
					
					
                   
                    <th width="17%"></th>
                    <th></th>
					<th></th>
					
					<th width="7%"></th>
					
                    <th width="12%"><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('quotations.index')}}">Clear</a></th>
					 </form>
                  </tr>
                  @foreach ($records as $record)
				  
                  <tr>
                  <td>{{ $record->created_at ? date("d-m-Y, H:i:s",strtotime($record->created_at)) : null }}</td>
				  <td>{{ ($record->code)}}</td>
                    <td>{{ ($record->agent)?$record->agent->company_name:''}}</td>
                    <td>{{ ($record->zone)}}</td>
					   <td>{{ $record->travel_from_date ? date(config('app.date_format'),strtotime($record->travel_from_date)) : null }} <b>To</b> {{ $record->travel_to_date ? date(config('app.date_format'),strtotime($record->travel_to_date)) : null }}</td>
               
					<td>{{ ($record->createdBy)?$record->createdBy->name:''}}</td>
					<td>{{  SiteHelpers::getVoucherTotalPriceNew($record->id);}}</td>
					 
						 
						   <td>
					 
						<a class="btn btn-info btn-sm" href="{{route('voucher.add.quick.activity',$record->id)}}">
                            <i class="fas fa-plus">  {{(SiteHelpers::voucherActivityCount($record->id) > 0)?SiteHelpers::voucherActivityCount($record->id):''}}
                            </i> 
                           
                        </a>
						
						  </td>
                     <td>
					 
						
                               <a class="btn btn-info btn-sm" href="{{route('quotationView',$record->id)}}">
                               <i class="fas fa-eye">
                              </i>
                         
                          </a>

						
						  
						  
							
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
