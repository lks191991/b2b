@php
			$activity = $variantData['activity'];
			$ap = $variantData['activityVariants']['0'];
			$currency = SiteHelpers::getCurrencyPrice();
			@endphp
			@if(!empty($variantData))
				<form action="{{route('voucher.activity.save')}}" method="post" class="form" id="cartForm" >
				{{ csrf_field() }}
				 <input type="hidden" id="activity_id" name="activity_id" value="{{ $aid }}"  />
				 <input type="hidden" id="v_id" name="v_id" value="{{ $vid }}"  />
				 <input type="hidden" id="activity_vat" name="activity_vat" value="{{ ($activity->vat > 0)?$activity->vat:0 }}"  />
				 <input type="hidden" id="vat_invoice" name="vat_invoice" value="{{ $voucher->vat_invoice }}"  />
				 <input type="hidden" id="activity_type" name="activity_type" value="{{ $activity->product_type }}"  />
				 <input type="hidden" id="ucode" name="ucode" value="{{$variantData['activityVariants']['0']['ucode']}}"  />
				 <input type="hidden" id="timeslot" name="timeslot" value=""  />
				
				 <table class="table rounded-corners" style="border-radius: 10px !important;font-size:10pt;">
                  <thead>
				 
				 
					 
					 
				
                  <tr>
				  <th valign="middle" style="width: 220px;">Tour Option</th>
					<th valign="middle" style="width: 100px;">Tour Date</th>
                    <th id="top" valign="middle" style="width: 150px;" colspan="2">Transfer Option</th>
					
					
					
					<th valign="middle">Adult</th>
                    <th valign="middle">Child<br/><small>({{$ap->prices->child_start_age}}-{{$ap->prices->child_end_age}} Yrs)</small></th>
                    <th valign="middle">Infant<br/><small>(Below {{$ap->prices->child_start_age}} Yrs)</small></th>
					
					<th valign="middle">Total Amount</th>
					<th valign="middle"></th>
                  </tr>
				  </thead>
				@if(($activity->product_type == 'Bundle_Same') )

				<tbody>
				 
				   <tr>
				  
					<td >
					 
					
						@php 
						$bap = $variantData['activityVariants']['0'];
						@endphp 
					@foreach($variantData['activityVariants'] as $kk => $abap)

				  
				  
@php

$activites_id[] = $abap->id;
$activites_code[] = $abap->ucode;

 $actZone = SiteHelpers::getZone($bap->variant->zones,$bap->variant->sic_TFRS);
$tourDates = SiteHelpers::getDateListHotel($voucher->travel_from_date,$voucher->travel_to_date,$abap->variant->black_out,$abap->variant->sold_out);
if(($abap->activity->entry_type=='Limo') || ($abap->activity->entry_type=='Yacht'))
{
	$transferOption = "Ticket Only";
 } elseif(($abap->activity->entry_type=='Ticket Only') && ($abap->prices->adult_rate_without_vat > 0)){
$transferOption = "Ticket Only";
} elseif($abap->variant->sic_TFRS==1){
	$transferOption = "Shared Transfer";
}elseif($abap->variant->pvt_TFRS==1){
	$transferOption = "Pvt Transfer";
}

$ad = ($abap->prices->adult_min_no_allowed > 0)?$abap->prices->adult_min_no_allowed:0;
$ch = ($abap->prices->child_min_no_allowed > 0)?$abap->prices->child_min_no_allowed:0;
$inf = ($abap->prices->infant_min_no_allowed > 0)?$abap->prices->infant_min_no_allowed:0;


 @endphp
					
					
					@if($kk == 0)
					<span class="">
						
					<input type="radio" name="activity_select"  required id="activity_select{{$kk}}" value="{{ $bap->ucode }}" @if($kk == '0')  @endif class="actcsk" data-inputnumber="{{$kk}}" /> 
</span>
					
					@endif
					
					
					
					
						@endforeach
		
					@if(($activity->product_type == 'Bundle_Same'))
					<strong>{{$bap->activity->title}} </strong>
