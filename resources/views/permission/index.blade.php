

@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Permissions</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Permissions</li>
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
                <h3 class="card-title">Permissions</h3>
				<div class="card-tools">
                  
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
             
                 <form method="POST" action="{{route('permrole.save')}}" id="permissions">
                      <input name="_token" type="hidden" value="{{ csrf_token() }}">
                      <table class="table table-bordered">
                          <thead>
                              <tr>
                                  <th class="td_perm_name td_divider"></th>
                                  @foreach ($roles as $role)
                                  <th class="td_divider">{{$role->name}}</th>
                                  @endforeach
                                  <!-- <td class="td_perm_spacer">&nbsp;</td>-->
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($perms as $module => $perm)        
                              <tr>
                                  <td colspan='4' class="td_perm_name td_divider td_module_name" style="padding:5px 10px;"><strong>{{strtoupper($module)}}</strong></td>
                              </tr>
                              @foreach ($perm as $slug => $p)
                              <tr>
                                  <td class="td_perm_name td_divider">{{$p->name}}</td>
                                  @foreach ($roles as $role)
                                  <td class="td_perm_export td_divider">
                                      <label class="switch switch-icon switch-pill switch-success" style="margin-bottom: 0px;" title="{{$p->name .' | '.$role->name}}">                                                  
                                        <input type="checkbox" class="switch-input" name="perm[{{$role->id}}][{{$p->id}}]" value="{{$slug}}" {{ isset($active_perm[$role->id][$p->id]) ?  'checked' : '' }}>
                                        <span class="switch-label" data-on="&#xf00c" data-off="&#xf00d"></span>
                                        <span class="switch-handle"></span>
                                      </label>

                                  </td>
                                  @endforeach
                                  <!-- <td class="td_perm_spacer">&nbsp;</td>-->
                              </tr>
                              @endforeach
                              @endforeach
                          </tbody>
                      </table>
                      <div class="modal-footer1">
                          <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                  </form>  
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

     <!-- Modal -->
    

  

@endsection

