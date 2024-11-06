
		@php
		$tourDateArray = SiteHelpers::getDateList($voucher->travel_from_date,$voucher->travel_to_date,$activity->black_sold_out)
		@endphp
       
				
				<form action="{{route('agent-voucher.activity.save')}}" method="post" class="form" >
				{{ csrf_field() }}
				 <input type="hidden" id="activity_id" name="activity_id" value="{{ $aid }}"  />
				 <input type="hidden" id="v_id" name="v_id" value="{{ $vid }}"  />
				 <input type="hidden" id="activity_vat" name="activity_vat" value="{{ ($activity->vat > 0)?$activity->vat:0 }}"  />
				
			
                <table class="table table-bordered">
                  <thead>
				  @if(!empty($activityPrices))
					  @foreach($activityPrices as $kk => $ap)
				  @if($kk == 0)
                  <tr>
					<th>Tour Option</th>
                    <th id="top">Transfer Option</th>
					<th>Tour Date</th>
					<th>Adult (Above {{$ap->chield_end_age}} Yrs)</th>
                    <th>Child({{$ap->chield_start_age}}-{{$ap->chield_end_age}} Yrs)</th>
                    <th>Infant (Below {{$ap->chield_start_age}} Yrs)</th>
				
					<th>Net Discount</th>
					<th>Total Amount</th>
                  </tr>
				  @endif
				  
				  @php
				  $markup = SiteHelpers::getAgentMarkup($voucher->agent_id,$ap->activity_id,$ap->variant_code);
				  $actZone = SiteHelpers::getZone($activity->zones,$activity->sic_TFRS);
				 
				  @endphp
				   <tr>
                    <th><input type="checkbox"  name="activity_select[{{$ap->u_code}}]" id="activity_select{{$kk}}" value="{{ $aid }}" class="actcsk" data-inputnumber="{{$kk}}" /> {{$ap->variant_name}} - {{$ap->variant_code}}
					<input type="hidden"  name="variant_unique_code[{{$ap->u_code}}]" id="variant_unique_code{{$kk}}" value="{{ $ap->u_code }}" data-inputnumber="{{$kk}}" /> 
					<input type="hidden"  name="variant_name[{{$ap->u_code}}]" id="variant_name{{$kk}}" value="{{ $ap->variant_name }}" data-inputnumber="{{$kk}}" /> 
					<input type="hidden"  name="variant_code[{{$ap->u_code}}]" id="variant_code{{$kk}}" value="{{ $ap->variant_code }}" data-inputnumber="{{$kk}}" /> 
					</th>
					<td> <select name="transfer_option[{{$ap->u_code}}]" id="transfer_option{{$kk}}" class="form-control t_option" data-inputnumber="{{$kk}}" disabled="disabled">
						<option value="">--Select--</option>
						@if($activity->entry_type=='Ticket Only')
						<option value="Ticket Only" data-id="1">Ticket Only</option>
						@endif
						@if($activity->sic_TFRS==1)
						<option value="Shared Transfer" data-id="2">Shared Transfer</option>
						@endif
						@if($activity->pvt_TFRS==1)
						<option value="Pvt Transfer" data-id="3">Pvt Transfer</option>
						@endif
						</select>
						<input type="hidden" id="pvt_traf_val{{$kk}}" value="0"  name="pvt_traf_val[{{$ap->u_code}}]"    />
						</td>
						<td style="display:none" id="transfer_zone_td{{$kk}}"> 
						@if($activity->sic_TFRS==1)
						@if(!empty($actZone))
						<select name="transfer_zone[{{$ap->u_code}}]" id="transfer_zone{{$kk}}" class="form-control zoneselect"  data-inputnumber="{{$kk}}">
						
						
						@foreach($actZone as $z)
						<option value="{{$z['zone_id']}}" data-zonevalue="{{$z['zoneValue']}}" data-zoneptime="{{$z['pickup_time']}}">{{$z['zone']}}</option>
						@endforeach
						@else
							<input type="hidden" id="transfer_zone{{$kk}}" value=""  name="transfer_zone[{{$ap->u_code}}]"    />
						@endif
						</select>
						@else
							<input type="hidden" id="transfer_zone{{$kk}}" value=""  name="transfer_zone[{{$ap->u_code}}]"    />
						@endif
						
						<input type="hidden" id="zonevalprice{{$kk}}" value="0"  name="zonevalprice[{{$ap->u_code}}]"    />
					</td>
					<td class="coltd" style="display:none" >
							<input type="hidden" id="pickup_location{{$kk}}" value=""  name="pickup_location[{{$ap->u_code}}]" placeholder="Pickup Location" class="form-control"   />
						</td>
					<td>
					<select name="tour_date[{{$ap->u_code}}]" id="tour_date{{$kk}}" class="form-control" required disabled="disabled" >
						
						<option value="">--Select--</option>
						@foreach($tourDateArray as $dt)
						<option value="{{$dt}}">{{$dt}}</option>
						@endforeach
						
						</select>
					</td>
					<td><select name="adult[{{$ap->u_code}}]" id="adult{{$kk}}" class="form-control priceChange" required data-inputnumber="{{$kk}}" disabled="disabled">
						<option value="">0</option>
						@for($a=$ap->adult_min_no_allowed; $a<=$ap->adult_max_no_allowed; $a++)
						<option value="{{$a}}">{{$a}}</option>
						@endfor
						</select></td>
                    <td><select name="child[{{$ap->u_code}}]" id="child{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" disabled="disabled">
						@for($child=$ap->chield_min_no_allowed; $child<=$ap->chield_max_no_allowed; $child++)
						<option value="{{$child}}">{{$child}}</option>
						@endfor
						</select></td>
                    <td><select name="infant[{{$ap->u_code}}]" id="infant{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" disabled="disabled">
						@for($inf=$ap->infant_min_no_allowed; $inf<=$ap->infant_max_no_allowed; $inf++)
						<option value="{{$inf}}">{{$inf}}</option>
						@endfor
						</select></td>
						
						<input type="hidden" value="{{$markup['ticket_only']}}" id="markup_p_ticket_only{{$kk}}"  name="markup_p_ticket_only[{{$ap->u_code}}]"    />
						
						<input type="hidden" value="{{$markup['sic_transfer']}}" id="markup_p_sic_transfer{{$kk}}"  name="markup_p_sic_transfer[{{$ap->u_code}}]"    />
						
						<input type="hidden" value="{{$markup['pvt_transfer']}}" id="markup_p_pvt_transfer{{$kk}}"  name="markup_p_pvt_transfer[{{$ap->u_code}}]"    />
						
						<td>
						<input type="text" id="discount{{$kk}}" value="0"  name="discount[{{$ap->u_code}}]" disabled="disabled" data-inputnumber="{{$kk}}" class="form-control onlynumbrf priceChangedis"    />
						</td>
						<td>
						@php
						$priceAd = ($ap->adult_rate_without_vat*$ap->adult_min_no_allowed);
						$mar = (($priceAd * $markup['ticket_only'])/100);
						$price = ($priceAd + ($ap->chield_rate_without_vat*$ap->chield_min_no_allowed) + ($ap->infant_rate_without_vat*$ap->infant_min_no_allowed));
						
						$price +=$mar;
						if($activity->vat > 0){
						$vat = (($activity->vat * $price)/100);
						$price +=$vat;
						}
						
						@endphp
						<input type="hidden" value="{{$ap->adult_rate_without_vat}}" id="adultPrice{{$kk}}"  name="adultPrice[{{$ap->u_code}}]"    />
						
						<input type="hidden" value="{{$ap->chield_rate_without_vat}}" id="childPrice{{$kk}}"  name="childPrice[{{$ap->u_code}}]"    />
						<input type="hidden" value="{{$ap->infant_rate_without_vat}}" id="infPrice{{$kk}}"  name="infPrice[{{$ap->u_code}}]"    />
						<span id="price{{$kk}}">0</span>
						<input type="hidden" id="totalprice{{$kk}}" value="0"  name="totalprice[{{$ap->u_code}}]"    />
						</td>
                  </tr>
				  @endforeach
				 @endif
				  </table>
             
			  <div class="row">

        <div class="col-12 mt-3">
          <button type="submit" class="btn btn-primary float-right" name="save">Save</button>
        </div>
      </div>
			 </form>
          <!-- /.card-body --> 
       
      
    <!-- /.content -->
