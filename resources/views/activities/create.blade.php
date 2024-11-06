@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Activity Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('activities.index') }}">Activities</a></li>
              <li class="breadcrumb-item active">Activity Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('activities.store') }}" method="post" class="form" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Activity</h3>
            </div>
            <div class="card-body row">
                <div class="form-group col-md-4">
                <label for="inputName">Title: <span class="red">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control"  placeholder="Title" />
                @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
              </div>
			<div class="form-group col-md-2">
                <label for="inputName">Min Starting Price <span class="red">*</span>:</label>
                <input type="text" id="min_price" name="min_price" value="{{ old('min_price') }}" class="form-control onlynumbrf"  placeholder="Min Starting Price" />
                @if ($errors->has('min_price'))
                    <span class="text-danger">{{ $errors->first('min_price') }}</span>
                @endif
              </div>
                <div class="form-group col-md-2">
                <label for="inputName">Min Sell Price <span class="red">*</span>:</label>
                <input type="text" id="list_price" name="list_price" value="{{ old('list_price') }}" class="form-control onlynumbrf"  placeholder="Min Starting Price" />
                @if ($errors->has('list_price'))
                    <span class="text-danger">{{ $errors->first('list_price') }}</span>
                @endif
              </div>
				<div class="form-group col-md-2">
                <label for="inputName">Product Type: <span class="red">*</span></label>
                <select name="product_type" id="product_type" class="form-control">
				<option value="">--select--</option>
				<option value="Bundle" @if(old('entry_type') == 'Bundle') {{'selected="selected"'}} @endif >Bundle</option>
        <option value="Bundle_Same" @if(old('entry_type') == 'Bundle_Same') {{'selected="selected"'}} @endif >Bundle Same Date</option>
        <option value="Bundle_Diff" @if(old('entry_type') == 'Bundle_Diff') {{'selected="selected"'}} @endif >Bundle Diff Date</option>
				<option value="Standalone" @if(old('entry_type') == 'Standalone') {{'selected="selected"'}} @endif >Standalone</option>
				<option value="Package" @if(old('entry_type') == 'Package') {{'selected="selected"'}} @endif >Package</option>

      </select>
				 @if ($errors->has('product_type'))
                    <span class="text-danger">{{ $errors->first('product_type') }}</span>
                @endif
              </div>
			  
			   <div class="form-group col-md-2">
                <label for="inputName">Entry Type: <span class="red">*</span></label>
                <select name="entry_type" id="entry_type" class="form-control">
				<option value="">--select--</option>
                   <option value="Ticket Only" @if(old('entry_type') =='Ticket Only') {{'selected="selected"'}} @endif>Ticket Only</option>
					<option value="Tour" @if(old('entry_type') == 'Tour') {{'selected="selected"'}} @endif >Tour</option>
          <option value="Arrival" @if(old('entry_type') == 'Arrival') {{'selected="selected"'}} @endif >Arrival</option>
          <option value="Departure" @if(old('entry_type') == 'Departure') {{'selected="selected"'}} @endif >Departure</option>
          <option value="Interhotel" @if(old('entry_type') == 'Interhotel') {{'selected="selected"'}} @endif >Interhotel</option>
		   <option value="Yacht" @if(old('entry_type') == 'Yacht') {{'selected="selected"'}} @endif >Yacht</option>
          <option value="Limo" @if(old('entry_type') == 'Limo') {{'selected="selected"'}} @endif >Limo</option>
                 </select>
				 @if ($errors->has('entry_type'))
                    <span class="text-danger">{{ $errors->first('entry_type') }}</span>
                @endif
              </div>
			   
			   <div class="form-group col-md-4">
                <label for="inputName">Vat %:</label>
                <select  id="vat" name="vat" class="form-control">
                    <option value="5" @if(old('vat') == 5) {{'selected="selected"'}} @endif>5</option>
                 </select>
				 @if ($errors->has('vat'))
                    <span class="text-danger">{{ $errors->first('vat') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-4">
			  <label for="inputName">Currency: <span class="red">*</span></label>
                <select name="currency_id" id="currency_id" class="form-control">
				<option value="">--select--</option>
				@foreach($currencies as $currency)
				@if(old('currency_id') == $currency->id)
                    <option value="{{$currency->id}}" selected="selected">{{$currency->name}} ({{$currency->code}})</option>
				@else
					<option value="{{$currency->id}}" @if($currency->code == 'AED') {{'selected="selected"'}} @endif>{{$currency->name}} ({{$currency->code}})</option>
				@endif
				@endforeach
                 </select>
				 @if ($errors->has('country_id'))
                    <span class="text-danger">{{ $errors->first('currency_id') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-2">
                <label for="inputName">Longitute:</label>
                <input type="text" id="longitute" name="longitute" value="{{ old('longitute') }}" class="form-control onlynumbrf"  placeholder="Longitute" />
                @if ($errors->has('longitute'))
                    <span class="text-danger">{{ $errors->first('longitute') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-2">
                <label for="inputName">Latitude:</label>
                <input type="text" id="latitude" name="latitude" value="{{ old('latitude') }}" class="form-control onlynumbrf"  placeholder="Latitude" />
                @if ($errors->has('latitude'))
                    <span class="text-danger">{{ $errors->first('latitude') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-4">
			  <label for="inputName">Country: <span class="red">*</span></label>
                <select name="country_id" id="country_id" class="form-control">
				<option value="">--select--</option>
				@foreach($countries as $country)
				@if(old('country_id') == $country->id)
                    <option value="{{$country->id}}" selected="selected">{{$country->name}}</option>
				@else
					<option value="{{$country->id}}" @if($country->id==1) {{'selected="selected"'}} @endif>{{$country->name}}</option>
				@endif
				
				@endforeach
                 </select>
				 @if ($errors->has('country_id'))
                    <span class="text-danger">{{ $errors->first('country_id') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-4">
			  <label for="inputName">State: <span class="red">*</span></label>
               <select name="state_id" id="state_id" class="form-control">
				<option value="">--select--</option>
				</select>
				 @if ($errors->has('state_id'))
                    <span class="text-danger">{{ $errors->first('state_id') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-4">
                <label for="inputName">City: <span class="red">*</span></label>
                <select name="city_id" id="city_id" class="form-control">
				<option value="">--select--</option>
				</select>
              </div>
			   <div class="form-group col-md-12">
                <label for="inputName">Tags: <span class="red">*</span></label>
               <select name="tags[]" id="tags" class="form-control select2" multiple>
					@foreach($tags as  $vs)
					<option value="{{ $vs->name }}" @if(in_array($vs->name, (array)old('tags'))) selected="selected" @endif>{{ $vs->name }}</option>
					@endforeach
					</select>
              </div>
			  
			   <div class="form-group col-md-12">
                <label for="inputName">Tags For Show: <span class="red">*</span></label>
               <select name="tagsforshow[]" id="tagsforshow" class="form-control select2" multiple>
					@foreach($tags as  $vs)
					<option value="{{ $vs->name }}" @if(in_array($vs->name, (array)old('tagsforshow'))) selected="selected" @endif>{{ $vs->name }}</option>
					@endforeach
					</select>
              </div>
			
              </div>
			  <!--form-group-->
              <div class="form-group col-md-12">
                  <label for="featured_image">Featured Image</label>
                  <input type="file" class="form-control" name="featured_image" accept="image/x-png,image/gif,image/jpeg">
                  @if ($errors->has('featured_image'))
                      <span class="text-danger">{{ $errors->first('featured_image') }}</span>
                  @endif
                </div>
			
			   <div class="form-group col-md-12">
                  <label for="featured_image">Images</label>
                  <div class="control-group">
                    <div class="file-loading">
                        <input id="image" type="file" name="image[]" data-min-file-count="0" multiple>
                    </div>
                  </div>
                @if($errors->has('image'))
                  <div class="col-md-12"><span class="text-danger">{{ $errors->first('image') }}</span></div>
                @endif
              </div><!--form control--> 
			  <div class="form-group col-md-12">
                <label for="inputName">Short Description: <span class="red">*</span></label>
				
                <textarea placeholder="Short Description" name="short_description" cols="50" rows="2" id="short_description" class="form-control box-size ">{{ old('short_description') }}</textarea>
                @if ($errors->has('short_description'))
                    <span class="text-danger">{{ $errors->first('short_description') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-12">
                <label for="inputName">Bundle Product Cancellation : <span class="red">*</span></label>
				
                <textarea placeholder="Bundle Product Cancellation" name="bundle_product_cancellation" cols="50" rows="2" id="bundle_product_cancellation" class="form-control box-size ">{{ old('bundle_product_cancellation') }}</textarea>
                @if ($errors->has('bundle_product_cancellation'))
                    <span class="text-danger">{{ $errors->first('bundle_product_cancellation') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-12">
                <label for="inputName">Description: <span class="red">*</span></label>
				
                <textarea placeholder="Description" name="description"  rows="10" id="content" class="form-control box-size text-editor">{{ old('description') }}</textarea>
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-12">
                <label for="inputName">Notes:</label>
				
                <textarea placeholder="Notes" id="notes" name="notes"  rows="15" id="notes" class="form-control box-size text-editor2">{{ old('notes') }}</textarea>
                @if ($errors->has('notes'))
                    <span class="text-danger">{{ $errors->first('notes') }}</span>
                @endif
              </div>
			  
			    <div class="form-group col-md-6">
                <label for="inputName">Popularity: <span class="red">*</span></label>
                <select name="popularity" id="popularity" class="form-control">
                    <option value="1" @if(old('popularity') ==1) {{'selected="selected"'}} @endif>Yes</option>
					          <option value="0" @if(old('popularity') ==0) {{'selected="selected"'}} @endif >No</option>
                 </select>
              </div>
			  
			 
			  
			 <div class="form-group col-md-6">
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
@include('inc.citystatecountryjs')
 <!-- Script -->
 <script type="text/javascript">
    $(document).ready(function() {
 

 $("#image").fileinput({
        theme: 'fa',
        allowedFileExtensions: ['jpg', 'png','jpeg'],
        overwriteInitial: false,
        maxFileCount: 10,
        showUpload:false
    });
	
	$(document).on('input', '.onlynumbrf', function() {
		$(this).val(function(index, value) {
			return value.replace(/[^0-9.]/g, '');
		});

		if (isNaN(parseFloat($(this).val()))) {
			$(this).val('');
		}
	});
});
       

   
  </script>   
  @include('inc.ckeditor')
@endsection
 
 
