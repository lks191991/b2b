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
              <li class="breadcrumb-item"><a href="{{ route('variants.index') }}">Variants</a></li>
			  <li class="breadcrumb-item"><a href="{{ route('activity.variant.prices',$record->activity_variant_id) }}">Activity Variant Price</a></li>
              <li class="breadcrumb-item active">View</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-12">
		
          <div class="card">
          
			<div class="card-body">
			
			<header class="profile-header">
        
				<div class="profile-content">
				<div class="row">
        
               <div class="col-lg-6 mb-3">
                <label for="inputName">Rate Valid From:</label>
                {{ $record->rate_valid_from }}
              </div>
			 
			      <div class="col-lg-6 mb-3">
                <label for="inputName">Rate Valid To:</label>
                {{ $record->rate_valid_to }}
              </div>
			  </div>
			 <div class="card ">
			  <h3 class="card-title p-2"><b>Adult Details</b></h3>
			  <div class="row p-2">
			  
                <div class="form-group col-md-3">
                <label for="inputName">Rate Including VAT</label>
				{{ $record->adult_rate_with_vat }}
               
              </div>
			 <div class="form-group col-md-3">
                <label for="inputName">Rate (Without VAT) (B2B): <span class="red">*</span></label>
               {{ $record->adult_rate_without_vat }}
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Rate (Mini. Selling Price): <span class="red">*</span></label>
				{{ $record->adult_mini_selling_price }}
               
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">B2C With VAT: <span class="red">*</span></label>
				{{ $record->adult_B2C_with_vat }}
               
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Max No Allowed:</label>
				{{ $record->adult_max_no_allowed }}
               
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Min No Allowed:</label>
				{{ $record->adult_min_no_allowed }}
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Start Age:</label>
				{{ $record->adult_start_age }}
               
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">End Age:</label>
				{{ $record->adult_end_age }}
              </div>
			   </div> </div>
              
			  
			   <div class="card ">
			  <h3 class="card-title p-2"><b>Child Details</b></h3>
			  <div class="row p-2">
			  
                <div class="form-group col-md-3">
                <label for="inputName">Rate Including VAT</label>
				{{ $record->child_rate_with_vat }}
               
              </div>
			 <div class="form-group col-md-3">
                <label for="inputName">Rate (Without VAT) (B2B): <span class="red">*</span></label>
               {{ $record->child_rate_without_vat }}
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Rate (Mini. Selling Price): <span class="red">*</span></label>
				{{ $record->child_mini_selling_price }}
               
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">B2C With VAT: <span class="red">*</span></label>
				{{ $record->child_B2C_with_vat }}
               
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Max No Allowed:</label>
				{{ $record->child_max_no_allowed }}
               
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Min No Allowed:</label>
				{{ $record->child_min_no_allowed }}
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Start Age:</label>
				{{ $record->child_start_age }}
               
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">End Age:</label>
				{{ $record->child_end_age }}
              </div>
			   </div> </div>
			   
			   
			   
			    <div class="card ">
			  <h3 class="card-title p-2"><b>Infant Details</b></h3>
			  <div class="row p-2">
			  
                <div class="form-group col-md-3">
                <label for="inputName">Rate Including VAT</label>
				{{ $record->infant_rate_with_vat }}
               
              </div>
			 <div class="form-group col-md-3">
                <label for="inputName">Rate (Without VAT) (B2B): <span class="red">*</span></label>
               {{ $record->infant_rate_without_vat }}
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Rate (Mini. Selling Price): <span class="red">*</span></label>
				{{ $record->infant_mini_selling_price }}
               
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">B2C With VAT: <span class="red">*</span></label>
				{{ $record->infant_B2C_with_vat }}
               
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Max No Allowed:</label>
				{{ $record->infant_max_no_allowed }}
               
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Min No Allowed:</label>
				{{ $record->infant_min_no_allowed }}
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">Start Age:</label>
				{{ $record->infant_start_age }}
               
              </div>
			   <div class="form-group col-md-3">
                <label for="inputName">End Age:</label>
				{{ $record->infant_end_age }}
              </div>
			   </div> </div>
			   
			   
            
          </div>
			
				
			
				</header>
		
		 <div class="row mb-3">
        <div class="col-12 mb-3">
		 <a href="{{ route('activity.variant.prices',$record->activity_variant_id) }}" class="btn btn-secondary float-right">Back</a>
         
        </div>
      </div>
          <!-- /.card-body --> 
        </div>
		
           
          </div>
          <!-- /.card -->
        </div>
      </div>
  
    </section>
    <!-- /.content -->
@endsection



@section('scripts')


@endsection