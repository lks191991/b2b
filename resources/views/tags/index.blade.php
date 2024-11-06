@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tags</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Tags</li>
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
                <h3 class="card-title">Tags</h3>
				<div class="card-tools">
				 <a href="{{ route('tags.create') }}" class="btn btn-sm btn-info">
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
                    <th>#</th>
                    <th>Name</th>
					<th>Image</th>
                    <th>Status</th>
                    <th>Created On</th>
                    <th>Updated On</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $record->name}}</td>
					<td>  @if($record->image)
                <img src="{{ url('/uploads/tags/thumb/'.$record->image) }}" width="50"  alt="tag" style="margin-top: 32px;" />
			  @endif</td>
					 <td>{!! SiteHelpers::statusColor($record->status) !!}</td>
                    <td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
                    <td>{{ $record->updated_at ? date(config('app.date_format'),strtotime($record->updated_at)) : null }}</td>
                     <td>
					 
						  <a class="btn btn-info btn-sm" href="{{route('tags.edit',$record->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a> <form id="delete-form-{{$record->id}}" method="post" action="{{route('tag.delete.image',$record->id)}}" style="display:none;">
                                {{csrf_field()}}
                            </form>
					 <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete image?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$record->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            ">Delele Image </a>
                          </td>
                  </tr>
				 
                  @endforeach
                  </tbody>
                 
                </table>
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
 
<script type="text/javascript">
  $(document).ready(function(){

	$('#example1').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
  </script> 
@endsection