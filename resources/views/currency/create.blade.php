@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Currency Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('countries.index') }}">Currencies</a></li>
              <li class="breadcrumb-item active">Currency Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('currency.store') }}" method="post" class="form">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Currency</h3>
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
                <label for="inputName">Code: <span class="red">*</span></label>
                <input type="text" id="code" name="code" value="{{ old('code') }}" class="form-control"  placeholder="Code" />
                @if ($errors->has('code'))
                    <span class="text-danger">{{ $errors->first('code') }}</span>
                @endif
              </div>
			   <div class="form-group">
                <label for="inputName">Currency Value (From Default Currency): <span class="red">*</span></label>
                <input type="text" id="value" name="value" value="{{ old('value') }}" class="form-control onlynumbrf"  placeholder="Value" />
                @if ($errors->has('value'))
                    <span class="text-danger">{{ $errors->first('value') }}</span>
                @endif
              </div>
			   <div class="form-group">
                <label for="inputName">Markup Value in Default Currency: <span class="red">*</span></label>
                <input type="text" id="markup_value" name="markup_value" value="{{ old('markup_value') }}" class="form-control onlynumbrf"  placeholder="Markup Value in Default Currency" />
                @if ($errors->has('value'))
                    <span class="text-danger">{{ $errors->first('value') }}</span>
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
          <a href="{{ route('currency.index') }}" class="btn btn-secondary">Cancel</a>
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
    $(document).ready(function() {
		$(document).on('input', '.onlynumbrf', function() {
		$(this).val(function(index, value) {
			return value.replace(/[^0-9.]/g, '');
		});

		if (isNaN(parseFloat($(this).val()))) {
			$(this).val(0);
		}
	});
		});
		  </script>   
@endsection