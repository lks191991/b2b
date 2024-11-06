@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cancellation Requested Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Cancellation Requested Report</li>
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
 @if ($errors->has('pdf_file'))
	  <div class="box no-border">
        <div class="box-tools">
            <p class="alert alert-danger alert-dismissible">
			{{$errors->first('pdf_file')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </p>
        </div>
    </div>
                @endif
            <div class="card">
              <div class="card-header">
				<div class="card-tools">
				 <div class="row">

				   </div></div>
				   
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  
			  <div class="row">
			  
            <form id="filterForm" class="form-inline" method="get" action="{{ route('voucherActivtyCancelRequestReport') }}" >
              <div class="form-row align-items-center">
			   <div class="col-auto col-md-3">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Search Result</div>
                  </div>
                 <select name="booking_type" id="booking_type" class="form-control">
                    <option value = "1" @if(request('booking_type')==1) selected="selected" @endif>Cancelled Date</option>
					<option value = "2" @if(request('booking_type')==2) selected="selected" @endif>Travel Date</option>
					<!--<option value = "3">Deadline Date</option>-->
                 </select>
                </div>
              </div>
			  <div class="col-auto col-md-2">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">From Date</div></div>
                    <input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control datepicker"  placeholder="From Date" />
                  </div>
                </div>
				<div class="col-auto col-md-2">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">To Date</div></div>
                    <input type="text" name="to_date" value="{{ request('to_date') }}" class="form-control datepicker" autocomplete ="off"  placeholder="To Date" />
                  </div>
                </div>
                <div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">Voucher Code</div></div>
                    <input type="text" name="vouchercode" value="{{ request('vouchercode') }}" class="form-control"  placeholder="Voucher Code" />
                  </div>
                </div>
                <div class="col-auto col-md-3" style="display:none">
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Booking Status</div>
                  </div>
                 <select name="booking_status" id="booking_status" class="form-control">
						<option value = "">All</option>
						@foreach($voucherStatus as $vsk => $vs)
						<option value = "{{$vsk}}" @if(request('booking_status')==$vsk) selected="selected" @endif>{{$vs}}</option>
						@endforeach
                 </select>
                </div>
              </div>
               
              <div class="col-auto col-md-2">
                <button class="btn btn-info mb-2" type="submit">Filter</button>
                <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('voucherActivtyCancelRequestReport') }}">Clear</a>
              </div>
            </form>
          </div>
        </div><div class="col-md-12" style="overflow-x:auto">
                <table id="" class="table rounded-corners">
                  <thead>
                  <tr>
					          <th>Booking #</th>
                    <th width="7%">Booking Date</th>
                    <th width="7%">Service Date</th>
                    <th>Slot</th>
                    <th>Service</th>
                    <th>Variant</th>
                    <th>Service Type</th>
                    <th>Agency</th>
                    <th>Guest Name</th>
                    
                    <th>A</th>
                    <th>C</th>
                    <th>I</th>
                    <th>Cancellation Request By</th>
                    <th>TKT Supplier</th>
                    <th>TKT Supplier Ref #</th>
                    <th>TKT SP</th>
                    <th>TKT Net Cost</th>
                   
                    <th>Refund TKT Value</th>
                    <th>Refund TRF Value</th>
                    <th>Remark</th>
					
                    
                    <th>Status</th>
                  
                    <th></th>
                  </tr>
				  
                  </thead>
                  <tbody>
				  @foreach ($records as $record)
                 @php
				  $class = SiteHelpers::voucherActivityStatus($record->status);
          $cancelBy = "";
          if($record->cancel_by != '')
            $cancelBy = SiteHelpers::getUserName($record->cancel_by);
				  @endphp
                  <tr class="{{$class}}">
					<td>{{($record->voucher)?$record->voucher->code:''}}
          <input type="hidden" readonly class="form-control " id="voucher_code{{$record->id}}" data-name="voucher_code"  data-id="{{$record->id}}" value="{{($record->voucher)?$record->voucher->code:''}}" />
          </td>
          <td>
          {{ $record->booking_date ? date("d-m-Y, H:i:s",strtotime($record->booking_date)) : null }}
				
					</td>          
          <td>
          {{ $record->tour_date ? date("d-m-Y",strtotime($record->tour_date)) : null }}
					<input type="hidden" readonly class="form-control" id="tour_date{{$record->id}}" data-name="tour_date"  data-id="{{$record->id}}" value=" {{ $record->tour_date ? date('d-m-Y',strtotime($record->tour_date)) : null }}" />  
					</td>
          <td>
          <input type="hidden" readonly class="form-control" id="slot_time{{$record->id}}" data-name="slot_time"  data-id="{{$record->id}}" value="{{$record->time_slot}}" />  
          {{$record->time_slot}}</td>
					<td>{{$record->activity_title}}
          <input type="hidden" readonly class="form-control " id="activity_name{{$record->id}}" data-name="activity_name"  data-id="{{$record->id}}" value="{{$record->activity_title}}" />

          </td>
					<td>{{($record->variant_name)?$record->variant_name:''}}
          <input type="hidden" readonly class="form-control " id="variant_name{{$record->id}}" data-name="variant_name"  data-id="{{$record->id}}" value="{{($record->variant_name)?$record->variant_name:''}}" />

          </td>
					<td>{{$record->transfer_option}}</td>
					<td>{{($record->voucher->agent)?$record->voucher->agent->company_name:''}}</td>
					<td>{{($record->voucher)?$record->voucher->guest_name:''}}

          <input type="hidden" readonly class="form-control " id="guest_name{{$record->id}}" data-name="guest_name"  data-id="{{$record->id}}" value="{{($record->voucher)?$record->voucher->guest_name:''}}" />
          </td>
					
					 <td>{{$record->adult}}  <input type="hidden" readonly class="form-control " id="adult{{$record->id}}" data-name="adult"  data-id="{{$record->id}}" value="{{$record->adult}}" /></td>
                    <td>{{$record->child}}  <input type="hidden" readonly class="form-control " id="child{{$record->id}}" data-name="child"  data-id="{{$record->id}}" value="{{$record->child}}" /></td>
                    <td>{{$record->infant}}</td>
                    <td>{{$cancelBy}}</td>
					<td>
          

					 <select name="supplier_ticket{{$record->id}}" disabled id="supplier_ticket{{$record->id}}" class="form-control inputsaveSp">
						<option data-name="supplier_ticket"  data-id="{{$record->id}}" value="">All</option>
						@foreach($supplier_ticket as  $stv)
						
						<option data-name="supplier_ticket"  data-id="{{$record->id}}" value = "{{$stv->id}}" @if($record->supplier_ticket==$stv->id) selected="selected" @endif >{{$stv->company_name}}</option>
						@endforeach
                 </select>
                 @php
				
          $priceCal = SiteHelpers::getActivitySupplierCost($record->activity_id,$record->supplier_ticket,"",$record->variant_unique_code,"1","1","0","0");
         
        
				  @endphp
                 <input type="hidden" class="form-control" id="supplier_email{{$record->id}}" data-name="supplier_email"  data-id="{{$record->id}}" value="{{$stv->booking_email}}" />

                 <input type="hidden" class="form-control" id="adult_cost{{$record->id}}" data-name="adult_cost"  data-id="{{$record->id}}" value="{{$priceCal['markup_p_ticket_only']}}" />

                 <input type="hidden" class="form-control" id="child_cost{{$record->id}}" data-name="child_cost"  data-id="{{$record->id}}" value="{{$priceCal['markup_p_sic_transfer']}}" />
					</td>
					<td><input type="hidden" class="form-control inputsave" id="ticket_supp_ref_no{{$record->id}}" data-name="ticket_supp_ref_no"  data-id="{{$record->id}}" value="{{$record->ticket_supp_ref_no}}" />{{$record->ticket_supp_ref_no}}</td>
					<td>{{$record->original_tkt_rate-$record->discount_tkt }}</td>
					<td><input type="hidden" class="form-control inputsave" @if($record->status == '4') disabled @endif id="actual_total_cost{{$record->id}}" data-name="actual_total_cost"  data-id="{{$record->id}}" value="{{$record->actual_total_cost}}" />{{$record->actual_total_cost}}</td>
					
          <input type="hidden" class="form-control" id="pickup{{$record->id}}" data-name="pickup"  data-id="{{$record->id}}" value="{{$record->pickup_location}}" />
					
          <input type="hidden" class="form-control" id="dropoff{{$record->id}}" data-name="dropoff"  data-id="{{$record->id}}" value="{{$record->dropoff_location}}" />
					
          <td>{{$record->org_refund_tkt_amt}}</td>
          <td>{{$record->org_refund_trf_amt}}</td>
          <td>
          {!!$record->internal_remark!!}
          <input type="hidden" class="form-control inputsave" id="remark_old{{$record->id}}" data-name="remark_old"  data-id="{{$record->id}}" value="{{$record->internal_remark}}" />
            <textarea  class="form-control inputsave" id="internal_remark{{$record->id}}" style="resize:none;" data-name="internal_remark"  data-id="{{$record->id}}"></textarea></td>
					
					<td style="width: 250px;">
            @if($record->status == '12')
              Cancelled
            @else
					@php
					$actStatus = config('constants.voucherActivityStatus');
					@endphp
					<select name="status{{$record->id}}" id="status{{$record->id}}" class="form-control inputsaveSp">
					
						<option data-name="status"  data-id="{{$record->id}}" value = "{{1}}" @if($record->status==1) selected="selected" @endif >Cancellation Requested</option>
            <option data-name="status"  data-id="{{$record->id}}" value = "{{11}}" @if($record->status==11) selected="selected" @endif >Cancellation Initiated</option>
            <option data-name="status"  data-id="{{$record->id}}" value = "{{12}}" @if($record->status==12) selected="selected" @endif >Cancelled</option>
					
            @endif
                 </select>
					</td>
					
          <td>
					<button class="btn btn-info btn-sm mb-2 mr-4 emailPopup" data-id="{{$record->id}}" >Email Send</button>
						
                
					</td>
                  </tr>
                  
                  @endforeach
				  </tbody>
                </table></div>
				<div class="pagination pull-right mt-3"> 
				</div> 
				
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
	
	<div class="modal fade" id="ticketUploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	 <form id="ticketUploadForm" method="post" action="{{route('uploadTicketFromReport')}}" enctype="multipart/form-data">
	 @csrf
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Ticket Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="file"  class="form-control" name="ticketFile" accept=".pdf" />
		 <input type="hidden"  id="vaid" name="vaid"   value="" />
	  <input type="hidden"  id="vid" name="vid"   value="" />
      </div>
	  
	 
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="sendEmailModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Send Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
            <div class="col-md-12 mb-3">
                  <label>Email To</label>
                  <input type="text" id="email_to" readonly='readonly' name="email_to" class="form-control" />
              </div>
			      <div class="col-md-12 mb-3">
                  <label>Subject</label>
                  <input type="text" id="email_subject" name="email_subject" class="form-control" />
              </div>
              <div class="col-md-12">
              <label>Body</label>
                  <textarea  id="email_body" name="email_body" class="form-control text-editor" rows="10" ></textarea>
              </div>
             
            <div id="">

            </div>
           

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary-flip btn-sm" id="emailSend">Send</button>
                <!-- You can add a button here for further actions if needed -->
            </div>
        </div>
    </div>
