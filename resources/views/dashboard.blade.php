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
		<div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
				<span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
              	<div class="info-box-content">
					<span class="info-box-text"><a href="{{ route('agents.index') }}">Agents</a></span>
					<span class="info-box-number">
					{{$totalAgentRecords}}
					</span>
              	</div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
		<div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
				<span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
              	<div class="info-box-content">
					<span class="info-box-text"><a href="{{ route('suppliers.index') }}">Suppliers</a></span>
					<span class="info-box-number">
					{{$totalSupplierRecords}}
					</span>
              	</div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
		
		<div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
				<span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
              	<div class="info-box-content">
					<span class="info-box-text"><a href="{{ route('activities.index') }}">Activities</a></span>
					<span class="info-box-number">
					{{$totalActivityRecords}}
					</span>
              	</div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
		<div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
				<span class="info-box-icon bg-info elevation-1"><i class="fas fa-hotel"></i></span>
              	<div class="info-box-content">
					<span class="info-box-text"><a href="{{ route('hotels.index') }}">Hotels</a></span>
					<span class="info-box-number">
					{{$totalHotelRecords}}
					</span>
              	</div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
	
		</div>
		@if(Auth::user()->role_id == '1')
		<div class="row"> 
		<div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
			<span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Amount (Today)</span>
                <span class="info-box-number">
					AED {{number_format(($vouchersCurrentDate->totalVoucherActivityAmount)?($vouchersCurrentDate->totalVoucherActivityAmount-($vouchersCurrentDate->totalTktDis+$vouchersCurrentDate->totalTrfDis)):0,2)}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
		  <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
			<span class="info-box-icon bg-success elevation-1"><i class="fas fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">No. Of Booking(s) / Pax(s) (Today) </span>
                <span class="info-box-number">
				{{$vouchersCurrentDate->totalVouchers}} / {{$vouchersCurrentDate->totalAdult+$vouchersCurrentDate->totalChild}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
		
		</div>
		<div class="row"> 
		<div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
			<span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Amount (MTD)</span>
                <span class="info-box-number">
					AED {{number_format(($vouchersMonth->totalVoucherActivityAmount)?($vouchersMonth->totalVoucherActivityAmount-($vouchersMonth->totalTktDis+$vouchersMonth->totalTrfDis)):0,2)}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
		  <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
			<span class="info-box-icon bg-success elevation-1"><i class="fas fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">No. Of Booking(s) / Pax(s) (MTD) </span>
                <span class="info-box-number">
				{{$vouchersMonth->totalVouchers}} / {{$vouchersMonth->totalAdult+$vouchersMonth->totalChild}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
	
		<div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
			<span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Amount (YTD)</span>
                <span class="info-box-number">
					AED {{number_format(($vouchersYear->totalVoucherActivityAmount)?($vouchersYear->totalVoucherActivityAmount-($vouchersYear->totalTktDis+$vouchersYear->totalTrfDis)):0,2)}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
		  <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
			<span class="info-box-icon bg-success elevation-1"><i class="fas fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">No. Of Booking(s) / Pax(s) (YTD) </span>
                <span class="info-box-number">
				{{$vouchersYear->totalVouchers}} / {{$vouchersYear->totalAdult+$vouchersYear->totalChild}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
		  @endif
		<div class="col-lg-12 col-6">
		<div class="card">
		<div class="card-body">
		<table id="example1" class="table table-bordered">
                  <thead>
                  <tr>
					<th>Code</th>
                    <th>Agency</th>
					<th>Zone</th>
                    <th>Status</th>
                    <th>Travel Date</th>
                    <th>Created On</th>
					<th>Created By</th>
                    <th width="4%"></th>
                  </tr>
				  
                  </thead>
                  <tbody>
				 
                  @foreach ($vouchers as $record)
				  
                  <tr>
				  <td>{{ ($record->code)}}</td>
                    <td>{{ ($record->agent)?$record->agent->company_name:''}}</td>
					<td>{{ ($record->zone)}}</td>
                     <td>{!! SiteHelpers::voucherStatus($record->status_main) !!}</td>
					   <td>{{ $record->travel_from_date ? date("M d Y, H:i:s",strtotime($record->travel_from_date)) : null }} <b>To</b> {{ $record->travel_to_date ? date(config('app.date_format'),strtotime($record->travel_to_date)) : null }}</td>
                    <td>{{ $record->created_at ? date("M d Y, H:i:s",strtotime($record->created_at)) : null }}</td>
					<td>{{ ($record->createdBy)?$record->createdBy->name:''}}</td>
                  
					
						 
                     <td>
					 
					 <a class="btn btn-info btn-sm" href="{{route('voucherView',$record->id)}}">
                              <i class="fas fa-eye">
                              </i>
                              
                          </a>
					
                            
                         </td>
                  </tr>
				 
                  @endforeach
                  </tbody>
                 
                </table>
				
				<div class="pagination pull-right mt-3"> {!! $vouchers->links() !!} </div> 
		</div> </div></div>
      
    </div>
    <!-- /.row --> 
  </div>
  <!-- /.container-fluid --> 
</section>
<!-- /.content --> 

@endsection

@section('scripts') 
<script>
	$(function() {
		var colors = [
			'#249efa',
		]
		var options = {
			series: [{
				data: [21, 22, 10, 28, 16, 21, 13, 30, 16, 21, 13, 30]
			}],
			tooltip: {
				custom: function({
					series,
					seriesIndex,
					dataPointIndex,
					w
				}) {
					return '<div class="arrow_box">' +
						'<span>' + series[seriesIndex][dataPointIndex] + '</span>' +
						'</div>'
				}
			},
			chart: {
				height: 350,
				type: 'bar',
				events: {
					click: function(chart, w, e) {
						// console.log(chart, w, e)
					}
				}
			},
			colors: colors,
			plotOptions: {
				bar: {
					columnWidth: '30%',
					distributed: false,
				}
			},
			dataLabels: {
				enabled: false
			},
			legend: {
				show: false
			},
			xaxis: {
				categories: [
					["Jan"],
					["Feb"],
					["Mar"],
					["Apr"],
					["May"],
					["Jun"],
					["Jul"],
					["Aug"],
					["Sep"],
					["Oct"],
					["Nov"],
					["Dec"],
				],
				labels: {
					style: {
						colors: colors,
						fontSize: '12px'
					}
				}
			}
		};

		var chart = new ApexCharts(document.querySelector("#chart"), options);
		chart.render();

		var options = {
			series: [30],
			chart: {
				height: 350,
				type: 'radialBar',
			},
			plotOptions: {
				radialBar: {
					hollow: {
						size: '30%',
					}
				},
			},
			labels: ['Available'],
		};

		var chart = new ApexCharts(document.querySelector("#chart2"), options);
		chart.render();
	});
</script> 
@endsection
