@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Change Password</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Change Password</li>
        </ol>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->
    <div class="card card-default">
        <!-- /.card-header -->
        <div class="card-body">
        <div class="row">
            <div class="col-md-12">
            @include('inc.messages')
            <form role="form" action="{{route('profile.save')}}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Old Password: <span class="red">*</span></label>
                <input type="password" class="form-control" id="OldPassword" name="OldPassword" placeholder="Old Password" />
            </div>
            <div class="form-group">
                <label>Password: <span class="red">*</span></label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" />(Password Format : 8 characters, 1 upper case & 1 number.)
            </div>
            <div class="form-group">
                <label>Confirm New Password: <span class="red">*</span></label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm New Password" />
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Update</button>
				<a href="{{ route('dashboard') }}" class="btn btn-warning">Back</a>
            </div>
            </form>
            </div>
        </div>
        <!-- /.row -->
        </div>
        <!-- /.card-body -->

    </div>
    <!-- /.card -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
