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
				 <a href="{{ route('vouchers.create') }}" class="btn btn-sm btn-info">
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
					<th>Code</th>
                    <th>Agency</th>
                    <th>Guest Name</th>
                    <th>Status</th>
                    <th>Travel Date</th>
                    <th>Created On</th>
					<th>Created By</th>
					<th>Hotels</th>
					<th width="7%">Activities</th>
					<th>Invoice</th>
					<th>Itinerary</th>
                    <th width="12%"></th>
                  </tr>
				  
                  </thead>
                  <tbody>
				   <form id="filterForm" method="get" action="{{route('vouchers.index')}}" >
				   <tr>
					<th><input type="text" name="code" value="{{request('code')}}" autocomplete="off" class="form-control"  placeholder="Code" /></th>
                    <th><input type="text" id="agent_id" name="agent_id" value="{{ request('agent_id') ?: $agetName }}" class="form-control"  placeholder="Agency Name" />
                    <th><input type="text" id="guest_name" name="guest_name" value="{{ request('guest_name') ?: '' }}" class="form-control"  placeholder="Guest Name" />
					<input type="hidden" id="agent_id_select" name="agent_id_select" value="{{ request('agent_id_select') ?: $agetid }}"  /></th>
					
					
                    <th><select name="status" id="status" class="form-control">
                    <option value="" @if(request('status') =='') {{'selected="selected"'}} @endif>Select</option>
                    <option value="1" @if(request('status') ==1) {{'selected="selected"'}} @endif>Draft</option>
					          <option value="2" @if(request('status') ==2) {{'selected="selected"'}} @endif >Create Quotation</option>
					 <option value="3" @if(request('status') ==3) {{'selected="selected"'}} @endif >In Process</option>
					 <option value="4" @if(request('status') ==4) {{'selected="selected"'}} @endif >Confirmed</option>
					 <option value="5" @if(request('status') ==5) {{'selected="selected"'}} @endif >Vouchered</option>
					 <option value="6" @if(request('status') ==6) {{'selected="selected"'}} @endif >Canceled</option>
					
                 </select></th>
                    <th width="17%"></th>
                    <th></th>
					<th></th>
					<th width="7%"></th>
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
                    <td>{{ $record->guest_name}}</td>
                     <td>{!! SiteHelpers::voucherStatus($record->status_main) !!}</td>
					   <td>{{ $record->travel_from_date ? date("M d Y, H:i:s",strtotime($record->travel_from_date)) : null }} <b>To</b> {{ $record->travel_to_date ? date(config('app.date_format'),strtotime($record->travel_to_date)) : null }}</td>
                    <td>{{ $record->created_at ? date("M d Y, H:i:s",strtotime($record->created_at)) : null }}</td>
					<td>{{ ($record->createdBy)?$record->createdBy->name:''}}</td>
                  
					 <td>
					 @if($record->is_hotel == 1)
						 @if($record->status_main < 4)
					 <a class="btn btn-info btn-sm" href="{{route('voucher.add.hotels',$record->id)}}">
                              <i class="fas fa-plus">
                              </i> {{(SiteHelpers::voucherHotelCount($record->id) > 0)?'('.SiteHelpers::voucherHotelCount($record->id).')':''}}
                             
                          </a>
						   @endif
						  @endif
						  </td>
						   
					 <td>
					 @if($record->is_activity == 1)
						 @if($record->status_main < 4)
					 <a class="btn btn-info btn-sm" href="{{route('voucher.add.activity',$record->id)}}">
                              <i class="fas fa-plus">
                              </i> {{(SiteHelpers::voucherActivityCount($record->id) > 0)?'('.SiteHelpers::voucherActivityCount($record->id).')':''}}
                             
                          </a>
						  @endif
						  @endif
						  </td>
						  <td>
						   @if($record->status_main >= 4)
					 <a class="btn btn-info btn-sm" href="{{route('voucherInvoicePdf',$record->id)}}" >
                              <i class="fas fa-download">
                              </i>
                             
                          </a>
						  @endif
						  </td>
						   <td>
					 
						 @if($record->status_main > 1)
					 <a class="btn btn-info btn-sm" href="{{route('voucherActivityItineraryPdf',$record->id)}}">
                              <i class="fas fa-download">
                              </i>
                             
                          </a>
						  @endif
						
						  </td>
                     <td>
					  @if($record->status_main < 5)
					  <a class="btn btn-info btn-sm" title="Checkout" href="{{route('vouchers.show',$record->id)}}">
                               <i class="fas fa-shopping-cart">
                              </i> 
                          </a>
						  @endif
					 <a class="btn btn-info btn-sm" href="{{route('voucherView',$record->id)}}">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a>
					 <a class="btn btn-info btn-sm" href="{{route('vouchers.edit',$record->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a>
						   <form id="delete-form-{{$record->id}}" method="post" action="{{route('vouchers.destroy',$record->id)}}" style="display:none;">
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
