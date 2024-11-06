@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Content Setting Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">Content Settings</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <form action="{{route('pages.update', $page->id)}}" method = "POST">
    <input type="hidden" name="_method" value="put">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit</h3>
            </div>
            <div class="card-body row">
              <div class="form-group col-md-12">
                <label for="inputName">Title:</label>
                <input type="text" name="title" readonly placeholder="Title" class="form-control" value="{{$page->title}}" required>
                @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-12">
                <label for="inputName">Content: <span class="red">*</span></label>
                <textarea name="page_content" id="content" class="form-control text-editor" placeholder="Content">{{$page->page_content}}</textarea>
                @if ($errors->has('page_content'))
                <span class="text-danger">{{ $errors->first('page_content') }}</span>
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
          <a href="{{ route('pages.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Update</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
@include('inc.ckeditor')
@endsection