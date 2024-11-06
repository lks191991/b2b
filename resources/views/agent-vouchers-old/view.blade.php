@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('agent-vouchers.index') }}">Vouchers</a></li>
              <li class="breadcrumb-item active">Voucher Details</li>
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
		
          <!-- left column -->
          <div class="col-md-8">
		   <form id="cusDetails" method="post" action="{{route('agent.vouchers.status.change',$voucher->id)}}" >
			 {{ csrf_field() }}
            <!-- general form elements -->
            <div class="card card-default">
              <div class="card-header">
                 <h3 class="card-title"><i class="nav-icon fas fa-user" style="color:blueviolet"></i> Passenger Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-2">
                      <select class="form-control">
                        <option>Mr.</option>
                        <option>Mrs.</option>
                        <option>Miss</option>
                      </select>
                    </div>
                    <div class="col-5">
                      <input type="text" name="fname"  class="form-control" placeholder="First Name" required>
                    </div>
                    <div class="col-5">
                      <input type="text" name="lname"  class="form-control" placeholder="Last Name" required>
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-4">
                      <input type="text" readonly value="{{$voucher->agent->email}}" class="form-control" placeholder="Email ID">
                    </div>
                    <div class="col-4">
                      <input type="text" readonly value="{{$voucher->agent->mobile }}" class="form-control" placeholder="Mobile No.">
                    </div>
                    <div class="col-4">
                      <input type="text" name="agent_ref_no" class="form-control" placeholder="Agent Reference No." required>
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-12">
                      <textarea type="text" class="form-control" style="resize:none;" name="remark" placeholder="Remark" rows="5"></textarea>
                    </div>
                   
                  </div>
                </div>
                <!-- /.card-body -->
				
               
            </div>
            <!-- /.card -->

            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title"><i class="nav-icon fas fa-book" style="color:blueviolet"></i> Additional Information</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
				@if(!empty($voucherActivity) && $voucher->is_activity == 1)
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
				  @if(($ap->transfer_option == 'Shared Transfer') || ($ap->transfer_option == 'Pvt Transfer'))
				  @php
					$activity = SiteHelpers::getActivity($ap->activity_id);
					@endphp
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-12"><p>{{$activity->title}} - {{$ap->variant_name}} : {{$ap->transfer_option}}</p></div>
                    <div class="col-6">
					<input type="text" class="form-control inputsave autocom" id="pickup_location{{$ap->id}}" name="pickup_location[]" data-name="pickup_location"  data-id="{{$ap->id}}" value="{{$ap->pickup_location}}" data-zone="{{$ap->transfer_zone}}" placeholder="Pickup Location" required />
					
                     
                    </div>
                    <div class="col-6">
					<input type="text" class="form-control inputsave" id="remark{{$ap->id}}" data-name="remark"  data-id="{{$ap->id}}" value="{{$ap->remark}}"  placeholder="Remark" />
                    </div>
                  </div>
				   @endif
				  @endforeach
                 @endif
				  @endif
                </div>
                <!-- /.card-body -->

               
            </div>
            <!-- /.card -->

            <div class="card card-default">
              <div class="card-header">
               <h3 class="card-title"><i class="nav-icon fas fa-credit-card" style="color:blueviolet"></i>  Payment Options</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">
                  <div class="row" style="margin-bottom: 15px;">
                    <div class="col-12">
                      <input type="radio" disabled name="payment"  /> Credit Card / Debit Card
                    </div>
                  </div>
                  <div class="row" style="margin-bottom: 5px;">
                    <div class="col-12">
                      <input type="radio" checked name="payment"  /> Credit Limit ({{($voucher->agent->agent_amount_balance)?$voucher->agent->agent_amount_balance:0}})
                    </div>
                   
                  </div>
                </div>
                <!-- /.card-body -->

               
            </div>
            <!-- /.card -->
 <!-- general form elements -->
 <div class="card card-default">
  
   

    <div class="card-footer">
      <div class="row" style="margin-bottom: 5px;">
        <div class="col-md-8 text-left">
          <input type="checkbox" name="tearmcsk" required id="tearmcsk" /> By clicking Pay Now you agree that you have read ad understood our<br>
          &nbsp; &nbsp; &nbsp; &nbsp;Terms and Conditions
		  <br><label id="tearmcsk_message" for="tearmcsk" class="error hide" >This field is required.</label>
        </div>
        <div class="col-4 text-right">
			<button type="submit" name="btn_hold" class="btn btn-primary">Hold</button>
            <button type="submit" name="btn_paynow" class="btn btn-success">Pay Now</button>
        </div>
      </div>
    </div>

</div>
<!-- /.card -->

            <!-- Horizontal Form -->
            
            <!-- /.card -->
</form>
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-4">
            <!-- Form Element sizes -->
			@php
				$totalGrand =0; 
			  @endphp
			  @if(!empty($voucherActivity) && $voucher->is_activity == 1)
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
				  @php
					$activity = SiteHelpers::getActivity($ap->activity_id);
					@endphp
            <div class="card card-default">
              <div class="card-header">
                <div class="row">
				<div class="col-md-8 text-left">
                    <h3 class="card-title">
                      <strong> {{$activity->title}}</strong></h3>
                  </div>
				<div class="col-md-4 text-right">
                    <form id="delete-form-{{$ap->id}}" method="post" action="{{route('agent.voucher.activity.delete',$ap->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn-danger btn-sm" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$ap->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i></a>
                    
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
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Transfer Type</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->transfer_option}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pickup Timing</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->actual_pickup_time}}
                  </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                  <div class="col-md-5 text-left">
                    <strong>Pax</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   {{$ap->adult}} Adult {{$ap->child}} Child
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
                    <strong>Total</strong>
                  </div>
                  <div class="col-md-7 text-right">
                   AED {{$ap->totalprice}}
                  </div>
                </div>
				</div>
				
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
@php
					$totalGrand += $ap->totalprice; 
				  @endphp
				 @endforeach
                 @endif
				  @endif
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
                    <h3>Final Amount</h3>
                  </div>
                  <div class="col-md-6 text-right">
                   <h3>AED {{$totalGrand}}</h3>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
  
    <!-- /.content -->
@endsection



@section('scripts')
<script  src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js
"></script>




<script type="text/javascript">
  $(function(){
$('#cusDetails').validate({});

	 $(document).on('change', '.inputsave', function(evt) {
		
		$("#loader-overlay").show();
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
			   val: $(this).val()
            },
            success: function( data ) {
               //console.log( data );
			  $("#loader-overlay").hide();
            }
          });
	 }); 

	 var path = "{{ route('auto.hotel') }}";
	 var inputElement = $(this); // Store reference to the input element

	 $(".autocom").each(function() {
    var inputElement = $(this);
    inputElement.autocomplete({
        source: function(request, response) {
            $.ajax({
                url: path,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term,
                    zone: inputElement.attr('data-zone')
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            $('#pickup_location' + inputElement.data('id')).val(ui.item.label);
            return false;
        },
        change: function(event, ui) {
            if (ui.item == null) {
                $('#pickup_location' + inputElement.data('id')).val('');
            }
        }
    });
});


	});
	

</script>
@endsection