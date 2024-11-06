@extends('layouts.app')
@section('content')
<style>
	.smart-box {background-color: #fff; border-radius: 10px; margin-bottom: 30px; box-shadow: 0px 0px 5px #ddd; padding:15px 20px 10px 20px;}
	.small-box {background-color: #fff; border-radius: 10px; margin-bottom: 30px; box-shadow: 0px 0px 5px #ddd; padding:15px 20px 10px 20px;
		position: relative}
	.small-box > h4 { position: absolute;}
	[class*=sidebar-dark-] {    background-color: #1a1c1e;}
	.arrow_box {background-color: #249efa; padding:5px 15px; border-radius: 5px; color: #fff;}
	
	.sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {background-color: #2ba0a6;}
	
</style>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Dashboard</h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
  </div>
  <!-- /.container-fluid --> 
</div>
<!-- /.content-header --> 

<!-- Main content -->
<section class="content">
  <div class="container-fluid"> 
    <!-- Small boxes (Stat box) -->
    <div class="row"> 
      
		<div class="col-lg-6 col-6 mb-5">
        Welcome <b> {{auth()->user()->company_name}}</b>.
	
        </div>
		
    </div>
    <!-- /.row --> 
    <div class="row">
		<div class="col-md-6">
		<a href="{{ route('agent-vouchers.create') }}" class="btn btn-sm btn-success">
                      <i class="fas fa-plus"></i>
                      Create New Booking
                  </a> 
		</div>
	</div>
    <!-- /.row --> 
  </div>
  <!-- /.container-fluid --> 
</section>
<!-- /.content --> 

@endsection

@section('scripts') 

@endsection