@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tag Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('countries.index') }}">Tags</a></li>
              <li class="breadcrumb-item active">Tag Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('tags.store') }}" enctype="multipart/form-data" method="post" class="form">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Tag</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Name: <span class="red">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control"  placeholder="Name" />
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
              </div>
			   <div class="form-group">
                <label for="inputName">Icon Css: <span class="red">*</span></label>
                <input type="text" id="icon_css" name="icon_css" value="{{ old('icon_css') }}" class="form-control"  placeholder="Icon Css" />
                @if ($errors->has('icon_css'))
                    <span class="text-danger">{{ $errors->first('icon_css') }}</span>
                @endif
              </div>
			   <div class="form-group">
                <label for="inputName">Image:</label>
                <input type="file" id="image" name="image"  class="form-control"  />
                @if ($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
				
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
          <a href="{{ route('tags.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Create</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection