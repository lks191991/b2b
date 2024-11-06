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

<div class="">
    <table id="example1" class="table rounded-corners">
        <thead>
            <tr>
                <th>Tour Date</th>
                <th>Activity Variant</th>
                <th>Transfer Option</th>
                <th>Adult</th>
                <th>Child</th>
                <th>Infant</th>
                <th>Total Transfer Cost</th>
                <th>Per Adult TC</th>
                <th>Per Child TC</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="dynamic-rows">
            @for($i = 1; $i <= 10; $i++)
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
                <td><input type="text" id="per_cticketCost_{{ $i }}" class="form-control" name="per_cticketCost[]" value="0" required></td>
                <td style="display: none;"><input type="hidden" id="aticketCost_{{ $i }}" class="form-control" name="aticketCost[]" value="0" required ></td>
                <td style="display: none;"><input type="hidden" id="cticketCost_{{ $i }}" class="form-control" name="cticketCost[]" value="0" required ></td>
            
                <td><input type="text" id="total_{{ $i }}" class="form-control" name="total[]" value="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-success addRow">+</button>
                    <button type="button" class="btn btn-danger removeRow">-</button>
                </td>
            </tr>
            @endfor
        </tbody>
    </table>
</div>

<div class="row">
  <div class="col-6 pull-right text-right pr-3">
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-4">Adult Markup:</div>
        <div class="col-md-8"><input type="text" id="adult_markup" class="form-control" name="adult_markup" value="0" readonly></div>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-4">Child Markup:</div>
        <div class="col-md-8"><input type="text" id="child_markup" class="form-control" name="child_markup" value="0" readonly></div>
    </div>
    
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-4"><h5>Grand Total:</h5></div>
        <div class="col-md-8"><h5><span id="grandTotal">0.00</span></h5></div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('vouchers.index') }}" class="btn btn-secondary">Cancel</a>
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

        // Update the respective total cost fields in the row
        row.querySelector('[name="aticketCost[]"]').value = totalAdultTC.toFixed(2);
        row.querySelector('[name="cticketCost[]"]').value = totalChildTC.toFixed(2);

        // Calculate overall total for this row
        const rowTotal = totalAdultTC + totalChildTC + transferCost;

        // Update the total field for the row
        row.querySelector('[name="total[]"]').value = rowTotal.toFixed(2);
        
        // Update grand total
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('[name="total[]"]').forEach(input => {
            grandTotal += parseFloat(input.value) || 0;
        });
        document.getElementById('grandTotal').innerText = grandTotal.toFixed(2);
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
                <td><input type="number" id="per_cticketCost_${rowCounter}" class="form-control" name="per_cticketCost[]" value="0" required></td>
                <td style="display: none;"><input type="hidden" id="aticketCost_${rowCounter}" class="form-control" name="aticketCost[]" value="0" required readonly></td>
                <td style="display: none;"><input type="hidden" id="cticketCost_${rowCounter}" class="form-control" name="cticketCost[]" value="0" required readonly></td>
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
    initAutocomplete("#avid_name_1");


</script>
@endsection
