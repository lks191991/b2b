@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->


<!-- Main content -->
<section class="content">

<div class="row" style="border-bottom:solid 1px #000;margin-bottom: 10px;">
    <div class="col-md-4" style="margin: 20px 0px;">
        <h4>QID: {{$voucher->code}}</h4>
    </div>
    <div class="col-md-4" style="margin: 20px 0px;">
        <h5>Travel Partner: {{$voucher->agent->company_name}}</h5>
        <h6>Travel Date:  {{ $voucher->travel_from_date ? date("d-M-Y",strtotime($voucher->travel_from_date)) : null }} -   {{ $voucher->travel_to_date ? date("d-M-Y",strtotime($voucher->travel_to_date)) : null }}</h6>
    </div>
    <div class="col-md-4" style="margin: 20px 0px;">
    <a  href="{{route('quotations.edit',$vid)}}" class="btn btn-secondary">Edit</a>
        </div>
</div>
<form action="{{ route('voucher.add.quick.activity.save') }}" method="post" class="form">
{{ csrf_field() }}
<input type="hidden" id="v_id" name="v_id" value="{{$vid}}" >


<h4 style="clear:both;">Quick Add</h4>
<div class="row" style="height:300px; overflow:auto; border-bottom: solid 1px #000;">

@foreach ($activityVariants as $avrecord)
<div class="col-md-4" >

<h6 style="border: solid 1px #000; padding: 10px;border-radius: 10px;">{{ $avrecord->ActivityVariantName }} <button type="button" class="btn btn-sm btn-success" onClick="funAdd('{{ $avrecord->ActivityVariantName }}',{{ $avrecord->id }});">+</button> </h6>
</div>

@endforeach
</div>
<div class="" style="height: 400px;overflow:auto;">





    <table id="example1" class="table rounded-corners">
        <thead>
            <tr>
               
                <th style="width: 130px">Day</th>
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
           @php
                $grant_total = $markup_amt = $markup_per = $per_adult = $per_child = $markup_per = 0;

                $markup_amt = $grant_total = $voucher->total_markup;
                $markup_per = $voucher->total_markup_per;
                $i = 0;
           @endphp
					@if(count($voucherActivity) > 0)
					  @foreach($voucherActivity as $ij => $ap)
                      @php 
                      $per_child_cost = $per_adult_cost = 0;
                      if($ap->adult > 0)
                            $per_adult_cost = round(($ap->adultPrice/$ap->adult+(($ap->original_trans_rate/($ap->adult+$ap->child)))),2);
                        if($ap->child > 0)
                            $per_child_cost = round(($ap->childPrice/$ap->child+(($ap->original_trans_rate/($ap->adult+$ap->child)))),2);

                        $per_adult_cost += round((($per_adult_cost*$markup_per)/100),2);
                        $per_child_cost += round((($per_child_cost*$markup_per)/100),2);

                        $grant_total += $ap->original_trans_rate+$ap->original_tkt_rate;
                        $per_adult += $per_adult_cost;
                        $per_child += $per_child_cost;
                        $i++;
                      @endphp
                      <tr>
                      <td><input type="text" id="tourDay_{{ $i }}" onBlur="funTourDate({{ $i }})" name="serial_no[]"  class="form-control onlynumbrf" required></td>
                <td><input type="text" id="tourDate_{{ $i }}" name="tourDate[]" value="{{$startDate}}" class="form-control" required>
                <input type="hidden" id="tourDateOrg_{{ $i }}" name="tourDateOrg[]" value="{{$startDate}}" class="form-control" required>
            </td>
               
                <td>
                    <input type="text" id="avid_name_{{ $i }}" name="avid_name[]" class="form-control" value="{{$ap->activity_title}}" required placeholder="Activity Variant Name" />
                    <input type="hidden" id="avid_{{ $i }}" name="avid[]" value="{{$ap->activity_varaint_id}}" class="form-control">
                </td>
                <td>
                    <select id="transferOption_{{ $i }}" name="transferOption[]" class="form-control" required>
                        <option value="Ticket Only"  @if($ap->transfer_option =='Ticket Only') {{'selected="selected"'}} @endif>Ticket Only</option>
                        <option value="Shared Transfer"  @if($ap->transfer_option =='Shared Transfer') {{'selected="selected"'}} @endif>Shared Transfer</option>
                        <option value="Pvt Transfer"  @if($ap->transfer_option =='Pvt Transfer') {{'selected="selected"'}} @endif>Pvt Transfer</option>
                    </select>
                </td>
                <td><input type="text" id="adult_{{ $i }}" name="adult[]" value="{{$ap->adult}}" class="form-control" required ></td>
                <td><input type="text" id="child_{{ $i }}" name="child[]" value="{{$ap->child}}" class="form-control" ></td>
                <td><input type="text" id="infant_{{ $i }}" name="infant[]" value="{{$ap->infant}}" class="form-control" ></td>
                <td><input type="text" id="transferCost_{{ $i }}" class="form-control" value="{{$ap->original_trans_rate}}" name="transferCost[]" value="0" required></td>
                <td><input type="text" id="per_aticketCost_{{ $i }}" class="form-control" @if($ap->adult > 0) value="{{$ap->adultPrice/$ap->adult}}" @endif name="per_aticketCost[]" value="0" required></td>
                <td><input type="text" id="per_cticketCost_{{ $i }}" class="form-control" @if($ap->child > 0) value=" {{$ap->childPrice/$ap->child}}" @endif name="per_cticketCost[]" value="0" required>
              <input type="hidden" id="aticketCost_{{ $i }}" class="form-control" value="{{$ap->adultPrice}}" name="aticketCost[]" value="0" required >
                <input type="hidden" id="t_per_aticketCost_${rowCounter}" class="form-control" name="t_per_aticketCost[]" value="{{ $per_adult_cost }}"  readonly>
                <input type="hidden" id="t_per_cticketCost_${rowCounter}" class="form-control" name="t_per_cticketCost[]" value="{{ $per_child_cost }}"  readonly>
            <input type="hidden" id="cticketCost_{{ $i }}" class="form-control" name="cticketCost[]" value="{{$ap->childPrice}}" value="0" required ></td>
            
                <td><input type="text" id="total_{{ $i }}" class="form-control" name="total[]" value="{{$ap->original_trans_rate+$ap->original_tkt_rate}}" value="0" readonly></td>
                <td>
                <button type="button" class="btn btn-sm btn-success addRow">+</button>

                    <button type="button" class="btn btn-sm btn-danger removeRow">-</button>
                </td>
            </tr>


                      @endforeach
                      <input type="hidden" id="row_cont" name="row_cont" value="{{ $i }}" >

                    @else

            @for($i = 1; $i <= 1; $i++)
            <tr>
            <td><input type="text" id="tourDay_{{ $i }}" onBlur="funTourDate({{ $i }})" name="serial_no[]"   class="form-control onlynumbrf" required></td>
                <td><input type="text" id="tourDate_{{ $i }}" name="tourDate[]" value="{{$startDate}}" class="form-control" required>
                <input type="hidden" id="tourDateOrg_{{ $i }}" name="tourDateOrg[]" value="{{$startDate}}" class="form-control" required>
            </td>
               
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
                <td><input type="text" id="adult_{{ $i }}" name="adult[]" value="{{$voucher->adults}}" class="form-control" required ></td>
                <td><input type="text" id="child_{{ $i }}" name="child[]" value="{{$voucher->childs}}" class="form-control" ></td>
                <td><input type="text" id="infant_{{ $i }}" name="infant[]" value="{{$voucher->infants}}" class="form-control" ></td>
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
            <input type="hidden" id="row_cont" name="row_cont" value="1" >

            @endif
           
        </tbody>
    </table>
</div>
<div class="row" style="margin-bottom: 20px;">
<div class="col-8  text-center pr-3">

<div class="row" style="margin-top: 10px;margin-left: 10px;">

    <div class="col-md-4" style="border: solid 1px #000;border-radius: 10px;font-family: inherit;font-weight: 500;line-height: 1.5;font-size: 1.25rem;">Total: 
        <input type="hidden" id="gtTotal" class="form-control" name="gtTotal" value="{{ $grant_total }}"  >

        <input type="hidden" id="markupValue" class="form-control" name="markupValue" value="{{ $markup_amt }}"  >
       AED <span id="grandTotal">{{ $grant_total }}</span><br/>
        Markup: AED <span id="markupgrandTotal">{{ $markup_amt }}</span>
    </div>
        <div class="col-md-1"></div>
        
        <div class="col-md-3 text-center" style="border: solid 1px #000;border-radius: 10px;font-family: inherit;font-weight: 500;font-size: 1.25rem; padding-top: 15px;">
      <span id="per_adult">AED {{ $per_adult }}</span> / Adult</div>
       <div class="col-md-1"></div>
        <div class="col-md-3" style="border: solid 1px #000;border-radius: 10px;font-family: inherit;font-weight: 500;font-size: 1.25rem;padding-top: 15px;"> <span id="per_child">AED {{ $per_child }}</span> / Child</div>
       
        
    </div>
