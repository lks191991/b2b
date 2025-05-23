@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tour Option - {{ $tourName ?: 'All' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Tour Option - {{ $tourName ?: 'All' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tour Option - {{ $tourName ?: 'All' }}</h3>
                            <div class="card-tools">
                                <!-- Add any additional buttons or filters here -->
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="overflow-x:auto">
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SN.</th>
                                        <th>Tour ID</th>
                                        <th>Tour Option ID</th>
                                        <th>Option Name</th>
                                        <th>Child Age</th>
                                        <th>Infant Age</th>
                                        <th>Option Description</th>
                                        <th>Cancellation Policy</th>
                                        <th>Cancellation Policy Description</th>
                                        <th>Min Pax</th>
                                        <th>Max Pax</th>
                                        <th>Duration</th>
                                        <th>Time Zone</th>
                                        <th>Is Without Adult</th>
                                        <th>Is Tour Guide</th>
                                        <th>Compulsory Options</th>
                                        <th>Is Hide Rate Breakup</th>
                                        <th>Is Hourly</th>
										<th></th>
                                    </tr>
                                </thead>
                                <tbody>
								
								 <tr>
								 <form id="filterForm" method="get" action="{{route('tourOptionStaticData')}}" >
                                        <th></th>
                                        <th width="8%"><input type="text" name="tourId" value="{{request('tourId')}}" class="form-control"  placeholder="Tour Id" /></th>
                                        <th width="10%"><input type="text" name="tourOptionId" value="{{request('tourOptionId')}}" class="form-control"  placeholder="Tour Option ID" /></th>
                                        <th width="10%"><input type="text" name="name" value="{{request('name')}}" class="form-control"  placeholder="Name" /></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
										<th></th>
                                        <th width="15%"><button class="btn btn-info btn-sm" type="submit">Filter</button>
                                        <a class="btn btn-default btn-sm" href="{{route('tourOptionStaticData')}}">Clear</a></th>
										 </form>
                                    </tr>
                                    @foreach ($records as $k => $record)
                                        <tr>
                                            <td>{{ $k+1 }}</td>
                                            <td>{{ $record->tourId }}</td>
                                            <td>{{ $record->tourOptionId }}</td>
                                            <td>{{ $record->optionName }}</td>
                                            <td>{{ $record->childAge }}</td>
                                            <td>{{ $record->infantAge }}</td>
                                            <td>{{ $record->optionDescription }}</td>
                                            <td>{{ $record->cancellationPolicy }}</td>
                                            <td>{!! $record->cancellationPolicyDescription !!}</td>
                                            <td>{{ $record->minPax }}</td>
                                            <td>{{ $record->maxPax }}</td>
                                            <td>{{ $record->duration }}</td>
                                            <td>{{ $record->timeZone }}</td>
                                            <td>{{ $record->isWithoutAdult ? 'Yes' : 'No' }}</td>
                                            <td>{{ $record->isTourGuide ? 'Yes' : 'No' }}</td>
                                            <td>{{ $record->compulsoryOptions ? 'Yes' : 'No' }}</td>
                                            <td>{{ $record->isHideRateBreakup ? 'Yes' : 'No' }}</td>
                                            <td>{{ $record->isHourly ? 'Yes' : 'No' }}</td>
											<td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
							<div class="pagination pull-right mt-3"> {!! $records->appends(request()->query())->links() !!} </div> 
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
