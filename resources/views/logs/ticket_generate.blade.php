@extends('layouts.app')
@section('content')
<style>td.json-data {
  min-width: 300px; /* Jitni chahiye utni badha sakte hain */
  max-width: 600px; /* Maximum width limit */
  word-wrap: break-word;
  white-space: pre-wrap; /* JSON ko properly wrap karne ke liye */
}</style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Ticket Generate Logs</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Ticket Generate Logs</li>
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
                <h3 class="card-title">Ticket Generate Logs</h3>
				<div class="card-tools">
				 
				   </div>
              </div>
              <!-- /.card-header -->
			  <div class="card-body" style="overflow-x: auto;
    width: 100%;">
			  <div class="row" >
            <form id="filterForm" class="form-inline" method="get" action="{{ route('logs.ticket.generate') }}" >
              <div class="form-row align-items-center">
			   
			  <div class="col-auto col-md-4">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">From Date</div></div>
                    <input type="text" name="from_date" value="{{ request('from_date') }}" autocomplete ="off" class="form-control datepicker"  placeholder="From Date" />
                  </div>
                </div>
				<div class="col-auto col-md-4">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend"><div class="input-group-text">To Date</div></div>
                    <input type="text" name="to_date" value="{{ request('to_date') }}" class="form-control datepicker" autocomplete ="off"  placeholder="To Date" />
                  </div>
                </div>
                <div class="col-auto col-md-3">
                  <div class="input-group mb-2">
                    <button class="btn btn-info mb-2" type="submit">Filter</button>
                <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('logs.ticket.generate') }}">Clear</a>
                  </div>
                </div>
                
               
             
            </form>
          </div>
        </div>
                <table id="example1" class="table table-bordered table-striped" >
                  <thead>
                  <tr>
                    <th width="10%">#</th>
                    <th width="10%">V-Code</th>
                    <th width="10%">V-Activity-Id</th>
                    <th width="30%">Total Record</th>
					          <th width="40%">Cost</th>
                    <th width="10%">Created</th>
                  </tr>
				  
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                     <a class="btn btn-info btn-sm" target="_blank" href="{{route('voucherView',$record->voucher->id)}}">
                      {{ $record->voucher->code }}
                                    </a>
                  </td>
                  <td class="">{{ $record->voucher_activity_id ?? 'N/A' }}</td>
                  <td class="">{{ $record->total_record ?? 'N/A' }}</td>
                  <td class="">{{ $record->supplier_cost ?? 'N/A' }}</td>
                    <td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
                     
                  </tr>
				 
                  @endforeach
                  </tbody>
                 
                </table>
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
