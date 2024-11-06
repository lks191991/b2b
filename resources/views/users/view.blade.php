@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $user->full_name }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
              <li class="breadcrumb-item active">User Details</li>
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
              <h3 class="card-title">{{ $user->full_name }}</h3>
            </div>
			
			<div class="card-body">
			
			
			<header class="profile-header">
          <div class="profile-image"> @if(!empty($user->image))<img src="{{asset('uploads/users/thumb/'.$user->image)}}"  />@endif </div>
			
				<div class="profile-content">
					<div class="row">
              
			 
			      <div class="col-lg-6 mb-3">
                <label for="inputName">Email:</label>
                {{ $user->email }}
              </div>
             
              <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Country:</label>
                {{($user->country)?$user->country->name:''}}
              </div>
			   <div class="form-group col-lg-6 mb-3">
                <label for="inputName">State:</label>
                
				 {{($user->state)?$user->state->name:''}}
              </div>
			   <div class="form-group col-lg-6 mb-3">
                <label for="inputName">City:</label>
                
				 {{($user->city)?$user->city->name:''}}
              </div>
              <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Postcode:</label>
                {{$user->postcode}}
              </div>
             
              <div class="form-group col-lg-6 mb-3">
			        <label for="inputName">Status:</label>
					{!! SiteHelpers::statusColor($user->is_active) !!}
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