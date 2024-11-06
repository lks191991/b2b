@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Modules</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Modules</li>
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
                <h3 class="card-title">Modules</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Created On</th>
                    <th>Updated On</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($modules as $module)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $module->name}}</td>
                    <td>{{ $module->status ? 'Active' : 'Inactive' }}</td>
                    <td>{{ $module->created_at ? date(config('app.date_format'),strtotime($module->created_at)) : null }}</td>
                    <td>{{ $module->updated_at ? date(config('app.date_format'),strtotime($module->updated_at)) : null }}</td>
                    <td><a class="btn btn-info btn-sm" href="{{route('modules.edit',$module->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
                          <form id="delete-form-{{$module->id}}" method="post" action="{{route('modules.destroy',$module->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$module->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i>Delete</a></td>
                  </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                
                  </tfoot>
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