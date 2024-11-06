@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Activities</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Activities</li>
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
                <h3 class="card-title">Activities</h3>
				<div class="card-tools">
				 <a href="{{ route('activities.create') }}" class="btn btn-sm btn-info">
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
					<th>Min Starting Price</th>
					<th>Min Selling Price</th>
					<th>Product Type</th>
					<th>Entry Type</th>
                    <th>Status</th>
					<th>Currency</th>
                    <th>Created</th>
                    <th>Updated</th>
					<th>Activity</th>
                    <th width="17%"></th>
                  </tr>
				  <tr>
                    <form id="filterForm" method="get" action="{{route('activities.index')}}" >
                    <th><input type="text" name="name" value="{{request('name')}}" class="form-control"  placeholder="Title" /></th>
					<th><input type="text" name="min_price" value="{{request('min_price')}}" class="form-control"  placeholder="Min Starting Price" /></th>
					<th><input type="text" name="list_price" value="{{request('list_price')}}" class="form-control"  placeholder="Min Selling Price" /></th>
                  <th></th>
				  
				  <th></th>
					 <th><select name="status" id="status" class="form-control">
                    <option value="" @if(request('status') =='') {{'selected="selected"'}} @endif>Select</option>
                    <option value="1" @if(request('status') ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="2" @if(request('status') ==2) {{'selected="selected"'}} @endif >Inactive</option>
                 </select></th>
				  <th></th>
					<th></th>
                    <th></th>
                    <th></th>
                    <th><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('activities.index')}}">Clear</a></th>
                    
                  </form>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  @php
				  $avc = SiteHelpers::getActivityVariantTotalCount($record->id);
				  @endphp
                  <tr>
					
                    <td>{{ $record->title}}</td>
					<td>{{ $record->min_price}}</td>
					<td>{{ $record->list_price}}</td>
					<td>{{ $record->product_type}}</td>
					<td>{{ $record->entry_type}}</td>
                    <td>{!! SiteHelpers::statusColor($record->status) !!}</td>
					<td>{{ @$record->currency->name}}</td>
                    <td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
                    <td>{{ $record->updated_at ? date(config('app.date_format'),strtotime($record->updated_at)) : null }}</td>
					 <td>
					<a class="btn btn-info btn-sm" href="{{route('activity.clone',$record->id)}}" title="clone" onclick="return confirm('You want to clone this activity?')">
                              <i class="fas fa-copy">
                              </i>
                              Copy
                          </a>
						  </td>
                     <td>
					
					  <a class="btn btn-info btn-sm" href="{{route('activities.show',$record->id)}}">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a>
					 <a class="btn btn-info btn-sm " href="{{route('activities.edit',$record->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a>
						    <a class="btn btn-info btn-sm" href="{{route('activity.variants',['activity_name'=>$record->title])}}">
                              <i class="fas fa-eye">
                              </i>
                               Variants({{$avc}})
                          </a>
						  
                          <form id="delete-form-{{$record->id}}" method="post" action="{{route('activities.destroy',$record->id)}}" style="display:none;">
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