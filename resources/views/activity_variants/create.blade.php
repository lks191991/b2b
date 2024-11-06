@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Activity Variant</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('activity.variants') }}">Activity Variants</a></li>
              <li class="breadcrumb-item active">Activity Variant Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
	@include('inc/messages')
    <form action="{{ route('activity.variants.store') }}" method="post" class="form" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Activity Variant</h3>
            </div>
            <div class="card-body row">
			
				   {{ csrf_field() }}
				    <div class="form-group col-md-10">
                <label for="inputName">Display Name: <span class="red">*</span></label>
                <input type="text" id="code" name="code" value="{{ old('code') }}" class="form-control"  placeholder="Display Name" />
                @if ($errors->has('code'))
                    <span class="text-danger">{{ $errors->first('code') }}</span>
                @endif
              </div>
              <div class="form-group col-md-2">
                <label for="inputName">Is Popular:</label>
                <select name="is_popular" id="is_popular" class="form-control">
                    <option value="2" @if(old('is_popular') ==2) {{'selected="selected"'}} @endif>Yes</option>
					          <option value="1" @if(old('is_popular') ==1) {{'selected="selected"'}} @endif >No</option>
                 </select>
              </div>
			  
				   <div class="col-md-6">
                <table id="" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                  <th></th>
                    <th>Activity Name</th>
				
                  </tr>
                  </thead>
                  <tbody>
				  
                  @foreach ($activities as $record)
				  
                  <tr>
                  <td><input type="radio" name="activity_id" {{ (old('activity_id') == $record->id) ? 'checked' : '' }} value="{{ $record->id }}" /></td>
                    <td>{{ $record->title}}</td>
				
                  </tr>
				 
                  @endforeach
				  
				  
                  </tbody>
                 
                </table>
				</div>
				
				<div class="col-md-6">
                <table id="" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                  <th></th>
                    <th>Variant Name</th>
				
                  </tr>
                  </thead>
                  <tbody>
				  
                  @foreach ($variants as $record)
				  @php
				  $varid = (!empty(old('variant_id')))?old('variant_id'):[];
				  @endphp
                  <tr>
                  <td><input type="checkbox" name="variant_id[]" value="{{ $record->id }}" {{ (in_array($record->id,$varid)) ? 'checked' : '' }} />
</td>
                    <td>{{ $record->title}} / {{ $record->code}}</td>
				
                  </tr>
				 
                  @endforeach
				  
				  
                  </tbody>
                 
                </table>
				</div>
            </div>
			
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-12 mb-3">
          <a href="{{ route('activities.index') }}" class="btn btn-secondary">Cancel</a>
		<!-- <button type="submit" name="save_and_continue" class="btn btn-success float-right  ml-3">Save and Continue</button>-->
		   <button type="submit" name="save" class="btn btn-primary float-right">Save</button>
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
		$('#example20').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "bFilter": true, // show search input
    });
	$('#example21').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "bFilter": true, // show search input
    });
});
   
  </script>   
@endsection
 
 
