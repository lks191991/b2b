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
              <div class="col-md-8">
                <div class="row">
                <div class="col-md-4 form-group ">
                    <label for="inputName" class="font-bold">Receipt No: </label><br/>
                  {{ $agentAmounts->receipt_no}}
                </div>
                <div class="col-md-5 form-group  text-left">
                        <label for="inputName" class="font-bold">Transaction Type:</label><br/> {{ $agentAmounts->transaction_type}}
                 </div>
                <div class="col-md-3 form-group  text-left">
                  <label for="inputName" class="font-bold">Date: </label><br/> {{$agentAmounts->date_of_receipt}}
                </div>
                <div class="col-md-12 form-group ">
                  <label for="inputName" class="font-bold">Agency / Supplier Name: </label><br/>
                {{ ($agentAmounts->agent)?$agentAmounts->agent->company_name:''}}
                </div>
               
                <div class="col-md-4 form-group ">
                      <label for="inputName" class="font-bold">Amount: </label><br/> AED {{$agentAmounts->amount}}
                </div>
                
                <div class="col-md-5 form-group ">
                  <label for="inputName" class="font-bold">Mode of Payment: </label><br/>
                  @if($agentAmounts->mode_of_payment =='1') {{'WIO BANK A/C No - 962 222 3261'}} @elseif($agentAmounts->mode_of_payment =='2') {{'RAK BANK A/C No -0033488116001'}} @elseif($agentAmounts->mode_of_payment =='3'){{'CBD BANK A/C No -1001303922'}} @elseif ($agentAmounts->mode_of_payment =='4'){{'Cash'}} @elseif($agentAmounts->mode_of_payment =='5'){{'Cheque'}} @elseif($agentAmounts->mode_of_payment =='6'){{'ICICI BANK - 006005013540 - VTZ'}} @elseif($agentAmounts->mode_of_payment =='7'){{' ICICI BANK - 006005015791 - BHO'}} @endif 
                </div>
           
                <div class="col-md-3 form-group  text-left">
                  <label for="inputName" class="font-bold">Status: </label><br/>
                  @if($agentAmounts->status =='1') {{'Pending'}}  @elseif($agentAmounts->status =='2') {{'Approved'}}  @elseif($agentAmounts->status =='3'){{'Rejected'}} @endif
                </div>
                <div class="col-md-3 form-group  text-left">
                  <label for="inputName" class="font-bold">Created By: </label><br/>
                  {{ $agentAmounts->created_by ? $agentAmounts->createdBy->name : null }}
                </div>
              
             

               
                
                <div class="form-group col-md-12">
                  <label for="inputName" class="font-bold">Remark: </label><br/> {{ $agentAmounts->remark }}
                </div>
                </div>
              </div>
              <div class="col-md-4">
              @if($agentAmounts->attachment !='')
            <a href="{{ url('/uploads/payment/'.$agentAmounts->attachment) }}" target="_blank"><img src="{{ url('/uploads/payment/'.$agentAmounts->attachment) }}" class="img-fluid"/></a>
            @endif
            </div>
           
            </div>
            
			 </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <a href="{{ route('agentamounts.index') }}" class="btn btn-secondary">Back</a>
    
        </div>
        @if($agentAmounts->status == '2')   
        <div class="col-6">
        <a class="btn btn-secondary btn-sm" href="{{route('receiptPdf',$agentAmounts->id)}}" >
           Download PDF
                          </a>
        </div>
        @endif

       
      </div>
    

    </section>
    <!-- /.content -->
@endsection
@section('scripts')
@include('inc.citystatecountryjs')


@endsection
