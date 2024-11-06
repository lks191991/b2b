@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Activity Variants</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Activity Variants</li>
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
                <h3 class="card-title">Activity Variants</h3>
				<div class="card-tools">
				 <a href="{{ route('activity.variants.create') }}" class="btn btn-sm btn-info">
                      <i class="fas fa-plus"></i>
                      Create
                  </a> 
				   </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>Activity</th>
					<th>Variant</th>
					<th>Display Name</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th width="17%"></th>
                  </tr>
				  <tr>
                    <form id="filterForm" method="get" action="{{route('activity.variants')}}" >
                    <th><input type="text" name="activity_name" value="{{request('activity_name')}}" class="form-control"  placeholder="Activity Name" /></th>
					<th><input type="text" name="variant_name" value="{{request('variant_name')}}" class="form-control"  placeholder="Variant Name" /></th>
                  <th><input type="text" name="code" value="{{request('code')}}" class="form-control"  placeholder="Code" /></th>
					
				  <th></th>
					<th></th>
                    
                   
                    <th><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('activity.variants')}}">Clear</a></th>
                    
                  </form>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  
                  <tr>
					
                    <td>{{ @$record->activity->title}}</td>
					<td>{{ @$record->variant->title}}</td>
					<td>{{ $record->code}}</td>
                    <td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
                    <td>{{ $record->updated_at ? date(config('app.date_format'),strtotime($record->updated_at)) : null }}</td>
                     <td>
					 <a class="btn btn-info btn-sm" href="{{route('activity.variant.prices',$record->id)}}">
                             Pricing
                          </a>
						   <a class="btn btn-info btn-sm " href="{{route('activity.variants.edit',$record->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
						   <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$record->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i></a>
                          <form id="delete-form-{{$record->id}}" method="post" action="{{route('activity.variants.destroy',$record->id)}}" >
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                           </td>
                  </tr>
				 
                  @endforeach
                  </tbody>
                 
                </table>
				<div class="pagination pull-right mt-3"> 
				{!! $records->appends(request()->query())->links() !!}
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
    <!-- /.content -->
@endsection

@section('scripts')
 @include('inc.citystatecountryjs')
@endsection