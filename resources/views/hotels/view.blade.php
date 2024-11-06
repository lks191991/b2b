@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Hotel : {{ $hotel->name }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('hotels.index') }}">Hotels</a></li>
              <li class="breadcrumb-item active">Hotel Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-12">
		
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{ $hotel->name }}</h3>
            </div>
			
			<div class="card-body">
			
			
			<header class="profile-header">
          <div class="profile-image" style="border-radius:0px;height:auto;margin-bottom:258px"> @if(!empty($hotel->image))<img src="{{asset('uploads/hotels/'.$hotel->image)}}"  />@endif </div>
				<div class="profile-content">
				
					<div class="row">
              
			 
			      <div class="col-lg-4 mb-3">
                <label for="inputName">Brand Name:</label>
                {{ $hotel->brand_name }}
              </div>
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Formerly Name:</label>
                {{ $hotel->formerly_name }}
              </div>
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Translates Name:</label>
                {{ $hotel->translates_name }}
              </div>
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Mobile:</label>
                {{ $hotel->mobile }}
              </div>
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Address Line 1:</label>
                {{ $hotel->address }}
              </div>
			   <div class="col-lg-4 mb-3">
                <label for="inputName">Address Line 2:</label>
                {{ $hotel->address2 }}
              </div>
			  <div class="col-lg-4 mb-3">
                <label for="inputName">Hotel Category:</label>
                {{ $hotel->hotelcategory->name }}
              </div>
              <div class="form-group col-lg-4 mb-3">
                <label for="inputName">City:</label>
                {{($hotel->city)?$hotel->city->name:''}}
              </div>
			  <div class="form-group col-lg-4 mb-3">
                <label for="inputName">State:</label>
                {{($hotel->state)?$hotel->state->name:''}}
              </div>
              <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Country:</label>
                {{($hotel->country)?$hotel->country->name:''}}
              </div>
              <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Zip Code:</label>
                {{$hotel->zip_code}}
              </div>
			   <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Zone:</label>
               {{($hotel->zone)?$hotel->zone->name:''}}
              </div>
			   <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Location:</label>
                {{$hotel->location}}
              </div>
			  <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Longitude:</label>
                {{$hotel->longitude}}
              </div>
			  <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Latitude:</label>
                {{$hotel->latitude}}
              </div>
			  <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Overview:</label>
                {{$hotel->overview}}
              </div>
			  <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Continent Name:</label>
                {{$hotel->continent_name}}
              </div>
			  <div class="form-group col-lg-4 mb-3">
                <label for="inputName">Accommodation Type:</label>
                {{$hotel->accommodation_type}}
              </div>
             
              <div class="form-group col-lg-4 mb-3">
			        <label for="inputName">Status:</label>
					{!! SiteHelpers::statusColor($hotel->status) !!}
              </div>
            
          </div>	
				</div>
          
			
				</header>
		
			
          <!-- /.card-body --> 
        </div>
		
           
          </div>
          <!-- /.card -->
        </div>
      </div>
  
    </section>
    <!-- /.content -->
@endsection



@section('scripts')


@endsection