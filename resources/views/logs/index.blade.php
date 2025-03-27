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
            <h1>Rayna Logs</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Rayna Logs</li>
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
                <h3 class="card-title">Rayna Logs</h3>
				<div class="card-tools">
				 
				   </div>
              </div>
              <!-- /.card-header -->
			  <div class="card-body" style="overflow-x: auto;
    width: 100%;">
			  <div class="row" >
            <form id="filterForm" class="form-inline" method="get" action="{{ route('logs.rayna.booking') }}" >
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
                <a class="btn btn-default mb-2  mx-sm-2" href="{{ route('logs.rayna.booking') }}">Clear</a>
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
                    <th width="30%">Payload</th>
					          <th width="40%">Responce</th>
                    <th width="10%">EndPoint</th>
                    <th width="10%">Created</th>
                  </tr>
				  
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>
                      @if(!empty($record->voucher->code))
                      @if($record->voucher->status_main < 5)
                      <a class="btn btn-info btn-sm" target="_blank" title="Checkout" href="{{route('vouchers.show',$record->voucher->id)}}">
                        {{ $record->voucher->code }}
                                    </a>
                        @else
                     <a class="btn btn-info btn-sm" target="_blank" href="{{route('voucherView',$record->voucher->id)}}">
                      {{ $record->voucher->code }}
                                    </a>
                                    @endif

                      @else
                          N/A
                      @endif
                  </td>
                  
                  
                    <td class="json-data">{{ json_encode($record->payload) }}</td>
					 <td class="json-data">{{ json_encode($record->response) }}</td>
					  <td>{{ $record->endpoint }}</td>
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
