@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Variants</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Variants</li>
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
                <h3 class="card-title">Variants</h3>
				<div class="card-tools">
				 <a href="{{ route('variants.create') }}" class="btn btn-sm btn-info">
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
                    <th>Title</th>
					<th>Code</th>
					<th>Min Starting Price</th>
					<th>Min Selling Price</th>
                    <th>Status</th>
					<th>Is Slot</th>
					<th>Is Canellation</th>
					<th>Backend Only</th>
                    <th>Created</th>
                    <th>Updated</th>
					<th>Variant</th>
                    <th width="17%"></th>
                  </tr>
				  <tr>
                    <form id="filterForm" method="get" action="{{route('variants.index')}}" >
                    <th><input type="text" name="name" value="{{request('name')}}" class="form-control"  placeholder="Title" /></th>
                 <th></th>
				 	<th><input type="text" name="list_price" value="{{request('list_price')}}" class="form-control"  placeholder="Min Starting Price" /></th>
					<th><input type="text" name="sell_price" value="{{request('sell_price')}}" class="form-control"  placeholder="Min Selling Price" /></th>
					 <th><select name="status" id="status" class="form-control">
                    <option value="" @if(request('status') =='') {{'selected="selected"'}} @endif>Select</option>
                    <option value="1" @if(request('status') ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="2" @if(request('status') ==2) {{'selected="selected"'}} @endif >Inactive</option>
                 </select></th>
				   
				 <th><select name="is_slot" id="is_slot" class="form-control">
                    <option value="" @if(request('is_slot') =='') {{'selected="selected"'}} @endif>Select</option>
                    <option value="1" @if(request('is_slot') ==1) {{'selected="selected"'}} @endif>Yes</option>
					          <option value="2" @if(request('is_slot') ==2) {{'selected="selected"'}} @endif >No</option>
                 </select></th>
				  <th><select name="is_canellation" id="is_canellation" class="form-control">
                    <option value="" @if(request('is_canellation') =='') {{'selected="selected"'}} @endif>Select</option>
                    <option value="1" @if(request('is_canellation') ==1) {{'selected="selected"'}} @endif>Yes</option>
					          <option value="2" @if(request('is_canellation') ==2) {{'selected="selected"'}} @endif >No</option>
                 </select></th>
				  <th><select name="for_backend_only" id="for_backend_only" class="form-control">
                    <option value="" @if(request('for_backend_only') =='') {{'selected="selected"'}} @endif>Select</option>
                    <option value="1" @if(request('for_backend_only') ==1) {{'selected="selected"'}} @endif>Yes</option>
					          <option value="2" @if(request('for_backend_only') ==2) {{'selected="selected"'}} @endif >No</option>
                 </select></th>
					<th></th>
                    <th></th>
                   <th></th>
                    <th><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('variants.index')}}">Clear</a></th>
                    
                  </form>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  
                  <tr>
					
                    <td>{{ $record->title}}</td>
					<td>{{ $record->code}}</td>
					<td>{{ $record->list_price}}</td>
					<td>{{ $record->sell_price}}</td>
                    <td>{!! SiteHelpers::statusColor($record->status) !!}</td>
					<td>{!! SiteHelpers::statusColorYesNo($record->is_slot) !!}</td>
					<td>{!! SiteHelpers::statusColorYesNo($record->is_canellation) !!}</td>
					<td>{!! SiteHelpers::statusColorYesNo($record->for_backend_only) !!}</td>
                    <td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
                    <td>{{ $record->updated_at ? date(config('app.date_format'),strtotime($record->updated_at)) : null }}</td>
					 <td>
					 <a class="btn btn-info btn-sm" href="{{route('variant.clone',$record->id)}}" title="clone" onclick="return confirm('You want to clone this variant?')">
                              <i class="fas fa-copy">
                              </i>
                              Copy
                          </a>
					</td>
                     <td>
					
					  <a class="btn btn-info btn-sm" href="{{route('variant.slots',$record->id)}}">
                             Slots
                          </a>
					<a class="btn btn-info btn-sm" href="{{route('variant.canellation',$record->id)}}">
                             Canellation Chart
                          </a>
					  <a class="btn btn-info btn-sm" href="{{route('variants.show',$record->id)}}">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a>
					 <a class="btn btn-info btn-sm " href="{{route('variants.edit',$record->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a>
                          <form id="delete-form-{{$record->id}}" method="post" action="{{route('variants.destroy',$record->id)}}" style="display:none;">
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
                            
                            "><i class="fas fa-trash"></i></a></td>
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
 @include('inc.citystatecountryjs')
@endsection