</td>
					<td>
						@php
						$dates = $disabledDay = "";
			$dates = SiteHelpers::getDisableDates($bap->variant->black_out,$bap->variant->sold_out);
			$disabledDay = SiteHelpers::getNovableActivityDays($bap->variant->availability);
						@endphp
				<input type="text" id="tour_date{{$kk}}" value="{{date('d-m-Y',strtotime($voucher->travel_from_date))}}"  name="tour_date[{{ $ap->ucode }}]" placeholder="Tour Date" class="form-control tour_datepicker priceChange" data-inputnumber="{{$kk}}" required    />
				
					
				<script>
$(function() {
    // PHP variables passed to JavaScript
    var disabledDates = <?php echo $dates; ?>;
    var disabledWeekdays = <?php echo $disabledDay; ?>;
	

    // Convert disabled dates to date objects
    var formattedDisabledDates = disabledDates.map(function(date) {
        return $.datepicker.parseDate('yy-mm-dd', date);
    });

    // Initialize datepicker with disabled weekdays and dates
    $('#tour_date{{$kk}}').datepicker({
        beforeShowDay: function(date) {
            // Get the day of the week (0-6)
            var day = date.getDay();
            // Check if the date is in the disabled dates array
            var isDateDisabled = formattedDisabledDates.some(function(disabledDate) {
                return disabledDate.getTime() === date.getTime();
            });
            // Disable the date if it is in disabled dates or if it's a disabled weekday
            return [!(isDateDisabled || disabledWeekdays.indexOf(day) !== -1)];
        },
        minDate: new Date(), // Disable past dates
        dateFormat: 'dd-mm-yy'
    });
});
</script>

						</td>	
					@endif
					
<td>
<input type="hidden"  name="activity_variant_id[{{$ap->ucode}}]" id="activity_variant_id{{$kk}}" value="{{implode(',',$activites_id)}}" data-inputnumber="{{$kk}}" /> 
<input type="hidden"  name="activity_variant_code[{{$ap->ucode}}]" id="activity_variant_code{{$kk}}" value="{{implode(',',$activites_code)}}" data-inputnumber="{{$kk}}" /> 

@php
	$priceCal = PriceHelper::getActivityPriceSaveInVoucher($transferOption,implode(',',$activites_id),$voucher->agent_id,$voucher->adults,$voucher->childs,$voucher->infants,0,$tourDates[0],"","","",$activity->product_type);
	
	@endphp
