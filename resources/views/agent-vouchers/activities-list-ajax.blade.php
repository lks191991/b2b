				@if($records->count() > 0)
                @foreach ($records as $record)
                @php
                  $minPrice = $record->min_price;
                  $cutoffTime = SiteHelpers::getActivityVarByCutoffCancellation($record->id);
                @endphp

                    <div class="room-suits-card mb-30  box-shadow" >
                        <div class="row g-0">
                            <div class="col-md-4">
                            <div class="room-img" style=" background-image:url('{{asset('uploads/activities/'.$record->image)}}');">
                                
                                </div>
                               
                            </div>
                            <div class="col-md-8">
                                <div class="room-content">
                                    <div class="content-top">
                                        <h5>
                                            <a class="" href="{{route('agent-vouchers.activity.view',[$record->id,$vid])}}" target="_blank">
                                              {{$record->title}}
                                            </a>
                                        </h5>
                                       
                                        <ul class="facilisis">
                                            @if($record->entry_type == 'Tour')
                                              <li>
                                              <span style="color: green;"> 
                                                  <i class="icon-price-tag mr-10"></i>
                                                  Instant Confirmation
                                                  </span>
                                              </li>
                                            @endif
                                            <li>
                                             <span style="color: green;">    
                                           {!!$cutoffTime!!}</span></li>
                                           
                                        </ul>
                                    </div>
                                    <div class="content-bottom">
                                        <div class="room-type">
                                            <div class="deals">
                                                <!-- <span><strong>Free cancellation</strong> <br> before 48 hours</span> -->
                                            </div>
                                        </div>
                                       <div class="price-and-book">
                                            <div class="price-area">
											@php
											$currency = SiteHelpers::getCurrencyPrice();
											@endphp
                                                <span>{{$currency['code']}} {{$minPrice*$currency['value']}}</span>
                                                
                                            </div>
                                            <div class="book-btn">

                                            <a class="primary-btn2 loadvari" data-act="{{ $record->id }}" style="cursor:pointer;"  data-vid="{{ $vid }}" data-card-widget="collapse" title="Collapse">
                                            Select <i class="bi bi-arrow-right"></i>
                    </a>
                                               
                                            </div>
                                       </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        </div>

                        <div style="padding: 0px 20px;">
                                <div class="col-md-12">
			                              <div class="pdivvarc tourCard -type-2" id="pdivvar{{ $record->id }}" style="display: none;">
                                       <div class="col-md-12 var_data_div_cc" id="var_data_div{{ $record->id }}">

                                        </div>
                                    </div>

                                </div>
              
          
                         </div>
                       
                    </div>

                    @endforeach 
          <div class="pagination pull-right mt-3" id="pagination_ajax"> 
            
          
          {!! $records->appends(request()->query())->links() !!} </div>  
         
		  @php
					$total = 0;
					
					@endphp
					
					@else
						 <div class="room-suits-card mb-30">
                        <div class="row g-0 text-center">
                                <div class="room-content">
                                    <div class="content-center">
                                        <h5>
                                           No Record Found
                                        </h5>
                                       
                                       
                                    </div>
                                   
                                    
                                </div>
                         
                        </div>

                     
                       
                    </div>
					@endif