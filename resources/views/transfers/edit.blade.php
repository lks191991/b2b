@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Transfer Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('transfers.index') }}">Transfers</a></li>
              <li class="breadcrumb-item active">Transfer Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('transfers.update', $record->id) }}" method="post" class="form">
    <input type="hidden" name="_method" value="put">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Transfer</h3>
            </div>
            <div class="card-body">
			<div class="row">
              <div class="form-group col-md-6">
                <label for="inputName">Name: <span class="red">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') ?: $record->name }}" class="form-control"  placeholder="Name" />
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
              </div>
			  
			   <div class="form-group col-md-5">
                <label for="inputName">Status: <span class="red">*</span></label>
                <select name="status" id="status" class="form-control">
                    <option value="1" @if($record->status ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="0" @if($record->status ==0) {{'selected="selected"'}} @endif >Inactive</option>
                 </select>
              </div>
			 <div class="form-group col-md-1 text-center">
                <label for="inputName">More Row:</label> </br>
               <a href="javascript:;" id="addMore" class="btn btn-success"><i class="fas fa-plus"></i></a>
              </div>
			  </div>
			  
			    <div  class="row">
				@foreach($record->transferdata as $data)
			  <div class="form-group col-md-1"><label for="inputName">Price {{$data->qty}}: <span class="red">*</span></label><br><input type="text" name="price[]" value="{{$data->price}}"  required="required" class="form-control" style="width: 60px;float: left; margin-right:5px;"   /> </div>
			   @endforeach
			   </div>
			   <div id="data_row" class="row">
			   
			   </div>
			   <input type="hidden" id="counterPrice" value="{{$record->transferdata->count()}}"    />
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="{{ route('transfers.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Update</button>
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

	$("#addMore").on("click", function () {
		var counter = $('#counterPrice').val();
		counter++;
	var htmlRow ='<div class="form-group col-md-1"><label for="inputName">Price '+counter+': <span class="red">*</span></label><br><input type="text" name="price[]" style="width: 60px;float: left; margin-right:5px;"  required="required" class="form-control"   /> <a href="javascript:;" id="removeRow"   class="btn btn-danger remCF"><i class="fas fa-minus"></i></a>';
				$("#data_row").append(htmlRow);
            $('#counterPrice').val(counter);    
        });
		
		$("body").on('click','.remCF',function(){
			$(this).parent().remove();
		});
	});
	</script>        
@endsection