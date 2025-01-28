@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Master Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Product Master Report</li>
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
                
                <h3 class="card-title">Product Master Report</h3>
				<div class="card-tools">
				
				   </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>Variant Code</th>
					<th>Activity</th>
					<th>Variant</th>
					<th>Rate Valid From</th>
					<th>Rate Valid To</th>
                    <th>TKT Price Adult</th>
					<th>TKT Price Child</th>
					<th></th>
                  </tr>
				 
                  </thead>
                  <tbody>
				  <form id="filterForm" method="get" action="{{route('productMaster')}}" >
				   <tr>
           
					<th><input type="text" name="vcode" value="{{ request('vcode') }}" autocomplete ="off" class="form-control "  placeholder="Variant Code" /></th>
                    <th></th>
                    <th></th>
						<th><input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control datepicker"  placeholder="Rate Valid From" /></th>
          <th><input type="text" name="to_date" value="{{ request('to_date') }}" class="form-control datepicker" autocomplete ="off"  placeholder="Rate Valid To" /></th>
		  <th width="12%"><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('productMaster')}}">Clear</a></th>
					 <th></th>
                   <th></th>
					 
                  </tr>
				  </form>
		@if (empty($filter))
		<tr>
		<td colspan="11"><p class="text-center">Please select filters.</p></td>
		</tr>
		@else
                  @foreach ($records as $record)
				  
                  <tr>
				  <td>{{ @$record->av->variant->code}}</td>
				  <td>{{ @$record->av->activity->title}}</td>
				  <td>{{ @$record->av->variant->title}}</td>
			<td>{{ $record->rate_valid_from ? date(config('app.date_format'),strtotime($record->rate_valid_from)) : null }}</td>
              <td>{{ $record->rate_valid_to ? date(config('app.date_format'),strtotime($record->rate_valid_to)) : null }}</td>
                    <td>{{ $record->adult_B2C_with_vat}}</td>
					<td>{{ $record->child_B2C_with_vat}}</td>
					
                     <td>
					
					  <a class="btn btn-info btn-sm" target="_blank" href="{{route('activity.variant.price.view',$record->id)}}">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a>
					 <a class="btn btn-info btn-sm " target="_blank" href="{{route('activity.variant.price.edit',$record->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a>
                          <form id="delete-form-{{$record->id}}" method="post" action="{{route('activity.variant.price.destroy',$record->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$record->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i></a></td>
                  </tr>
				 
                  @endforeach
				  @endif
                  </tbody>
                 
                </table>
				@if (!empty($filter))
				<div class="pagination pull-right mt-3"> 
				{!! $records->appends(request()->query())->links() !!}
				</div> 
				@endif
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
 @include('inc.citystatecountryjs')
@endsection