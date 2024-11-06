@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Activity Variant Price</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('activity.variants') }}">Activity Variant</a></li>
			  <li class="breadcrumb-item"><a href="{{ route('activity.variant.prices',$vid) }}">Activity Variant Price</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{ route('activity.variant.price.update', $record->id) }}" method="post" class="form" >
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Edit Activity Variant Price</h3>
            </div>
            <div class="card-body row">
			  <div class="form-group col-md-6">
			  <input type="hidden" id="activity_variant_id" name="activity_variant_id" value="{{ $vid }}"  />
                <label for="inputName">Rate Valid From: <span class="red">*</span></label>
                <input type="text" id="rate_valid_from" name="rate_valid_from" autocomplete="off" value="{{ old('rate_valid_from') ?: $record->rate_valid_from }}" class="form-control datepicker"  placeholder="Rate Valid From" />
                @if ($errors->has('rate_valid_from'))
                    <span class="text-danger">{{ $errors->first('rate_valid_from') }}</span>
                @endif
              </div>
			    <div class="form-group col-md-6">
                <label for="inputName">Rate Valid To: <span class="red">*</span></label>
                <input type="text" id="rate_valid_to" name="rate_valid_to" autocomplete="off" value="{{ old('rate_valid_to') ?: $record->rate_valid_to }}" class="form-control datepicker"  placeholder="Rate Valid To" />
                @if ($errors->has('rate_valid_to'))
                    <span class="text-danger">{{ $errors->first('rate_valid_to') }}</span>
                @endif
              </div>
			  <div class="card ">
			  <h3 class="card-title p-2"><b>Adult Details</b></h3>
			  <div class="row p-2">
			  
                <div class="form-group col-md-3">
                <label for="inputName">Rate Including VAT: <span class="red">*</span></label>
                <input type="text" id="adult_rate_with_vat" name="adult_rate_with_vat" value="{{ old('adult_rate_with_vat') ?: $record->adult_rate_with_vat }}" class="form-control onlynumbrf vatCal"  placeholder="B2B Standard Selling Price" data-withvatinputid="adult_rate_without_vat" />
                @if ($errors->has('adult_rate_with_vat'))
                    <span class="text-danger">{{ $errors->first('adult_rate_with_vat') }}</span>
                @endif
              </div>
			 <div class="form-group col-md-3">
                <label for="inputName">Rate (Without VAT) (B2B): <span class="red">*</span></label>
                <input type="text" id="adult_rate_without_vat" readonly name="adult_rate_without_vat" value="{{ old('adult_rate_without_vat') ?: $record->adult_rate_without_vat }}" class="form-control onlynumbrf"  placeholder="Adult Rate (Without VAT) (B2B)" />
                @if ($errors->has('adult_rate_without_vat'))
                    <span class="text-danger">{{ $errors->first('adult_rate_without_vat') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Rate (Mini. Selling Price): <span class="red">*</span></label>
                <input type="text" id="adult_mini_selling_price" name="adult_mini_selling_price" value="{{ old('adult_mini_selling_price') ?: $record->adult_mini_selling_price }}" class="form-control onlynumbrf"  placeholder="Adult Rate (Mini. Selling Price)" />
                @if ($errors->has('adult_mini_selling_price'))
                    <span class="text-danger">{{ $errors->first('adult_mini_selling_price') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">B2C With VAT: <span class="red">*</span></label>
                <input type="text" id="adult_B2C_with_vat" name="adult_B2C_with_vat" value="{{ old('adult_B2C_with_vat') ?: $record->adult_B2C_with_vat }}" class="form-control onlynumbrf"  placeholder="Adult B2C With VAT" />
                @if ($errors->has('adult_B2C_with_vat'))
                    <span class="text-danger">{{ $errors->first('adult_B2C_with_vat') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Max No Allowed:</label>
                <input type="text" id="adult_max_no_allowed" name="adult_max_no_allowed" value="{{ old('adult_max_no_allowed') ?: $record->adult_max_no_allowed }}" class="form-control onlynumbr"  placeholder="Adult Max No Allowed" />
                @if ($errors->has('adult_max_no_allowed'))
                    <span class="text-danger">{{ $errors->first('adult_max_no_allowed') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Min No Allowed:</label>
                <input type="text" id="adult_min_no_allowed" name="adult_min_no_allowed" value="{{ old('adult_min_no_allowed') ?: $record->adult_min_no_allowed }}" class="form-control onlynumbr"  placeholder="Adult Min No Allowed" />
                @if ($errors->has('adult_min_no_allowed'))
                    <span class="text-danger">{{ $errors->first('adult_min_no_allowed') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Start Age:</label>
                <input type="text" id="adult_start_age" name="adult_start_age" value="{{ old('adult_start_age') ?: $record->adult_start_age }}" class="form-control onlynumbrf"  placeholder="Adult Start Age" />
                @if ($errors->has('adult_start_age'))
                    <span class="text-danger">{{ $errors->first('adult_start_age') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">End Age:</label>
                <input type="text" id="adult_end_age" name="adult_end_age" value="{{ old('adult_end_age') ?: $record->adult_end_age }}" class="form-control onlynumbrf"  placeholder="Adult End Age" />
                @if ($errors->has('adult_end_age'))
                    <span class="text-danger">{{ $errors->first('adult_end_age') }}</span>
                @endif
              </div>
			   </div> </div>
			  
			  <div class="card ">
			   <h3 class="card-title p-2"><b>Child Details</b></h3>
			  <div class="row p-2">
			  
			   <div class="form-group col-md-3">
                <label for="inputName">Rate Including VAT:</label>
                <input type="text" id="child_rate_with_vat" name="child_rate_with_vat" value="{{ old('child_rate_with_vat') ?: $record->child_rate_with_vat }}" class="form-control onlynumbrf vatCal"  placeholder="B2B Standard Selling Price" data-withvatinputid="child_rate_without_vat" />
                @if ($errors->has('child_rate_with_vat'))
                    <span class="text-danger">{{ $errors->first('child_rate_with_vat') }}</span>
                @endif
              </div>
			 <div class="form-group col-md-3">
                <label for="inputName">Rate (Without VAT) (B2B):</label>
                <input type="text" id="child_rate_without_vat" name="child_rate_without_vat" value="{{ old('child_rate_without_vat') ?: $record->child_rate_without_vat }}" class="form-control onlynumbrf"  placeholder="Child Rate (Without VAT) (B2B)" readonly />
                @if ($errors->has('child_rate_without_vat'))
                    <span class="text-danger">{{ $errors->first('child_rate_without_vat') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Rate (Mini. Selling Price):</label>
                <input type="text" id="child_mini_selling_price" name="child_mini_selling_price" value="{{ old('child_mini_selling_price') ?: $record->child_mini_selling_price }}" class="form-control onlynumbrf"  placeholder="Child Rate (Mini. Selling Price)" />
                @if ($errors->has('child_mini_selling_price'))
                    <span class="text-danger">{{ $errors->first('child_mini_selling_price') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">B2C With VAT:</label>
                <input type="text" id="child_B2C_with_vat" name="child_B2C_with_vat" value="{{ old('child_B2C_with_vat') ?: $record->child_B2C_with_vat }}" class="form-control onlynumbrf"  placeholder="Child B2C With VAT" />
                @if ($errors->has('child_B2C_with_vat'))
                    <span class="text-danger">{{ $errors->first('child_B2C_with_vat') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Max No Allowed:</label>
                <input type="text" id="child_max_no_allowed" name="child_max_no_allowed" value="{{ old('child_max_no_allowed') ?: $record->child_max_no_allowed }}" class="form-control onlynumbr"  placeholder="Child Max No Allowed" />
                @if ($errors->has('child_max_no_allowed'))
                    <span class="text-danger">{{ $errors->first('child_max_no_allowed') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Min No Allowed:</label>
                <input type="text" id="child_min_no_allowed" name="child_min_no_allowed" value="{{ old('child_min_no_allowed') ?: $record->child_min_no_allowed }}" class="form-control onlynumbr"  placeholder="Child Min No Allowed" />
                @if ($errors->has('child_min_no_allowed'))
                    <span class="text-danger">{{ $errors->first('child_min_no_allowed') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Start Age:</label>
                <input type="text" id="child_start_age" name="child_start_age" value="{{ old('child_start_age') ?: $record->child_start_age }}" class="form-control onlynumbrf"  placeholder="Child Start Age" />
                @if ($errors->has('child_start_age'))
                    <span class="text-danger">{{ $errors->first('child_start_age') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">End Age:</label>
                <input type="text" id="child_end_age" name="child_end_age" value="{{ old('child_end_age') ?: $record->child_end_age }}" class="form-control onlynumbrf"  placeholder="Child End Age" />
                @if ($errors->has('child_end_age'))
                    <span class="text-danger">{{ $errors->first('child_end_age') }}</span>
                @endif
              </div>
			  </div></div>
			  <div class="card ">
			  <h3 class="card-title p-2"><b>Infant Details</b></h3>
			  <div class="row p-2">
			   <div class="form-group col-md-3">
                <label for="inputName">Rate Including VAT:</label>
                <input type="text" id="infant_rate_with_vat" name="infant_rate_with_vat" value="{{ old('infant_rate_with_vat') ?: $record->infant_rate_with_vat }}" class="form-control onlynumbrf vatCal"  placeholder="B2B Standard Selling Price" data-withvatinputid="infant_rate_without_vat" />
                @if ($errors->has('infant_rate_with_vat'))
                    <span class="text-danger">{{ $errors->first('infant_rate_with_vat') }}</span>
                @endif
              </div>
			 <div class="form-group col-md-3">
                <label for="inputName">Rate (Without VAT) (B2B):</label>
                <input type="text" id="infant_rate_without_vat" name="infant_rate_without_vat" value="{{ old('infant_rate_without_vat') ?: $record->infant_rate_without_vat }}" class="form-control onlynumbrf"  placeholder="Infant Rate (Without VAT) (B2B)" readonly />
                @if ($errors->has('infant_rate_without_vat'))
                    <span class="text-danger">{{ $errors->first('infant_rate_without_vat') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Rate (Mini. Selling Price):</label>
                <input type="text" id="infant_mini_selling_price" name="infant_mini_selling_price" value="{{ old('infant_mini_selling_price') ?: $record->infant_mini_selling_price }}" class="form-control onlynumbrf"  placeholder="Infant Rate (Mini. Selling Price)" />
                @if ($errors->has('infant_mini_selling_price'))
                    <span class="text-danger">{{ $errors->first('infant_mini_selling_price') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">B2C With VAT:</label>
                <input type="text" id="infant_B2C_with_vat" name="infant_B2C_with_vat" value="{{ old('infant_B2C_with_vat') ?: $record->infant_B2C_with_vat }}" class="form-control onlynumbrf"  placeholder="Infant B2C With VAT" />
                @if ($errors->has('infant_B2C_with_vat'))
                    <span class="text-danger">{{ $errors->first('infant_B2C_with_vat') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Max No Allowed:</label>
                <input type="text" id="infant_max_no_allowed" name="infant_max_no_allowed" value="{{ old('infant_max_no_allowed') ?: $record->infant_max_no_allowed }}" class="form-control onlynumbr"  placeholder="Infant Max No Allowed" />
                @if ($errors->has('infant_max_no_allowed'))
                    <span class="text-danger">{{ $errors->first('infant_max_no_allowed') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Min No Allowed:</label>
                <input type="text" id="infant_min_no_allowed" name="infant_min_no_allowed" value="{{ old('infant_min_no_allowed') ?: $record->infant_min_no_allowed }}" class="form-control onlynumbr"  placeholder="Infant Min No Allowed" />
                @if ($errors->has('infant_min_no_allowed'))
                    <span class="text-danger">{{ $errors->first('infant_min_no_allowed') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Start Age:</label>
                <input type="text" id="infant_start_age" name="infant_start_age" value="{{ old('infant_start_age') ?: $record->infant_start_age }}" class="form-control onlynumbrf"  placeholder="Infant Start Age" />
                @if ($errors->has('infant_start_age'))
                    <span class="text-danger">{{ $errors->first('infant_start_age') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">End Age:</label>
                <input type="text" id="infant_end_age" name="infant_end_age" value="{{ old('infant_end_age') ?: $record->infant_end_age }}" class="form-control onlynumbrf"  placeholder="Infant End Age" />
                @if ($errors->has('infant_end_age'))
                    <span class="text-danger">{{ $errors->first('infant_end_age') }}</span>
                @endif
              </div>
			 </div></div>
			  
            </div>
			
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-12 mb-3">
          <a href="{{ route('activity.variant.prices',$vid) }}" class="btn btn-secondary">Cancel</a>
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
		 $(document).on('input', '.onlynumbr', function() {
			$(this).val(function(index, value) {
				return value.replace(/[^0-9]/g, '');
			});

			if (isNaN(parseInt($(this).val()))) {
				$(this).val(0);
			}
		});

	$(document).on('input', '.onlynumbrf', function() {
		$(this).val(function(index, value) {
			return value.replace(/[^0-9.]/g, '');
		});

		if (isNaN(parseFloat($(this).val()))) {
			$(this).val(0);
		}
	});
   
   $(document).on('change', '.vatCal', function(evt) {
	
	var vat = "{{$vat}}"/100;
	if(isNaN(vat)){
		vat = 0;
	}
	let inputvale = parseFloat($(this).val());
	if(inputvale == null || isNaN(inputvale))
	{
		inputvale = 0;
		$(this).val(0);
	}
	let taxvalu = parseFloat(1 + vat);
	var taxAmount = parseFloat(inputvale / taxvalu);
	let withVatInputId = $(this).data('withvatinputid');
	
	if(!isNaN(taxAmount)){
	$("body #"+withVatInputId).val(taxAmount.toFixed(2));
	}
	
});

});
   
  </script>   
@endsection
 
 
