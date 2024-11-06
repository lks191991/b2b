@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $supplier->name }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">Suppliers</a></li>
              <li class="breadcrumb-item active">Supplier Details</li>
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
              <h3 class="card-title">{{ $supplier->name }}</h3>
            </div>
			
			<div class="card-body">
			
			
			<header class="profile-header">
          <div class="profile-image"> @if(!empty($supplier->image))<img src="{{asset('uploads/suppliers/thumb/'.$supplier->image)}}"  />@endif </div>
			
				<div class="profile-content">
					<div class="row">
              <div class="col-lg-6 mb-3">
                <label for="inputName">Service Type:</label>
                {{ $supplier->service_type }}
              </div>
			 
			      <div class="col-lg-6 mb-3">
                <label for="inputName">Email:</label>
                {{ $supplier->email }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Code:</label>
                {{ $supplier->code }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Mobile:</label>
                {{ $supplier->mobile }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Company Name:</label>
                {{ $supplier->company_name }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Department:</label>
                {{ $supplier->department }}
              </div>
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Phone Number:</label>
                {{ $supplier->phone }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Address:</label>
                {{ $supplier->address }}
              </div>
              <div class="form-group col-lg-6 mb-3">
                <label for="inputName">City:</label>
                {{$supplier->city->name}}
              </div>
			  <div class="form-group col-lg-6 mb-3">
                <label for="inputName">State:</label>
                {{$supplier->state->name}}
              </div>
              <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Country:</label>
                {{$supplier->country->name}}
              </div>
              <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Postcode:</label>
                {{$supplier->postcode}}
              </div>
			  
			 
             
              <div class="form-group col-lg-6 mb-3">
			        <label for="inputName">Status:</label>
					{!! SiteHelpers::statusColor($supplier->is_active) !!}
              </div>
            
          </div>	
				</div>
          
			
				</header>
		<div class="row">
				<div class="form-group col-lg-12 mb-3">
					<table id="example1" class="table table-bordered table-striped">
                  <thead>
				  <tr>
                    <th colspan="2" ><h3>Markup</h3></th>
                  </tr>
                  <tr>
                    <th>Activity Name</th>
					<th>Price</th>
                  </tr>
                  </thead>
                  <tbody>
				   
                  @foreach ($markups as $activityName => $record)
                  <tr>
					
                    <td>{{ $activityName }}</td>
					<td>
						<table class="table table-bordered table-striped">
						<tr>
							<th>Variant Code</th>
							<th>Adult</th>
							<th>Child</th>
							<th>Infant</th>
						</tr>
						@foreach($record as $variant_code => $variant)
						@php
						$ticket_only = (isset($variant['ticket_only']))?$variant['ticket_only']:'';
						$sic_transfer = (isset($variant['sic_transfer']))?$variant['sic_transfer']:'';
						$pvt_transfer = (isset($variant['pvt_transfer']))?$variant['pvt_transfer']:'';
						
						@endphp
						<tr>
						<td>{{ $variant_code }}</td>
						<td>
						{{$ticket_only}}
						</td>
						<td>
						{{$sic_transfer}}
						</td>
						<td>
						{{$pvt_transfer}}
						</td>
						</tr>
						@endforeach
						</table>
					</td>
                  </tr>
				 
                  @endforeach

                  </tbody>
                 
                </table>
				</div>
			</div>
			
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