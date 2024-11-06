@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Country Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('countries.index') }}">Countries</a></li>
              <li class="breadcrumb-item active">Country Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('countries.update', $record->id) }}" enctype="multipart/form-data" method="post" class="form">
    <input type="hidden" name="_method" value="put">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Country</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Name: <span class="red">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') ?: $record->name }}" class="form-control"  placeholder="Name" />
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
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
                <img src="{{ url('/uploads/country/thumb/'.$record->image) }}" width="50"  alt="airlines-logo" />
              </div>
              @endif
			  </div>
			  <div class="form-group">
                <label for="inputName">Show Home Page: <span class="red">*</span></label>
                <select name="show_home" id="show_home" class="form-control">
                    <option value="1" @if($record->show_home ==1) {{'selected="selected"'}} @endif>Yes</option>
					<option value="0" @if($record->show_home ==0) {{'selected="selected"'}} @endif >No</option>
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
          <a href="{{ route('countries.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Update</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection
