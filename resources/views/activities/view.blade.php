@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Activity : {{ $activity->title }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('activities.index') }}">Activities</a></li>
              <li class="breadcrumb-item active">Activity Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    
        <div class="col-md-12">
		<div class="card card-primary card-outline card-tabs">
		<div class="card card-primary card-outline card-tabs">
			<div class="card-header p-0 pt-1 border-bottom-0">
			<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
			<li class="nav-item">
			<a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Activity</a>
			</li>
			
			<li class="nav-item">
			<a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Images</a>
			</li>
			
		
			</ul>
			</div>
		 </div>
       </div>
		 </div>
	   
	   <div class="card-body">
		<div class="tab-content" id="custom-tabs-three-tabContent">
			<div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
				<header class="profile-header">
         
				<div class="profile-content">
				
					<div class="row">
              <div class="col-lg-12 mb-3">
				<h4>Activity Details</h4>
				 </div>
			     <div class="col-lg-6 mb-3">
                <label for="inputName">Min Starting Price:</label>
                {{ $activity->min_price }}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Product Type:</label>
                {{ $activity->product_type }}
              </div>
			
			 
			 <div class="col-lg-6 mb-3">
                <label for="inputName">Entry Type:</label>
               {{ $activity->entry_type }}
              </div>
			 
			  
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Vat:</label>
               {{ $activity->vat }}%
              </div>
			  
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Currency:</label>
               {{ @$activity->currency->name}}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Longitute:</label>
               {{ $activity->longitute }}%
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Latitude:</label>
               {{ $activity->latitude }}%
              </div>
			  
			  <div class="col-lg-6 mb-3">
                <label for="inputName">Country:</label>
               {{ @$activity->country->name}}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">State:</label>
               {{ @$activity->state->name}}
              </div>
			  <div class="col-lg-6 mb-3">
                <label for="inputName">City:</label>
               {{ @$activity->city->name}}
              </div>
			   <div class="form-group col-lg-6 mb-3">
			        <label for="inputName">Status:</label>
					{!! SiteHelpers::statusColor($activity->status) !!}
              </div>
			   <div class="form-group col-lg-6 mb-3">
                <label for="inputName">Tags:</label>
                {!!$activity->tags!!}
              </div>
			 
			  <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Short Description:</label>
                {!!$activity->short_description!!}
              </div>
			   
              <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Description:</label>
                {!!$activity->description!!}
              </div>
             
			  
			  
			   <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Bundle Product Cancellation:</label>
                {!!$activity->bundle_product_cancellation!!}
              </div>
			  <div class="form-group col-lg-12 mb-3">
                <label for="inputName">Notes:</label>
                {!!$activity->notes!!}
              </div>
			 
             
            
          </div>	
				</div>
          
			
				</header>
			</div>
			
			<div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
			 <div class="row">
			 <div class="col-md-6 mb-3">
				<h4>Featured Image</h4>
				 </div>
				 <div class="col-md-6 mb-3">
				<h4>Images</h4>
				 </div>
				  <div class="form-group col-md-6">
                 @if(!empty($activity->image))
               
                  <img src="{{asset('uploads/activities/thumb/'.$activity->image)}}"  class="cimage" />
                
				@endif
              </div>
			  
				 <div class="slider-outer col-md-6">
				 <div class="owl-theme owl-carousel">
                       @if($activity->images->count() > 0)
                           
                                
                                @foreach($activity->images as $image)
                                <div clss="item">
                              <img src="{{asset('uploads/activities/thumb/'.$image->filename)}}"  class="img-responsive">
                                </div>
                                @endforeach
                           
                            @endif 
                            </div>
				 </div>
			 </div>
			  
			
			</div></div>
			  
			
			</div>
	  <!-- /.content -->
@endsection



@section('scripts')
<script type="text/javascript">
$(window).on('load', function(){
 var owl = $('.owl-carousel');
owl.owlCarousel({
    loop:true,
    nav:true,
	dots:false,
    margin:10,
	items:1
  
});

  
  
});


</script>
@endsection