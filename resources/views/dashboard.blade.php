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

		@php
		$totalSellsRaw = $vouchersCurrentDate ? ($vouchersCurrentDate->totalSells - $vouchersCurrentDate->totalSellsDis) : 0;
		$totalTransSellsRaw = $vouchersCurrentDate ? ($vouchersCurrentDate->totalTransSells - $vouchersCurrentDate->totalTransSellsDis) : 0;
		$currentDateSellRaw = $totalSellsRaw + $totalTransSellsRaw;
		$currentDateSell = number_format($currentDateSellRaw, 2);
	@endphp
	


		<div class="row"> 
		<div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
			<span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Amount (Today)</span>
                <span class="info-box-number">
					AED {{$currentDateSell}}

					
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
			@php
    $totalSellsMonthRaw = $vouchersMonth ? ($vouchersMonth->totalSells - $vouchersMonth->totalSellsDis) : 0;
    $totalTransSellsMonthRaw = $vouchersMonth ? ($vouchersMonth->totalTransSells - $vouchersMonth->totalTransSellsDis) : 0;
    $monthTotalSellRaw = $totalSellsMonthRaw + $totalTransSellsMonthRaw;
    $monthTotalSell = number_format($monthTotalSellRaw, 2);
@endphp

              <div class="info-box-content">
                <span class="info-box-text">Total Amount (MTD)</span>
                <span class="info-box-number">
					AED {{$monthTotalSell}}
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
				@php
			

				$totalSellsYear = $vouchersYear ? ($vouchersYear->totalSells - $vouchersYear->totalSellsDis) : 0;
    $totalTransSellsYear = $vouchersYear ? ($vouchersYear->totalTransSells - $vouchersYear->totalTransSellsDis) : 0;
    $totalSellYear = $totalSellsYear + $totalTransSellsYear;
    $yearTotalSale = number_format($totalSellYear, 2);

				@endphp

              <div class="info-box-content">
                <span class="info-box-text">Total Amount (YTD)</span>
                <span class="info-box-number">
					AED {{$yearTotalSale}}
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
		<div class="col-lg-12">
		<div class="card">
		<div class="card-body">
      <div class="row">
        <h2 class="text-center mb-3">Sell Report</h2>
    
        <style>
            table, th, td {
                border: 1px solid #dee2e6 !important;
                border-collapse: collapse;
                text-align: center;
            }
            th, td {
                padding: 8px;
            }
           
        </style>
    
        @php
            use Carbon\Carbon;
    
            $todayDate = date("d-m-Y");
            $currentDate = Carbon::now();
            $currentYear = $currentDate->year;
            $currentMonthStartDate = $currentDate->startOfMonth()->format('d-m-Y');
            $startDateOfYear = Carbon::createFromDate($currentYear, 1, 1)->format('d-m-Y');
            $endDateOfYear = Carbon::createFromDate($currentYear, 12, 31)->format('d-m-Y');
        @endphp
    
        
    
<table class="table text-center mb-4">
  
  <thead class="table-light">
    <tr>
      <th colspan="4"><strong>Current Date</strong> : <span>({{ $todayDate }})</span></th>
      <th colspan="5"><strong>MTD</strong> : ({{ $currentMonthStartDate }} - {{ $todayDate }})</span></th>
      <th colspan="4"><strong>YTD</strong><span> : ({{ $startDateOfYear }} - {{ $endDateOfYear }})</span></th>
      
  </tr>
      <tr>
          <th rowspan="2">Service</th>
          <th colspan="3">Total Sales</th>
          <th colspan="3">Total Cost</th>
          <th colspan="3">Profit Cost</th>
          <th colspan="3">Unaccounted</th>
      </tr>
      <tr>
          <th>Current Date</th>
          <th>MTD</th>
          <th>YTD</th>
          <th>Current Date</th>
          <th>MTD</th>
          <th>YTD</th>
          <th>Current Date</th>
          <th>MTD</th>
          <th>YTD</th>
          <th>Unaccounted Service</th>
          <th>Value</th>
          <th>Count</th>
      </tr>
  </thead>
  <tbody>
      <tr>
          <td>Ticket</td>
          <td>{{ number_format((float)$cDReport['totalSells'], 2) }}</td>
          <td>{{ number_format((float)$cMReport['totalSells'], 2) }}</td>
          <td>{{ number_format((float)$cYReport['totalSells'], 2) }}</td>
          <td>{{ number_format((float)$cDReport['totalCost'], 2) }}</td>
          <td>{{ number_format((float)$cMReport['totalCost'], 2) }}</td>
          <td>{{ number_format((float)$cYReport['totalCost'], 2) }}</td>
          <td>{{ number_format((float)$cDReport['totalAccountedProfit'], 2) }}</td>
          <td>{{ number_format((float)$cMReport['totalAccountedProfit'], 2) }}</td>
          <td>{{ number_format((float)$cYReport['totalAccountedProfit'], 2) }}</td>
          <td>Ticket</td>
          <td>{{ number_format((float)$cYReport['totalUnAccountedSell'], 2) }}</td>
          <td>Ticket Count</td>
      </tr>
      <tr>
          <td>Transfers</td>
          <td>{{ number_format((float)$cDReport['totalTransSells'], 2) }}</td>
          <td>{{ number_format((float)$cMReport['totalTransSells'], 2) }}</td>
          <td>{{ number_format((float)$cYReport['totalTransSells'], 2) }}</td>
          <td>{{ number_format((float)$cDReport['totalTransCost'], 2) }}</td>
          <td>{{ number_format((float)$cMReport['totalTransCost'], 2) }}</td>
          <td>{{ number_format((float)$cYReport['totalTransCost'], 2) }}</td>
          <td>{{ number_format((float)$cDReport['totalAccountedTransProfit'], 2) }}</td>
          <td>{{ number_format((float)$cMReport['totalAccountedTransProfit'], 2) }}</td>
          <td>{{ number_format((float)$cYReport['totalAccountedTransProfit'], 2) }}</td>
          <td>Transfers</td>
          <td>{{ number_format((float)$cYReport['totalUnAccountedTransSell'], 2) }}</td>
          <td>Transfers Count</td>
      </tr>
      <tr>
          <td>Hotel</td>
          <td>{{ number_format((float)$cDReport['totalHotelSP'], 2) }}</td>
          <td>{{ number_format((float)$cMReport['totalHotelSP'], 2) }}</td>
          <td>{{ number_format((float)$cYReport['totalHotelSP'], 2) }}</td>
          <td>{{ number_format((float)$cDReport['totalHotelCost'], 2) }}</td>
          <td>{{ number_format((float)$cMReport['totalHotelCost'], 2) }}</td>
          <td>{{ number_format((float)$cYReport['totalHotelCost'], 2) }}</td>
          <td>{{ number_format((float)$cDReport['PLHotel'], 2) }}</td>
          <td>{{ number_format((float)$cMReport['PLHotel'], 2) }}</td>
          <td>{{ number_format((float)$cYReport['PLHotel'], 2) }}</td>
          <td>Total</td>
          <td>Hotel Value</td>
          <td>Hotel Count</td>
      </tr>
      <tr>
          <th>Total</th>
          <th>{{ number_format((float)($cDReport['totalSells'] + $cDReport['totalTransSells'] + $cDReport['totalHotelSP']), 2) }}</th>
          <th>{{ number_format((float)($cMReport['totalSells'] + $cMReport['totalTransSells'] + $cMReport['totalHotelSP']), 2) }}</th>
          <th>{{ number_format((float)($cYReport['totalSells'] + $cYReport['totalTransSells'] + $cYReport['totalHotelSP']), 2) }}</th>
          <th>{{ number_format((float)($cDReport['totalCost'] + $cDReport['totalTransCost'] + $cDReport['totalHotelCost']), 2) }}</th>
          <th>{{ number_format((float)($cMReport['totalCost'] + $cMReport['totalTransCost'] + $cMReport['totalHotelCost']), 2) }}</th>
          <th>{{ number_format((float)($cYReport['totalCost'] + $cYReport['totalTransCost'] + $cYReport['totalHotelCost']), 2) }}</th>
          <th>{{ number_format((float)($cDReport['totalAccountedProfit'] + $cDReport['totalAccountedTransProfit'] + $cDReport['PLHotel']), 2) }}</th>
          <th>{{ number_format((float)($cMReport['totalAccountedProfit'] + $cMReport['totalAccountedTransProfit'] + $cMReport['PLHotel']), 2) }}</th>
          <th>{{ number_format((float)($cYReport['totalAccountedProfit'] + $cYReport['totalAccountedTransProfit'] + $cYReport['PLHotel']), 2) }}</th>
          <th>Total</th>
          <th>Total Sales Value</th>
          <th>Total Sales Count</th>
      </tr>
  </tbody>
</table>





    </div>

    <div class="row">
	<h2 class="text-center mb-3">Current Bookings</h2>
        <table id="example1" class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Code</th>
                    <th>Agency</th>
                    <th>Zone</th>
                    <th>Status</th>
                    <th>Travel Date</th>
                    <th>Booking Date</th>
                    <th>Created On</th>
                    <th>Created By</th>
                    <th width="4%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vouchers as $record)
                <tr>
                    <td>{{ $record->code }}</td>
                    <td>{{ $record->agent ? $record->agent->company_name : '' }}</td>
                    <td>{{ $record->zone }}</td>
                    <td>{!! SiteHelpers::voucherStatus($record->status_main) !!}</td>
                    <td>
                        {{ $record->travel_from_date ? date("M d Y, H:i:s", strtotime($record->travel_from_date)) : null }} 
                        <b>To</b> 
                        {{ $record->travel_to_date ? date(config('app.date_format'), strtotime($record->travel_to_date)) : null }}
                    </td>
                    <td>{{ $record->booking_date ? date("M d Y", strtotime($record->booking_date)) : null }}</td>
                    <td>{{ $record->created_at ? date("M d Y, H:i:s", strtotime($record->created_at)) : null }}</td>
                    <td>{{ $record->createdBy ? $record->createdBy->name : '' }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('voucherView', $record->id) }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination float-end mt-3"> {!! $vouchers->links() !!} </div>
    </div>
</div>


		</div>
		</div>
      
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
