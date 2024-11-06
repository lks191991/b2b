<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="initial-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="format-detection" content="telephone=no"/>
<title>Invoice</title>

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
      <table id="mainStructure" class="full-width" width="800" align="center" border="0" cellspacing="0" cellpadding="10px" style="background-color: #efefef; max-width: 800px;   margin: 0px auto;border: 1px solid #000;"><!--START LAYOUT-2 ( LOGO / MENU )-->
        <tr>
          <td align="center" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">  
           
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="max-width: 100%; margin: 0px auto;">
                  
                    <tr>
                        <td align="left" valign="top" style="width: 200px;border-bottom: 2px solid #000;">
                         
                            <img src="{{asset('images/1.png/')}}" width="100" style="max-width: 100px; display: block !important; width: 136px; height: auto;margin-bottom: 20px;" alt="logo-top" border="0" hspace="0" vspace="0" height="auto">
                           
                        </td>
                        <td align="center" valign="middle" style="border-bottom: 2px solid #000;"> <h1>
						                {{$agentAmounts->transaction_type }} Slip
						          </h1></td>
                        <td  align="right" valign="top"  style="width: 200px;border-bottom: 2px solid #000;" > 
                        <h3>Abatera Tourism LLC</h3>
                            <p>TRN No.: 100327054100003</p>
                           </td>
                    </tr>
                   
                    <tr>
                        <td align="right" colspan="3" valign="top" style="padding-top: 0px;" >

                        <table width="100%" border="0" cellspacing="10" cellpadding="5" align="right" class="full-width" style="max-width: 50%; margin: 0px auto;">
                  
                  <tr>
                   <td align="left" style="border: 1px solid #000;">
                   No.:  {{$agentAmounts->receipt_no}}
                   </td>
                   <td align="left" style="border: 1px solid #000;">
                    Date.: {{date("d-M-Y",strtotime($agentAmounts->date_of_receipt))}}
                   </td>
                  </tr>
                 
                 </table>
                       
                     
                        
                           </td>
                    </tr>
                  </table>
               
          </td>
        </tr><!--END LAYOUT-2 ( LOGO / MENU )--><!--START LAYOUT-13 ( 2-COL TEXT / BG )  -->
        <tr>
          <td align="center" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">  
           
                
               
          </td>
        </tr><!--END LAYOUT-2 ( LOGO / MENU )--><!--START LAYOUT-13 ( 2-COL TEXT / BG )  -->
        <tr>
          <td align="center" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">  
          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="max-width: 100%; margin: 0px auto;">
                  
                  <tr>
                    <td style="width: 70%">
          <table width="100%" border="0" cellspacing="0" cellpadding="5px;" align="left" class="full-width" style="max-width: 100%; margin: 0px auto;">
                   
                    <tr>
                      <th align="left" valign="top" style="width: 150px;">Received From : </th>
                        <td align="left" valign="top">
						
                       {{($agentAmounts->agent)?$agentAmounts->agent->company_name:''}}
                      
                       <br/>
                        {{($agentAmounts->agent->address)?$agentAmounts->agent->address:''}}
                        {{($agentAmounts->agent->city)?' ,'.$agentAmounts->agent->city->name:''}}
                        
                        {{($agentAmounts->agent->state)?' ,'.$agentAmounts->agent->state->name:''}}
                       
                      <br/>{{($agentAmounts->agent->country)?$agentAmounts->agent->country->name:''}}
                      <br/>{{$agentAmounts->agent->mobile}}</p>
                       
                        </td>
                    </tr>
                    <tr>
                      <th align="left" valign="top">Amount : </th>
                      <td>AED {{number_format($agentAmounts->amount,"2",".",",")}}</td>
                    </tr>
                    <tr>
                      <th align="left" valign="top">Note : </th>
                      <td> {{ $agentAmounts->remark }}</td>
                    </tr>
                    <tr>
                      <th align="left" valign="top" colspan="2"></th>
                     
                    </tr>
                   
                   
                  </table>
                  </td>
                  <td align="left" valign="bottom">
                  <table width="100%" border="0" cellspacing="0" cellpadding="5px;" align="left" class="full-width" style="max-width: 100%; margin: 0px auto;">
                   
                   <tr>
                    <td>
                    <strong>Payment Method</strong><br/><br/>
                    @if($agentAmounts->mode_of_payment =='1') {{'WIO BANK A/C No - 962 222 3261'}} @elseif($agentAmounts->mode_of_payment =='2') {{'RAK BANK A/C No -0033488116001'}} @elseif($agentAmounts->mode_of_payment =='3'){{'CBD BANK A/C No -1001303922'}} @elseif ($agentAmounts->mode_of_payment =='4'){{'Cash'}} @elseif($agentAmounts->mode_of_payment =='5'){{'Cheque'}} @endif 
                    </td>
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
                            
                        </td>
                      
                    </tr>
                    <tr>
                      <td valign="top" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse;"></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr><!--END LAYOUT-2 ( LOGO / MENU )--><!--START LAYOUT-13 ( 2-COL TEXT / BG )  -->
        
        <tr>
        <tr>
          <td align="center" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">  
           
                  <table width="100%" border="0" cellspacing="0" cellpadding="20" align="left" class="full-width" style="max-width: 50%; margin: 0px auto;">
                  
                   <tr>
                    <td style="border: solid 1px #000;">
                          <strong>Received By / Date</strong>
                          <br/>
<br/>
                          {{ $agentAmounts->updatedBy ?$agentAmounts->updatedBy->name: null }} 
<br/>
<br/>
                    {{ $agentAmounts->updated_at ? date("M d, Y",strtotime($agentAmounts->updated_at)) : null }} 
                    </td>
                   </tr>
                  
                  </table>
               
          </td>
        </tr><!--END LAYOUT-2 ( LOGO / MENU )--><!--START LAYOUT-13 ( 2-COL TEXT / BG )  -->
          <td align="center" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">  
            <table width="760" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; max-width: 760px; margin: 0px auto;">
              <tr style="border-top: 2px solid #000;">
                <td valign="top">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="full-width" style="max-width: 100%; margin: 0px auto;">
                    <tr>
                      <td valign="top" colspan="2" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse; border-top: 2px solid #000!important;"></td>
                    </tr>
                    <tr>
                       
                        <td align="center" valign="middle">
					
						
                          <p>System generated slip and therefore does not require a signature </p>
                         
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
    </body>
</html>
