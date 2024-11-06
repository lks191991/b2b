@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Activity Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('activities.index') }}">Activities</a></li>
              <li class="breadcrumb-item active">Activity Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('activities.update', $record->id) }}" method="post" class="form" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="put">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Activity</h3>
            </div>
<div class="card-body row">
                <div class="form-group col-md-4">
                <label for="inputName">Title: <span class="red">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title') ?: $record->title }}" class="form-control"  placeholder="Title" />
                @if ($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
              </div>
			<div class="form-group col-md-2">
                <label for="inputName">Min Starting Price <span class="red">*</span>:</label>
                <input type="text" id="min_price" name="min_price" value="{{ old('min_price') ?: $record->min_price }}" class="form-control onlynumbrf"  placeholder="Min Starting Price" />
                @if ($errors->has('min_price'))
                    <span class="text-danger">{{ $errors->first('min_price') }}</span>
                @endif
              </div>
                <div class="form-group col-md-2">
                <label for="inputName">Min Sell Price <span class="red">*</span>:</label>
                <input type="text" id="list_price" name="list_price" value="{{ old('list_price') ?: $record->list_price }}" class="form-control onlynumbrf"  placeholder="Min Starting Price" />
                @if ($errors->has('list_price'))
                    <span class="text-danger">{{ $errors->first('list_price') }}</span>
                @endif
              </div>
				<div class="form-group col-md-2">
                <label for="inputName">Product Type: <span class="red">*</span></label>
                <select name="product_type" id="product_type" class="form-control">
				<option value="">--select--</option>
				<option value="Bundle" @if($record->product_type == 'Bundle') {{'selected="selected"'}} @endif >Bundle</option>
        <option value="Bundle_Same" @if($record->product_type == 'Bundle_Same') {{'selected="selected"'}} @endif >Bundle Same Date</option>
        <option value="Bundle_Diff" @if($record->product_type == 'Bundle_Diff') {{'selected="selected"'}} @endif >Bundle Diff Date</option>
				<option value="Standalone" @if($record->product_type == 'Standalone') {{'selected="selected"'}} @endif >Standalone</option>
        <option value="Package" @if($record->product_type == 'Package') {{'selected="selected"'}} @endif >Package</option>

                 </select>
				 @if ($errors->has('product_type'))
                    <span class="text-danger">{{ $errors->first('product_type') }}</span>
                @endif
              </div>
			  
			   <div class="form-group col-md-2">
                <label for="inputName">Entry Type: <span class="red">*</span></label>
               <select name="entry_type" id="entry_type" class="form-control">
				<option value="">--select--</option>
                   <option value="Ticket Only" @if($record->entry_type =='Ticket Only') {{'selected="selected"'}} @endif>Ticket Only</option>
					<option value="Tour" @if($record->entry_type == 'Tour') {{'selected="selected"'}} @endif >Tour</option>
          <option value="Arrival" @if($record->entry_type == 'Arrival') {{'selected="selected"'}} @endif >Arrival</option>
          <option value="Departure" @if($record->entry_type == 'Departure') {{'selected="selected"'}} @endif >Departure</option>
          <option value="Interhotel" @if($record->entry_type == 'Interhotel') {{'selected="selected"'}} @endif >Interhotel</option>
		   <option value="Yacht" @if($record->entry_type == 'Yacht') {{'selected="selected"'}} @endif >Yacht</option>
          <option value="Limo" @if($record->entry_type == 'Limo') {{'selected="selected"'}} @endif >Limo</option>
                 </select>
				 @if ($errors->has('entry_type'))
                    <span class="text-danger">{{ $errors->first('entry_type') }}</span>
                @endif
              </div>
			  
			   <div class="form-group col-md-4">
                <label for="inputName">Vat %:</label>
                <select  id="vat" name="vat" class="form-control">
				<option value="">--select--</option>
                    <option value="5" @if($record->vat == 5) {{'selected="selected"'}} @endif>5</option>
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
                    <option value="{{$currency->id}}" @if($record->currency_id == $currency->id) {{'selected="selected"'}} @endif>{{$currency->name}} ({{$currency->code}})</option>
				@endforeach
                 </select>
				 @if ($errors->has('currency_id'))
                    <span class="text-danger">{{ $errors->first('currency_id') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-2">
                <label for="inputName">Longitute:</label>
                <input type="text" id="longitute" name="longitute" value="{{ old('longitute') ?: $record->longitute }}" class="form-control onlynumbrf"  placeholder="Longitute" />
                @if ($errors->has('longitute'))
                    <span class="text-danger">{{ $errors->first('longitute') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-2">
                <label for="inputName">Latitude:</label>
                <input type="text" id="latitude" name="latitude" value="{{ old('latitude') ?: $record->latitude }}" class="form-control onlynumbrf"  placeholder="Latitude" />
                @if ($errors->has('latitude'))
                    <span class="text-danger">{{ $errors->first('latitude') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-4">
			  <label for="inputName">Country: <span class="red">*</span></label>
                <select name="country_id" id="country_id" class="form-control">
				<option value="">--select--</option>
				@foreach($countries as $country)
                    <option value="{{$country->id}}" @if($record->country_id == $country->id) {{'selected="selected"'}} @endif>{{$country->name}}</option>
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
				@foreach($states as $state)
                    <option value="{{$state->id}}" @if($record->state_id == $state->id) {{'selected="selected"'}} @endif>{{$state->name}}</option>
				@endforeach
                 </select>
				 @if ($errors->has('state_id'))
                    <span class="text-danger">{{ $errors->first('state_id') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-4">
                <label for="inputName">City: <span class="red">*</span></label>
                 <select name="city_id" id="city_id" class="form-control">
				<option value="">--select--</option>
        	@foreach($cities as $city)
                    <option value="{{$city->id}}" @if($record->city_id == $city->id) {{'selected="selected"'}} @endif>{{$city->name}}</option>
				@endforeach
				</select>
              </div>
			  <div class="form-group col-md-12">
                <label for="inputName">Tags: <span class="red">*</span></label>
               <select name="tags[]" id="tags" class="form-control select2" multiple>
					@foreach($tags as  $vs)
					<option value="{{ $vs->name }}" @if(in_array($vs->name, explode(",",$record->tags))) selected="selected" @endif>{{ $vs->name }}</option>
					@endforeach
					</select>
              </div>
			  
			   <div class="form-group col-md-12">
                <label for="inputName">Tags For Show: <span class="red">*</span></label>
               <select name="tagsforshow[]" id="tagsforshow" class="form-control select2" multiple>
					@foreach($tags as  $vs)
					<option value="{{ $vs->name }}" @if(in_array($vs->name, explode(",",$record->tagsforshow))) selected="selected" @endif>{{ $vs->name }}</option>
					@endforeach
					</select>
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
                      <input id="addtional_image" type="file" name="image[]" data-min-file-count="0" multiple>
                    </div>
                </div>
				</div>
			  <div class="form-group col-md-12">
                <label for="inputName">Short Description: <span class="red">*</span></label>
				
                <textarea placeholder="Short Description" name="short_description" cols="50" rows="2" id="short_description" class="form-control box-size ">{{ old('short_description')?:$record->short_description }}</textarea>
                @if ($errors->has('short_description'))
                    <span class="text-danger">{{ $errors->first('short_description') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-12">
                <label for="inputName">Bundle Product Cancellation : <span class="red">*</span></label>
				
                <textarea placeholder="Bundle Product Cancellation" name="bundle_product_cancellation" cols="50" rows="2" id="bundle_product_cancellation" class="form-control box-size ">{{ old('bundle_product_cancellation')?:$record->bundle_product_cancellation }}</textarea>
                @if ($errors->has('bundle_product_cancellation'))
                    <span class="text-danger">{{ $errors->first('bundle_product_cancellation') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Description: <span class="red">*</span></label>
				
                <textarea placeholder="Description" name="description" cols="50" rows="10" id="content" class="form-control box-size text-editor">{{ old('description')?:$record->description }}</textarea>
                @if ($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-6">
                <label for="inputName">Notes:</label>
				
                <textarea placeholder="Notes" id="notes" name="notes" cols="50" rows="15" id="notes" class="form-control box-size text-editor2">{{ old('notes')?:$record->notes }}</textarea>
                @if ($errors->has('notes'))
                    <span class="text-danger">{{ $errors->first('notes') }}</span>
                @endif
              </div>
			  
			   
			  <div class="form-group col-md-6">
                <label for="inputName">Popularity: <span class="red">*</span></label>
              <select name="popularity" id="popularity" class="form-control">
                    <option value="1" @if($record->popularity ==1) {{'selected="selected"'}} @endif>Yes</option>
					  <option value="0" @if($record->popularity ==0) {{'selected="selected"'}} @endif >No</option>
                 </select>
              </div>
			 
			  
			 <div class="form-group col-md-6">
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
      <div class="row mb-3">
        <div class="col-12  mb-3">
          <a href="{{ route('activities.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Update</button>
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
  

 $("#addtional_image").fileinput({
		
        theme: 'fa',
        initialPreview: {!! $images !!},

        initialPreviewConfig: [
            @foreach($image_key as $val)
                {
                    fileType: 'image',
                    previewAsData: true,
                    key:"{!! $val !!}",
					url:"{{ route('fileinput.imagedelete',['id'=> $val]) }}",
                },
            @endforeach
           ],
		
        initialPreviewShowDelete: true,
        initialPreviewAsData: true,
        allowedFileExtensions: ['jpg', 'png','jpeg'],
        overwriteInitial: false,
        maxFileCount: 10,
        uploadAsync: false,
        showUpload:false,
		ajaxDeleteSettings: {
        type: 'GET' // This should override the ajax as $.ajax({ type: 'DELETE' })
		},
        //deleteUrl: "{{ url('fileinput/image-delete') }}",
		layoutTemplates: {
      }
        
    }).on('filebeforedelete', function() {
        return new Promise(function(resolve, reject) {
            $.confirm({
                title: 'Confirmation!',
                content: 'Are you sure you want to delete this Image?',
                type: 'red',
                buttons: {   
                    ok: {
                        btnClass: 'btn-primary text-white',
                        keys: ['enter'],
                        action: function(){
                            resolve();
                        }
                    },
                    cancel: function(){
                        
                    }
                }
            });
        });
    }).on('filedeleted', function() {
        setTimeout(function() {
            $.alert('File deletion was successful! ' + krajeeGetCount('file-6'));
        }, 900);
    });;

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