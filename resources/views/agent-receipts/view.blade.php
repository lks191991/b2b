@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Agent/Supplier Amount Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('agentamounts.index') }}">Agent/Supplier Amounts</a></li>
              <li class="breadcrumb-item active">Agent/Supplier Amount Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    
    <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Agent/Supplier Amount</h3>
            </div>
            <div class="card-body row">
            <div class="form-group col-md-6">
                <label for="inputName" class="font-bold">Receipt No: </label>
               {{ $agentAmounts->receipt_no}}
              </div>
              <div class="form-group col-md-6 text-right">
                 <label for="inputName" class="font-bold">Date of Receipt/Payment: </label> {{$agentAmounts->date_of_receipt}}
              </div>
              <div class="form-group col-md-12">
                <label for="inputName" class="font-bold">Agency / Supplier Name: </label>
               {{ ($agentAmounts->agent)?$agentAmounts->agent->company_name:''}}
              </div>
			  
			     <div class="form-group col-md-4">
                 <label for="inputName" class="font-bold">Amount: </label> {{$agentAmounts->amount}}
				 
              </div>
			 
			   <div class="form-group col-md-4">
                 <label for="inputName" class="font-bold">Transaction Type:</label> {{ $agentAmounts->transaction_type}}
			
                 </select>
              </div>
			 
           
              <div class="form-group col-md-4">
                 <label for="inputName" class="font-bold">Status: </label>
                 @if($agentAmounts->status =='1') {{'Pending'}}  @elseif($agentAmounts->status =='2') {{'Approved'}}  @elseif($agentAmounts->status =='3'){{'Rejected'}} @endif
              
              </div>
              <div class="form-group col-md-4">
                 <label for="inputName" class="font-bold">Mode of Payment: </label>
                 @if($agentAmounts->mode_of_payment =='1') {{'Bank Account 1'}} @elseif($agentAmounts->mode_of_payment =='2') {{'Bank Account 1'}} @elseif($agentAmounts->mode_of_payment =='3'){{'Bank Account 3'}} @elseif ($agentAmounts->mode_of_payment =='4'){{'Cash'}} @elseif($agentAmounts->mode_of_payment =='5'){{'Cheque'}} @endif 
                 </select>
              </div>

              @if($agentAmounts->attachment)
              <div class="form-group col-md-4">
                 <label for="inputName" class="font-bold">Attachment: </label>
                <a href="{{ url('/uploads/payment/'.$agentAmounts->attachment) }}" target="_blank">View</a>
                 </select>
              </div>
              
             
              @endif
			  <div class="form-group col-md-12">
                 <label for="inputName" class="font-bold">Remark: </label> {{ $agentAmounts->remark }}
              </div>
           
			 </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a href="{{ route('agentamounts.index') }}" class="btn btn-secondary">Back</a>
    
        </div>
      </div>
    

    </section>
    <!-- /.content -->
@endsection
@section('scripts')
@include('inc.citystatecountryjs')


@endsection
