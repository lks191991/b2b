@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Edit Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('profile-edit-post', $user->id) }}" method="post" class="form" enctype="multipart/form-data">
    
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit User</h3>
            </div>
            <div class="card-body">
              <div class="form-group col-md-6">
                <label for="inputName">First Name: <span class="red">*</span></label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') ?: $user->name }}" class="form-control"  placeholder="Name" />
                @if ($errors->has('first_name'))
                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                @endif
              </div>
			  <div class="form-group">
                <label for="inputName">Last Name: <span class="red">*</span></label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') ?: $user->lname }}" class="form-control"  placeholder="Last name" />
                @if ($errors->has('last_name'))
                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="inputName">Mobile Number:</label>
                <input type="text" id="mobile" name="mobile" value="{{ old('mobile') ?: $user->mobile }}" class="form-control"  placeholder="Mobile Number" />
                @if ($errors->has('mobile'))
                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="inputName">Email Address: <span class="red">*</span></label>
                <input type="text" id="email" name="email" readonly value="{{ old('email') ?: $user->email }}" class="form-control"  placeholder="Email Address" />
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
          
              
              <div class="form-group">
                <label for="inputName">Profile Image:</label>
                <input type="file" name="image" id="image" class="form-control" /> 
                @if ($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
              </div>
              @if($user->image)
              <div class="form-group">
                <img src="{{ url('/uploads/users/thumb/'.$user->image) }}"  alt="profile-image" />
              </div>
              @endif

             
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Update</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection