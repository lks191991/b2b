@extends('layouts.appLogin')
@section('content')

    <!-- Start Banner section -->
    <div class="home1-banner-area " style="margin-top:20px">
        <div class="container-fluid">
           
        </div>
    </div>
    @php
        $url = "https://agent.flyremit.com/Abatera/AbateraAgent/Result?AbateraId=".$voucher->agent_id."&AbateraDealId=".$voucher->code."&Amount=".$gtotal."&Currency=INR&TranGUID=".$voucher->code;			
    @endphp
<iframe src="{{ $url }}" width="100%" height="1300px"></iframe>


   
   
    <!-- /.content -->
@endsection
@section('scripts')

<script type="text/javascript">
  
  // ... your existing JavaScript code ...

</script>
@endsection
