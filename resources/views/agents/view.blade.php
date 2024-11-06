@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $agent->name }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('agents.index') }}">Agents</a></li>
              <li class="breadcrumb-item active">Agent Details</li>
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
              <h3 class="card-title">{{ $agent->name }}</h3>
            </div>
			
			<div class="card-body">
			
			
			<header class="profile-header">
          <div class="profile-image"> @if(!empty($agent->image))<img src="{{asset('uploads/users/thumb/'.$agent->image)}}"  />@endif </div>
			
				<div class="profile-content">
					<div class="row">
               <div class="col-lg-6 mb-3">
                <label for="inputName">Company Name:</label>
                {{ $agent->company_name }}
              </div>
			 
			      <div class="col-lg-6 mb-3">
                <label for="inputName">Email:</label>
                {{ $agent->email }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Code:</label>
                {{ $agent->code }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Mobile:</label>
                {{ $agent->mobile }}
              </div>
			 
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Department:</label>
                {{ $agent->department }}
              </div>
			   <div class="col-lg-6 mb-3">
                <label for="inputName">Phone Number:</label>
                {{ $agent->phone_number }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Address:</label>
                {{ $agent->address }}
              </div>
              <div class="form-group col-lg-6 mb-3">
                <label for="inputName">City:</label>
                {{$agent->city->name}}
              </div>
			  <div class="form-group col-lg-6 mb-3">
                <label for="inputName">State:</label>
                {{$agent->state->name}}
              </div>
              <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Country:</label>
                {{$agent->country->name}}
              </div>
              <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Postcode:</label>
                {{$agent->postcode}}
              </div>
			   <div class="form-group col-lg-6 mb-3">
                <label for="inputName">TRN No:</label>
                {{$agent->vat}}
              </div>
             <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Ticket Only:</label>
                {{$agent->ticket_only}}%
              </div>
			  
			  <div class="form-group col-lg-6 mb-3">
                <label for="inputName">SIC Transfer:</label>
                {{$agent->sic_transfer}}%
              </div>
			  
			  <div class="form-group col-lg-6 mb-3">
                <label for="inputName">PVT Transfer:</label>
                {{$agent->pvt_transfer}}%
              </div>
               
			  <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Agent Category:</label>
                {{$agent->agent_category}}
              </div>
               
			  <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Agent Credit Limit (Amount):</label>
                {{$agent->agent_credit_limit}}
              </div>
               
			  <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Sales Person:</label>
                {{$agent->sales_person}}
              </div>
             
              <div class="form-group col-lg-6 mb-3">
			        <label for="inputName">Status:</label>
					{!! SiteHelpers::statusColor($agent->is_active) !!}
              </div>
            
          </div>
			
				</div>
          
			
				</header>
		
			<div class="row">
			 <div class="form-group col-md-12 mt-3">
				@if(!empty($agentAdditionalUsers))
                <table id="myTable" class="table table-bordered ">
					  <thead>
					   <tr>
                    <th colspan="5" ><h3>Additional Contact</h3></th>
                  </tr>
						<tr>
						  <th>Name</th>
						  <th>Department</th>
						  <th>Mobile</th>
						  <th>Phone</th>
						  <th>Email</th>
						</tr>
					  </thead>
					  <tbody>
					  
					
						 @foreach($agentAdditionalUsers as $k => $agentAdditionalUser)
							<tr>
						  <td>{{$agentAdditionalUser->name}}</td>
						  <td>{{$agentAdditionalUser->department}}</td>
						  <td>{{$agentAdditionalUser->mobile}}</td>
						  <td>{{$agentAdditionalUser->phone}}</td>
						  <td>{{$agentAdditionalUser->email}}</td>
						</tr>
						@endforeach
					
					  </tbody>
					</table>
				@endif
					
              </div>
			  
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
							<th>Ticket Only</th>
							<th>SIC Transfer</th>
							<th>PVT Transfer</th>
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

        <div class="form-group col-md-12 mt-3">
				@if(!empty($creditLogs))
                <table id="myTable" class="table table-bordered ">
					  <thead>
					   <tr>
                    <th colspan="5" ><h3>Credit Update Log</h3></th>
                  </tr>
						<tr>
						  <th>Updated On</th>
						  <th>Updated By</th>
						  <th>Action</th>
						  <th>Value</th>
						 
						</tr>
					  </thead>
					  <tbody>
					  
					
						 @foreach($creditLogs as $k => $creditLog)

             @php 
             $updatedby = "";
             $updatedby = SiteHelpers::getUserName($creditLog->updated_by);

             @endphp
							<tr>
              <td>{{ $creditLog->created_at ? date("M d Y, H:i:s",strtotime($creditLog->created_at)) : null }}</td>
              <td>{{ $updatedby }}</td>
						  <td>{{$creditLog->input}}</td>
						  <td>{{$creditLog->input_vaue}}</td>
						</tr>
						@endforeach
					
					  </tbody>
					</table>
				@endif
					
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