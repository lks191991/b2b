@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Hotel Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('hotels.index') }}">Hotels</a></li>
              <li class="breadcrumb-item active">Hotel Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('hotels.update', $record->id) }}" method="post" class="form" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="put" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Hotel</h3>
            </div>
            <div class="card-body row">
               <div class="form-group col-md-6">
                <label for="inputName">Name: <span class="red">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') ?: $record->name }}" class="form-control"  placeholder="Name" />
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-6">
                <label for="inputName">Brand Name:</label>
                <input type="text" id="brand_name" name="brand_name" value="{{ old('brand_name') ?: $record->brand_name }}" class="form-control"  placeholder="Brand Name" />
                @if ($errors->has('brand_name'))
                    <span class="text-danger">{{ $errors->first('brand_name') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Formerly Name:</label>
                <input type="text" id="formerly_name" name="formerly_name" value="{{ old('formerly_name') ?: $record->formerly_name }}" class="form-control"  placeholder="Formerly Name" />
                @if ($errors->has('formerly_name'))
                    <span class="text-danger">{{ $errors->first('formerly_name') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-6">
                <label for="inputName">Translates Name:</label>
                <input type="text" id="translates_name" name="translates_name" value="{{ old('translates_name') ?: $record->translates_name }}" class="form-control"  placeholder="Translates Name" />
                @if ($errors->has('translates_name'))
                    <span class="text-danger">{{ $errors->first('translates_name') }}</span>
                @endif
              </div>
               <div class="form-group col-md-6">
                <label for="inputName">Mobile: <span class="red">*</span></label>
                <input type="text" id="mobile" name="mobile" value="{{ old('mobile') ?: $record->mobile }}" class="form-control"  placeholder="Mobile" />
                @if ($errors->has('mobile'))
                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                @endif
              </div>
                <div class="form-group col-md-6">
                <label for="inputName">Address Line 1: <span class="red">*</span></label>
                <input type="text" id="address" name="address" value="{{ old('address') ?: $record->address }}" class="form-control"  placeholder="Address Line 1" />
                @if ($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Address Line 2:</label>
                <input type="text" id="address2" name="address2" value="{{ old('address2') ?: $record->address2 }}" class="form-control"  placeholder="Address Line 2" />
                @if ($errors->has('address2'))
                    <span class="text-danger">{{ $errors->first('address2') }}</span>
                @endif
              </div>
			   @if($record->image)
			  <div class="form-group col-md-4">
			@else
				<div class="form-group col-md-6">
				@endif
                <label for="inputName">Image:</label>
                <input type="file" id="image" name="image"  class="form-control"   />
                @if ($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
              </div>
			   @if($record->image)
              <div class="form-group col-md-2">
                <img src="{{ url('/uploads/hotels/thumb/'.$record->image) }}" width="50"  alt="hotels-logo" style="margin-top: 32px;" />
              </div>
              @endif
               <div class="form-group col-md-6">
                
                <label for="inputName">Hotel Category: <span class="red">*</span></label>
                 <select name="hotel_category_id" id="hotel_category_id" class="form-control">
                  <option value="">--select--</option>
                  @foreach($hotelcategories as $hotelcategory)
                              <option value="{{$hotelcategory->id}}" @if($record->hotel_category_id == $hotelcategory->id) {{'selected="selected"'}} @endif>{{$hotelcategory->name}}</option>
                  @endforeach
                          </select>
               
                @if ($errors->has('hotel_category_id'))
                    <span class="text-danger">{{ $errors->first('hotel_category_id') }}</span>
                @endif
              </div>
			<div class="form-group col-md-6">
			  <label for="inputName">Country: <span class="red">*</span></label>
                <select name="country_id" id="country_id" class="form-control">
				<option value="">--select--</option>
				@foreach($countries as $country)
                    <option value="{{$country->id}}" @if($record->country_id == $country->id) {{'selected="selected"'}} @endif>{{$country->name}}</option>
				@endforeach
                 </select>
				 @if ($errors->has('country_id'))
                    <span class="text-danger">{{ $errors->first('country_id') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-6">
			  <label for="inputName">State: <span class="red">*</span></label>
                <select name="state_id" id="state_id" class="form-control">
				<option value="">--select--</option>
				@foreach($states as $state)
                    <option value="{{$state->id}}" @if($record->state_id == $state->id) {{'selected="selected"'}} @endif>{{$state->name}}</option>
				@endforeach
                 </select>
				 @if ($errors->has('state_id'))
                    <span class="text-danger">{{ $errors->first('state_id') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-6">
                <label for="inputName">City: <span class="red">*</span></label>
                <select name="city_id" id="city_id" class="form-control">
				<option value="">--select--</option>
        	@foreach($cities as $city)
                    <option value="{{$city->id}}" @if($record->city_id == $city->id) {{'selected="selected"'}} @endif>{{$city->name}}</option>
				@endforeach
				</select>
              </div>
               <div class="form-group col-md-6">
                <label for="inputName">Zip Code: <span class="red">*</span></label>
                <input type="text" id="zip_code" name="zip_code"  value="{{ old('zip_code') ?: $record->zip_code }}" class="form-control"   />
                @if ($errors->has('zip_code'))
                    <span class="text-danger">{{ $errors->first('zip_code') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-6">
			  <label for="inputName">Zone: <span class="red">*</span></label>
                <select name="zone_id" id="zone_id" class="form-control">
				<option value="">--select--</option>
				@foreach($zones as $zone)
                    <option value="{{$zone->id}}" @if($record->zone_id == $zone->id) {{'selected="selected"'}} @endif>{{$zone->name}}</option>
				@endforeach
                 </select>
				 @if ($errors->has('zone_id'))
                    <span class="text-danger">{{ $errors->first('zone_id') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-6">
                <label for="inputName">Location: <span class="red">*</span></label>
                <input type="text" id="location" name="location"  value="{{ old('location') ?: $record->location }}" class="form-control"   />
                @if ($errors->has('location'))
                    <span class="text-danger">{{ $errors->first('location') }}</span>
                @endif
              </div>
              <div class="form-group col-md-6">
                <label for="inputName">Longitude:</label>
                <input type="text" id="longitude" name="longitude" value="{{ old('longitude') ?: $record->longitude }}" class="form-control"  placeholder="Longitude" />
                @if ($errors->has('longitude'))
                    <span class="text-danger">{{ $errors->first('longitude') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Latitude:</label>
                <input type="text" id="latitude" name="latitude" value="{{ old('latitude') ?: $record->latitude }}" class="form-control"  placeholder="Latitude" />
                @if ($errors->has('latitude'))
                    <span class="text-danger">{{ $errors->first('latitude') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Overview:</label>
                <input type="text" id="overview" name="overview" value="{{ old('overview') ?: $record->overview }}" class="form-control" placeholder="Overview"  />
                @if ($errors->has('overview'))
                    <span class="text-danger">{{ $errors->first('overview') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Continent Name:</label>
                <input type="text" id="continent_name" name="continent_name" value="{{ old('continent_name') ?: $record->continent_name }}" class="form-control" placeholder="Continent Name"  />
                @if ($errors->has('continent_name'))
                    <span class="text-danger">{{ $errors->first('continent_name') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Accommodation Type:</label>
                <input type="text" id="accommodation_type" name="accommodation_type" value="{{ old('accommodation_type') ?: $record->accommodation_type }}" class="form-control"  placeholder="Accommodation Type" />
                @if ($errors->has('accommodation_type'))
                    <span class="text-danger">{{ $errors->first('accommodation_type') }}</span>
                @endif
              </div>
              <div class="form-group col-md-6">
                <label for="inputName">Status: <span class="red">*</span></label>
                <select name="status" id="status" class="form-control">
                    <option value="1" @if($record->status ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="0" @if($record->status ==0) {{'selected="selected"'}} @endif >Inactive</option>
                 </select>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12 mb-3">
          <a href="{{ route('hotels.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Update</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
 @include('inc.citystatecountryjs')
@endsection