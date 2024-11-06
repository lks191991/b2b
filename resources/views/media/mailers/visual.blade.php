<html>
@include('mailers.email_header')
<div class="Email__Header">
    <span class="Header__Text">{{$contact->contact_name}} : Your Hoodies4Schools artwork approval</span>
</div>
<div class="Email__Content">
    <p>{!!$template->salutation!!} {{$contact->contact_name}},</p>

    <p>Please find attached your visual for approval.
    Please click the link below and follow the instructions for approving your artwork.</p>
    <p>Note: Production and stock allocation cannot begin until this visual has been approved.</p>
    <p>(Please note that you must check the artwork for all graphical and type elements, it is your responsibility for any errors that are printed if you approve the
    artwork. This artwork is not to scale and is for layout purposes only.)</p>

    <p><a href="http://ordering.hoodies4schools.co.uk/visual/{{$visual->hash_value}}" class="butpink" >Approve Artwork</a></p>

    <p>What happens next?<br>
    If you approve the artwork your order will be placed into production and will be ready for dispatch within 5-7 working days.
    If you disapprove your artwork due to a spelling mistake or another issue, we will update the artwork and send a secondary visual for approval.
    We will only start production once you have an approved artwork.<p>

    <p><b style="color:#ff0000">Please note any delays in the approval process of your artwork can impact on the production and delivery schedule.</b></p>

    <p>If you have any questions about the artwork approval process, please call 0800 817 4901.</p>
    <p>&nbsp;</p>
    <p>Kindest Regards,<br>
    The Hoodies4schools Team</p>
</div>

@include('mailers.email_footer')