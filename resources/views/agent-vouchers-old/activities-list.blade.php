@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Activities Add To Vouchers(Voucher Code : {{$voucher->code}} )</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Activities</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
				<div class="card-tools">
          @if($voucherActivityCount > 0)
          <a href="{{ route('agent-vouchers.show',$voucher->id) }}" class="btn btn-sm btn-success">
            <i class="fas fa-shopping-cart"></i>
            Checkout({{$voucherActivityCount}})
        </a> 
        @endif
				 <a href="{{ route('agent-vouchers.index') }}" class="btn btn-sm btn-info">
                      <i class="fas fa-arrow-left"></i>
                      Back To Vouchers
                  </a> 
                 
				   </div>
           
              </div>
              <div class="">
                <div class="col-12 pt-2">
                <form id="filterForm" class="form-inline" method="get" action="{{ route('agent-vouchers.add.activity',$vid) }}" >
                  <div class="form-row align-items-center">
            
                    <div class="col-auto col-md-8">
                      <div class="input-group mb-2">
                        <div class="input-group-prepend"><div class="input-group-text">Activity Name</div></div>
                        <input type="text" name="name" value="{{ request('name') }}" class="form-control"  placeholder="Activity Name" />
                      </div>
                    </div>
                   
                   
                  <div class="col-auto col-md-4">
                    <button class="btn btn-info mb-2" type="submit">Filter</button>
                    <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('agent-vouchers.add.activity',$vid) }}">Clear</a>
                  </div>
                </form>
              </div></div>
              <!-- /.card-header -->
             <div class="card-body">
             
                  @foreach ($records as $record)
				  @php
            $minPrice = SiteHelpers::getActivityLowPrice($record->id,$record->agent_id);
          @endphp
                   <!-- Default box -->
      <div class="card collapsed-card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-3">
              <img src="{{asset('uploads/activities/'.$record->image)}}" class="img-fluid" style="width: 278px;height:173px" />
            </div>
            <div class="col-md-6">
              <h2 class="card-title" style="color: #000"><strong>{{$record->title}}</strong></h2>
              <br/> <br/>
              <ul class="list-unstyled">
                <li>
                  <a href="#" class="btn-link text-secondary"><i class="far fa-fw  fa-check-circle"></i> Instant Confirmation</a>
                </li>
                <li>
                  <a href="#" class="btn-link text-secondary"><i class="far fa-fw  fa-check-circle "></i> Free Cancellation 24 hrs. Piror </a>
                </li>
               
                
              </ul>
            </div>
            <div class="col-md-3 text-right">
              <br/>
              <br/>
              <br/>
              <span style="color: #000;">
              From 
              <br/>
              AED {{$minPrice}}
              <br/>
              </span>
              <br/>
              <button type="button" data-act="{{ $record->id }}"  data-vid="{{ $vid }}" class="btn btn-info btn-tool loadvari" data-card-widget="collapse" title="Collapse">
                SELECT
              </button>
            </div>
          </div>
        
        </div>
        <div class="card-body pdivvarc" id="pdivvar{{ $record->id }}" style="display: none;">
          <div class="row p-2">
			 
            <div class="col-md-12 var_data_div_cc" id="var_data_div{{ $record->id }}">
                    
                  </div>
              
           </div>
        </div>
        <!-- /.card-body -->
        
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
				 
                  @endforeach
                 
				<div class="pagination pull-right mt-3"> {!! $records->appends(request()->query())->links() !!} </div> 
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
<script type="text/javascript">
  $(document).ready(function() {
$(document).on('click', '.loadvari', function(evt) {
  var actid = $(this).data('act');
  $("body #loader-overlay").show();
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           
		$.ajax({
            url: "{{route('get-agent-vouchers.activity.variant')}}",
            type: 'POST',
            dataType: "json",
            data: {
              act: $(this).data('act'),
              vid: $(this).data('vid'),
            },
            success: function( data ) {
               //console.log( data.html );
               //alert("#var_data_div");
               
             $("body .var_data_div_cc").html('');
             $("body .pdivvarc").css('display','none');
			      $("body #var_data_div"+actid).html(data.html);
            $("body #pdivvar"+actid).css('display','block');
            $("body #loader-overlay").hide();
            }
          });
});
});
</script>  
<script type="text/javascript">
  $(document).ready(function() {
   
 
 $(document).on('change', '.priceChange', function(evt) {
  
   let inputnumber = $(this).data('inputnumber');
   var activity_id = $("body  #activity_id").val();
   let activity_vat = $("body #activity_vat").val();
  
   let adult = parseInt($("body #adult"+inputnumber).val());
   let child = parseInt($("body #child"+inputnumber).val());
   let infant = parseInt($("body #infant"+inputnumber).val());
   let discount = parseFloat($("body #discount"+inputnumber).val());
   //alert(discount);
   let markup_p_ticket_only = parseFloat($("body #markup_p_ticket_only"+inputnumber).val());
   let markup_p_sic_transfer = parseFloat($("body #markup_p_sic_transfer"+inputnumber).val());
   let markup_p_pvt_transfer = parseFloat($("body #markup_p_pvt_transfer"+inputnumber).val());
   
   let adultPrice = $("body #adultPrice"+inputnumber).val();
   let childPrice = $("body #childPrice"+inputnumber).val();
   let infPrice = $("body #infPrice"+inputnumber).val();
   var ad_price = (adult*adultPrice) ;
   var chd_price = (child*childPrice) ;
   var ad_ch_TotalPrice = ad_price + chd_price;
   var ticket_only_markupamt = ((ad_ch_TotalPrice*markup_p_ticket_only)/100);
   
   
   let t_option_val = $("body #transfer_option"+inputnumber).find(':selected').data("id");
   $("body #pickup_location"+inputnumber).val('');
   let grandTotal = 0;
   let grandTotalAfterDis = 0;
   if(t_option_val == 3)
   {
     var totaladult = parseInt(adult + child);
   getPVTtransfer(activity_id,totaladult,markup_p_pvt_transfer,inputnumber);
   $("body #loader-overlay").show();	
   waitForInputValue(inputnumber, function(pvt_transfer_markupamt_total) {
     var totalPrice = parseFloat(ad_ch_TotalPrice + (infant * infPrice) + ticket_only_markupamt  + pvt_transfer_markupamt_total);
     
     grandTotal = ( (totalPrice - discount));
     let vatPrice = parseFloat(((activity_vat/100) * grandTotal));
     grandTotalAfterDis = parseFloat(grandTotal+vatPrice);
        
     if(isNaN(grandTotalAfterDis))
     {
     $("body #totalprice"+inputnumber).val(0);
     $("body #price"+inputnumber).text(0);
     }
     else
     {
       if(grandTotalAfterDis > 0)
       {
       $("body #totalprice"+inputnumber).val(grandTotalAfterDis.toFixed(2));
       $("body #price"+inputnumber).text(grandTotalAfterDis.toFixed(2));
       }
       else
       {
         $("body #totalprice"+inputnumber).val(0);
         $("body #price"+inputnumber).text(0);
       }
     }
     $("body #loader-overlay").hide();
     });
   }
   else
   {
     if(t_option_val == 2)
     {
       let zonevalue = parseFloat($("body #transfer_zone"+inputnumber).find(':selected').data("zonevalue"));
       let zoneptime = $("body #transfer_zone"+inputnumber).find(':selected').data("zoneptime");
       
       $("body #pickup_location"+inputnumber).val(zoneptime);
       var totaladult = parseInt(adult + child);
       let zonevalueTotal = (totaladult * zonevalue);
       $("body #zonevalprice"+inputnumber).val(zonevalueTotal);
       var sic_transfer_markupamt = ((zonevalueTotal *  markup_p_sic_transfer)/100);
       var totalPrice = parseFloat(ad_ch_TotalPrice + (infant * infPrice) + ticket_only_markupamt + sic_transfer_markupamt + zonevalueTotal);
       
       grandTotal = ( (totalPrice - discount));
        let vatPrice = parseFloat(((activity_vat/100) * grandTotal));
        grandTotalAfterDis = parseFloat(vatPrice + grandTotal);
     }
     else
     {
       var totalPrice = parseFloat(ad_ch_TotalPrice + (infant * infPrice) + ticket_only_markupamt);
       
        grandTotal = ( (totalPrice - discount));
       let vatPrice = parseFloat(((activity_vat/100) * grandTotal));
        grandTotalAfterDis = parseFloat(vatPrice + grandTotal);
       
     }
     
     if(isNaN(grandTotalAfterDis))
     {
     $("body #totalprice"+inputnumber).val(0);
     $("body #price"+inputnumber).text(0);
     }
     else
     {
     if(grandTotalAfterDis > 0)
       {
       $("body #totalprice"+inputnumber).val(grandTotalAfterDis.toFixed(2));
       $("body #price"+inputnumber).text(grandTotalAfterDis.toFixed(2));
       }
       else
       {
         $("body #totalprice"+inputnumber).val(0);
         $("body #price"+inputnumber).text(0);
       }
     }
   }
   
   
   
 });
 $(document).on('blur','.priceChangedis',function(){
   let inputnumber = $(this).data('inputnumber');
   let inputvale = parseFloat($(this).val());
   if(inputvale == null || isNaN(inputvale))
   {
     inputvale = 0;
     $(this).val(0);
   }
   $("body #adult"+inputnumber).trigger("change");
 });
 $(document).on('change', '.actcsk', function(evt) {
   let inputnumber = $(this).data('inputnumber');
   if ($(this).is(':checked')) {
       $("body #transfer_option"+inputnumber).prop('required',true);
     $("body #tour_date"+inputnumber).prop('required',true);
     
     $("body #transfer_option"+inputnumber).prop('disabled',false);
     $("body #tour_date"+inputnumber).prop('disabled',false);
     $("body #adult"+inputnumber).prop('disabled',false);
     $("body #child"+inputnumber).prop('disabled',false);
     $("body #infant"+inputnumber).prop('disabled',false);
     $("body #discount"+inputnumber).prop('disabled',false);
     } else {
       $("body #transfer_option"+inputnumber).prop('required',false);
     $("body #tour_date"+inputnumber).prop('required',false);
     
     $("body #transfer_option"+inputnumber).prop('disabled',true);
     $("body #tour_date"+inputnumber).prop('disabled',true);
     $("body #adult"+inputnumber).prop('disabled',true);
     $("body #child"+inputnumber).prop('disabled',true);
     $("body #infant"+inputnumber).prop('disabled',true);
     $("body #discount"+inputnumber).prop('disabled',true);
     }
 });
 
 $(document).on('change', '.t_option', function(evt) {
   //alert("Asas");
   //alert("Asas");
   let inputnumber = $(this).data('inputnumber');
   let t_option_val = $(this).find(':selected').data("id");
   $("body #top").removeAttr("colspan");
   $("body #transfer_zone_td"+inputnumber).css("display","none");
   $("body .coltd").css("display","none");
   //$("#pickup_location_td"+inputnumber).css("display","none");
   $("body #transfer_zone"+inputnumber).prop('required',false);
   $("body #zonevalprice"+inputnumber).val(0);
   $('body #transfer_zone'+inputnumber).prop('selectedIndex',0);
   $("body #pvt_traf_val"+inputnumber).val(0);
   $("body #adult"+inputnumber).trigger("change");
   if(t_option_val == 2){
     $("body #top").attr("colspan",2);
     $("body #transfer_zone_td"+inputnumber).css("display","block");
     $("body .coltd").css("display","block");
    // $("#pickup_location_td"+inputnumber).css("display","block");
     $("body #transfer_zone"+inputnumber).prop('required',true);
   } else if(t_option_val == 3){
     $("body #top").attr("colspan",2);
	 $("body .coltd").css("display","block")
     //$("#pickup_location_td"+inputnumber).css("display","block");
     var activity_id = $("body #activity_id").val();
     let adult = parseInt($("body #adult"+inputnumber).find(':selected').val());
     let child = parseInt($("body #child"+inputnumber).find(':selected').val());
     var totaladult = parseInt(adult + child);
     //alert(totaladult);
     let markup_p_pvt_transfer = parseFloat($("body #markup_p_pvt_transfer"+inputnumber).val());
     getPVTtransfer(activity_id,totaladult,markup_p_pvt_transfer,inputnumber);
     $("body #adult"+inputnumber).trigger("change");
   }
 });
 
 $(document).on('change', '.zoneselect', function(evt) {
   let inputnumber = $(this).data('inputnumber');
   let zonevalue = parseFloat($(this).find(':selected').data("zonevalue"));
   $("body #top").attr("colspan",2);
   let adult = parseInt($("body #adult"+inputnumber).find(':selected').val());
     let child = parseInt($("body #child"+inputnumber).find(':selected').val());
     var totaladult = parseInt(adult + child);
     let zonevalueTotal = totaladult * zonevalue;
     $("body #zonevalprice"+inputnumber).val(zonevalueTotal);
     $("body #adult"+inputnumber).trigger("change");
 });
 
 function getPVTtransfer(acvt_id,adult,markupPer,inputnumber)
 {
     $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });
     $.ajax({
             url: "{{route('voucher.getPVTtransferAmount')}}",
             type: 'POST',
             dataType: "json",
             data: {
                acvt_id: acvt_id,
          adult: adult,
          markupPer: markupPer
             },
             success: function( data ) {
                //console.log( data );
          $("body #pvt_traf_val"+inputnumber).val(data);
             }
           });
 }
 
 function waitForInputValue(inputnumber, callback) {
   var $input = $("body #pvt_traf_val" + inputnumber);
   
   var interval = setInterval(function() {
     var pvt_transfer_markupamt_total = parseFloat($input.val());
     
     if (!isNaN(pvt_transfer_markupamt_total)) {
       // Value is available, execute the callback function
       clearInterval(interval); // Stop the interval
       callback(pvt_transfer_markupamt_total);
     }
   }, 2000); // Check every 100 milliseconds
 }
 });
 
 $(document).on('keypress', '.onlynumbrf', function(evt) {
   var charCode = (evt.which) ? evt.which : evt.keyCode
   if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
     return false;
   return true;
 
 });
 
   </script> 
@endsection
