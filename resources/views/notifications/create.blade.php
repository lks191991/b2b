@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Notifications Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('notifications.index') }}">Countries</a></li>
              <li class="breadcrumb-item active">Notifications Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('notifications.store') }}" enctype="multipart/form-data" method="post" class="form">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Notification</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Title: <span class="red">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control"  placeholder="Title" />
                @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
              </div>
			   <div class="form-group ">
                <label for="inputName">Image: <span class="red">*</span></label>
                <input type="file" id="image" name="image"  class="form-control"  />
                @if ($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
				
              </div>
              <div class="form-group ">
                <label for="inputName">Description: <span class="red">*</span></label>
				
                <textarea placeholder="Description" name="content" cols="50" rows="10" id="content" class="form-control box-size text-editor">{{ old('content')}}</textarea>
                @if ($errors->has('content'))
                    <span class="text-danger">{{ $errors->first('content') }}</span>
                @endif
              </div>
			   <div class="form-group">
                <label for="inputName">Type: <span class="red">*</span></label>
                <select name="type" required id="type" class="form-control">
                <option value="" >Select One</option>
                    <option value="1" @if(old('type') ==1) {{'selected="selected"'}} @endif>Notification</option>
					      <option value="2" @if(old('type') ==2) {{'selected="selected"'}} @endif >Announcements</option>
                 </select>
              </div>
			   <div class="form-group">
                <label for="inputName">Status: <span class="red">*</span></label>
                <select name="status" id="status" class="form-control">
                    <option value="1" @if(old('status') ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="0" @if(old('status') ==0) {{'selected="selected"'}} @endif >Inactive</option>
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
          <a href="{{ route('notifications.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Create</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection
@section('scripts')