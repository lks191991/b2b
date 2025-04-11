@extends('layouts.app')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Cancellation Chart - {{ $variant->title }} ({{ $variant->ucode }})</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('variants.index') }}">Variants</a></li>
          <li class="breadcrumb-item active">Cancellation Chart</li>
        </ol>
      </div>
    </div>
  </div>
</section>

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
                  <th colspan="3"><h4 class="text-center">Variant : {{ $variant->title }}</h4></th>
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

                @php
                  $recordsByDuration = collect($records)->keyBy('duration');
                @endphp

                @foreach($durationSet as $i => $duration)
                  @php
                    $record = $recordsByDuration->get($duration);
                    $ticket = $record->ticket_refund_value ?? 0;
                    $transfer = $record->transfer_refund_value ?? 0;
                  @endphp

                  <tr>
                    <td>
                      {{ $duration }}
                      <input type="hidden" name="duration[]" value="{{ $duration }}" class="form-control" />
                    </td>
                    <td>
                      <input type="number" max="100" step="any" tabindex="1{{ $i }}" name="ticket_refund_value[]" value="{{ $ticket }}" id="tkt_{{ $i }}" onChange="fun_get_value({{ $i }}, '1');" class="form-control onlynumbr" placeholder="Ticket (Refund Value) %" required />
                    </td>
                    <td>
                      <input type="number" max="100" step="any" tabindex="2{{ $i }}" name="transfer_refund_value[]" value="{{ $transfer }}" id="trf_{{ $i }}" onChange="fun_get_value({{ $i }}, '2');" class="form-control onlynumbr" placeholder="Transfer (Refund Value) %" required />
                    </td>
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
@endsection

@section('scripts')
<script>
  let previousValues = {};

  $(document).on('focus', '.onlynumbr', function () {
    previousValues[this.id] = this.value;
  });

  function fun_get_value(id, ty) {
    if (ty === '1') {
      let tkt_price = parseFloat($("#tkt_" + id).val());
      if (tkt_price > 100) {
        alert('You have entered more than 100 as input');
        $("#tkt_" + id).val(previousValues["tkt_" + id]);
        return;
      }
    } else if (ty === '2') {
      let trf_price = parseFloat($("#trf_" + id).val());
      if (trf_price > 100) {
        alert('You have entered more than 100 as input');
        $("#trf_" + id).val(previousValues["trf_" + id]);
        return;
      }
    }
  }

  $(document).on('keypress', '.onlynumbr', function (evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) return false;
    return true;
  });

  $(document).on('blur', '.onlynumbr', function () {
    let val = parseFloat(this.value);
    if (val > 100) {
      alert('You have entered more than 100 as input');
      this.value = previousValues[this.id] ?? '';
    }
  });
</script>

@endsection
