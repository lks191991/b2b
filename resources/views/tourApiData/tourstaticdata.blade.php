@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tour Static Data</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Tour Static Data</li>
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
                            <h3 class="card-title">Tour Static Data</h3>
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
                                        <th>Country Id</th>
										<th>Country Name</th>
										 <th>City Id</th>
                                        <th>City Name</th>
                                        <th>Tour Name</th>
                                        <th>Review Count</th>
                                        <th>Rating</th>
                                        <th>Duration</th>
										 <th>City Tour Type ID</th>
                                        <th>City Tour Type</th>
                                        <th>Tour Short Description</th>
                                        <th>Cancellation Policy</th>
                                        <th>Is Slot</th>
                                        <th>Only Child</th>
                                        <th>Contract ID</th>
                                        <th>Recommended</th>
                                        <th>Is Private</th>
										 <th>Tour Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($records as $k => $record)
                                        <tr>
                                            <td>{{ $k+1 }}</td>
                                            <td>{{ $record->tourId }}</td>
											 <td>{{ $record->countryId }}</td>
                                            <td>{{ $record->countryName }}</td>
											<td>{{ $record->cityId }}</td>
                                            <td>{{ $record->cityName }}</td>
                                            <td>{{ $record->tourName }}</td>
                                            <td>{{ $record->reviewCount }}</td>
                                            <td>{{ $record->rating }}</td>
                                            <td>{{ $record->duration }}</td>
											<td>{{ $record->cityTourTypeId }}</td>
                                            <td>{{ $record->cityTourType }}</td>
                                            <td>{!! $record->tourShortDescription !!}</td>
                                            <td>{{ $record->cancellationPolicyName }}</td>
                                            <td>{{ $record->isSlot ? 'Yes' : 'No' }}</td>
                                            <td>{{ $record->onlyChild ? 'Yes' : 'No' }}</td>
                                            <td>{{ $record->contractId }}</td>
                                            <td>{{ $record->recommended ? 'Yes' : 'No' }}</td>
                                            <td>{{ $record->isPrivate ? 'Yes' : 'No' }}</td>
											<td>@if ($record->tourOption)
											<a class="btn btn-info btn-sm" href="{{ route('tourOptionStaticData', $record->tourId) }}">
											Yes
											</a>
											@else
											No
											@endif</td>
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
