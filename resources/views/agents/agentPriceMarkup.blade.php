@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Markup for {{ $agentCompany }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Markup for {{ $agentCompany }}</li>
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
                <h3 class="card-title">Markup</h3>
				<div class="card-tools">
				
				   </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
			  <form id="filterForm" method="post" action="{{route('agents.markup.price.save')}}" >
				   {{ csrf_field() }}
				 <input type="hidden" name="agent_id" value="{{ $agentId}}" />
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Activity Name</th>
					          <th>Price</th>
                  </tr>
                  </thead>
                  <tbody>
				   
                  @foreach ($activities as $record)
				  <input type="hidden" name="activity_id[]" value="{{ $record->id}}" />
                  <tr>
					
                    <td>{{ $record->title}}</td>
					<td>
						<table class="table table-bordered table-striped">
						
						@foreach($variants[$record->id] as $variant)
						@php
						$ticket_only = (isset($markups[$variant['ucode']]))?$markups[$variant['ucode']]['ticket_only']:'';
						$sic_transfer = (isset($markups[$variant['ucode']]))?$markups[$variant['ucode']]['sic_transfer']:'';
						$pvt_transfer = (isset($markups[$variant['ucode']]))?$markups[$variant['ucode']]['pvt_transfer']:'';

            $variant_cost = 0;

						@endphp
						<tr>
						<th>Variant (Code)</th>
						<td>{{ $variant->variant->title}}({{ $variant->ucode}})</td>
						</tr>
						<tr>
						<th>Adult Markup Without VAT</th>
						<td>
						<input type="text"  name="ticket_only[{{ $record->id}}][{{$variant->ucode}}]" value="{{$ticket_only}}" min="0"  class="form-control onlynumbr" required  />
						</td>
						</tr>
						
						<tr>
						<th>Child Markup Without VAT</th>
						<td>
						<input type="text" name="sic_transfer[{{ $record->id}}][{{$variant->ucode}}]" value="{{$sic_transfer}}" min="0"  class="form-control onlynumbr" required />
						
						
						
							 <tr>
							 <th>Infant Markup Without VAT</th>
						<td>
					<input type="text" name="pvt_transfer[{{ $record->id}}][{{$variant->ucode}}]" value="{{$pvt_transfer}}" min="0" class="form-control onlynumbr" required />
						
						
						@endforeach
						</table>
					</td>
                  </tr>
				 
                  @endforeach

                  </tbody>
                 
                </table>
				<button type="submit" class="btn btn-success float-right">Save</button>
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
@endsection

@section('scripts')
 <script type="text/javascript">
$(document).on('keypress', '.onlynumbr', function(evt) {
	var charCode = (evt.which) ? evt.which : evt.keyCode
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
  {
    return false;
  }
  else
  {
	return true;
	
  }
  

});
$(document).on('blur', '.onlynumbr', function(evt) {
	/* if(this.value > 100){
       alert('You have entered more than 100 as input');
	   this.value = 0;
       return false;
    } */

});
</script>   
  
@endsection
