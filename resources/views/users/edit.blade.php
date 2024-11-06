@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
              <li class="breadcrumb-item active">User Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('users.update', $user->id) }}" method="post" class="form" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="put">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit User</h3>
            </div>
		
            <div class="card-body row">
				<div class="form-group col-md-6">
                <label for="inputName">Role: <span class="red">*</span></label>
                <select name="role_id" id="role_id" class="form-control">
                    <option value = "">-Select Role-</option>
                    @foreach($roles as $role)
                      <option value="{{ $role->id }}" @if($role->id == $user->role_id) selected="selected" @endif >{{ $role->name }}</option>
                    @endforeach
                 </select>
                @if ($errors->has('role_id'))
                    <span class="text-danger">{{ $errors->first('role_id') }}</span>
                @endif
              </div>
              <div class="form-group col-md-6">
                <label for="inputName ">First Name: <span class="red">*</span></label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') ?: $user->name }}" class="form-control"  placeholder="First Name" />
                @if ($errors->has('first_name'))
                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Last Name: <span class="red">*</span></label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') ?: $user->lname }}" class="form-control"  placeholder="Last Name" />
                @if ($errors->has('last_name'))
                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                @endif
              </div>
            
              <div class="form-group col-md-6">
                <label for="inputName">Email Address: <span class="red">*</span></label>
                <input type="text" id="email" name="email" value="{{ old('email') ?: $user->email }}" class="form-control"  placeholder="Email Address" />
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
			 
            <div class="form-group col-md-6">
			  <label for="inputName">Country: <span class="red">*</span></label>
                <select name="country_id" id="country_id" class="form-control">
				<option value="">--select--</option>
				@foreach($countries as $country)
                    <option value="{{$country->id}}" @if($user->country_id == $country->id) {{'selected="selected"'}} @endif>{{$country->name}}</option>
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
                    <option value="{{$state->id}}" @if($user->state_id == $state->id) {{'selected="selected"'}} @endif>{{$state->name}}</option>
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
                    <option value="{{$city->id}}" @if($user->city_id == $city->id) {{'selected="selected"'}} @endif>{{$city->name}}</option>
				@endforeach
				</select>
              </div>
			  
              <div class="form-group col-md-6">
                <label for="inputName">Postcode:</label>
                <input type="text" id="postcode" name="postcode" value="{{ old('postcode') ?: $user->postcode }}" class="form-control"  placeholder="Postcode" />
                @if ($errors->has('postcode'))
                    <span class="text-danger">{{ $errors->first('postcode') }}</span>
                @endif
              </div>
              
			   
              <div class="form-group col-md-6">
                <label for="inputName">Profile Image:</label>
                <input type="file" name="image" id="image" class="form-control" /> 
                @if ($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
              </div>
              @if($user->image)
              <div class="form-group col-md-6">
                <img src="{{ url('/uploads/users/thumb/'.$user->image) }}"  alt="profile-image" />
              </div>
              @endif
			 <div class="form-group col-md-6">
			  @php
			 $zones = config("constants.agentZone");
			  @endphp
                <label for="inputName">Zone:</label>
                <select name="zone" id="zone" class="form-control">
				<option value="">--select--</option>
				@foreach($zones as $zone)
                    <option value="{{$zone}}" @if($user->zone == $zone) {{'selected="selected"'}} @endif>{{$zone}}</option>
				@endforeach
                 </select>
				 @if ($errors->has('zone'))
                    <span class="text-danger">{{ $errors->first('zone') }}</span>
                @endif
              </div>
              <div class="form-group col-md-6">
                <label for="inputName">Status: <span class="red">*</span></label>
                <select name="is_active" id="is_active" class="form-control">
                    <option value="1" @if($user->is_active ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="0" @if($user->is_active ==0) {{'selected="selected"'}} @endif >Inactive</option>
                 </select>
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
          <button type="submit" class="btn btn-success float-right">Update</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
	var country = "{{$user->country_id}}";
	var oldstate = "{{$user->state_id}}";
	var oldcity = "{{$user->city_id}}";
	var pan_no_file = "{{$user->pan_no_file}}";
	var trade_license_no_file = "{{$user->trade_license_no_file}}";
	$(".india").css("display", "none");
	$(".uae").css("display", "none");
	
		
		$("body #country_id_signup").on("change", function () {
            var country_id = $(this).val();
				if (country_id == 1) {
				$(".india").css("display", "none");
				$(".uae").css("display", "block");
				$("#pan_no, #pan_no_file").attr("required", false);
				//$("#trade_license_no, #trn_no").attr("required", true);
				if(trade_license_no_file == ''){
					$("#trade_license_no_file").attr("required", true);
				}
				
				} else if (country_id == 94) {
				$(".india").css("display", "block");
				$(".uae").css("display", "none");
				$("#pan_no").attr("required", true);
				if(pan_no_file == ''){
					$("#pan_no_file").attr("required", true);
				}
				$("#trade_license_no, #trade_license_no_file , #trn_no").attr("required", false);
				}
			$("#state_id").prop("disabled",true);
			$("#city_id").prop("disabled",true);
            $.ajax({
                type: "POST",
                url: '{{ route("state.list") }}',
                data: {'country_id': country_id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
					 $('#state_id').html('<option value="">--select--</option>');
					$.each(data, function (key, value) {
                            $("#state_id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
					$('#state_id').val(oldstate).prop('selected', true);
					$("#state_id").prop("disabled",false);
					$('#city_id').html('<option value="">--select--</option>');
					$("#city_id").prop("disabled",false);
					if(oldstate){
					$("body #state_id").trigger("change");
					}
                }
            });
        });
		
		$("body #state_id").on("change", function () {
            var state_id = $(this).val();
			$("#city_id").prop("disabled",true)
            $.ajax({
                type: "POST",
                url: '{{ route("city.list") }}',
                data: {'state_id': state_id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
					 $('#city_id').html('<option value="">--select--</option>');
					$.each(data, function (key, value) {
                            $("#city_id").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
					$("#city_id").prop("disabled",false);
					$('#city_id').val(oldcity).prop('selected', true);
                }
            });
        });
		
	if(country){
		$("body #country_id_signup").trigger("change");
	}
	
	
	});
	</script>
@endsection