</div>
    <!-- /.content -->
@endsection
@section('scripts')
 <!-- Script -->
 <script type="text/javascript">
    $(function () {
        $(".uploadTicketbtn").click(function () {
            $("#ticketUploadModal").modal("show");
			var vid= $(this).data('vid');
			var vaid= $(this).data('vaid');
			$("#vaid").val(vaid);
			$("#vid").val(vid);
        });
		
		$("#emailSend").click(function () {
			 $("body #loader-overlay").show();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "{{ route('report.email.send') }}",
        type: 'POST',
        dataType: "json",
        data: {
            email_to: $('#email_to').val(),
            email_subject: $('#email_subject').val(),
            email_body: CKEDITOR.instances.email_body.getData(),
        },
        success: function(data) {
            if (data.status == 1) {
                alert(data.message);
            }
			
			$('#sendEmailModal').modal('hide');
			$("body #loader-overlay").hide();
        },
        error: function(xhr) {
			 $("body #loader-overlay").hide();
            if (xhr.status === 422) {
                // Process validation errors here.
                var errors = xhr.responseJSON.errors;
                var errorString = '';
                $.each(errors, function(key, value) {
                    errorString += value[0] + "\n"; // Collecting error messages
                });
                alert(errorString); // Display all errors
            } else {
                alert('An error occurred. Please try again.');
            }
        }
    });
});
    });
