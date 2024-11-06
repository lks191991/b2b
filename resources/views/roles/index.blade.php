@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Roles</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Roles</li>
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
                <h3 class="card-title">Roles</h3>
				<div class="card-tools">
				 <a href="{{ route('roles.create') }}" class="btn btn-sm btn-info">
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
                    <!--th>Status</th-->
                    <th>Created On</th>
                    <th>Updated On</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($roles as $role)
				  @if($role->id > 1)
                  <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $role->name}}</td>
                    <!--td>{{ $role->status ? 'Active' : 'Inactive' }}</td-->
                    <td>{{ $role->created_at ? date(config('app.date_format'),strtotime($role->created_at)) : null }}</td>
                    <td>{{ $role->updated_at ? date(config('app.date_format'),strtotime($role->updated_at)) : null }}</td>
                    <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('permrole.index') }}">
                              <i class="fas fa-eye">
                              </i>
                              View Permissions
                          </a>
                     </td>
                  </tr>
				  @endif
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