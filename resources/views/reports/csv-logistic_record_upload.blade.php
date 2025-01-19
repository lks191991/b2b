@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Logistic Record CSV Upload</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('voucherReport') }}">Logistic Report</a></li>
              <li class="breadcrumb-item active">Logistic Record CSV Upload</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('logistic.record.csv.upload.save') }}" method="post" class="form" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Logistic Record CSV Upload</h3>
            </div>
            <div class="card-body">
			<div class="row">
			 
				  
			 
			 
			    <div class="form-group col-md-6">
                <label for="inputName">CSV File: <span class="red">*</span></label>
                <input type="file" id="logistic_record_upload" name="logistic_record_upload" value="{{ old('logistic_record_upload') }}" class="form-control"  placeholder="Serial Number" />
                @if ($errors->has('logistic_record_upload'))
                    <span class="text-danger">{{ $errors->first('logistic_record_upload') }}</span>
                @endif
              </div>
			  
               </div>
			  
			   
            </div>
			
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-success float-right">Upload</button>
        </div>
      </div>
    </form>
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
@include('inc.ckeditor')
	<script type="text/javascript">
 $(document).ready(function(){
	var activity_id = "{{old('activity_id')}}";
	var oldactivity_variant = "{{old('activity_variant')}}";
	
	$("body #activity_id").on("change", function () {
            var activity_id = $(this).val();
			$("#activity_variant").prop("disabled",true);
            $.ajax({
                type: "POST",
                url: '{{ route("variantByActivity") }}',
                data: {'activity_id': activity_id, '_token': '{{ csrf_token() }}'},
                success: function (data) {
					 $('#activity_variant').html('<option value="">--select--</option>');
					$.each(data, function (key, value) {
                            $("#activity_variant").append('<option value="' + value
                                .variant_code + '">' + value.variant_name + '</option>');
                        });
					$('#activity_variant').val(oldactivity_variant).prop('selected', true);
					$("#activity_variant").prop("disabled",false);
					
					
                }
            });
        });
		if(oldactivity_variant){
					$("body #activity_id").trigger("change");
					}
		});
			</script>  
@endsection