</script>

 <script type="text/javascript">
$(document).ready(function() {
	
	$(document).on('change', '.inputsave', function(evt) {
		$("#loader-overlay").show();
    var id= $(this).data('id');
    var txt_name =  $(this).data('name');
    var txt_var =  $(this).val();
    if(txt_name == 'internal_remark')
    {
      txt_var =  $("body #remark_old"+id).val()+"<br/>"+txt_var;
    }
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
				id: $(this).data('id'),
				inputname: $(this).data('name'),
        val: txt_var,
				type: "Report",
				report_type: "Ticket Only"
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
	 });	
	 
	 $(document).on('change', '.inputsaveSp', function(evt) {
		$("#loader-overlay").show();
		var id = $(this).find(':selected').data('id');
		var inputname = $(this).find(':selected').data('name');
		//alert(inputname);
		$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
		$.ajax({
            url: "{{route('voucherReportSave')}}",
            type: 'POST',
            dataType: "json",
            data: {
               id: id,
			   inputname: inputname,
			   val: $(this).val(),
			   type: "Report",
			   report_type: "Ticket Only"
            },
            success: function( data ) {
            if(inputname == 'supplier_ticket')
            {
              
              $("#actual_total_cost"+id).val(data[0].cost);
              $("#supplier_email"+id).val(data[0].email);
              $("#adult_cost"+id).val(data[0].adult);
              $("#child_cost"+id).val(data[0].child);
            }
			        $("#loader-overlay").hide();
            }
          });
	 });

   $(document).on('click', '.emailPopup', function(evt) {
		var id = $(this).data('id'); 
    var supplier = $("body #supplier_ticket" + id).val();
    var status = $("body #status" + id).val();
    if(supplier == '')
    {
      alert("Kindly select Supplier");
      return false;
    }
    else
    {
      
      var toe = $("body #tour_date" + id).val();
      var st = $("body #slot_time" + id).val();
      var vc = $("body #voucher_code" + id).val();
      var an = $("body #activity_name" + id).val();
      var vn = $("body #variant_name" + id).val();
      var a = $("body #adult" + id).val();
      var c = $("body #child" + id).val();
      var gn = $("body #guest_name" + id).val();
      var cost = $("body #actual_total_cost" + id).val();
      var srefno = $("body #ticket_supp_ref_no" + id).val();
      var semail = $("body #supplier_email" + id).val();
      var schildcost = $("body #child_cost" + id).val();
      var sadultcost = $("body #adult_cost" + id).val();
      var pickup = $("body #pickup" + id).val();
      if(pickup == '')
      pickup = "N/A";
      var dropoff = $("body #dropoff" + id).val();
      if(dropoff == '')
        dropoff = "N/A";
    
      $("body #email_to").val(semail);
      if(status == '11')
      {

        $("body #email_subject").val("Request you to cancel the booking for "+an+" on "+toe+" Abatera Ref No# "+vc);
        // Set content dynamically
CKEDITOR.instances.email_body.setData("<p>Dear Team / Travel partner,<br/>Greetings from Abatera Tourism LLC!!!<br/>Request you to cancel the booking as per below /service at NIL charges.</p><p>Invoice/Confirmation Number :"+srefno+"</p><p>Abatera Reference # :"+vc+"</p><p>Tour Name:"+an+"</p><p>Tour Option:"+vn+"</p><p>Guest name: "+gn+"</p><p>Service date:"+toe+" : Slot Timings: </p><p>No of Adults:"+a+" Rate: AED "+sadultcost+"</p><p>No of Child: "+c+" : Rate: AED "+schildcost+"</p><p>Pick up Location: "+pickup+"</p><p>Drop Off Location: "+dropoff+"</p><p>Regards,</p><p>{{\Auth::user()->name}}</p><p>AbateraB2B.com</p>");
      }

      
      $('#sendEmailModal').modal('show'); 
	  

    }
      });
    
	
	
});

  </script> 
@include('inc.ckeditor')
  @endsection
