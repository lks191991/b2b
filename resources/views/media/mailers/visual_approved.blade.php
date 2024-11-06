@include('mailers.email_header')

<table style="border-collapse: collapse ; " width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff" align="center">
    <tbody>
      <tr>
        <td width="100%" valign="top"><table class="mobile" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody>
              <tr>
                <td style="padding: 20px 0px"><table class="mobile" width="49%" cellspacing="0" cellpadding="0" border="0" align="left">
                    <tbody>
                      <tr>
                        <td width="100%" align="center" style="padding-bottom: 10px;"> <img src="{{asset('\images\hoodies4schools.png')}}" alt="hoodies4schools"></td>
                      </tr>
                    </tbody>
                  </table>
                  <table width="49%" class="mobile" cellspacing="0" cellpadding="0" border="0" align="right">
                    <tbody>
                      <tr>
                        <td width="100%" align="center" style="padding-bottom: 10px;"> <img src="{{asset('\images\aprons4schools.png')}}" alt="a4s-full"></td>
                      </tr>
                    </tbody>
                  </table>
                  </td>
              </tr>
            </tbody>
          </table></td>
      </tr>
      <tr>
        <td width="100%" valign="middle" align="center" style="padding: 0 10px;">

          <table style="background-color: rgb(29 , 34 , 43) ; background-image: none"  class="mobile" width="700" cellspacing="0" cellpadding="0" border="0" bgcolor="#010101" align="center">
            <tbody>
              <tr>
                <td style="background-image: url(&quot;http://hoodies4schools.co.uk/components/com_h4s/assets/images/quote_email/top-header.jpg&quot;) ; background-size: cover ; background-position: center center ; background-repeat: no-repeat ; background-color: rgb(29 , 34 , 43); padding: 0px 10px;" id="BGheaderChange"><table class="mobile" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                    <tbody>
                      <tr>
                        <td><table  class="mobile" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
                            <tbody>
                              <tr>
                                <td width="100%"><table style="border-collapse: collapse" class="mobile" width="600" cellspacing="0" cellpadding="0" border="0">
                                    <tbody>
                                      <tr>
                                        <td width="100%" height="35"></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <table style="border-collapse: collapse" class="mobile" width="600" cellspacing="0" cellpadding="0" border="0">
                                    <tbody>
                                      <tr>
                                      <td style="font-size: 32px ; color: rgb(255 , 255 , 255) ; text-align: center ; font-family: &quot;helvetica&quot; , &quot;arial&quot; , sans-serif ; line-height: 38px ; font-weight: bold ; vertical-align: top ; text-transform: uppercase" class="font32" width="100%" align="center"><span class="font32" style="font-size: 32px">{!!$template->subject!!}</span> <br>
                                         </td>
                                      </tr>
                                    </tbody>
                                  </table>

                                  </td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="border-collapse: collapse" class="mobile" width="600" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                              <tr>
                                <td width="100%" height="35"></td>
                              </tr>
                            </tbody>
                          </table></td>
                      </tr>
                    </tbody>
                  </table></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
    </tbody>
  </table>
  <table style="background-color: rgb(255 , 255 , 255)"  class="mobile" width="700" cellspacing="0" cellpadding="0" border="0" align="center">
    <tbody>
      <tr>
        <td width="100%" valign="top"><table class="mobile" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody>
              <tr>
                <td><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                    <tbody>
                      <tr>
                        <td width="100%" height="35"></td>
                      </tr>
                    </tbody>
                  </table></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
    </tbody>
  </table>

  <table style="background-color: rgb(255 , 255 , 255) ; position: relative ; left: 0px ; top: 0px"  class="mobile" width="700" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center">
    <tbody>
      <tr>
        <td width="100%" valign="top"  style="padding: 0px 10px;"><table class="mobile" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody>
              <tr>
                <td><table class="mobile" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
                    <tbody>
                      <tr>
                        <td width="100%"><table style="border-collapse: collapse"  width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                            <tbody>
                              <tr>
                                <td style="color: rgb(1 , 1 , 1)" width="100%" valign="top" height="30">{!!$template->salutation!!} {{$contact->contact_name}},<br>
                                    <p>Order Reffrence: {{$visual->Orders->order_ref}}</P>
                                        <p>Please find attached your visual for approval.
                                                Please click the link below and follow the instructions for approving your artwork.</p>

                                                <p>Note: Production and stock allocation cannot begin until this visual has been approved.</p>
                                                <p>(Please note that you must check the artwork for all graphical and type elements, it is your responsibility for any errors that are printed if you approve the
                                                artwork. This artwork is not to scale and is for layout purposes only.)</p>

                                                <p><a href="{{route('frontend.visual.visualApprove',$visual->hash_key)}}" class="butpink" >Approve Artwork</a></p>
                                                <p>Check Your Visual <a href="{{url('uploads/images/order_visual/'.$visual->image)}}">Click here</a></p>

                                                <p>What happens next?<br>
                                                If you approve the artwork your order will be placed into production and will be ready for dispatch within 5-7 working days.
                                                If you disapprove your artwork due to a spelling mistake or another issue, we will update the artwork and send a secondary visual for approval.
                                                We will only start production once you have an approved artwork.<p>
                                                <p><b style="color:#ff0000">Please note any delays in the approval process of your artwork can impact on the production and delivery schedule.</b></p>

                                                <p>If you have any questions about the artwork approval process, please call 0800 817 4901.</p>
                                        <p>&nbsp;</p>
                                        <p>Kindest Regards,<br>
                                            {{ config('app.name') }}</p>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                      </td>
                      </tr>
                    </tbody>
                  </table>
                  <table style="border-collapse: collapse" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
                    <tbody>
                      <tr>
                        <td width="100%" height="35"></td>
                      </tr>
                    </tbody>
                  </table></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
    </tbody>
  </table>
@include('mailers.email_footer')


