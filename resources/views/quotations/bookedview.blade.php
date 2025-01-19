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
         <a class="btn btn-info btn-sm" href="{{route('voucher.add.quick.activity',$voucher->id)}}">
         Add More Service 
                           
                        </a>

                        <a class="btn btn-secondary btn-sm" href="{{route('quotationInvoiceSummaryPdf',$voucher->id)}}" >
                            Payment Advise <i class="fas fa-download">
                           </i>
                        </a>
        
             
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
            

          <div class="card card-default">
              <div class="card-header">
                <div class="row">
				
               
                <h3 class="card-title">Email Content</h3>
                <h3 class="card-title" style="float:right">
                     <a  class="btn btn-sm btn-info pull-right text-right" style="margin-left: 300px;float:right;" title="email" href="javascript:void(0)" onclick="copyDivContent();" id="copy_text">Click to Copy </a>
                    
                   
                    
                    </h3>
                    </div>
                    </div>
        <div class="card-body">
			  
			
                <div class="row" style="margin-bottom: 5px;">
                    
                    <div class="col-md-12" id="email_content">
                    <p style="color: #000;">Dear Travel Partner,</p>
                    <p style="color: #000;">  Greeting From Abatera Tourism LLC!</p>

 
                    <p style="color: #000;"> 
Thanks for your query, we are pleased to offer the below-</p>

 
<p style="color: #000;"> 
 

QUERY NO: {{$voucher->code}} </p>                 
<p style="color: #000;"> 
NO OF PAX: {{$voucher->adults}} Adult(s)  @if($voucher->childs > 0) / {{$voucher->childs}} Child(s) @endif   </p>            
<p style="color: #000;"> 
@php
				$no_of_days = $no_of_nights =  0;
					$no_of_days = SiteHelpers::dateDiffInDays($voucher->travel_from_date,$voucher->travel_to_date)
					
				@endphp
				
				
				
TRAVEL DATE : {{ $voucher->travel_from_date ? date(config('app.date_format'),strtotime($voucher->travel_from_date)) : null }} (@if(($no_of_days-1) > 0){{$no_of_days-1}} N @endif / {{$no_of_days}} D)       
</p>
<p style="color: #000;"> Option – 1 <br/><br/>Hotel 1: <br/><br/><br/><br/><br/><br/></p>
<p style="color: #000;"> Option – 2 <br/><br/>Hotel 2: <br/><br/><br/><br/><br/><br/></p>
<p style="color: #000;">
<strong>Land Part Cost</strong>
<br/>
@php
                $grant_total = $markup_amt = $markup_per = $per_adult = $per_child = $markup_per = 0;

                $markup_amt = $grant_total = $voucher->total_markup;
                $markup_per = $voucher->total_markup_per;
                $i = 0;
           @endphp
@foreach($voucherActivity as $ap)
@php 
                      $per_child_cost = $per_adult_cost = 0;
                      if($ap->adult > 0)
                            $per_adult_cost = round(($ap->adultPrice/$ap->adult+(($ap->original_trans_rate/($ap->adult+$ap->child)))),2);
                        if($ap->child > 0)
                            $per_child_cost = round(($ap->childPrice/$ap->child+(($ap->original_trans_rate/($ap->adult+$ap->child)))),2);

                        $per_adult_cost += round((($per_adult_cost*$markup_per)/100),2);
                        $per_child_cost += round((($per_child_cost*$markup_per)/100),2);

                        $grant_total += $ap->original_trans_rate+$ap->original_tkt_rate;
                        $per_adult += $per_adult_cost;
                        $per_child += $per_child_cost;
                        $i++;
                      @endphp
          @endforeach
          @php
            $per_adult_usd = $per_adult/3.65;
            $per_child_usd = $per_child/3.65;
          @endphp
Adult(s): AED  {{ $per_adult }} / Adult (USD {{ round($per_adult_usd,2) }})<br/>
@if($voucher->childs > 0)
Child(s): AED  {{ $per_child }} / Adult (USD  round($per_child_usd,2))<br/>
@endif
</p>
<p style="color: #000;">
@if(!empty($voucherActivity) && $voucher->is_activity == 1)
					@if(!empty($voucherActivity))
          INCLUSIONS<br/>
        
					  @foreach($voucherActivity as $ap)
            -  {{$ap->variant_name}} - {{ $ap->transfer_option}}<br/>
          
            @endforeach

                 @endif
				  @endif
</p>
<p style="color: #000;">
          EXCLUSIONS:<br/>
- TOURISM DIRHAMS<br/>

- 30 DAYS VISA<br/>

- ANY EXPENSE OF PERSONAL NATURE.<br/>

- TIPS / GRATITUDE.<br/>

- ANY MEALS / EXCURSIONS NOT MENTIONED IN THE INCLUSION.<br/>

</p>
@if(!empty($voucherActivity) && $voucher->is_activity == 1)
					@if(!empty($voucherActivity))
         
<p style="color: #000;">
<b>Remarks:</b><br/>

					  @foreach($voucherActivity as $ap)
            @php
            $varaint_data = SiteHelpers::getVariant($ap->variant_code);
            @endphp
            @if($varaint_data->cancellation_policy != '')
 - {!!$varaint_data->cancellation_policy!!} <br/>
@endif
@endforeach

                 @endif
				  @endif
</p>


<p style="color: #000;">
<b>Notes:</b><br/>
⁠- ⁠The above is only a quotation and we are not holding any confirmed reservation/services at the moment.<br/>
⁠-  ⁠Any amendments in the dates of travel or number of passengers will attract a re-quote.<br/>
⁠- ⁠Prices are subject to change unless booked and paid for in advance.<br/>
⁠- ⁠Rates for arrival and departure transfers and coach tours are based on and valid for pax onwards in one vehicle with all passengers arriving / departing together (in the same flight).<br/>
⁠- ⁠Airport transfer rates are not valid in case passengers are arriving / departing on different flights. Any change in pax numbers will result in change in rates.<br/>
⁠- ⁠Rooms will be subject to availability at the time of confirming the reservation.<br/>
</p>
                    </div>
                

</div>
</div>
</div>

      
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
<script>
    function copyDivContent() {
      // Get the content of the div by id
      const divContent = document.getElementById("email_content").innerText;

      // Create a temporary textarea element to copy the text
      const tempTextArea = document.createElement("textarea");
      tempTextArea.value = divContent;

      // Append the textarea to the body
      document.body.appendChild(tempTextArea);

      // Select the content and copy it to clipboard
      tempTextArea.select();
      document.execCommand("copy");

      // Remove the temporary textarea
      document.body.removeChild(tempTextArea);

      // Alert the user that content has been copied
      //alert("Content copied to clipboard!");
      document.getElementById("copy_text").innerText = "copied";
    }
  </script>
@endsection
