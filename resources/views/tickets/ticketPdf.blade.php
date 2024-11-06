<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="initial-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="format-detection" content="telephone=no"/>
<title>Ticket</title>

<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700&subset=latin,cyrillic,greek" rel="stylesheet" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
body
{
  font-size: 10pt;
}
body p
{
  font-size: 8pt;
}
.col-6 {
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
}


h1 {
  font-size: 1.1em;
  margin: 0rem;
  span {
    font-weight: normal;
  }
}

.title, .name, .seat, .time {
  text-transform: uppercase;
  font-weight: normal;
 
  h2 {
    font-size: .9em;
    color: #525252;
    margin: 0;
    color: #000;
   }
  span {
    margin-top: 5px;
    font-size: 10px;
    color: #000;
  }
}

.title {
  
  margin: 0 0 0 0;
}

.name{
  margin: 10px 0 0 0;
  width: 100%;
  display: block;
}
.seat {
  margin: 10px 0 0 0;
}

.time {
  margin: 10px 0 0 1em;
}

.seat, .time {
  float: left;
}
.eye {
  position: relative;
  width: 2em;
  height: 1.5em;
  background: #fff;
  margin: 0 auto;
  border-radius: 1em/0.6em;
  z-index: 1;
}
.eye:before, .eye:after {
    content:"";
    display: block;
    position: absolute;
    border-radius: 50%;
  }
.eye:before {
    width: 1em;
    height: 1em;
    background: #E84C3D;
    z-index: 2;
    left: 6px;
    top: 4px;
  }
.eye:after {
  width: .5em;
  height: .5em;
  background: #fff;
  z-index: 3;
  left: 9px;
  top: 7px;
  }
  .cardRight:before
  {
    top: -0.4em;
  }
  .cardRight:before {
    content: "";
    position: relative;
    display: block;
    width: 15px;
    height: 13px;
    background: #fff;
    border-radius: 50%;
    left: -14px;
    top: -25px;
}

.cardLeft:before {
    content: "";
    position: relative;
    display: block;
    width: 15px;
    height: 13px;
    background: #fff;
    border-radius: 50%;
    right: 14px;
    top: 10px;
    float: left;
}

</style>
</head>
  <body  style=" width:100%; height:100%;">
  @foreach($tickets as $ticket)
  <div style = "display:block; clear:both; page-break-after:always;"></div>
  <div class="width:100%; padding: 10px 0px;">
            <div style="width: 35%;float: left;">
                @if(file_exists(public_path('uploads/variants/'.$ticket->variant->brand_logo)) && !empty($ticket->variant->brand_logo))
                  <img src="{{asset('uploads/variants/thumb/'.$ticket->variant->brand_logo)}}" style="max-height: 150px;max-width: 150px; display: block !important; height: auto; width: auto;" alt="logo-top" border="0" hspace="0" vspace="0" height="auto">
                  @else
                  {{-- Code to show a placeholder or alternate image --}}
                  <img src="{{ asset('uploads/variants/thumb/no-image.png') }}" style="max-width: 200px;width: 200px;height: 150px" alt="no-image">
                  @endif
            </div>
            <div style="width: 55%;float: right;margin-top: 15px;;padding:15px 10px 0px 10px;text-align: right;">
               <h3 style="margin:0px;">This is your E-Ticket.</h3>
               <p>This ticket is non refundable , non transferable and Void if altered.</p>
            </div>
             
          </div>
          <div style="clear:both; width: 100%;height: 10px;border-bottom: 2px #000 solid;">&nbsp;</div>
      <div style="width: 100%;margin-top: 10px;">
          
          <div style="width:100%; padding: 10px 0px;">
