@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Hotel Add To Vouchers(Voucher Code : {{$voucher->code}} )</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Hotels</li>
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
                <h3 class="card-title">Hotel Add To Vouchers</h3>
				<div class="card-tools">
				 <a href="{{ route('vouchers.index') }}" class="btn btn-sm btn-info">
                      <i class="fas fa-arrow-left"></i>
                      Back To Vouchers
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
                    <th>Mobile</th>
                    <th>Category</th>
                    <th>Address</th>
					 <th>Zone</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Zip Code</th>
                   <th></th>
                  </tr>
				  <tr>
                    <form id="filterForm" method="get" action="{{route('voucher.add.hotels',[$vid])}}" >
					 <th></th>
                    <th><input type="text" name="name" value="{{request('name')}}" class="form-control"  placeholder="Name" /></th>
                    <th></th>
					 <th></th>
                    <th></th>
                    <th><select name="zone_id" id="zone_id" class="form-control">
					 <option value="">--select--</option>
				@foreach($zones as $zone)
                    <option value="{{$zone->id}}" @if(request('zone_id') == $zone->id) {{'selected="selected"'}} @endif>{{$zone->name}}</option>
				@endforeach
                 </select></th>
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
                 <th><select name="city_id" id="city_id" class="form-control">
				<option value="">--select--</option>
				@if(request('state_id'))
				@foreach($cities as $city)
                    <option value="{{$city->id}}" @if(request('city_id') == $city->id) {{'selected="selected"'}} @endif>{{$city->name}}</option>
				@endforeach
				@endif
                 </select>
				 </th>
                
                   <th></th>
                    <th><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('voucher.add.hotels',[$vid])}}">Clear</a></th>
                   
                   
                  </form>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $record->name}}</td>
                    <td>{{ $record->mobile}}</td>
                    <td>{{ ($record->hotelcategory)?$record->hotelcategory->name:''}}</td>
                    <td>{{ $record->address}}</td>
					<td>{{ ($record->zone)?$record->zone->name:''}}</td>
                    <td>{{ ($record->country)?$record->country->name:''}}</td>
					<td>{{ ($record->state)?$record->state->name:''}}</td>
					<td>{{ ($record->city)?$record->city->name:''}}</td>
                    <td>{{ $record->zip_code}}</td>
                   <td>
				   <a class="btn btn-info btn-sm" href="{{route('voucher.hotel.view',[$record->id,$vid])}}">
                              <i class="fas fa-plus">
                              </i>
                              Add
                          </a></td>
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
 @include('inc.citystatecountryjs')
@endsection
