@extends('layouts.app')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cancellation Chart -  {{ $variant->title }} ({{ $variant->ucode }})</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('variants.index') }}">Variants</a></li>
              <li class="breadcrumb-item active">Cancellation Chart</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('variant.canellation.save') }}" method="post" class="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Cancellation Chart</h3>
                        </div>
                        <div class="card-body row">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
								 <tr>
            <th colspan="4"><h4 class="text-center">Variant : {{$variant->title}}</h4></th>
        </tr>
                                    <tr>
                                        <th>Duration (Hours)</th>
                                        <th>Ticket (Refund Value) %</th>
                                        <th>Transfer (Refund Value) %</th>
                                    </tr>
                                </thead>
                                <tbody>
								
								<input type="hidden" name="varidid" value="{{ $varidid }}" />
								<input type="hidden" name="varidCode" value="{{ $variant->ucode }}" />
                                        @for($i=0; $i<4; $i++)
											@php
										$duration = ["0-24", "24-48", "48-72", "72+"];
											if(isset($records[$i])){
												$records[$i] = [
												'duration'=> $records[$i]->duration,
												'ticket_refund_value'=> $records[$i]->ticket_refund_value,
												'transfer_refund_value'=> $records[$i]->transfer_refund_value,
												];
											} else 
                                            {
                                                if($i == '0')
                                                {
                                                    $records[$i] = 
                                                    [
                                                        'duration'=> $duration[$i],
                                                        'ticket_refund_value'=> '0',
                                                        'transfer_refund_value'=> '0',
                                                    ];
                                                }
                                                else
                                                {
                                                    $records[$i] = [
                                                        'duration'=> $duration[$i],
                                                        'ticket_refund_value'=> '',
                                                        'transfer_refund_value'=>'',
                                                    ];
                                                }
                                                
											}
											
											
											@endphp
										@endfor
										@foreach($records as $i => $record)
										<tr>
											<td>
												{{$record['duration']}}
												<input type="hidden" name="duration[]"  value="{{$record['duration']}}" class="form-control "  />
												
											</td>
											<td><input type="number" maxlength="3" tabindex="1{{$i}}" name="ticket_refund_value[]"  value="{{$record['ticket_refund_value']}}" id="tkt_{{$i}}" onChange="fun_get_value({{$i}},'1');" class="form-control onlynumbr" placeholder="Ticket (Refund Value) %" required /></td>
											<td><input type="number"  maxlength="3" tabindex="2{{$i}}" name="transfer_refund_value[]"  onChange="fun_get_value({{$i}},'2');"  value="{{$record['transfer_refund_value']}}"  id="trf_{{$i}}" class="form-control onlynumbr" placeholder="Transfer (Refund Value) %" required /></td>
											
											
										</tr>
									@endforeach

                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 mb-3">
                    <a href="{{ route('variants.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" name="save" class="btn btn-primary float-right">Save</button>
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection
@section('scripts')
    <!-- Script -->
    <script>
      document.addEventListener("DOMContentLoaded", function () {
    // Function to add a new row
    function addRow() {
        var tableBody = document.querySelector("#example1 tbody");
        // Check if the number of existing rows is less than 3 before inserting a new row
        if (tableBody.rows.length < 4) {
            var newRow = tableBody.insertRow(tableBody.rows.length);

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);

            cell1.innerHTML = '<select name="duration[]" class="form-control" required><option value="0-24" selected>0-24</option><option value="24-48">24-48</option><option value="48-72">48-72</option><option value="72+">72+</option></select>';
            cell2.innerHTML = '<input type="text" name="ticket_refund_value[]" value="" class="form-control" placeholder="Ticket (Refund Value)" required />';
            cell3.innerHTML = '<input type="text" name="transfer_refund_value[]" value="" class="form-control" placeholder="Transfer (Refund Value)" required />';
            cell4.innerHTML = '<button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>';

            // Add event listener for remove button
            cell4.querySelector(".remove-row").addEventListener("click", function () {
                tableBody.deleteRow(newRow.rowIndex);
            });
        }
    }

    // Add event listener for "Add More" button
    document.querySelector(".add-more-row").addEventListener("click", addRow);

    // Event delegation for remove buttons
    document.querySelector("#example1 tbody").addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-row")) {
            var rowToRemove = event.target.closest("tr");
            rowToRemove.remove();
        }
    });
});

    </script>
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
	if(this.value > 100){
       alert('You have entered more than 100 as input');
	   this.value = 0;
       return false;
    }

});
function fun_get_value(id,ty)
{
    if(ty == '1')
    {
        var tkt_price = parseInt($("body #tkt_" + id).val());
        if(tkt_price > 100)
            tkt_price = 100;
        for(var ik=id;ik<=4;ik++)
        {
            $("body #tkt_"+ik).val(tkt_price);
        }
        
    }
    else if(ty == '2')
    {
        var trf_price = parseInt($("body #trf_" + id).val());
        if(trf_price > 100)
            trf_price = 100;
        for(var ik=id;ik<=4;ik++)
        {
            $("body #trf_"+ik).val(trf_price);
        }
        
    }
    
}
</script>
@endsection
