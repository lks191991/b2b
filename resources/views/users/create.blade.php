@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
              <li class="breadcrumb-item active">User Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('users.store') }}" method="post" class="form">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add User</h3>
            </div>
            <div class="card-body">
			
			  <div class="form-group">
                <label for="inputName">Role: <span class="red">*</span></label>
                <select name="role_id" id="role_id" class="form-control">
                    <option value = "">-Select Role-</option>
                    @foreach($roles as $role)
                      <option value="{{ $role->id }}" @if($role->id == old('role_id')) selected="selected" @endif >{{ $role->name }}</option>
                    @endforeach
                 </select>
                @if ($errors->has('role_id'))
                    <span class="text-danger">{{ $errors->first('role_id') }}</span>
                @endif
              </div>
			
				
              <div class="form-group">
                <label for="inputName">First Name: <span class="red">*</span></label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="form-control"  placeholder="First Name" />
                @if ($errors->has('first_name'))
                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                @endif
              </div>
			<div class="form-group">
                <label for="inputName">Last Name: <span class="red">*</span></label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="form-control"  placeholder="Last Name" />
                @if ($errors->has('last_name'))
                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="inputName">Email Address: <span class="red">*</span></label>
                <input type="text" id="email" name="email" value="{{ old('email') }}" class="form-control"  placeholder="Email Address" />
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
			        <div class="form-group">
                <label for="inputName">Password: <span class="red">*</span></label>
                <input type="button" class="generate-pass button" value="Generate" onClick="randomPassword(10);" />
                <input type="password" id="password" name="password" value="{{ old('password') }}" class="form-control pass"  placeholder="Password" /><i class="far fa-eye" id="togglePassword"></i>
                @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
              </div>
			 <div class="form-group">
			  @php
				$zones = config("constants.agentZone");
			  @endphp
                <label for="inputName">Zone: </label>
                <select name="zone" id="zone" class="form-control">
				<option value="">--select--</option>
				@foreach($zones as $zone)
                    <option value="{{$zone}}" @if(old('zone') == $zone) {{'selected="selected"'}} @endif>{{$zone}}</option>
				@endforeach
                 </select>
				 @if ($errors->has('zone'))
                    <span class="text-danger">{{ $errors->first('zone') }}</span>
                @endif
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Create</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
 <!-- Script -->
 <script type="text/javascript">
    function randomPassword(length) {
        var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
        var pass = "";
        for (var x = 0; x < length; x++) {
            var i = Math.floor(Math.random() * chars.length);
            pass += chars.charAt(i);
        }
       // myform.row_password.value = pass;
        $('#password').val(pass);
    }

    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
  
    togglePassword.addEventListener('click', function (e) {
      // toggle the type attribute
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      // toggle the eye slash icon
      this.classList.toggle('fa-eye-slash');
  });
       

    $(document).ready(function(){
		var roelid = $('#role_id').val();
	$('#company_dd').css("display","none");
	if(roelid==4)
	{
		$('#company_dd').css("display","block");
	}
	
     $('#role_id').on("change",function() {
		
    if($(this).val()=='4')
	{
		$('#company_dd').css("display","block")
	}
	else
	{
		$('#company_dd').css("display","none");
	}
	
	});

    });
  </script>   
  
@if ($errors->has('company_name'))
	 <script type="text/javascript">
	 $(document).ready(function(){
	$('#company_dd').css("display","block");
    });
  </script> 
@endif
@endsection
