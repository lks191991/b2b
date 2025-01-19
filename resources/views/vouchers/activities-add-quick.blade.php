@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Activities Add</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Vouchers</a></li>
          <li class="breadcrumb-item active">Activities Add</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- Main content -->
<section class="content">
<form action="{{ route('voucher.add.quick.activity.save') }}" method="post" class="form">
{{ csrf_field() }}
<input type="hidden" id="v_id" name="v_id" value="{{$vid}}" >

<div class="" style="height: 400px;overflow:auto;">
    <table id="example1" class="table rounded-corners">
        <thead>
            <tr>
                <th style="width: 130px">Tour Date</th>
                <th>Activity Variant</th>
                <th  style="width: 150px">Transfer Option</th>
                <th style="width: 80px">Adult</th>
                <th  style="width: 80px">Child</th>
                <th  style="width: 80px">Infant</th>
                <th  style="width: 80px">Total Transfer Cost</th>
                <th  style="width: 80px">Per Adult TC</th>
                <th  style="width: 80px">Per Child TC</th>
                <th  style="width: 150px">Total</th>
                <th  style="width: 80px">Action</th>
            </tr>
        </thead>
        <tbody id="dynamic-rows">
            @for($i = 1; $i <= 1; $i++)
            <tr>
                <td><input type="text" id="tourDate_{{ $i }}" name="tourDate[]" value="{{$startDate}}" class="form-control" required></td>
                <td>
                    <input type="text" id="avid_name_{{ $i }}" name="avid_name[]" class="form-control" required placeholder="Activity Variant Name" />
                    <input type="hidden" id="avid_{{ $i }}" name="avid[]" value="" class="form-control">
                </td>
                <td>
                    <select id="transferOption_{{ $i }}" name="transferOption[]" class="form-control" required>
                        <option value="Ticket Only">Ticket Only</option>
                        <option value="Shared Transfer">Shared Transfer</option>
                        <option value="Pvt Transfer">Pvt Transfer</option>
                    </select>
                </td>
                <td><input type="text" id="adult_{{ $i }}" name="adult[]" value="1" class="form-control" required></td>
                <td><input type="text" id="child_{{ $i }}" name="child[]" value="0" class="form-control" required></td>
                <td><input type="text" id="infant_{{ $i }}" name="infant[]" value="0" class="form-control" required></td>
                <td><input type="text" id="transferCost_{{ $i }}" class="form-control" name="transferCost[]" value="0" required></td>
                <td><input type="text" id="per_aticketCost_{{ $i }}" class="form-control" name="per_aticketCost[]" value="0" required></td>
                <td><input type="text" id="per_cticketCost_{{ $i }}" class="form-control" name="per_cticketCost[]" value="0" required>
              <input type="hidden" id="aticketCost_{{ $i }}" class="form-control" name="aticketCost[]" value="0" required >
                <input type="hidden" id="t_per_aticketCost_${rowCounter}" class="form-control" name="t_per_aticketCost[]" value="0"  readonly>
                <input type="hidden" id="t_per_cticketCost_${rowCounter}" class="form-control" name="t_per_cticketCost[]" value="0"  readonly>
            <input type="hidden" id="cticketCost_{{ $i }}" class="form-control" name="cticketCost[]" value="0" required ></td>
            
                <td><input type="text" id="total_{{ $i }}" class="form-control" name="total[]" value="0" readonly></td>
                <td>
                <button type="button" class="btn btn-sm btn-success addRow">+</button>

                    <button type="button" class="btn btn-sm btn-danger removeRow">-</button>
                </td>
            </tr>
            @endfor
            @for($i = 2; $i <= 10; $i++)
            <tr>
                <td><input type="text" id="tourDate_{{ $i }}" name="tourDate[]" value="{{$startDate}}" class="form-control" ></td>
                <td>
                    <input type="text" id="avid_name_{{ $i }}" name="avid_name[]" class="form-control"  placeholder="Activity Variant Name" />
                    <input type="hidden" id="avid_{{ $i }}" name="avid[]" value="" class="form-control">
                </td>
                <td>
                    <select id="transferOption_{{ $i }}" name="transferOption[]" class="form-control" >
                        <option value="Ticket Only">Ticket Only</option>
                        <option value="Shared Transfer">Shared Transfer</option>
                        <option value="Pvt Transfer">Pvt Transfer</option>
                    </select>
                </td>
                <td><input type="text" id="adult_{{ $i }}" name="adult[]" value="1" class="form-control" ></td>
                <td><input type="text" id="child_{{ $i }}" name="child[]" value="0" class="form-control" ></td>
                <td><input type="text" id="infant_{{ $i }}" name="infant[]" value="0" class="form-control" ></td>
                <td><input type="text" id="transferCost_{{ $i }}" class="form-control" name="transferCost[]" value="0" ></td>
                <td><input type="text" id="per_aticketCost_{{ $i }}" class="form-control" name="per_aticketCost[]" value="0" ></td>
                <td><input type="text" id="per_cticketCost_{{ $i }}" class="form-control" name="per_cticketCost[]" value="0" >
              <input type="hidden" id="aticketCost_{{ $i }}" class="form-control" name="aticketCost[]" value="0"  >
                <input type="hidden" id="t_per_aticketCost_${rowCounter}" class="form-control" name="t_per_aticketCost[]" value="0"  readonly>
                <input type="hidden" id="t_per_cticketCost_${rowCounter}" class="form-control" name="t_per_cticketCost[]" value="0"  readonly>
            <input type="hidden" id="cticketCost_{{ $i }}" class="form-control" name="cticketCost[]" value="0"  ></td>
            
                <td><input type="text" id="total_{{ $i }}" class="form-control" name="total[]" value="0" readonly></td>
                <td>
                <button type="button" class="btn btn-sm btn-success addRow">+</button>

                    <button type="button" class="btn btn-sm btn-danger removeRow">-</button>
                </td>
            </tr>
            @endfor
        </tbody>
    </table>
