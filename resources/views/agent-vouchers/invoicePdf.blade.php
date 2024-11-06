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
      <table id="mainStructure" class="full-width" width="800" align="center" border="0" cellspacing="0" cellpadding="0" style="background-color: #efefef; max-width: 800px;   margin: 0px auto;"><!--START LAYOUT-2 ( LOGO / MENU )-->
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
                         
                            <img src="https://www.abateratourism.com/templates/shaper_travel/images/styles/style4/logo.png" width="100" style="max-width: 100px; display: block !important; width: 136px; height: auto;" alt="logo-top" border="0" hspace="0" vspace="0" height="auto">
                            <h3>Abatera Tourism LLC</h3>
                        </td>
                        <td  align="center" valign="middle" > <h1>
						@if($voucher->vat_invoice == 1)
							VAT INVOICE
						@else
							PROFORMA INVOICE
						@endif
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
                        <td align="left" valign="top">
						@if(!empty($agent))
                         <p>Invoice To</p>
                         <p>{{$agent->company_name}}</p>
                         <p>{{$agent->address}}<br/>{{($agent->city)?$agent->city->name:''}}, {{($agent->state)?$agent->state->name:''}}<br/>{{($agent->country)?$agent->country->name:''}}</p>
                         <p>{{$agent->phone}},{{$agent->mobile}}</p>
                         <p>{{$agent->email }}</p>
						 <p>TRN No. : {{$agent->vat}}</p>
						 @endif
                        </td>
                        <td align="right" valign="top">
                          <p>Invoice No.:  {{$voucher->invoice_number}}</p>
                          <p>Invoice Date.: {{date("d-M-Y")}}</p>
                         
                         </td>
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
                            <table class="table table-condensed table-striped" cellspacing="0" cellpadding="10px">
                                <thead>
                                  <tr >
                                    <th >
                                      Service 
                                    </th>
                                    <th >
                                      Service Date
                                    </th>
                                   
                                    <th >
                                      No. of Pax(s)
                                    </th>
                                    <th >
                                      Agent Ref
                                    </th>
                                    <th >
                                      Amount (In AED)
                                    </th>
                                  </tr>
                                </thead>
                                <tbody>
								 @if(!empty($dataArray))
					  @foreach($dataArray as $ap)
					 
                                  <tr>
                                    <td style="border-bottom:1px solid #000!important;">
                                      {{$ap['hhotelActName']}}
                                    </td>
                                    <td  style="border-bottom:1px solid #000!important;">
									{{$ap['TouCheckInCheckOutDate']}}
                                    </td>
                                   
                                    <td  style="border-bottom:1px solid #000!important;">
									@if($ap['hotel'])
									{{$ap['NoofPax']}}
									@else
									Adult : {{$ap['adult']}} <br/>
									Child : {{$ap['child']}} <br/>
									@endif
                                    </td  style="border-bottom:1px solid #000!important;">
                                    <td  style="border-bottom:1px solid #000!important;">
                                     {{$voucher->agent_ref_no}}
                                    </td>
                                    <td  style="border-bottom:1px solid #000!important;">
									{{number_format($ap['totalprice'],2)}}
                                     
                                    </td>
                                  </tr>
								   @endforeach
				 @endif
         @if($voucher->vat_invoice == 1)
         <tr >
                                    <td >
                                      
                                    </td>
                                    <td >
                                    
                                    </td>
                                   
                                    <td colspan="2" >
                                    Sub Total: 
                                    </td>
                                  
                                    <td >
                                    AED {{number_format($grandWithOutVatTotal,2)}}
                                    </td>
                                  </tr>
                                  <tr >
                                    <td >
                                      
                                    </td>
                                    <td >
                                    
                                    </td>
                                   
                                    <td colspan="2" >
                                   VAT (5%)
                                    </td>
                                   
                                    <td >
                                    AED {{number_format($vatTotal,2)}}
                                    </td>
                                  </tr>
                                  
                                  @endif
                        <tr >
                                    <td >
                                      
                                    </td>
                                    <td >
                                    
                                    </td>
                                   
                                    <th colspan="2" >
                                   <strong>Grand Total: </strong> 
                                    </th>
                                   
                                    <th >
                                    <strong>AED {{number_format($grandWithVatTotal,2)}}</strong> 
                                    </th>
                                  </tr>
                                
                                </tbody>
                            </table>
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
          <td align="center" valign="top" style="background-color: #ffffff;" bgcolor="#ffffff">  
            <table width="760" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width" style="background-color: #ffffff; max-width: 760px; margin: 0px auto;">
              <tr style="border-top: 2px solid #000;">
                <td valign="top">
                  <table width="100%" border="0" cellspacing="0" cellpadding="10" align="center" class="full-width" style="max-width: 100%; margin: 0px auto;">
                  <tr>
                      <td colspan="3" valign="top" colspan="2" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse;"></td>
                    </tr>
                
                  <tr>
                      <td valign="top" style="border-right:solid 1px #000;">
                      <h3>Bank Details</h3>
                      <strong>ABATERA TOURISM LLC</strong><br/>
Account -0033488116001  <br/> IBAN - AE530400000033488116001
Corresponding Bank (USD) : <br/>BANK OF NEW YORK,NEW YORK, U.S.A<br/>
SWIFT CODE (AED) : NRAKAEAK<br/> | Swift Code(USD) : IRVTUS3N<br/>
Branch Name: Bur Dubai Branch
                      </td> 
                      <td valign="top"  style="border-right:solid 1px #000;">
                      <h3>&nbsp;</h3>
                      
                      <strong>ABATERA TOURISM LLC</strong><br/>
Account -1001303922 <br/> IBAN -  AE870230000001001303922<br/>
SWIFT CODE(AED) : CBDUAEAD<br/>
Branch Name: Immigration Branch
                        </td>
                        <td valign="top">
                        <h3>&nbsp;</h3>
                      
                        <strong>ABATERA TOURISM LLC</strong><br/>
Account – 9622223261<br/>
IBAN - AE850860000009622223261s<br/>
SWIFT CODE(AED) : WIOBAEADXXX
                        </td>
                   </tr>
                   
                       
                    <tr>
                      <td colspan="3" valign="top" colspan="2" height="11" style="height: 11px; font-size: 0px; line-height: 0; border-collapse: collapse;"></td>
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
                       
                        <td align="center" valign="middle">
						@if($voucher->vat_invoice == 1)
							<p>VAT Credit on this Tax Invoice can only be claimed after maturity of service date</p>
						@endif
						
                          <p>System generated invoice no signature is required.</p>
                         
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