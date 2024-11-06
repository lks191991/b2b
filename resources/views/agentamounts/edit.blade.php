@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Agent/Supplier Amount Update</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('agentamounts.index') }}">Agent/Supplier Amounts</a></li>
              <li class="breadcrumb-item active">Agent/Supplier Amount Update</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <form action="{{route('agentamounts.update', $agentAmounts->id) }}" method="post" class="form" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Agent/Supplier Amount</h3>
            </div>
            <div class="card-body row">
              <div class="col-md-8">
                  <div class="row">
              <div class="form-group col-md-12">
                <label for="inputName">Agency / Supplier Name: <span class="red">*</span></label>
                <input type="text" readonly='readonly' id="agent_name" name="agent_name" value="{{ ($agentAmounts->agent)?$agentAmounts->agent->company_name:''}}" class="form-control"  placeholder="Agency Name" />
                <input type="hidden" id="agent_id" name="agent_id" value="{{$agentAmounts->agent_id }}" class="form-control"  placeholder="Agency Name" />
                @if ($errors->has('agent_id'))
                    <span class="text-danger">{{ $errors->first('agent_id') }}</span>
                @endif
				
				<input type="hidden" id="agent_id_select" name="agent_id_select"  />
				
              </div>
			   <div class="form-group col-md-12" id="agent_details">
			   </div>
			     <div class="form-group col-md-4">
                <label for="inputName">Amount In (AED): <span class="red">*</span></label>
                 <input type="text" id="amount" name="amount" value="{{$agentAmounts->amount}}" class="form-control"  placeholder="Amount" />
				  @if ($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
              </div>
			  <div class="form-group col-md-4">
                <label for="inputName">Date of Receipt/Payment: <span class="red">*</span></label>
               <input type="text" id="date_of_receipt" name="date_of_receipt" value="{{$agentAmounts->date_of_receipt}}" class="form-control datepicker"  placeholder="Date of Receipt" />
				  @if ($errors->has('date_of_receipt'))
                    <span class="text-danger">{{ $errors->first('date_of_receipt') }}</span>
                @endif
              </div>
			   <div class="form-group col-md-4">
                <label for="inputName">Transaction Type:</label>
                <select name="transaction_type" id="transaction_type" class="form-control">
                <option value="Receipt" @if($agentAmounts->transaction_type == 'Receipt') {{'selected="selected"'}} @endif >Receipt</option>
                @permission('list.agentamount.approve') 
                    <option value="Payment" @if($agentAmounts->transaction_type == 'Payment') {{'selected="selected"'}} @endif>Payment</option>
                    @endpermission
			
                 </select>
              </div>
			  <div class="form-group col-md-6 d-none">
                <label for="inputName">Transaction From:</label>
                <select name="transaction_from" id="transaction_from" class="form-control">
                    <option value="1" @if($agentAmounts->transaction_from == '1') {{'selected="selected"'}} @endif>Amount</option>
				
                 </select>
              </div>
			   <div class="form-group col-md-6 d-none">
                <label for="inputName">Payment Against:</label>
                <select name="is_vat_invoice" id="is_vat_invoice" class="form-control">
                    <option value="1" @if($agentAmounts->is_vat_invoice == '1') {{'selected="selected"'}} @endif>VAT Invoice</option>
				
                 </select>
              </div>
             
            
              <div class="form-group col-md-6">
                <label for="inputName">Mode of Payment: <span class="red">*</span></label>
                <select name="mode_of_payment" id="mode_of_payment" required='required' class="form-control">
                  
                   
                    <option value="1" @if($agentAmounts->mode_of_payment =='1') {{'selected="selected"'}} @endif>WIO BANK A/C No - 962 222 3261</option>
					          <option value="2" @if($agentAmounts->mode_of_payment =='2') {{'selected="selected"'}} @endif >RAK BANK A/C No -0033488116001</option>
                    <option value="3" @if($agentAmounts->mode_of_payment =='3'){{'selected="selected"'}} @endif >CBD BANK A/C No -1001303922</option>
                    <option value="4" @if($agentAmounts->mode_of_payment =='4'){{'selected="selected"'}} @endif >Cash</option>
                    <option value="5" @if($agentAmounts->mode_of_payment =='5'){{'selected="selected"'}} @endif >Cheque</option>
                    <option value="6" @if($agentAmounts->mode_of_payment =='6'){{'selected="selected"'}} @endif >ICICI BANK - 006005013540 - VTZ</option>
                      <option value="7" @if($agentAmounts->mode_of_payment =='7'){{'selected="selected"'}} @endif >ICICI BANK - 006005015791 - BHO</option>
                 </select>
              </div>
              <div class="form-group col-md-6">
                <label for="inputName">Attachment:</label>
                <input type="file" name="image" id="image" class="form-control" /> 
                 @if ($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
                <p>Allowed File Extension : .jpg,.jpeg,.png</p>

               
              </div>
			  <div class="form-group col-md-12">
                <label for="inputName">Remark:</label>
                 <textarea type="text" id="remark" name="remark" class="form-control"  placeholder="Remark" >{{ $agentAmounts->remark }}</textarea>
				  @if ($errors->has('remark'))
                    <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
              </div>

              <div class="form-group col-md-3">
                <label for="inputName">Status: <span class="red">*</span></label>
                <select name="status" id="status" class="form-control">
                    <option value="1" @if($agentAmounts->status =='1') {{'selected="selected"'}} @endif>Pending</option>
                    @permission('list.agentamount.approve') 
                      <option value="2" @if($agentAmounts->status =='2') {{'selected="selected"'}} @endif >Approved</option>
                      <option value="3" @if($agentAmounts->status =='3'){{'selected="selected"'}} @endif >Rejected</option>
                      @endpermission
                 </select>
              </div>
              </div>
              </div>
              <div class="form-group col-md-4">
              @if($agentAmounts->attachment !='')
            <a href="{{ url('/uploads/payment/'.$agentAmounts->attachment) }}" target="_blank"><img src="{{ url('/uploads/payment/'.$agentAmounts->attachment) }}" class="img-fluid"/></a>
            @endif
              </div>

			 </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="{{ route('agentamounts.index') }}" class="btn btn-secondary">Cancel</a>
          
		   <button type="submit" name="save_and_view" class="btn btn-primary float-right">Save</button>
        </div>
      </div>
    </form>

    </section>
    <!-- /.content -->
@endsection
@section('scripts')
@include('inc.citystatecountryjs')
<script type="text/javascript">
    var path = "{{ route('auto.agent.supp') }}";
  
    $( "#agent_id" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term,
            },
            success: function( data ) {
               response( data );
            }
          });
        },
		
        select: function (event, ui) {
           $('#agent_id').val(ui.item.label);
           //console.log(ui.item); 
		   $('#agent_id_select').val(ui.item.value);
		    $('#agent_details').html(ui.item.agentDetails);
           return false;
        },
        change: function(event, ui){
            // Clear the input field if the user doesn't select an option
            if (ui.item == null){
                $('#agent_id').val('');
				 $('#agent_id_select').val('');
				 $('#agent_details').html('');
            }
        }
      });
  
</script>


@endsection