</div>
<div class="row">
  <div class="col-6 pull-right text-right pr-3">
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-4">Markup:</div>
        <div class="col-md-8"><input type="text" id="adult_markup" class="form-control" name="adult_markup" value="0" onkeyUp="funMarkup()" ></div>
    </div>
    <div class="row d-none" style="margin-top: 10px;">
        <div class="col-md-4">Child Markup:</div>
        <div class="col-md-8"><input type="text" id="child_markup" class="form-control" name="child_markup" value="0" readonly></div>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-4"><h5>Total Markup:</h5></div>
        <div class="col-md-8"><h5><span id="markupgrandTotal">0.00</span></h5></div>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-4"><h5>Grand Total:</h5></div>
        <input type="hidden" id="gtTotal" class="form-control" name="gtTotal" value="0"  >
        <div class="col-md-8"><h5><span id="grandTotal">0.00</span></h5></div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-md-4">Per Adult Cost:</div>
        <div class="col-md-8"><h5><span id="per_adult">0.00</span></h5></div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-md-4">Per Child Cost:</div>
        <div class="col-md-8"><h5><span id="per_child">0.00</span></h5></div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('quotations.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" name="save_and_view" class="btn btn-success float-right">Save</button>
    </div>
</div>

</form>

</section>
@endsection

@section('scripts')
   <script>
    const startDate = @json($startDate);
    document.addEventListener('DOMContentLoaded', function() {
    let rowCounter = 10;

    function calculateRowTotal(row) {
        // Get values from the row
        const adultCount = parseFloat(row.querySelector('[name="adult[]"]').value) || 0;
        const childCount = parseFloat(row.querySelector('[name="child[]"]').value) || 0;
        const perAdultTC = parseFloat(row.querySelector('[name="per_aticketCost[]"]').value) || 0;
        const perChildTC = parseFloat(row.querySelector('[name="per_cticketCost[]"]').value) || 0;
        const transferCost = parseFloat(row.querySelector('[name="transferCost[]"]').value) || 0;
        // Calculate Total Adult TC and Total Child TC
        const totalAdultTC = adultCount * perAdultTC;
        const totalChildTC = childCount * perChildTC;

        var perTrans = parseFloat(transferCost)/(parseInt(adultCount)+parseInt(childCount))

        // Update the respective total cost fields in the row
        row.querySelector('[name="aticketCost[]"]').value = totalAdultTC.toFixed(2);
        row.querySelector('[name="cticketCost[]"]').value = totalChildTC.toFixed(2);


        row.querySelector('[name="t_per_aticketCost[]"]').value = (parseFloat((parseFloat(totalAdultTC))/parseInt(adultCount))+parseFloat(perTrans)).toFixed(2);
        row.querySelector('[name="t_per_cticketCost[]"]').value = 0;
        if(childCount > 0)
            row.querySelector('[name="t_per_cticketCost[]"]').value = (parseFloat((parseFloat(perChildTC))/parseInt(childCount))+parseFloat(perTrans)).toFixed(2);
        

        // Calculate overall total for this row
        const rowTotal = totalAdultTC + totalChildTC + transferCost;

        // Update the total field for the row
        row.querySelector('[name="total[]"]').value = rowTotal.toFixed(2);
        
        // Update grand total
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let grandTotal = grandTotalA = grandTotalC = 0;
        document.querySelectorAll('[name="total[]"]').forEach(input => {
            grandTotal += parseFloat(input.value) || 0;
        });

        document.querySelectorAll('[name="t_per_cticketCost[]"]').forEach(input => {
            grandTotalC += parseFloat(input.value) || 0;
        });
        document.querySelectorAll('[name="t_per_aticketCost[]"]').forEach(input => {
            grandTotalA += parseFloat(input.value) || 0;
        });
        document.getElementById('gtTotal').value = grandTotal.toFixed(2);

        document.getElementById('grandTotal').innerText = grandTotal.toFixed(2);
        document.getElementById('per_child').innerText = 0;
        document.getElementById('per_adult').innerText = grandTotalA.toFixed(2);
        document.getElementById('per_child').innerText = grandTotalC.toFixed(2);
    }

   

    document.getElementById('dynamic-rows').addEventListener('click', function(event) {
        if (event.target.classList.contains('addRow')) {
            rowCounter++;
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" id="tourDate_${rowCounter}" name="tourDate[]" value="${startDate}" class="form-control" required></td>
                <td>
                    <input type="text" id="avid_name_${rowCounter}" name="avid_name[]" class="form-control" required placeholder="Activity Variant Name" />
                    <input type="hidden" id="avid_${rowCounter}" name="avid[]" value="" class="form-control">
                </td>
                <td>
                    <select id="transferOption_${rowCounter}" name="transferOption[]" class="form-control" required>
                        <option value="Ticket Only">Ticket Only</option>
                        <option value="Shared Transfer">Shared Transfer</option>
                        <option value="Pvt Transfer">Pvt Transfer</option>
                    </select>
                </td>
                <td><input type="number" id="adult_${rowCounter}" name="adult[]" value="1" class="form-control" required></td>
                <td><input type="number" id="child_${rowCounter}" name="child[]" value="0" class="form-control" required></td>
                <td><input type="number" id="infant_${rowCounter}" name="infant[]" value="0" class="form-control" required></td>
                 <td><input type="number" id="transferCost_${rowCounter}" class="form-control" name="transferCost[]" value="0" required></td>
                <td><input type="number" id="per_aticketCost_${rowCounter}" class="form-control" name="per_aticketCost[]" value="0" required></td>
                <td><input type="number" id="per_cticketCost_${rowCounter}" class="form-control" name="per_cticketCost[]" value="0" required>
                <input type="hidden" id="aticketCost_${rowCounter}" class="form-control" name="aticketCost[]" value="0" required readonly>
                <input type="hidden" id="t_per_aticketCost_${rowCounter}" class="form-control" name="t_per_aticketCost[]" value="0"  readonly>
                <input type="hidden" id="t_per_cticketCost_${rowCounter}" class="form-control" name="t_per_cticketCost[]" value="0"  readonly>
                <input type="hidden" id="cticketCost_${rowCounter}" class="form-control" name="cticketCost[]" value="0" required readonly></td>
                <td><input type="number" id="total_${rowCounter}" class="form-control" name="total[]" value="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success addRow">+</button>
                    <button type="button" class="btn btn-danger removeRow">-</button>
                </td>
            `;
            document.getElementById('dynamic-rows').appendChild(newRow);
            initAutocomplete(`#avid_name_${rowCounter}`);
        } else if (event.target.classList.contains('removeRow')) {
            if (document.querySelectorAll('#dynamic-rows tr').length > 1) {
                event.target.closest('tr').remove();
                calculateGrandTotal();
            }
        }
    });

    document.getElementById('dynamic-rows').addEventListener('input', function(event) {
        if (event.target.matches('[name="adult[]"], [name="child[]"], [name="per_aticketCost[]"], [name="per_cticketCost[]"], [name="transferCost[]"]')) {
            calculateRowTotal(event.target.closest('tr'));
        }
    });
});

function funMarkup() 
    {
        var mkup = document.getElementById('adult_markup').value;
        let grandTotal = grandTotalA = grandTotalC = 0;
        document.querySelectorAll('[name="total[]"]').forEach(input => {
            grandTotal += parseFloat(input.value) || 0;
        });

        document.querySelectorAll('[name="t_per_cticketCost[]"]').forEach(input => {
            grandTotalC += parseFloat(input.value) || 0;
        });
        document.querySelectorAll('[name="t_per_aticketCost[]"]').forEach(input => {
            grandTotalA += parseFloat(input.value) || 0;
        });
        var markup  = (parseFloat(grandTotal)*mkup)/100;
        document.getElementById('gtTotal').value = (parseFloat(grandTotal)+parseFloat(markup)).toFixed(2);
        document.getElementById('markupgrandTotal').innerText =markup.toFixed(2);
        document.getElementById('grandTotal').innerText =(parseFloat(grandTotal)+parseFloat(markup)).toFixed(2);

        var markupA  = (parseFloat(grandTotalA)*mkup)/100;
        var markupC  = (parseFloat(grandTotalC)*mkup)/100;
        document.getElementById('per_adult').innerText = (parseFloat(grandTotalA)+parseFloat(markupA)).toFixed(2);
        document.getElementById('per_child').innerText = (parseFloat(grandTotalC)+parseFloat(markupC)).toFixed(2);
    }

    function initAutocomplete(selector) {
        let path = "{{ route('auto.activityvariantname') }}";

        $(selector).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            select: function (event, ui) {
                $(selector).val(ui.item.label);
                $(selector).closest('tr').find('input[type=hidden]').val(ui.item.value);
                return false;
            },
            change: function (event, ui) {
                if (ui.item == null) {
                    $(selector).val('');
                    $(selector).closest('tr').find('input[type=hidden]').val('');
                }
            }
        });
    }

    // Initialize autocomplete for the first row
//    initAutocomplete("#avid_name_1");
for(var i=1;i<=10;i++)
    {
    initAutocomplete("#avid_name_"+i);
    }

</script>
@endsection
