<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="initial-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="format-detection" content="telephone=no"/>
<title>Ticket</title>

<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700|Open+Sans:400,700,300|Roboto:400,300,700&subset=latin,cyrillic,greek" rel="stylesheet" type="text/css">
<style>
body
{
  font-size: 10pt;
}
.table
{
	border-collapse:collapse!important;
	width: 100%;
  
}
.table th
{
	background-color: #ddd;
  font-weight: bold;
  word-wrap: break-word;
}
.table td
{
	
}
.table td,.table th
{
	text-align: left;
}
.table-bordered th,.table-bordered td
{
	border:1px solid #000!important;
}
.table-borderless th,.table-borderless td
{
	border:none!important;
}
.table-striped>thead>tr:nth-of-type(odd){background-color:#f9f9f9}
</style>
</head>
  <body  style=" width:100%; height:100%;">
      <table id="mainStructure" class="full-width" width="800" align="center" border="0" cellspacing="0" cellpadding="0" style="background-color: #efefef; max-width: 800px;   margin: 0px auto;"><!--START LAYOUT-2 ( LOGO / MENU )-->
        @foreach($tickets as $ticket)
        <tr>
          <td align="center" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">  
            <table width="760" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; max-width: 760px; margin: 0px auto;">
              <tr>
                <td valign="top">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="max-width: 100%; margin: 0px auto;">
                    <tr>
                      <td valign="top" colspan="2" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse;"></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" width="136" style="width: 136px;">
                          @if(file_exists(public_path('uploads/activities/'.$voucherActivity->activity->brand_logo)) && !empty($voucherActivity->activity->brand_logo))
                          <img src="{{asset('uploads/activities/thumb/'.$voucherActivity->activity->brand_logo)}}" width="100" style="max-width: 100px; display: block !important; width: 136px; height: auto;" alt="logo-top" border="0" hspace="0" vspace="0" height="auto">
                          @else
                          {{-- Code to show a placeholder or alternate image --}}
                          <img src="{{ asset('uploads/activities/thumb/no-image.png') }}" style="max-width: 150px;width: 120px;height: 120px" alt="no-image">
                          @endif
                           
                        </td>
                        <td  align="center" valign="middle" > <h1>
						
						</h1></td>
                    </tr>
                    <tr>
                      <td valign="top" colspan="2" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse;"></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr><!--END LAYOUT-2 ( LOGO / MENU )--><!--START LAYOUT-13 ( 2-COL TEXT / BG )  -->
        <tr>
          <td align="center" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">  
            <table width="760" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; max-width: 760px; margin: 0px auto;">
              <tr style="border-top: 2px solid #000;">
                <td valign="top">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="max-width: 100%; margin: 0px auto;">
                    <tr>
                      <td valign="top" colspan="2" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse; border-top: 2px solid #000!important;"></td>
                    </tr>
                   
                    <tr>
                      <td valign="top" colspan="2" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse;"></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr><!--END LAYOUT-2 ( LOGO / MENU )--><!--START LAYOUT-13 ( 2-COL TEXT / BG )  -->
	
        <tr>
          <td align="center" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">  
            <table width="760" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; max-width: 760px; margin: 0px auto;">
              <tr style="border-top: 2px solid #000;">
                <td valign="top">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="max-width: 100%; margin: 0px auto;">
                    <tr>
                      <td valign="top"  height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse; "></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
						 <h3>Ticket Details</h3>
                            <table class="table table-condensed table-striped" cellspacing="0" cellpadding="10px">
                                <thead>
								
                                  <tr >
                                    <th >
                                      Guest Name 
                                    </th>
                                    <th >
									{{(empty($voucher->guest_name))?$voucher->agent->name:$voucher->guest_name}}
                                    </th>
                                   </tr>
								   <tr >
                                    <th >
                                       Service Date
                                    </th>
                                    <th >
									{{ $voucherActivity->tour_date ? date(config('app.date_format'),strtotime($voucherActivity->tour_date)) : null }}
                                    </th>
                                   </tr>
								   <tr >
                                    <th >
                                      Timing
                                    </th>
                                    <th >
                                    
                                    </th>
									 </tr>
									 <tr>
                                    <th >
                                      Confirmation Id
                                    </th>
                                    <th >
                                    {{ $voucher->code}}
                                    </th>
									 </tr>
									  <tr >
                                    <th >
                                       Valid Until
                                    </th>
                                    <th >
                                     {{ $ticket->valid_till ? date(config('app.date_format'),strtotime($ticket->valid_till)) : null }}
                                    </th>
									 </tr>
								  
                                </thead>
                               
                    <tr>
                      <td valign="top" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse;"></td>
                    </tr>
                  </table>
                </td>
				<td align="left" valign="top">
				<h3>&nbsp;</h3>
				<img src="https://chart.googleapis.com/chart?cht=qr&chs=200x200&choe=UTF-8&chld=L|1&chl={{$ticket->ticket_no}}" width="200" style="max-width: 200px; display: block !important; width: 200px; height: 200px;margin:-7px" alt="logo-top" border="0" hspace="0" vspace="0" height="auto">
				<span style="margin-left: 54px;font-size:20px">{{ $ticket->ticket_no}}</span>
				</td>
              </tr>
            </table>
          </td>
        </tr><!--END LAYOUT-2 ( LOGO / MENU )--><!--START LAYOUT-13 ( 2-COL TEXT / BG )  -->
        <!--END LAYOUT-2 ( LOGO / MENU )--><!--START LAYOUT-13 ( 2-COL TEXT / BG )  -->
        <tr>
          <td align="left" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">  
            <table width="760" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; max-width: 760px; margin: 0px auto;">
              <tr style="border-top: 2px solid #000;">
                <td valign="top">
				
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="max-width: 100%; margin: 0px auto;">
                    <tr>
                      <td valign="top" colspan="2" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse; border-top: 2px solid #000!important;"></td>
                    </tr>
                    <tr>
                       
                        <td align="left" valign="left">
						 <h3>Terms And Conditions</h3>
						<p>{!! $ticket->terms_and_conditions !!}</p>
          
            @if(file_exists(public_path('uploads/activities/'.$voucherActivity->activity->image)) && !empty($voucherActivity->activity->image))
            <img src="{{asset('uploads/activities/'.$voucherActivity->activity->image)}}"  alt="logo-top" border="0" hspace="0" vspace="0" height="auto" style="max-width: 150px;width: 120px;height: 120px">
            @else
            {{-- Code to show a placeholder or alternate image --}}
            <img src="{{ asset('uploads/activities/thumb/no-image.png') }}" style="max-width: 150px;width: 120px;height: 120px" alt="no-image">
            @endif        
                         </td>
                    </tr>
                    <tr>
                      <td valign="top"  height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse;"></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr><!--END LAYOUT-2 ( LOGO / MENU )--><!--START LAYOUT-13 ( 2-COL TEXT / BG )  -->
		
      </table>
	  </td>
        </tr>
      
        @endforeach
		</table>
    </body>
</html>