<select name="transfer_option[{{$ap->ucode}}]" id="transfer_option{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}"  >
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
						<div  id="transfer_zone_td{{$kk}}">
						@if($ap->variant->sic_TFRS==1)
						@if(!empty($actZone))
						<select name="transfer_zone[{{$ap->ucode}}]" id="transfer_zone{{$kk}}" class="form-control priceChange "  data-inputnumber="{{$kk}}">
						
						
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
					
					@if(($activity->entry_type == 'Yacht') || ($activity->entry_type == 'Limo'))
					<td>
						<select name="adult[{{$ap->ucode}}]" id="adult{{$kk}}" class="form-control priceChange"  data-inputnumber="{{$kk}}" >
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
						<td><select name="adult[{{$ap->ucode}}]" id="adult{{$kk}}" class="form-control priceChange"  data-inputnumber="{{$kk}}" >
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
                    <td><select name="child[{{$ap->ucode}}]" id="child{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" >
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
                    <td><select name="infant[{{$ap->ucode}}]" id="infant{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" >
						@if($ap->prices->infant_min_no_allowed == 0 || empty($ap->prices->infant_min_no_allowed))
						<option value="0">{{$ap->prices->infant_min_no_allowed}}</option>
						@endif
						@for($inf=$ap->prices->infant_min_no_allowed; $inf<=$ap->prices->infant_max_no_allowed; $inf++)
						<option value="{{$inf}}" @if($voucher->infants==$inf && $voucher->infants > 0) selected="selected" @endif>{{$inf}}</option>
						@endfor
						</select>
						
						</td>
						@endif
					
						<input type="hidden" id="discount{{$kk}}" style="width: 50px;" value="0"  name="discount[{{$ap->ucode}}]" data-inputnumber="{{$kk}}" class="form-control onlynumbrf priceChangedis"    />
						
						<td class="text-center" >
						<button type="button" class="btn btn-info btn-rounded priceModalBtn" data-inputnumber="{{$kk}}" data-variantid="{{$ap->variant_id}}"  name="save"><i class="fa fa-info"></i> </button>
						@if($kk == 0)
						{{$currency['code']}}  <span id="price{{$kk}}" class="priceclass" style="font-weight:bold">0</span>
					<input type="hidden" id="totalprice{{$kk}}" value="0"  name="totalprice[{{$ap->ucode}}]"    />
						@else
						{{$currency['code']}}  <span id="price{{$kk}}" class="priceclass" style="font-weight:bold">{{number_format($priceCal['totalprice']*$currency['value'], 0, '.', '')}}</span>
						<input type="hidden" id="totalprice{{$kk}}" value="{{number_format($priceCal['totalprice'], 0, '.', '')}}"  name="totalprice[{{$ap->ucode}}]"    />
						@endif
						
						</td>
						
						<td class="text-center" >
						
						<button type="button" class="primary-btn1-sm btn-sm addToCart" data-inputnumber="{{$kk}}" data-variantid="{{$ap->variant_id}}" id="addToCart{{$kk}}" name="save"><svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M17 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2M1 2v2h2l3.6 7.59l-1.36 2.45c-.15.28-.24.61-.24.96a2 2 0 0 0 2 2h12v-2H7.42a.25.25 0 0 1-.25-.25c0-.05.01-.09.03-.12L8.1 13h7.45c.75 0 1.41-.42 1.75-1.03l3.58-6.47c.07-.16.12-.33.12-.5a1 1 0 0 0-1-1H5.21l-.94-2M7 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2"/></svg> </button>
						</td>
						
                  </tr>
				  @if($ap->variant->cancellation_policy != '') 
					
				  	<tr style="background:green;color:#fff!important;">
					  <td colspan="9" style="color:#fff!important;">
							{!! $ap->variant->cancellation_policy !!}
						</td>
					</tr>

					@endif
				 
 <!-- End Same Date -->
   <!-- Start Different Date -->

@elseif(($activity->product_type == 'Bundle_Diff') || ($activity->activity_product_type == 'Package'))
@php
$varaint_count = 0;
@endphp
@foreach($variantData['activityVariants'] as $kk => $bap)
@php
$varaint_count++;
$activites_id[] = $bap->id;
$activites_code[] = $bap->ucode;
@endphp
@endforeach


<tbody>
				  @foreach($variantData['activityVariants'] as $kk => $ap)

				  
				 
				 @php
$dates = $disabledDay = "";
			$dates = SiteHelpers::getDisableDates($ap->variant->black_out,$ap->variant->sold_out);
			$disabledDay = SiteHelpers::getNovableActivityDays($ap->variant->availability);

				  $actZone = SiteHelpers::getZone($ap->variant->zones,$ap->variant->sic_TFRS);
				 $tourDates = SiteHelpers::getDateListHotel($voucher->travel_from_date,$voucher->travel_to_date,$ap->variant->black_out,$ap->variant->sold_out);
				 if(($ap->activity->entry_type=='Limo') || ($ap->activity->entry_type=='Yacht'))
				 {
					 $transferOption = "Ticket Only";
				  } elseif(($ap->activity->entry_type=='Ticket Only') && ($ap->prices->adult_rate_without_vat > 0)){
				 $transferOption = "Ticket Only";
				 } elseif($ap->variant->sic_TFRS==1){
					 $transferOption = "Shared Transfer";
				 }elseif($ap->variant->pvt_TFRS==1){
					 $transferOption = "Pvt Transfer";
				 }
				
				 $ad = ($ap->prices->adult_min_no_allowed > 0)?$ap->prices->adult_min_no_allowed:0;
				 $ch = ($ap->prices->child_min_no_allowed > 0)?$ap->prices->child_min_no_allowed:0;
				 $inf = ($ap->prices->infant_min_no_allowed > 0)?$ap->prices->infant_min_no_allowed:0;
				 
				//$priceCal = PriceHelper::getActivityPriceSaveInVoucher($transferOption,$ap->id,$voucher->agent_id,$ad,$ch,$inf,0,$tourDates[0]);
				$priceCal = PriceHelper::getActivityPriceSaveInVoucher($transferOption,implode(',',$activites_id),$voucher->agent_id,$voucher->adults,$voucher->childs,$voucher->infants,0,$tourDates[0]);
 
				  @endphp
				   <tr>
                    <td style="width: 200px;">
					
					<input type="hidden"  name="variant_dis_dates[{{$ap->ucode}}]" id="variant_dis_dates{{$kk}}" value="{{$disabledDay}}" data-inputnumber="{{$kk}}" /> 
					<input type="hidden"  name="variant_dis_days[{{$ap->ucode}}]" id="variant_dis_days{{$kk}}" value="{{$dates}}" data-inputnumber="{{$kk}}" /> 
					

					<input type="hidden"  name="activity_variant_id[{{$ap->ucode}}]" id="activity_variant_id{{$kk}}" value="{{implode(',',$activites_id)}}" data-inputnumber="{{$kk}}" /> 