<table class="table table-borderless" cellspacing="0px" cellpadding="5px" style="width:98%;border:none;" border="0px" >
  <tr>
    <td style="background: #E84C3D;color:#fff;border-radius: 10px 0px 0px 0px;border:none;" colspan="2"><h1 style="font-size: 18px;margin: 10px 5px;">{{ $voucherActivity->variant_name }}</h1></td>
    <td  style="background: #E84C3D;border-radius: 0px 10px 0px 0px;width: 20%;border:none;border-left:dotted 4px #fff;margin-top: 10px;">
      <div class="cardRight"></div>
   <!-- <div class="eye"></div> -->

    </td>
  </tr>
  <tr>
    <td style=" background: #ECEDEF;width: 150px;border:none;height: 30px;"> Guest Name :</td>
    <td class="" style=" background: #ECEDEF;border:none;">
   {{(empty($voucher->guest_name))?$voucher->agent->name:$voucher->guest_name}}
    </td>
    @php
    $rowspan =4;
    if($ticket->ticket_for != 'Both')
    $rowspan =5;
    @endphp
    <td align="center" valign="middle"  rowspan="{{ $rowspan }}" style="width: 30%; background: #ECEDEF;border-radius: 0px 0px 10px 0px;border-left:dotted 4px #fff;padding-top: 20px;" class="">
   
   @if($ticket->type_of_ticket == 'Barcode')
   {!! DNS1D::getBarcodeHTML(trim($ticket->ticket_no), 'C128', 2, 50) !!}
   @else
          {!! QrCode::size(100)->generate(trim($ticket->ticket_no)) !!}
        @endif
            <p style="color:#000;text-wrap:balance;margin: 10px 0px 0px 0px;">{{$ticket->ticket_no}} </p>
          
            <div class="cardLeft"></div>

    </td>
</tr>
@if($ticket->ticket_for != 'Both')
<tr>
    <td style=" background: #ECEDEF;border:none;"> Ticket Type:</td>
    <td class="" style=" background: #ECEDEF;border:none;">
     {{$ticket->ticket_for}}

    </td>
    
</tr>

@endif
<tr>
    <td style=" background: #ECEDEF;border:none;height: 30px;">Travel Date  @if($voucherActivity->time_slot != '') {{ '/' }} @endif :</td>
    <td class="" style=" background: #ECEDEF;border:none;">
    {{ $voucherActivity->tour_date ? date(config('app.date_format'),strtotime($voucherActivity->tour_date)) : null }}
    {{$voucherActivity->time_slot ? ' / '.$voucherActivity->time_slot: null}} 
    </td>
    
</tr>
<tr>
    <td style=" background: #ECEDEF;border:none;height: 30px;">Valid Till : </td>
    <td class="" style=" background: #ECEDEF;border:none;">
   {{ $ticket->valid_till ? date(config('app.date_format'),strtotime($ticket->valid_till)) : null }}
    </td>
    
</tr>
<tr>
    <td style=" background: #ECEDEF;border:none;border-radius: 0px 0px 0px 10px;height: 30px;"> 
    Confirmation ID : </td>
    <td style=" background: #ECEDEF;border:none;border-radius: 0px 0px 0px 0px;"> 
   {{ $voucher->code}}
   
    </td>
    
</tr>

   
</table>

</div>

        
             
          </div>
      </div>
      <div style="clear:both; width: 100%;height: 10px;border-bottom: 2px #000 solid;">&nbsp;</div>
      <div style="width: 98%;margin-top:10px;text-align:justify;" style="">
      @if(file_exists(public_path('uploads/variants/'.$ticket->variant->ticket_banner_image)) && !empty($ticket->variant->ticket_banner_image))
            <img src="{{asset('uploads/variants/'.$ticket->variant->ticket_banner_image)}}"  alt="" border="0" hspace="0" vspace="0" height="auto" style="max-width: 100%;width: 100%;height: auto;max-height: 250px;border-radius:5px;">
           
            @endif   
      <h3>General Rules and Regulations</h3>
						<p style="font-size: 9px!important;">{!! @$ticket->variant->terms_conditions !!}</p>
          
               @if(file_exists(public_path('uploads/variants/'.$ticket->variant->ticket_footer_image)) && !empty($ticket->variant->ticket_footer_image))
            <img src="{{asset('uploads/variants/'.$ticket->variant->ticket_footer_image)}}"  alt="" border="0" hspace="0" vspace="0" height="auto" style="max-width: 100%;width: 100%;height: auto;max-height: 250px;border-radius:5px;">
           
            @endif   
      </div>
     

      @endforeach
     
    </body>
</html>
