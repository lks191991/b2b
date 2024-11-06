@extends('layouts.app')
  <!-- jQuery CDN -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Users <input type="hidden" name="role" id="role" value="2" /></li>
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
                <h3 class="card-title">Users</h3>
				<div class="card-tools">
				 <a href="{{ route('users.create') }}" class="btn btn-sm btn-info">
                      <i class="fas fa-plus"></i>
                      Create
                  </a> 
				   </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="usersData" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Profile Picture</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created On</th>
                    <th>Password</th>
                    <!--th>Updated On</th-->
                    <th class="nowrap" width="20%"></th>
                  </tr>
				   <tr>
                    <form id="filterForm" method="get" action="{{route('users.index')}}" >
					<th></th>
                    <th><input type="text" name="user_name" value="{{request('user_name')}}" class="form-control"  placeholder="Name" /></th>
                    
                    <th><input type="text" name="user_email" value="{{request('user_email')}}" class="form-control"  placeholder="Email" /></th>
					<th> <select name="role_id" id="role_id" class="form-control">
                    <option value = "">-Select Role-</option>
                    @foreach($roles as $role)
                      <option value="{{ $role->id }}" @if($role->id == request('role_id')) selected="selected" @endif >{{ $role->name }}</option>
                    @endforeach
                 </select></th>
                   
                    <th><select name="status" id="status" class="form-control">
                    <option value="" @if(request('status') =='') {{'selected="selected"'}} @endif>Select</option>
                    <option value="1" @if(request('status') ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="2" @if(request('status') ==2) {{'selected="selected"'}} @endif >Inactive</option>
                 </select></th>
                    <th></th>
					<th></th>
                    <th><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('users.index')}}">Clear</a></th>
                  </form>
                  </tr>
                  </thead>
                   @if (!empty($records->count()))
                  @foreach ($records as $record)
                  <tr>
                    <td>@if($record->image!='')<img src="{{asset('uploads/users/thumb/'.$record->image)}}" width="50">@endif</td>
                    <td>{{ $record->full_name}}</td>
					<td>{{ $record->email}}</td>
					<td>{{ $record->roles[0]->name}}</td>
                    <td>{!! SiteHelpers::statusColor($record->is_active) !!}</td>
					
					<td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
					<td>
					  
                          <form id="resetpsw-form-{{$record->id}}" method="post" action="{{route('passwordResetAdmin',$record->id)}}" style="display:none;">
                                {{csrf_field()}}
                               <input type="hidden" name="user" value="user">
                            </form>
                            <a class="btn btn-warning btn-sm " href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to reset password this user?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('resetpsw-form-{{$record->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            ">Reset <i class="fas fa-key"></i></a>
						    </td>
                    <td>
						  <a class="btn btn-info btn-sm" href="{{route('users.show',$record->id)}}">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a>
						  <a class="btn btn-info btn-sm" href="{{route('users.edit',$record->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a>
						
						  
						 
						 </td>
                            
                  </tr>
                  @endforeach
                  @else
                    <td colspan="10"><center><b>No Record Found</b></center></td>
                    @endif
                  </tbody>
                  <tfoot>
                
                  </tfoot>
                </table>
                <div class="pagination pull-right mt-3"> {!! $records->appends(request()->query())->links() !!} </div> 
                <!-- Script -->
                          
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
