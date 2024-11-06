<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link href="{{asset('dist/css/custom.css')}}" rel="stylesheet">

</head>
<body >
  <div class="hold-transition ">
<div class="">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    
    @include('inc.errors-and-messages')

    <!-- Main content -->
    <section class="content">
        
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Search</h3>
				<div class="card-tools">
				
				   </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Mobile</th>
                    <th>Code</th>
                    <th>Status</th>
                  </tr>
				  <tr>
                    <form id="filterForm" method="get" action="{{route('csvlist')}}" >
                    <th><input type="text" name="name" value="{{request('name')}}" class="form-control"  placeholder="Name" /></th>
                    <th><input type="text" name="email" value="{{request('email')}}" class="form-control"  placeholder="Email" /></th>
                    <th><input type="text" name="company" value="{{request('company')}}" class="form-control"  placeholder="Company" /></th>
                    <th><input type="text" name="state" value="{{request('state')}}" class="form-control"  placeholder="State" /></th>
                    <th><input type="text" name="city" value="{{request('city')}}" class="form-control"  placeholder="City" /></th>
                    <th><input type="text" name="mobile" value="{{request('mobile')}}" class="form-control"  placeholder="Mobile" /></th>
                    <th></th>
                   
                    <th><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('csvlist')}}">Clear</a></th>
                    
                  </form>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($records as $record)
				  
                  <tr>
					
                  <td>{{ $record->name}}</td>
					        <td>{{ $record->email}}</td>
                  <td>{{ $record->company}}</td>
					        <td>{{ $record->state}}</td>
                  <td>{{ $record->city}}</td>
					        <td>{{ $record->code}}</td>
                  <td>{{ $record->mobile}}</td>
					        <td>{{ $record->status}}</td>
					
                  </tr>
				 
                  @endforeach
                  </tbody>
                 
                </table>
				<div class="pagination pull-right mt-3"> 
          @if(!empty($records))
				{!! $records->appends(request()->query())->links() !!}
        @endif
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
 <!-- /.card-body -->
 </div>
  <!-- /.card -->
</div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
</body>
</html>