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
                                             {!!$template->content!!}
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


