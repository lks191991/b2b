@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Quick Quotation ( {{$voucher->code}})</h1>
          </div>
		 
						
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
     

        <div class="row" style="margin-top: 30px;">
       
		
          <!-- left column -->
          <div class="offset-md-2 col-md-8">
		   <form id="cusDetails" method="post" action="{{route('agent.vouchers.status.change',$voucher->id)}}" >
			 {{ csrf_field() }}
            <!-- general form elements -->
            <div class="card card-default">
              <div class="card-header">
                 <h3 class="card-title"><i class="nav-icon fas fa-user" style="color:black"></i> Agent Details</h3>
				 <h3 class="card-title" style="float:right">
				 @if(($voucher->status_main == 4) OR ($voucher->status_main == 5))

         <a class="btn btn-success btn-sm" href="{{route('voucherActivityItineraryPdf',$voucher->id)}}" >
                              Itinerary <i class="fas fa-download">
                              </i>
                             
                          </a>
                          @if(($voucher->status_main == 4))
          <a class="btn btn-info btn-sm" href="{{route('voucherInvoicePdf',$voucher->id)}}" >
                              Proforma Invoice <i class="fas fa-download">
                              </i>
                             
                          </a>
                          @else

                          <a class="btn btn-info btn-sm" href="{{route('voucherInvoicePdf',$voucher->id)}}" >
                               Invoice <i class="fas fa-download">
                              </i>
                             
                          </a>

                          <a class="btn btn-secondary btn-sm" href="{{route('voucherInvoiceSummaryPdf',$voucher->id)}}" >
                               Invoice (Summary) <i class="fas fa-download">
                              </i>
                             
                          </a>
                          

						  @endif
              @endif
             
						  </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
                  <div class="row" style="margin-bottom: 15px;">
                    
                    <div class="col-6">
					<label for="inputName">Agency Name:</label>
          {{ ($voucher->agent)?$voucher->agent->company_name:''}}
                    </div>
                   
                
                   
                   
                    
                    
                  </div>

                  <div class="row" style="margin-bottom: 15px;">
                    
                    <div class="col-6">
					<label for="inputName">Created On:</label>
          {{ $voucher->created_at ? date("M d Y, H:i:s",strtotime($voucher->created_at)) : null }}
                    </div>
                   
                
                   
                   
                    <div class="col-6">
					  <label for="inputName">Created By.:</label>
            {{ ($voucher->createdBy)?$voucher->createdBy->name:''}}
                    </div>
                    
                  </div>
                  <div class="row" style="margin-bottom: 15px;">
                    
                    
                   
                
                   
                   
                  
                  </div>
                 
                </div>
                <!-- /.card-body -->
				
               
            </div>

           
          

            <!-- /.card -->

           
            <!-- /.card -->
 <!-- general form elements -->
 
