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
				 <a href="{{ route('vouchers.index') }}" class="btn btn-sm btn-info">
                      <i class="fas fa-arrow-left"></i>
                      Back To Vouchers
                  </a> 
				   </div>
              </div>
              <!-- /.card-header -->
             <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Title</th>
					<th>Code</th>
					 <th>Type of Activity</th>
                    <th>Created On</th>
                    <th>Updated On</th>
                    <th></th>
                  </tr>
				  <tr>
                    <form id="filterForm" method="get" action="{{route('voucher.add.activity',$vid)}}" >
                    <th><input type="text" name="name" value="{{request('name')}}" class="form-control"  placeholder="Title" /></th>
                  <th><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('voucher.add.activity',$vid)}}">Clear</a></th>
				  <th></th>
					
					<th></th>
                    <th></th>
                   
                    <th></th>
                    
                  </form>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  
                  <tr>
					
                    <td>{{ $record->title}}</td>
					<td>{{ $record->code}}</td>
					<td>{{ ($record->type_activity)?$typeActivities[$record->type_activity]:''}}</td>
                   
                    <td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
                    <td>{{ $record->updated_at ? date(config('app.date_format'),strtotime($record->updated_at)) : null }}</td>
                     <td>
					 <a class="btn btn-info btn-sm" href="{{route('voucher.activity.view',[$record->id,$vid])}}">
                             Add
                          </a>
					
					  </td>
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

@section('scripts')
 @include('inc.citystatecountryjs')
@endsection
