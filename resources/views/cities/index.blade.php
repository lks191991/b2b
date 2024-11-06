@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cities</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Cities</li>
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
                <h3 class="card-title">Cities</h3>
				<div class="card-tools">
				 <a href="{{ route('cities.create') }}" class="btn btn-sm btn-info">
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
                    <th>#</th>
                    <th>Name</th>
					<th>Country</th>
					<th>State</th>
                    <th>Status</th>
					<th>Show Home</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th></th>
                  </tr>
				  <tr>
                    <form id="filterForm" method="get" action="{{route('cities.index')}}" >
					 <th></th>
                    <th><input type="text" name="name" value="{{request('name')}}" class="form-control"  placeholder="State Name" /></th>
                     <th>
					 <select name="country_id" id="country_id" class="form-control">
					 <option value="">--select--</option>
				@foreach($countries as $country)
                    <option value="{{$country->id}}" @if(request('country_id') == $country->id) {{'selected="selected"'}} @endif>{{$country->name}}</option>
				@endforeach
                 </select></th>
                    <th><select name="state_id" id="state_id" class="form-control">
				<option value="">--select--</option>
				@if(request('country_id'))
				@foreach($states as $state)
                    <option value="{{$state->id}}" @if(request('state_id') == $state->id) {{'selected="selected"'}} @endif>{{$state->name}}</option>
				@endforeach
				@endif
                 </select></th>
					 <th><select name="status" id="status" class="form-control">
                    <option value="" @if(request('status') =='') {{'selected="selected"'}} @endif>Select</option>
                    <option value="1" @if(request('status') ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="2" @if(request('status') ==2) {{'selected="selected"'}} @endif >Inactive</option>
                 </select></th>
					 <th><select name="show_home" id="show_home" class="form-control">
                    <option value="" @if(request('show_home') =='') {{'selected="selected"'}} @endif>Select</option>
                    <option value="1" @if(request('show_home') ==1) {{'selected="selected"'}} @endif>Yes</option>
					          <option value="2" @if(request('show_home') ==2) {{'selected="selected"'}} @endif >No</option>
                 </select></th>
                    <th></th>
                   
                    <th><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('cities.index')}}">Clear</a></th>
                   
                  </form>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $record->name}}</td>
					 <td>{{ $record->country->name}}</td>
					 <td>{{ $record->state->name}}</td>
                     <td>{!! SiteHelpers::statusColor($record->status) !!}</td>
					  <td>{!! SiteHelpers::statusColorYesNo($record->show_home) !!}</td>
                    <td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
                    <td>{{ $record->updated_at ? date(config('app.date_format'),strtotime($record->updated_at)) : null }}</td>
                     <td><a class="btn btn-info btn-sm" href="{{route('cities.edit',$record->id)}}">
                              <i class="fas fa-pencil-alt">
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
 @include('inc.citystatecountryjs')
@endsection