<!-- /.card -->

            <!-- Horizontal Form -->
            
            <!-- /.card -->

          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="offset-md-2 col-md-8">
            <!-- Form Element sizes -->
			@php
				$totalGrand =0; 
				$totalGrandDiscount =0; 
			  @endphp
			  @if(!empty($voucherActivity) && $voucher->is_activity == 1)
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
				  @php
         
            $delKey = $ap->id;
          if($ap->parent_code == 0)
            $ticketCount = SiteHelpers::getTicketCountByCode($ap->parent_code);
          else
					  $ticketCount = SiteHelpers::getTicketCountByCode($ap->variant_code);
					
					@endphp
					@php
				$tourDt = date("Y-m-d",strtotime($ap->tour_date));
				$validTime = PriceHelper::checkCancellation($ap->id);
				$activity = SiteHelpers::getActivity($ap->activity_id);
      
				@endphp
            <div class="card card-default">
              <div class="card-header">
                <div class="row">
				<div class="col-md-6 text-left">
                    <h3 class="card-title">
                      <strong> {{$ap->activity_title}}</strong>
                    
                   
                    
                    </h3>

                      
  @if($ap->status == '1')
 <span class='badge bg-danger' style='margin-left: 5px;'>Cancellation Requested</span>
  @elseif($ap->status == '2')
  <span class='badge bg-danger' style='margin-left: 5px;'>Cancelled</span> 
   @elseif($ap->status == '3')
   <span class='badge bg-warning' style='margin-left: 5px;'>In Process</span> 
   @elseif($ap->status == '4')
   <span class='badge bg-success' style='margin-left: 5px;'>Confirm</span> 
   @elseif($ap->status == '5')
   <span class='badge bg-success' style='margin-left: 5px;'>Vouchered</span>
     @endif 
     </span> 
                  </div>
                  <div class="col-md-2 text-rihgt">
                    <h6 class="card-title" style="font-size:10px">
                  
					@if($validTime['btm'] == '0')
                      <strong> Non - Refundable</strong>
          @elseif($validTime['btm'] == '2')
                      <strong> Partial Refundable</strong>
					@else
						 <strong> Free Cancellation upto<br/>{{$validTime['validuptoTime']}}</strong>
					@endif
				  </h6>
                  </div>
				 
				  
                
        
     
   

        <div class="col-md-4 text-right ">
        <small>
          <a class="btn btn-xs btn-danger border-round" title="delete" href="javascript:void(0)" onclick="
              if (confirm('Are you sure you want to delete this?')) {
                  const delKey = '{{ $delKey }}'; 
                  const url = '{{ route('quotation.activity.delete', ['id' => ':delKey']) }}'.replace(':delKey', delKey);  // Construct the URL with dynamic key
                  window.location.href = url;  
              }
          ">
              <small><i class="fas fa-trash-alt"></i></small>  
          </a>
      </small>
      
          @if($ap->status > 2)
		@if((auth()->user()->role_id == '1'))
						
						<form id="cancel-form-{{$ap->id}}" method="post" action="{{route('voucher.activity.cancel',$ap->id)}}" >
						{{csrf_field()}}
						<input type="hidden" id="cancel_remark_data-{{$ap->id}}" name="cancel_remark_data-{{$ap->id}}" class="form-control cancel_remark" />
						</form>
						@if(($ap->ticket_downloaded == '0'))
							<a class="btn btn-primary  float-right cancelAct btn-sm ml-2" data-variantcode="{{$ap->variant_code}}" data-apid="{{$ap->id}}" href="javascript:void(0)" ><i class="fas fa-times"></i> Cancel </a>
            @else
            <a class="btn btn-danger  float-right cancelAct btn-sm ml-2" style="color:#fff;" data-variantcode="{{$ap->variant_code}}" data-apid="{{$ap->id}}" href="javascript:void(0)" ><i class="fas fa-times"></i> Cancel </a>
            @endif
					
				@elseif(($ap->ticket_downloaded == '0') && ($validTime['btm'] == '1') || ($ap->status == '3'))
						
						<form id="cancel-form-{{$ap->id}}" method="post" action="{{route('voucher.activity.cancel',$ap->id)}}" style="display:none;">
						{{csrf_field()}}
						<input type="hidden" id="cancel_remark_data-{{$ap->id}}" name="cancel_remark_data-{{$ap->id}}" class="form-control cancel_remark" />
						</form>
						
							<a class="btn btn-primary  float-right cancelAct btn-sm ml-2" data-variantcode="{{$ap->variant_code}}" href="javascript:void(0)" data-apid="{{$ap->id}}" ><i class="fas fa-times"></i> Cancel </a>
						@endif
          	@endif
                    @if(($voucher->status_main == 5) and ($ap->ticket_generated == '0') and ($ticketCount > '0') and ($ap->status == '3'))
						<form id="tickets-generate-form-{{$ap->id}}" method="post" action="{{route('tickets.generate',$ap->id)}}" style="display:none;">
                                {{csrf_field()}}
								<input type="hidden" id="statusv" value="2" name="statusv"  /> 
								<input type="hidden" id="payment_date" name="payment_date"  /> 
                            </form>
						
							<a class="btn btn-success float-right mr-3 btn-sm" href="javascript:void(0)" onclick="TicketModel('{{$ap->id}}')"><i class="fas fa-download"></i> Ticket</a>
							
							@elseif(($ap->ticket_generated == '1') and ($ap->status == '4'))
							<a class="btn btn-success float-right  btn-sm  d-pdf" href="#" onclick='window.open("{{route('ticket.dwnload',$ap->id)}}");return false;'  ><i class="fas fa-download"></i> Ticket</a>
							@endif
							@if($ap->status == 1)
							<span style="color:red"  >{{ config('constants.voucherActivityStatus')[$ap->status] }}</span>
							@endif
                   
                    
                    
                  </div>
				  
				   </div>
              </div>
              <div class="card-body">
			  
			  <div class="">
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-5 text-left">
                      <strong>Tour Option</strong>
                    </div>
                    <div class="col-md-7 text-right">
                      {{$ap->variant_name}}
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Date</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->tour_date}}
                  </div>
                </div>
                @if($ap->time_slot != '')
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Time Slot</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->time_slot}}
                  </div>
                </div>
                @endif
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Transfer Type</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->transfer_option}}
                  </div>
                </div>
               @if($ap->transfer_option == 'Shared Transfer')
					@php
					$pickup_time = SiteHelpers::getPickupTimeByZone($ap->variant_zones,$ap->transfer_zone);
					@endphp
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pickup Timing</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$pickup_time}}
                  </div>
                </div>
				@endif
				@if(($ap->transfer_option == 'Pvt Transfer') && ($ap->variant_pick_up_required == '1')  && ($ap->variant_pvt_TFRS == '1'))
					
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pickup Timing</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->variant_pvt_TFRS_text}}
                  </div>
                </div>
				@endif
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pax</strong>
                  </div>
                  <div class="col-md-7 text-right">
                  @if(($ap->activity_entry_type == 'Yacht') || ($ap->activity_entry_type == 'Limo'))
							        {{$ap->adult}}  Hour(s)
						    	@else
                      {{$ap->adult}} Adult {{$ap->child}} Child
                  @endif
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Amount Incl. VAT</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   AED {{$ap->totalprice}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Markup</strong>
                  </div>
                  <div class="col-md-7 text-right">
                    @php
                    $totalDiscount = $ap->discount_tkt+ $ap->discount_sic_pvt_price;
                    @endphp
                   AED {{($totalDiscount>0)?$totalDiscount*-1:$totalDiscount*-1}}
                  </div>
                </div>
				
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Invoice Amt </strong>
                  </div>
                  <div class="col-md-7 text-right">
				  @php
				  $totalDiscount = $ap->discount_tkt+ $ap->discount_sic_pvt_price;
				  @endphp
                  AED {{$ap->totalprice - $totalDiscount}}
                  </div>
                </div>
				</div>
				
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
@php
					$totalGrand += $ap->totalprice; 
					$totalGrandDiscount += $totalDiscount; 
				  @endphp
				 @endforeach
                 @endif
				  @endif
   


            
            <!-- /.startteldiv-->
          
         
          

             <!-- /.endhoteldiv-->
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title"><strong>Total Payment</strong></h3>
              </div>
              <div class="card-body">
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-6 text-left">
                    <strong>Amount Incl. VAT</strong>
                  </div>
                  <div class="col-md-6 text-right">
                   AED {{$totalGrand}}
                  </div>
                </div>
				 <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-6 text-left">
                    <strong>Markup</strong>
                  </div>
                  <div class="col-md-6 text-right">
                   AED {{-$totalGrandDiscount}}
                  </div>
                </div>
               <!-- <div class="row" style="margin-bottom: 15px;">
                  <div class="col-md-6 text-left">
                    <strong>Handling charges (2%)</strong>
                  </div>
                  <div class="col-md-6 text-right">
                   AED 2.30
                  </div>
                </div> -->
                 <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-6 text-left">
                    <h5>Final Amount</h5>
                  </div>
                  <div class="col-md-6 text-right">
                   <h5>AED {{$totalGrand - $totalGrandDiscount}}</h5>
                  </div>
                </div>
				
              </div>
			  
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
			
            @if(count($childVoucher) > 0)
             
            
             <div class="card card-default">
               <div class="card-header">
               <h3 class="card-title">
                       <strong> Child Vouchers</strong></h3>
     
         
               </div>
               <div class="card-body">
         
         <div class="">
          
                 <div class="row" style="margin-bottom: 5px;">
                     <div class="col-md-12 text-left">
                       <table class="table table-condensed table-bordered">
                               <tr>
                                   <th>Voucher Code</th>
                                   <th>Created On</th>
                                   <th>Booked Code</th>
                                   <th>Invoice No</th>
                                   <th>Total Amount</th>
                               </tr>
                     @foreach($childVoucher as $vc)
                     <tr>
                                   <td>  <a class="btn btn-info btn-sm" target="_blank" href="{{route('voucherView',$vc->id)}}">
                                   {{$vc->code}}
                              
                          </a></td>
                                   <td> {{$vc->created_at}}</td>
                                   <td> {{$vc->booking_date}}</td>
                                   <td>
                                   @if($vc->status_main >= 4)
					 <a class="btn btn-secondary btn-sm" href="{{route('voucherInvoicePdf',$vc->id)}}" >
           {{$vc->invoice_number}}
                          </a>
						  @endif 
                                  </th>
                                   <td>{{  SiteHelpers::getVoucherTotalPriceNew($vc->id);}}</th>
                               </tr>
                     @endforeach
                             </table>
                     </div>
                   
                      
                  
                 </div>
                 
         </div>
 
               </div>
               <!-- /.card-body -->
             </div>
             <!-- /.card -->

       
                  @endif
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  
    <!-- /.content -->
	
    <div class="modal fade" id="HotelCancellation" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancel Hotel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="mbody">
          To You Want to Cancel the Booking         </div>
            <div class="modal-footer">
			 
                <button type="button" class="btn btn-secondary close" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" onclick="HotelCancelModelAPI()">Yes</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="hapid" value="0"  /> 
<div class="modal fade" id="DownloadTicketmodel" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Download Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="mbody">
            Once the Tickets are downloaded it’s Non Refundable.<br/>

Do you want proceed with the Download ?             </div>
            <div class="modal-footer">
			 
                <button type="button" class="btn btn-secondary close" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" onclick="downloadTicket()">Yes</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="apid" value="0"  /> 
	<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancellation Chart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group" id="dataCancel">
                  <div id="cancel-header"></div>
                   <table id="cancellationTable" class="table table-striped" style="display: none;">
					<thead>
						
					</thead>
					<tbody>
						<!-- Table rows will be dynamically added here -->
					</tbody>
				</table>
        <div id="cancel-footer"></div>
                </div>
				 <div >Remark : <input type="text" id="cancel_remark" name="cancel_remark" class="form-control cancel_remark" /></div>
            </div>
           <div class="modal-footer d-flex justify-content-between">
			<button type="button" class="btn btn-sm btn-primary-flip btn-sm" id="selectCancelBtn"><i class="fa fa-tick"></i> Yes</button>
			<button type="button" class="btn btn-sm btn-secondary close1" data-dismiss="modal">No</button>
		</div>

        </div>
    </div>
</div>

@endsection



@section('scripts')

<script type="text/javascript">

   $(".d-pdf").on('click', function (e) {
    e.preventDefault();
    window.location.href = this.getAttribute('href');
    // Reload the page after a delay (adjust the delay time as needed)
    setTimeout(function () {
        location.reload();
    }, 2000); // Reload after 2 seconds
});
 $(document).ready(function() {
 $(document).on('click', '.cancelAct', function(evt) {
	 variantcode = $(this).data('variantcode');
	 formid = $(this).data('apid');
	  evt.preventDefault();
	
		 $.ajax({
			  url: "{{ route('get.vacancellation.chart') }}",
			  type: 'POST',
			  dataType: "json",
			  data: {
				  "_token": "{{ csrf_token() }}",
				  variantcode:variantcode,
          formid:formid
				  },
			  success: function(data) {
				   var cancellationData = data.cancel_table;
           $('#cancellationTable tbody').empty();
           $('#cancel-header').html("");
            $('#cancel-footer').html("");
				  if(cancellationData.length > 0) {
					
          
            if(data.free_cancel_till != '')
            {
              var row = '<p style="text-align: center;font-size: 12px;">To Avoid cancellation charges the booking must be cancelled on or before '+data.free_cancel_till+'</p>';
              $('#cancel-header').html(row);
            }
            else
            {
              var row = '<p style="text-align: center;font-size: 12px;">The Booking is Partial Refundable as Ticket is Not Refundable</p>';
              $('#cancel-header').html(row);
            }
            var row = '<p style="text-align: center;font-size: 12px;">All dates of special conditions are based on Dubai time. Please Consider local time difference and allow extra time where applicable</p>';
            $('#cancel-footer').html(row);
            var row = '<tr>' +
                '<tr><th>From Date</th><th>To Date</th><th>Refund Amount</th></tr>';
            $('#cancellationTable tbody').append(row);
           

						cancellationData.forEach(function(cancel) {
							var row = '<tr>' +
								'<td>' + cancel.start_time + '</td>' +
								'<td>' + cancel.end_time + '</td>' +
								'<td> ' + cancel.refund_amt + '</td>' +
								'</tr>';
							$('#cancellationTable tbody').append(row);
						});
					
						$('#cancellationTable').show();
						openModal(data.cancel,formid);
				} else {
						 var row = '<tr>' +
                '<td colspan="3" style="text-align: center;">Non-Refundable</td>' +
                '</tr>';
            $('#cancellationTable tbody').append(row);
			$('#cancellationTable').show();
			openModal(data.cancel,formid);
					}
				//console.log(data);
			  },
			  error: function(error) {
				console.log(error);
			  }
		});
	
	
 });
 });
function openModal(cancel,formid) {
        $('#cancelModal').modal('show');
        $('#selectCancelBtn').on('click', function() {
			console.log($("body #cancel_remark").val());
			$("body #cancel_remark_data-"+formid).val($("body #cancel_remark").val());
			$("body #cancel-form-"+formid).submit();
        });
		
        $('#cancelModal .close,.close1').on('click', function() {
			$('body .cancel_remark').each(function() {
			$(this).val('');  
			});
            $('#cancelModal').modal('hide');
			 
        });
   
}



$('#Ticketmodel .close').on('click', function() {
            $('#DownloadTicketmodel').modal('hide');
			$('#apid').val('0');
        });
function TicketModel(id) {

       $('#DownloadTicketmodel').modal('show');
	   $('#apid').val(id);
    }
function downloadTicket() {
		var id = $('#apid').val();
        event.preventDefault();
        document.getElementById('tickets-generate-form-'+id).submit();
    }

function HotelCancelModel(id) 
{
  $('#HotelCancellation').modal('show');
  $('#hapid').val(id);
}
function HotelCancelModelAPI() 
{
var id = $('#hapid').val();
 event.preventDefault();
 document.getElementById('cancel--hotel-form-'+id).submit();
}




</script>
@endsection
