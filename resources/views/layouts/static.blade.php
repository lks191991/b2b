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
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
  <link href="{{asset('dist/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('dist/css/custom.css')}}" rel="stylesheet">

</head>
<body >
  <div class="hold-transition login-page">
<div class="login-div" style="width:70%">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
    <a href="https://abaterab2b.com/"><img src="{{asset('Abatera_logo.jpg')}}" style="max-width: 120px"></a>
    </div>
    @include('inc.errors-and-messages')
    @yield('content')
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>

<!-- /.login-box -->
</div>
@include('inc.footer')

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
@yield('scripts')
</body>
</html>