<input type="hidden"  name="activity_variant_code[{{$ap->ucode}}]" id="activity_variant_code{{$kk}}" value="{{implode(',',$activites_code)}}" data-inputnumber="{{$kk}}" /> 

					<input type="checkbox"  name="activity_select_display" required id="activity_select_display{{$kk}}" value="" checked  data-inputnumber="{{$kk}}" disabled />
					<input type="checkbox"  name="activity_select" required id="activity_select{{$kk}}" value="{{ $ap->ucode }}" @if($kk == '0')  @endif class="actcsk d-none" data-inputnumber="{{$kk}}" /> <strong>{{$ap->variant->title}} </strong>

				
					</td>
				<td>
					<input type="text" id="tour_date{{$kk}}" value="{{date('d-m-Y',strtotime($voucher->travel_from_date))}}"  name="tour_date[{{ $ap->ucode }}]" placeholder="Tour Date" class="form-control tour_datepicker priceChange" data-inputnumber="{{$kk}}" required @if($kk > '0') disabled="disabled" @endif     />

					<script>
$(function() {
    // PHP variables passed to JavaScript
    var disabledDates = <?php echo $dates; ?>;
    var disabledWeekdays = <?php echo $disabledDay; ?>;
	

    // Convert disabled dates to date objects
    var formattedDisabledDates = disabledDates.map(function(date) {
        return $.datepicker.parseDate('yy-mm-dd', date);
    });

    // Initialize datepicker with disabled weekdays and dates
    $('#tour_date{{$kk}}').datepicker({
        beforeShowDay: function(date) {
            // Get the day of the week (0-6)
            var day = date.getDay();
            // Check if the date is in the disabled dates array
            var isDateDisabled = formattedDisabledDates.some(function(disabledDate) {
                return disabledDate.getTime() === date.getTime();
            });
            // Disable the date if it is in disabled dates or if it's a disabled weekday
            return [!(isDateDisabled || disabledWeekdays.indexOf(day) !== -1)];
        },
        minDate: new Date(), // Disable past dates
        dateFormat: 'dd-mm-yy',
		onSelect: function(selectedDate) {
        // Your function to handle the date selection
        handleDateSelection(selectedDate); // Call your custom function with the selected date
    }
    });
});
</script>

					
					</td>

					<td> <select name="transfer_option[{{$ap->ucode}}]" id="transfer_option{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" @if($kk > 0) readonly='readonly' @endif >
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
						<select name="transfer_zone[{{$ap->ucode}}]" id="transfer_zone{{$kk}}" class="form-control priceChange trfzone"  data-inputnumber="{{$kk}}">
						
						
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
						
					
					@if(($activity->entry_type == 'Yacht') || ($activity->entry_type == 'Limo'))
					<td>
						<select name="adult[{{$ap->ucode}}]" id="adult{{$kk}}" class="form-control priceChange"  data-inputnumber="{{$kk}}"  @if($kk > 0) readonly='readonly' @endif>
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
						<td><select name="adult[{{$ap->ucode}}]" id="adult{{$kk}}" class="form-control priceChange priceChangeBDA"  data-inputnumber="{{$kk}}" @if($kk > 0) readonly='readonly' @endif>
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
                    <td><select name="child[{{$ap->ucode}}]" id="child{{$kk}}" class="form-control priceChange priceChangeBDC" data-inputnumber="{{$kk}}" @if($kk > 0) readonly='readonly'  @endif>
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
                    <td><select name="infant[{{$ap->ucode}}]" id="infant{{$kk}}" class="form-control priceChange priceChangeBDI" data-inputnumber="{{$kk}}" @if($kk > 0) readonly='readonly'  @endif>
						@if($ap->prices->infant_min_no_allowed == 0 || empty($ap->prices->infant_min_no_allowed))
						<option value="0">{{$ap->prices->infant_min_no_allowed}}</option>
						@endif
						@for($inf=$ap->prices->infant_min_no_allowed; $inf<=$ap->prices->infant_max_no_allowed; $inf++)
						<option value="{{$inf}}" @if($voucher->infants==$inf && $voucher->infants > 0) selected="selected" @endif>{{$inf}}</option>
						@endfor
						</select>
						
						</td>
						@endif
					
						<input type="hidden" id="discount{{$kk}}" style="width: 50px;" value="0"  name="discount[{{$ap->ucode}}]" data-inputnumber="{{$kk}}" class="form-control onlynumbrf priceChangedis"    />
						@if($kk == 0)
						<td class="text-center" rowspan="{{ $varaint_count }}" >
						<button type="button" class="btn btn-info btn-rounded priceModalBtn" data-inputnumber="{{$kk}}" data-variantid="{{$ap->variant_id}}"  name="save"><i class="fa fa-info"></i> </button>
						@if($kk == 0)
						{{$currency['code']}} <span id="price{{$kk}}" class="priceclass" style="font-weight:bold">0</span>
					<input type="hidden" id="totalprice{{$kk}}" value="0"  name="totalprice[{{$ap->ucode}}]"    />
						@else
						{{$currency['code']}}  <span id="price{{$kk}}" class="priceclass" style="font-weight:bold">{{number_format($priceCal['totalprice']*$currency['value'], 0, '.', '')}}</span>
						<input type="hidden" id="totalprice{{$kk}}" value="{{number_format($priceCal['totalprice'], 0, '.', '')}}"  name="totalprice[{{$ap->ucode}}]"    />
						@endif
						
						</td>
					
						<td class="text-center" rowspan="{{ $varaint_count }}">
						
						<button type="button" class="primary-btn1-sm btn-sm addToCart" data-inputnumber="{{$kk}}" data-variantid="{{$ap->variant_id}}" id="addToCart{{$kk}}" name="save"><svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M17 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2M1 2v2h2l3.6 7.59l-1.36 2.45c-.15.28-.24.61-.24.96a2 2 0 0 0 2 2h12v-2H7.42a.25.25 0 0 1-.25-.25c0-.05.01-.09.03-.12L8.1 13h7.45c.75 0 1.41-.42 1.75-1.03l3.58-6.47c.07-.16.12-.33.12-.5a1 1 0 0 0-1-1H5.21l-.94-2M7 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2"/></svg> </button>
						</td>
						@endif
						
                  </tr>
				  @if($ap->variant->cancellation_policy != '') 
					
				  <tr id="note_{{$kk}}" class="note d-none" style="background:green;color:#fff!important;">
						<td colspan="9" style="color:#fff!important;">
							{!! $ap->variant->cancellation_policy !!}
						</td>
					</tr>

					@endif
				  @endforeach
