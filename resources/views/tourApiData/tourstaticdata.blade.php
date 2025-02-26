@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tour Data</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Tour  Data</li>
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
                            <h3 class="card-title">Tour Data</h3>
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
										<th>Country Name</th>
                                        <th>City Name</th>
                                        <th>Tour Name</th>
                                        <th>Review Count</th>
                                        <th>Rating</th>
                                        <th>Duration</th>
										 <th>City Tour Type ID</th>
                                        <th>City Tour Type</th>
                                        <th>Is Slot</th>
                                        <th>Only Child</th>
                                        <th>Contract ID</th>
                                        <th>Is Private</th>
										 <th>Tour Option</th>
                                         <th></th>
                                    </tr>
                                    <tr>
                                        <form id="filterForm" method="get" action="{{route('tourStaticData')}}" >
                                            <th></th>
                                            <th width="10%"><input type="text" name="tourId" value="{{request('tourId')}}" class="form-control"  placeholder="Tour Id" /></th>
                                       
                                        <th></th>
                                        <th></th>
                                        <th width="10%"><input type="text" name="name" value="{{request('name')}}" class="form-control"  placeholder="Name" /></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        
                                        <th></th>
                                        <th width="10%"><select name="isSlot" id="isSlot" class="form-control">
                                            <option value="" @if(request('isSlot') =='') {{'selected="selected"'}} @endif>Select</option>
                                            <option value="1" @if(request('isSlot') ==1) {{'selected="selected"'}} @endif>Yes</option>
                                            <option value="2" @if(request('isSlot') ==2) {{'selected="selected"'}} @endif >No</option>
                                         </select></th>
                                      <th></th>
                                      
                                      
                                      <th></th>
                                         <th></th>
                                         <th width="10%"><select name="tourOption" id="tourOption" class="form-control">
                                            <option value="" @if(request('tourOption') =='') {{'selected="selected"'}} @endif>Select</option>
                                            <option value="1" @if(request('tourOption') ==1) {{'selected="selected"'}} @endif>Yes</option>
                                            <option value="2" @if(request('tourOption') ==2) {{'selected="selected"'}} @endif >No</option>
                                         </select></th>
                                         <th width="15%"><button class="btn btn-info btn-sm" type="submit">Filter</button>
                                        <a class="btn btn-default btn-sm" href="{{route('tourStaticData')}}">Clear</a></th>
                                        
                                      </form>
                                      </tr>
                                </thead>
                                <tbody>
                                    @foreach ($records as $k => $record)
                                        <tr>
                                            <td>{{ $k+1 }}</td>
                                            <td>{{ $record->tourId }}</td>
                                            <td>{{ $record->countryName }}</td>
											
                                            <td>{{ $record->cityName }}</td>
                                            <td>{{ $record->tourName }}</td>
                                            <td>{{ $record->reviewCount }}</td>
                                            <td>{{ $record->rating }}</td>
                                            <td>{{ $record->duration }}</td>
											<td>{{ $record->cityTourTypeId }}</td>
                                            <td>{{ $record->cityTourType }}</td>
                                            <td>{{ $record->isSlot ? 'Yes' : 'No' }}</td>
                                            <td>{{ $record->onlyChild ? 'Yes' : 'No' }}</td>
                                            <td>{{ $record->contractId }}</td>
                                            <td>{{ $record->isPrivate ? 'Yes' : 'No' }}</td>
                                            <td>@if ($record->tourOption)
                                                Yes
                                                @else
                                                No
                                                @endif</td>
											<td>@if ($record->tourOption)
											<a class="btn btn-info btn-sm" href="{{ route('tourOptionStaticData', $record->tourId) }}">
											View
											</a>
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
