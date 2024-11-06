@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Agents</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Agents</li>
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
                <h3 class="card-title">Agents</h3>
				<div class="card-tools">
				 <a href="{{ route('agents.create') }}" class="btn btn-sm btn-info">
                      <i class="fas fa-plus"></i>
                      Create
                  </a> 
				   </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="" class="table table-bordered table-striped example3">
                  <thead>
                  <tr>
					<th>SN.</th>
					<th>Code</th>
					<th>Company</th>
                  
                    
                    <th>City</th>
                    <th>Status</th>
					<th>Ledger Balance</th>
					
					<th>Password</th>
                    <th>Created</th>
                    
					<th>Updated</th>
					<th>Currency</th>
					
					
					<th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
					<th width="17%">Flyremit</th>
          <th width="17%">Doc Name</th>
					<th>Doc</th>
					<th width="17%"></th>
                  </tr>
				  <!-- <tr style="display:none">
                    <form id="filterForm" method="get" action="{{route('agents.index')}}" >
					<th><input type="text" name="code" value="{{request('code')}}" class="form-control"  placeholder="Code" /></th>
                    <th><input type="text" name="name" value="{{request('name')}}" class="form-control"  placeholder="Name" /></th>
                   <th><input type="text" name="mobile" value="{{request('mobile')}}" class="form-control"  placeholder="Mobile" /></th>
                   <th><input type="text" name="email" value="{{request('email')}}" class="form-control"  placeholder="Email" /></th>
                   <th><input type="text" name="cname" value="{{request('cname')}}" class="form-control"  placeholder="Company Name" /></th>
                  
                 <th><select name="city_id" id="city_id" class="form-control">
				<option value="">--select--</option>
				@foreach($cities as $city)
                    <option value="{{$city->id}}" @if(request('city_id') == $city->id) {{'selected="selected"'}} @endif>{{$city->name}}</option>
				@endforeach
                 </select></th>
                
					 <th><select name="status" id="status" class="form-control">
                    <option value="" @if(request('status') =='') {{'selected="selected"'}} @endif>Select</option>
                    <option value="1" @if(request('status') ==1) {{'selected="selected"'}} @endif>Active</option>
					          <option value="2" @if(request('status') ==2) {{'selected="selected"'}} @endif >Inactive</option>
                 </select></th>
				 <th></th>
					<th></th>
                    <th></th>
					
                  <th></th>
                    <th><button class="btn btn-info btn-sm" type="submit">Filter</button>
                    <a class="btn btn-default btn-sm" href="{{route('agents.index')}}">Clear</a></th>
                    
                  </form>
                  </tr> -->
                  </thead>
                  <tbody>
                  @foreach ($records as $k => $record)
				  
                  <tr>
					<td>{{ $k+1}}</td>
                    <td><a class="badge bg-success" href="{{route('agents.show',$record->id)}}">{{ $record->code}}</a></td>
					<td>{{ $record->company_name}}</td>
                   
                    
                    <td>{{ ($record->city)?$record->city->name:''}}</td>
                     <td>{!! SiteHelpers::statusColor($record->is_active) !!}</td>
					  <td>AED {{ number_format($record->agent_amount_balance,2)}}</td> 
					  
					  
					  <td>
					  
                          <form id="resetpsw-form-{{$record->id}}" method="post" action="{{route('passwordResetAdmin',$record->id)}}" style="display:none;">
                                {{csrf_field()}}
                               <input type="hidden" name="user" value="agent">
                            </form>
                            <a class="badge bg-warning" href="javascript:void(0)" onclick="
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
                    <td>{{ $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null }}</td>
                    <td>{{ $record->updated_at ? date(config('app.date_format'),strtotime($record->updated_at)) : null }}</td>
					<td>{{ ($record->currency)?$record->currency->name:''}}</td>
                     
 
<td>{{ $record->name}}</td>
                    <td>{{ $record->mobile}}</td>
					<td>{{ $record->email}}</td>
          <td>
					  
					   @if($record->country_id == 94)
             Flyremit Status : {!! SiteHelpers::statusColor($record->flyremit_reg) !!} : {{$record->flyremit_response}}
					   @endif
					  
						  </td>
					<td>
					  
					   @if($record->country_id == 1)
						   Trade License No : {{$record->trade_license_no}}</br> TRN No: {{$record->trn_no}}
					   @elseif($record->country_id == 94)
						   Pan Card No : {{$record->pan_no}}
					   @endif
					  
						  </td>
						  
					<td>
					   @php
					   $filename = '';
					   if($record->country_id == 1){
						   $filename =$record->trade_license_no_file;
						 $path = asset('uploads/users/'.$filename);  
					   } else if($record->country_id == 94){
						   $filename =$record->pan_no_file;
						 $path = asset('uploads/users/'.$filename);   
					   }
					   @endphp
					   @if(!empty($filename))
						<a class="btn btn-info btn-sm" href="{{ $path }}">
						<i class="fas fa-eye"></i>
						</a>
						@endif
						
						  </td>
					<td  style="padding:0px">
					  <a class="btn btn-info btn-sm"  href="{{route('agents.markup.activity',$record->id)}}">
            <i class="fas fa-file-alt">
            </i>
                               
                          </a>
					  
					 <a class="btn btn-info btn-sm" href="{{route('agents.edit',$record->id)}}">
                              <i class="fas fa-pencil-alt">
                              </i>
                              
                          </a>
                          <form id="delete-form-{{$record->id}}" method="post" action="{{route('agents.destroy',$record->id)}}" style="display:none;">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                            </form>
                            <a class="btn btn-danger btn-sm hide" href="javascript:void(0)" onclick="
                                if(confirm('Are you sure, You want to delete this?'))
                                {
                                    event.preventDefault();
                                    document.getElementById('delete-form-{{$record->id}}').submit();
                                }
                                else
                                {
                                    event.preventDefault();
                                }
                            
                            "><i class="fas fa-trash"></i></a></td>
                  </tr>
				 
                  @endforeach
                  </tbody>
                 
                </table>
				
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

@section('scripts')
<script>
 $(document).ready(function () {
  $('.example3').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "ordering": true, // Enable sorting
    "info": true,
    "autoWidth": false,
    "responsive": true,
    "bFilter": true, // Show search input
    "columnDefs": [
      {
        "targets": [12], // Column index (0-indexed) for which to customize sorting and width
        "orderable": false, // Set to false to disable sorting for this column
      },
      // You can add more objects to customize sorting and width for other columns
    ],
  });
});

	</script>
 @include('inc.citystatecountryjs')
@endsection