</tbody>
				  <!-- Normal Products -->
@else
				  @foreach($variantData['activityVariants'] as $kk => $ap)

				  
				  <tbody>
				 @php
$dates = $disabledDay = "";
			$dates = SiteHelpers::getDisableDates($ap->variant->black_out,$ap->variant->sold_out);
			$disabledDay = SiteHelpers::getNovableActivityDays($ap->variant->availability);

				  $actZone = SiteHelpers::getZone($ap->variant->zones,$ap->variant->sic_TFRS);
				 $tourDates = SiteHelpers::getDateListHotel($voucher->travel_from_date,$voucher->travel_to_date,$ap->variant->black_out,$ap->variant->sold_out);
				 if(($ap->activity->entry_type=='Limo') || ($ap->activity->entry_type=='Yacht'))
				 {
					 $transferOption = "Ticket Only";
				  } elseif(($ap->activity->entry_type=='Ticket Only') && ($ap->prices->adult_rate_without_vat > 0)){
				 $transferOption = "Ticket Only";
				 } elseif($ap->variant->sic_TFRS==1){
					 $transferOption = "Shared Transfer";
				 }elseif($ap->variant->pvt_TFRS==1){
					 $transferOption = "Pvt Transfer";
				 }
				
				 $ad = ($ap->prices->adult_min_no_allowed > 0)?$ap->prices->adult_min_no_allowed:0;
				 $ch = ($ap->prices->child_min_no_allowed > 0)?$ap->prices->child_min_no_allowed:0;
				 $inf = ($ap->prices->infant_min_no_allowed > 0)?$ap->prices->infant_min_no_allowed:0;
				 
				$priceCal = PriceHelper::getActivityPriceSaveInVoucher($transferOption,$ap->id,$voucher->agent_id,$ad,$ch,$inf,0,$tourDates[0]);
				 
				  @endphp
				   <tr>
                    <td style="width: 300px;">
					
					<input type="hidden"  name="variant_dis_dates[{{$ap->ucode}}]" id="variant_dis_dates{{$kk}}" value="{{$disabledDay}}" data-inputnumber="{{$kk}}" /> 
					<input type="hidden"  name="variant_dis_days[{{$ap->ucode}}]" id="variant_dis_days{{$kk}}" value="{{$dates}}" data-inputnumber="{{$kk}}" /> 
					

					<input type="hidden"  name="activity_variant_code[{{$ap->ucode}}]" id="activity_variant_code{{$kk}}" value="{{$ap->ucode}}" data-inputnumber="{{$kk}}" /> 
					<input type="hidden"  name="activity_variant_id[{{$ap->ucode}}]" id="activity_variant_id{{$kk}}" value="{{$ap->id}}" data-inputnumber="{{$kk}}" /> 
					
					<input type="radio"  name="activity_select" required id="activity_select{{$kk}}" value="{{ $ap->ucode }}" @if($kk == '0') checked='checked' @endif class="actcsk" data-inputnumber="{{$kk}}" /> <strong>{{$ap->variant->title}} </strong>

				
					</td>
				<td>
					<input type="text" id="tour_date{{$kk}}" value="{{date('d-m-Y',strtotime($voucher->travel_from_date))}}"  name="tour_date[{{ $ap->ucode }}]" placeholder="Tour Date" class="form-control tour_datepicker priceChange" data-inputnumber="{{$kk}}" required @if($kk > '0') disabled="disabled" @endif     />

					<script>
