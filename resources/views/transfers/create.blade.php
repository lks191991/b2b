@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Transfer Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('transfers.index') }}">Transfers</a></li>
              <li class="breadcrumb-item active">Transfer Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('transfers.store') }}" method="post" class="form">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Transfer</h3>
            </div>
            <div class="card-body">
			  <div class="row">
              <div class="form-group col-md-4">
                <label for="inputName">Name: <span class="red">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control"  placeholder="Name" />
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
              </div>
			  
			   <div class="form-group col-md-4">
                <label for="inputName">Status: <span class="red">*</span></label>
                <select name="status" id="status" class="form-control">
                    <option value="1" @if(old('status') ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="0" @if(old('status') ==0) {{'selected="selected"'}} @endif >Inactive</option>
                 </select>
              </div>
			  <div class="form-group col-md-4">
                <label for="inputName">Number Of Row: <span class="red">*</span></label>
                <select  id="number_of_row" required="required" class="form-control">
				<option value="">--select--</option>
				@for($i=1; $i<101;$i++)
                    <option value="{{$i}}" @if(old('country_id') == $i) {{'selected="selected"'}} @endif>{{$i}}</option>
				@endfor
                 </select>
				
              </div>
			  </div>
			  <div id="data_row" class="row">
			  
			  
			   
			   </div>
            </div>
			
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="{{ route('transfers.index') }}" class="btn btn-secondary">Cancel</a>
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
	$(document).ready(function(){
		$("#number_of_row").on("change", updateDivs);
	});
	function updateDivs() {
		  var numSelect = $("#number_of_row");
		  var num = parseInt(numSelect.val());
		  var container = $("#data_row");
		  var divs = container.find("div");
		  var divCount = divs.length;

		  if (num > divCount) {
			for (var i = divCount + 1; i <= num; i++) {
			 var htmlRow ='<div class="form-group col-md-1"><label for="inputName">Price '+i+': <span class="red">*</span></label><input type="text" name="price[]"  required="required" class="form-control"   /> </div>';
			  container.append(htmlRow);
			}
		  } else if (num < divCount) {
			for (var i = divCount; i > num; i--) {
			  divs.eq(i - 1).remove();
			}
		  }
		}
	</script>        
@endsection