</div>
<div class="col-1 pull-right text-right pr-3">
</div>
  <div class="col-3 pull-right text-right pr-3">
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-4">Markup (in %):</div>
        <div class="col-md-8"><input type="text" id="adult_markup" class="form-control" name="adult_markup" value="{{ $markup_per }}" onkeyUp="funMarkup()" ></div>
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

    function funAdd(avname,avid)
{
    var rowCounter =  document.getElementById('row_cont').value;
    rowCounter++;
    
    var a =  document.getElementById('adult_1').value;
    var c =  document.getElementById('child_1').value;
    var i =  document.getElementById('infant_1').value;

    const newRow = document.createElement('tr');
            newRow.innerHTML = `
             <td><input type="text" id="tourDay_{${rowCounter}" onBlur="funTourDate(${rowCounter})" name="serial_no[]"  class="form-control onlynumbrf" required></td>
                <td><input type="text" id="tourDate_${rowCounter}" name="tourDate[]" value="${startDate}" class="form-control" required>
                                <input type="hidden" id="tourDateOrg_${rowCounter}" name="tourDateOrg[]" value="${startDate}" class="form-control" required>

                </td>
                
                <td>
                    <input type="text" id="avid_name_${rowCounter}" name="avid_name[]" value="`+avname+`" class="form-control" required placeholder="Activity Variant Name" />
                    <input type="hidden" id="avid_${rowCounter}" name="avid[]" value="`+avid+`"  class="form-control">
                </td>
                <td>
                    <select id="transferOption_${rowCounter}" name="transferOption[]" class="form-control" required>
                        <option value="Ticket Only">Ticket Only</option>
                        <option value="Shared Transfer">Shared Transfer</option>
                        <option value="Pvt Transfer">Pvt Transfer</option>
                    </select>
                </td>
                <td><input type="number" id="adult_${rowCounter}" name="adult[]" value="${a}" class="form-control" required></td>
                <td><input type="number" id="child_${rowCounter}" name="child[]" value="${c}" class="form-control" required></td>
                <td><input type="number" id="infant_${rowCounter}" name="infant[]" value="${i}" class="form-control" required></td>
                 <td><input type="number" id="transferCost_${rowCounter}" class="form-control" name="transferCost[]" value="0" required></td>
                <td><input type="number" id="per_aticketCost_${rowCounter}" class="form-control" name="per_aticketCost[]" value="0" required></td>
                <td><input type="number" id="per_cticketCost_${rowCounter}" class="form-control" name="per_cticketCost[]" value="0" required>
                <input type="hidden" id="aticketCost_${rowCounter}" class="form-control" name="aticketCost[]" value="0" required readonly>
                <input type="hidden" id="t_per_aticketCost_${rowCounter}" class="form-control" name="t_per_aticketCost[]" value="0"  readonly>
                <input type="hidden" id="t_per_cticketCost_${rowCounter}" class="form-control" name="t_per_cticketCost[]" value="0"  readonly>
                <input type="hidden" id="cticketCost_${rowCounter}" class="form-control" name="cticketCost[]" value="0" required readonly></td>
                <td><input type="number" id="total_${rowCounter}" class="form-control" name="total[]" value="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-sm btn-success addRow">+</button>
                    <button type="button" class="btn btn-sm btn-danger removeRow">-</button>
                </td>
            `;
            document.getElementById('dynamic-rows').appendChild(newRow);
            initAutocomplete(`#avid_name_${rowCounter}`);

    document.getElementById('row_cont').value = rowCounter;
}
    document.addEventListener('DOMContentLoaded', function() {
   // let rowCounter = 10;

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

        funMarkup();
    }

   

    document.getElementById('dynamic-rows').addEventListener('click', function(event) {
        if (event.target.classList.contains('addRow')) {
            var rowCounter =  document.getElementById('row_cont').value;

            var a =  document.getElementById('adult_1').value;
    var c =  document.getElementById('child_1').value;
    var i =  document.getElementById('infant_1').value;
            rowCounter++;
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
             <td><input type="text" id="tourDay_${rowCounter}" onBlur="funTourDate(${rowCounter})" name="serial_no[]"  class="form-control onlynumbrf" required></td>
                <td><input type="text" id="tourDate_${rowCounter}" name="tourDate[]" value="${startDate}" class="form-control" required>
                <input type="hidden" id="tourDateOrg_${rowCounter}" name="tourDateOrg[]" value="${startDate}" class="form-control" required>
                </td>
                
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
                <td><input type="number" id="adult_${rowCounter}" name="adult[]" value="${a}" class="form-control" required></td>
                <td><input type="number" id="child_${rowCounter}" name="child[]" value="${c}" class="form-control" required></td>
                <td><input type="number" id="infant_${rowCounter}" name="infant[]" value="${i}" class="form-control" required></td>
                 <td><input type="number" id="transferCost_${rowCounter}" class="form-control" name="transferCost[]" value="0" required></td>
                <td><input type="number" id="per_aticketCost_${rowCounter}" class="form-control" name="per_aticketCost[]" value="0" required></td>
                <td><input type="number" id="per_cticketCost_${rowCounter}" class="form-control" name="per_cticketCost[]" value="0" required>
                <input type="hidden" id="aticketCost_${rowCounter}" class="form-control" name="aticketCost[]" value="0" required readonly>
                <input type="hidden" id="t_per_aticketCost_${rowCounter}" class="form-control" name="t_per_aticketCost[]" value="0"  readonly>
                <input type="hidden" id="t_per_cticketCost_${rowCounter}" class="form-control" name="t_per_cticketCost[]" value="0"  readonly>
                <input type="hidden" id="cticketCost_${rowCounter}" class="form-control" name="cticketCost[]" value="0" required readonly></td>
                <td><input type="number" id="total_${rowCounter}" class="form-control" name="total[]" value="0" readonly></td>
                <td>
                    <button type="button" class="btn btn-sm btn-success addRow">+</button>
                    <button type="button" class="btn btn-sm btn-danger removeRow">-</button>
                </td>
            `;
            document.getElementById('dynamic-rows').appendChild(newRow);
            initAutocomplete(`#avid_name_${rowCounter}`);

            document.getElementById('row_cont').value = rowCounter;
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
        document.getElementById('markupValue').value = parseFloat(markup).toFixed(2);
        document.getElementById('grandTotal').innerText =(parseFloat(grandTotal)+parseFloat(markup)).toFixed(2);

        var markupA  = (parseFloat(grandTotalA)*mkup)/100;
        var markupC  = (parseFloat(grandTotalC)*mkup)/100;
        document.getElementById('per_adult').innerText = (parseFloat(grandTotalA)+parseFloat(markupA)).toFixed(2);
        document.getElementById('per_child').innerText = (parseFloat(grandTotalC)+parseFloat(markupC)).toFixed(2);
    }

    function funTourDate(i) 
    {
        var mkupDt = parseInt(document.getElementById('tourDay_' + i).value, 10); // Parse mkupDt as an integer
        var orgDayValue = document.getElementById('tourDateOrg_' + i).value; // Get original date value as string

        if(mkupDt > 0)
    {

// Convert orgDayValue to a Date object
var orgDay = new Date(orgDayValue);

if (isNaN(orgDay) || isNaN(mkupDt)) {
    console.error("Invalid date or markup days");
} else {
    // Add mkupDt days to orgDay
    orgDay.setDate(orgDay.getDate() + (mkupDt-1));

    // Format the updated date to 'yyyy-mm-dd'
    var ntdate = orgDay.toISOString().split('T')[0];

    // Set the updated date value in the input field
    document.getElementById('tourDate_' + i).value = ntdate;
}
    }
    else
    {
        document.getElementById('tourDate_' + i).value = orgDayValue;
    }
  
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
for(var i=1;i<=1;i++)
    {
    initAutocomplete("#avid_name_"+i);
    }
    $(document).on('keypress', '.onlynumbrf', function(evt) {
   var charCode = (evt.which) ? evt.which : evt.keyCode
   if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
     return false;
   return true;
 
 });
</script>
@endsection
