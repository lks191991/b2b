			@php
			$activity = $variantData['activity'];
			 
			@endphp
				<form action="{{route('agent-voucher.activity.save')}}" method="post" class="form" id="cartForm" >
				{{ csrf_field() }}
				 <input type="hidden" id="activity_id" name="activity_id" value="{{ $aid }}"  />
				 <input type="hidden" id="v_id" name="v_id" value="{{ $vid }}"  />
				 <input type="hidden" id="activity_vat" name="activity_vat" value="{{ ($activity->vat > 0)?$activity->vat:0 }}"  />
				 <input type="hidden" id="vat_invoice" name="vat_invoice" value="{{ $voucher->vat_invoice }}"  />
				 <input type="hidden" id="ucode" name="ucode" value=""  />
				 <input type="hidden" id="timeslot" name="timeslot" value=""  />
				 <table class="table rounded-corners" style="border-radius: 10px !important;font-size:10pt;">
                  <thead>
				 
				  @if(!empty($variantData))
					 
					  @foreach($variantData['activityVariants'] as $kk => $ap)
				  @if($kk == 0)
                  <tr>
					<th valign="middle">Tour Option</th>
                    <th id="top" valign="middle"  colspan="2">Transfer Option</th>
					<th valign="middle">Tour Date</th>
					@if(($activity->entry_type == 'Yacht') || ($activity->entry_type == 'Limo'))
					<th valign="middle">Hours</th>
					@else
					<th valign="middle">Adult<small style="display:block">(8+)</small></th>
                    <th valign="middle">Child<small  style="display:block">(3-8)</small></th>
                    <th valign="middle">Infant<small  style="display:block">0-3)</small></th>
					@endif
					<th valign="middle" colspan="2">Total</th>
					
                  </tr>
				  </thead>
				  @endif
				  <tbody>
				 @php
				  $actZone = SiteHelpers::getZone($ap->variant->zones,$ap->variant->sic_TFRS);
				 $tourDates = SiteHelpers::getDateList($voucher->travel_from_date,$voucher->travel_to_date,$ap->variant->black_out,$ap->variant->sold_out);
				 
				 if(($ap->activity->entry_type=='Ticket Only') && ($ap->prices->adult_rate_without_vat > 0)){
				 $transferOption = "Ticket Only";
				 } elseif($ap->variant->sic_TFRS==1){
					 $transferOption = "Shared Transfer";
				 }elseif($ap->variant->pvt_TFRS==1){
					 $transferOption = "Pvt Transfer";
				 }
				 
				 $ad = ($ap->prices->adult_min_no_allowed > 0)?$ap->prices->adult_min_no_allowed:0;
				 $ch = ($ap->prices->child_min_no_allowed > 0)?$ap->prices->child_min_no_allowed:0;
				 $inf = ($ap->prices->infant_min_no_allowed > 0)?$ap->prices->infant_min_no_allowed:0;
				 
				 $priceCal = PriceHelper::getActivityPriceSaveInVoucher($transferOption,$ap->id,$voucher->agent_id,$voucher,$ap->ucode,$ad,$ch,$inf,0,$tourDates[0]);
				 $currency = SiteHelpers::getCurrencyPrice();
				  @endphp
				   <tr>
                    <td>
					
					<input type="hidden"  name="activity_variant_id[{{$ap->ucode}}]" id="activity_variant_id{{$kk}}" value="{{$ap->id}}" data-inputnumber="{{$kk}}" /> 
					<input type="hidden"  name="activity_variant_name[{{$ap->ucode}}]" id="activity_variant_name{{$kk}}" value="{{$ap->variant->title}}" data-inputnumber="{{$kk}}" /> 
					
					<input type="radio"  name="activity_select" required id="activity_select{{$kk}}" value="{{ $ap->ucode }}" @if($kk == '0')  @endif class="actcsk" data-inputnumber="{{$kk}}" /> {{$ap->variant->title}} 
					</td>
					<td> <select name="transfer_option[{{$ap->ucode}}]" id="transfer_option{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" @if($kk > '0') disabled="disabled" @endif >
					@if(($activity->entry_type == 'Yacht') || ($activity->entry_type == 'Limo'))
					<option value="Ticket Only" data-id="1">Ticket Only</option>
					@else	
						@if(($ap->activity->entry_type=='Ticket Only') && ($ap->prices->adult_rate_without_vat > 0))
						<option value="Ticket Only" data-id="1">Ticket Only</option>
						@endif
						@if($ap->variant->sic_TFRS==1)
						<option value="Shared Transfer" data-id="2">Shared Transfer</option>
						@endif
						@if($ap->variant->pvt_TFRS==1)
						<option value="Pvt Transfer" data-id="3" data-variant="{{$ap->variant_id}}" >Pvt Transfer</option>
						@endif
					@endif
						</select>
						<input type="hidden" id="pvt_traf_val{{$kk}}" value="0"  name="pvt_traf_val[{{$ap->ucode}}]"    />
						</td>
						<td> 
						<div  style="display:none;border:none;" id="transfer_zone_td{{$kk}}">
						@if($ap->variant->sic_TFRS==1)
						@if(!empty($actZone))
						<select name="transfer_zone[{{$ap->ucode}}]" id="transfer_zone{{$kk}}" class="form-control priceChange"  data-inputnumber="{{$kk}}">
						
						
						@foreach($actZone as $z)
						<option value="{{$z['zone_id']}}" data-zonevalue="{{$z['zoneValue']}}" data-zonevaluechild="{{@$z['zoneValueChild']}}" data-zoneptime="{{$z['pickup_time']}}">{{$z['zone']}}</option>
						@endforeach
						@else
							<input type="hidden" id="transfer_zone{{$kk}}" value=""  name="transfer_zone[{{$ap->ucode}}]"    />
						@endif
						</select>
						@else
							<input type="hidden" id="transfer_zone{{$kk}}" value=""  name="transfer_zone[{{$ap->ucode}}]"    />
						@endif
						
						</div> 
						</td>
					<td>
				
					<select name="tour_date[{{$ap->ucode}}]" id="tour_date{{$kk}}"  class="form-control priceChange" data-inputnumber="{{$kk}}"  >
						
						<option value="">--Select--</option>
						@foreach($tourDates as $k => $tourDate)
						<option value="{{$tourDate}}" {{($k==0)?'selected':'' }} >{{$tourDate}}</option>
						@endforeach
						</select>
						
					
					</td>
					@if(($activity->entry_type == 'Yacht') || ($activity->entry_type == 'Limo'))
					<td><select name="adult[{{$ap->ucode}}]" id="adult{{$kk}}" class="form-control priceChange"  data-inputnumber="{{$kk}}" @if($kk > '0') disabled="disabled" @endif>
						@if($ap->prices->adult_min_no_allowed == 0 || empty($ap->prices->adult_min_no_allowed))
						<option value="0">{{$ap->prices->adult_min_no_allowed}}</option>
						@endif
						@for($a=$ap->prices->adult_min_no_allowed; $a<=$ap->prices->adult_max_no_allowed; $a++)
						@if($ap->prices->adult_max_no_allowed > 0)
							@if($voucher->adults > 0)
						<option value="{{$a}}" @if($voucher->adults==$a) selected="selected" @endif>{{$a}}</option>
							@else
							<option value="{{$a}}" @if($a==$ap->prices->adult_min_no_allowed) selected="selected" @endif>{{$a}}</option>	
							@endif
						@endif
						@endfor
						</select>
						<input type="hidden" name="child[{{$ap->ucode}}]" id="child{{$kk}}"  value="0"   />
						<input type="hidden" name="infant[{{$ap->ucode}}]" id="infant{{$kk}}"  value="0"    />
					
					</td>
						@else
					<td><select name="adult[{{$ap->ucode}}]" id="adult{{$kk}}" class="form-control priceChange"  data-inputnumber="{{$kk}}" @if($kk > '0') disabled="disabled" @endif>
						@if($ap->prices->adult_min_no_allowed == 0 || empty($ap->prices->adult_min_no_allowed))
						<option value="0">{{$ap->prices->adult_min_no_allowed}}</option>
						@endif
						@for($a=$ap->prices->adult_min_no_allowed; $a<=$ap->prices->adult_max_no_allowed; $a++)
						@if($ap->prices->adult_max_no_allowed > 0)
							@if($voucher->adults > 0)
						<option value="{{$a}}" @if($voucher->adults==$a) selected="selected" @endif>{{$a}}</option>
							@else
							<option value="{{$a}}" @if($a==$ap->prices->adult_min_no_allowed) selected="selected" @endif>{{$a}}</option>	
							@endif
						@endif
						@endfor
						</select></td>
                    <td><select name="child[{{$ap->ucode}}]" id="child{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" @if($kk > '0') disabled="disabled" @endif>
						@if($ap->prices->child_min_no_allowed == 0  || empty($ap->prices->child_min_no_allowed))
						<option value="0">{{$ap->prices->child_min_no_allowed}}</option>
						@endif
						
						@for($child=$ap->prices->child_min_no_allowed; $child<=$ap->prices->child_max_no_allowed; $child++)
							@if($child > 0)
								@if($voucher->childs > 0)
						<option value="{{$child}}" @if($voucher->childs==$child) selected="selected" @endif>{{$child}}</option>
							@else
							<option value="{{$child}}" @if($child==$ap->prices->child_min_no_allowed) selected="selected" @endif>{{$child}}</option>	
							@endif
					@endif
						@endfor
						</select></td>
						
                    <td><select name="infant[{{$ap->ucode}}]" id="infant{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" @if($kk > '0') disabled="disabled" @endif>
					@if($ap->prices->infant_min_no_allowed == 0 || empty($ap->prices->infant_min_no_allowed))
						<option value="0">{{$ap->prices->infant_min_no_allowed}}</option>
						@endif
						@if($ap->prices->infant_max_no_allowed == 0 )
						<option value="0">{{$ap->prices->infant_max_no_allowed}}</option>
						@endif
						@for($inf=$ap->prices->infant_min_no_allowed; $inf<=$ap->prices->infant_max_no_allowed; $inf++)
						<option value="{{$inf}}" @if($voucher->infants==$inf && $voucher->infants > 0) selected="selected" @endif>{{$inf}}</option>
					
						@endfor
						</select>
						
						</td>
						@endif
					
					
						<td class="text-center" >
							
						<input type="hidden" id="discount{{$kk}}" style="width: 50px;" value="0"  name="discount[{{$ap->ucode}}]" data-inputnumber="{{$kk}}" class="form-control onlynumbrf priceChangedis"    />
						
						<!--<a id="" class="btn popoverOption" href="#" data-content="Popup with option trigger" rel="popover" data-placement="bottom" data-original-title="Title">Popup with option trigger</a>-->



						
						
						
							{{$currency['code']}}  <span id="price{{$kk}}" class="priceclass" style="font-weight:bold">{{number_format($priceCal['totalprice']*$currency['value'], 0, '.', '')}}</span>
						<input type="hidden" id="totalprice{{$kk}}" value="{{number_format($priceCal['totalprice'], 0, '.', '')}}"  name="totalprice[{{$ap->ucode}}]"    />
						
						<button type="button" class="btn btn-info btn-rounded priceModalBtn" data-inputnumber="{{$kk}}" data-variantid="{{$ap->variant_id}}"  name="save"><i class="fa fa-info"></i> </button>
						
						</td>
						
						<td class="text-center" >
						
						<button type="button" class="primary-btn1-sm btn-sm addToCart" data-inputnumber="{{$kk}}" data-variantid="{{$ap->variant_id}}" id="addToCart{{$kk}}" name="save"><svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M17 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2M1 2v2h2l3.6 7.59l-1.36 2.45c-.15.28-.24.61-.24.96a2 2 0 0 0 2 2h12v-2H7.42a.25.25 0 0 1-.25-.25c0-.05.01-.09.03-.12L8.1 13h7.45c.75 0 1.41-.42 1.75-1.03l3.58-6.47c.07-.16.12-.33.12-.5a1 1 0 0 0-1-1H5.21l-.94-2M7 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2"/></svg> </button>
						</td>
						
                  </tr>
				  @endforeach
				 @endif
					</tbody>
				  </table>
				  
			
			 </form>
          <!-- /.card-body --> 
       <script>
		$(document).ready(function() {

$('.popoverOption').popover({ trigger: "hover" });
		});
	   </script>
      
    <!-- /.content -->