$(function() {
    // PHP variables passed to JavaScript
    var disabledDates = <?php echo $dates; ?>;
    var disabledWeekdays = <?php echo $disabledDay; ?>;
	

    // Convert disabled dates to date objects
    var formattedDisabledDates = disabledDates.map(function(date) {
        return $.datepicker.parseDate('yy-mm-dd', date);
    });

    // Initialize datepicker with disabled weekdays and dates
    $('#tour_date{{$kk}}').datepicker({
        beforeShowDay: function(date) {
            // Get the day of the week (0-6)
            var day = date.getDay();
            // Check if the date is in the disabled dates array
            var isDateDisabled = formattedDisabledDates.some(function(disabledDate) {
                return disabledDate.getTime() === date.getTime();
            });
            // Disable the date if it is in disabled dates or if it's a disabled weekday
            return [!(isDateDisabled || disabledWeekdays.indexOf(day) !== -1)];
        },
        minDate: new Date(), // Disable past dates
        dateFormat: 'dd-mm-yy'
    });
});
</script>

					
					</td>

					<td> <select name="transfer_option[{{$ap->ucode}}]" id="transfer_option{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" @if($kk > 0) disabled="disabled" @endif >
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
						
					
					@if(($activity->entry_type == 'Yacht') || ($activity->entry_type == 'Limo'))
					<td>
						<select name="adult[{{$ap->ucode}}]" id="adult{{$kk}}" class="form-control priceChange"  data-inputnumber="{{$kk}}" @if($kk > 0) disabled="disabled" @endif>
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
						<td><select name="adult[{{$ap->ucode}}]" id="adult{{$kk}}" class="form-control priceChange"  data-inputnumber="{{$kk}}" @if($kk > 0) disabled="disabled" @endif>
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
                    <td><select name="child[{{$ap->ucode}}]" id="child{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" @if($kk > 0) disabled="disabled" @endif>
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
                    <td><select name="infant[{{$ap->ucode}}]" id="infant{{$kk}}" class="form-control priceChange" data-inputnumber="{{$kk}}" @if($kk > 0)disabled="disabled" @endif>
						@if($ap->prices->infant_min_no_allowed == 0 || empty($ap->prices->infant_min_no_allowed))
						<option value="0">{{$ap->prices->infant_min_no_allowed}}</option>
						@endif
						@for($inf=$ap->prices->infant_min_no_allowed; $inf<=$ap->prices->infant_max_no_allowed; $inf++)
						<option value="{{$inf}}" @if($voucher->infants==$inf && $voucher->infants > 0) selected="selected" @endif>{{$inf}}</option>
						@endfor
						</select>
						
						</td>
						@endif
					
						<input type="hidden" id="discount{{$kk}}" style="width: 50px;" value="0"  name="discount[{{$ap->ucode}}]" data-inputnumber="{{$kk}}" class="form-control onlynumbrf priceChangedis"    />
						
						<td class="text-center" >
						<button type="button" class="btn btn-info btn-rounded priceModalBtn" data-inputnumber="{{$kk}}" data-variantid="{{$ap->variant_id}}"  name="save"><i class="fa fa-info"></i> </button>
						@if($kk == 0)
						{{$currency['code']}}  <span id="price{{$kk}}" class="priceclass" style="font-weight:bold">0</span>
					<input type="hidden" id="totalprice{{$kk}}" value="0"  name="totalprice[{{$ap->ucode}}]"    />
						@else
						{{$currency['code']}}  <span id="price{{$kk}}" class="priceclass" style="font-weight:bold">{{number_format($priceCal['totalprice']*$currency['value'], 0, '.', '')}}</span>
						<input type="hidden" id="totalprice{{$kk}}" value="{{number_format($priceCal['totalprice'], 0, '.', '')}}"  name="totalprice[{{$ap->ucode}}]"    />
						@endif
						
						</td>
						
						<td class="text-center" >
						
						<button type="button" class="primary-btn1-sm btn-sm addToCart" data-inputnumber="{{$kk}}" data-variantid="{{$ap->variant_id}}" id="addToCart{{$kk}}" name="save"><svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M17 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2M1 2v2h2l3.6 7.59l-1.36 2.45c-.15.28-.24.61-.24.96a2 2 0 0 0 2 2h12v-2H7.42a.25.25 0 0 1-.25-.25c0-.05.01-.09.03-.12L8.1 13h7.45c.75 0 1.41-.42 1.75-1.03l3.58-6.47c.07-.16.12-.33.12-.5a1 1 0 0 0-1-1H5.21l-.94-2M7 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2"/></svg> </button>
						</td>
						
                  </tr>
				  @if($ap->variant->cancellation_policy != '') 
					
				  <tr id="note_{{$kk}}" class="note d-none" style="background:green;color:#fff!important;">
						<td colspan="9" style="color:#fff!important;">
							{!! $ap->variant->cancellation_policy !!}
						</td>
					</tr>

					@endif
				  @endforeach
				@endif
					</tbody>
				  </table>
				  
			
			 </form>
			 @endif
   
          <!-- /.card-body --> 
       <script>
		$(document).ready(function() {

$('.popoverOption').popover({ trigger: "hover" });
		});
	   </script>
      
    <!-- /.content -->


						