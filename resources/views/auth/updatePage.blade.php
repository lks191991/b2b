@extends('layouts.appLogin')
  
@section('content')


             
                
    <!-- Start package Card tab section -->
    <div class="package-card-tab-section">
        
        <div class="container">
           
             <div class="package-card-with-tab" >
                 <ul class="nav nav-pills" id="pills-tab4" role="tablist">
                 @if(count($allrecords) > 0)
                     <li class="nav-item" role="presentation">
                         <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">All</button>
                     </li>
                     @endif
                     @if(count($notifications) > 0)
                     <li class="nav-item" role="presentation">
                         <button class="nav-link" id="notification-tab" data-bs-toggle="pill" data-bs-target="#notification" type="button" role="tab" aria-controls="notification" aria-selected="false">Notification</button>
                     </li>
                     @endif
                      @if(count($announcments) > 0)
                     <li class="nav-item" role="presentation">
                         <button class="nav-link" id="announcments-tab" data-bs-toggle="pill" data-bs-target="#announcments" type="button" role="tab" aria-controls="announcments" aria-selected="false">Announcments</button>
                     </li>
                      @endif
                    
                 </ul>
                 <div class="row" style="">
                     <div class="col-lg-12" >
                         <div class="tab-content" id="pills-tab4Content">
                             <div class="tab-pane fade show active" id="all" role="tabpanel">
                                
                                       
                                    @foreach ($allrecords as $record)
                                      
                                            <div class="col-md-12 mb-20">
                                                <div class="package-card row">
                                                    <div class="col-md-3">
                                                        <div class="package-card-img-wrap" style="padding:15px 0px;">
                                                            <a href="javascript:void(0);" class="card-img"><img src="{{ url('/uploads/notification/'.$record->image) }}" alt=""></a>
                                                            <div class="batch">
                                                                {!! SiteHelpers::notificationTypeHome($record->type) !!}
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="package-card-content">
                                                            <div class="card-content-top">
                                                                <h5>{{$record->title}}</h5>
                                                                <p>
                                                                    {{$record->content}} 
                                                                </p>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                 
                                            </div>
                                       
                                    @endforeach
                                    
                                 
                             </div>

                             <div class="tab-pane fade" id="notification" role="tabpanel">
                             

                                    @foreach ($notifications as $record)
                                    <div class="col-md-12  mb-20">
                                                <div class="package-card row">
                                                    <div class="col-md-3">
                                                        <div class="package-card-img-wrap" style="padding:15px 0px;">
                                                            <a href="javascript:void(0);" class="card-img"><img src="{{ url('/uploads/notification/'.$record->image) }}" alt=""></a>
                                                            <div class="batch">
                                                                {!! SiteHelpers::notificationTypeHome($record->type) !!}
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="package-card-content">
                                                            <div class="card-content-top">
                                                                <h5>{{$record->title}}</h5>
                                                                <p>
                                                                    {{$record->content}} 
                                                                </p>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                 
                                            </div>
                                    @endforeach

                                   
                             </div>

                             <div class="tab-pane fade" id="announcments" role="tabpanel">
                                
                                       
                                    @foreach ($announcments as $record)
                                    <div class="col-md-12  mb-20">
                                                <div class="package-card row">
                                                    <div class="col-md-3">
                                                        <div class="package-card-img-wrap" style="padding:15px 0px;">
                                                            <a href="javascript:void(0);" class="card-img"><img src="{{ url('/uploads/notification/'.$record->image) }}" alt=""></a>
                                                            <div class="batch">
                                                                {!! SiteHelpers::notificationTypeHome($record->type) !!}
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="package-card-content">
                                                            <div class="card-content-top">
                                                                <h5>{{$record->title}}</h5>
                                                                <p>
                                                                    {{$record->content}} 
                                                                </p>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                 
                                            </div>
                                    @endforeach

                                 
                             </div>
                             
                                
                        </div>
                            
                     </div>
                 </div>
             </div>
        </div>
    </div>
    <!-- End package Card tab section -->
                        
               

@endsection
