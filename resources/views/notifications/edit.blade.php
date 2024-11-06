@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Notification Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('notifications.index') }}">Notifications</a></li>
              <li class="breadcrumb-item active">Notification Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('notifications.update', $record->id) }}" enctype="multipart/form-data" method="post" class="form">
    <input type="hidden" name="_method" value="put">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Notifications</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Title: <span class="red">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') ?: $record->title }}" class="form-control"  placeholder="Title" />
                @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
              </div>
			  <div class="row">
			  @if($record->image)
			  <div class="form-group col-md-11">
			@else
				<div class="form-group col-md-12">
				@endif
                <label for="inputName">Image: <span class="red">*</span></label>
                <input type="file" id="image" name="image"  class="form-control"   />
                @if ($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
              </div>
			   @if($record->image)
              <div class="form-group col-md-1">
				<br>
                <img src="{{ url('/uploads/notification/thumb/'.$record->image) }}" width="50"  alt="airlines-logo" />
              </div>
              @endif
			  </div>
        <div class="form-group col-md-6">
                <label for="inputName">Description: <span class="red">*</span></label>
				
                <textarea placeholder="Description" name="content" cols="50" rows="10" id="content" class="form-control box-size text-editor">{{ old('content')?:$record->content }}</textarea>
                @if ($errors->has('content'))
                    <span class="text-danger">{{ $errors->first('content') }}</span>
                @endif
              </div>
			  <div class="form-group">
                <label for="inputName">Type: <span class="red">*</span></label>
                <select name="type" id="type" class="form-control">
                    <option value="1" @if($record->type ==1) {{'selected="selected"'}} @endif>Notification</option>
					<option value="2" @if($record->type ==2) {{'selected="selected"'}} @endif >Announcements</option>
                 </select>
              </div>
              <div class="form-group">
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
        <div class="col-12">
          <a href="{{ route('notifications.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Update</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection
