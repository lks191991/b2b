@extends('emails.layout')
@section('message')

<div style="width: 100%;margin: 20px 0px;padding: 0px 20px">
		<p>
			<strong>Hello {{ $adminuser_details['name']}},</strong>
		</p>
		<p> We've received your request to reset the password for user id .</p>
 
<p>You can reset your password by clicking the link below:</p>
 
<p style="text-align: center;">
    <a href="{{url('forgot-password', $adminuser_details['token'])}}">Reset your password</a>
</p>
<p><strong>The above link is valid for 20 Minutes.</strong></p>
<p>For any further information or assistance please feel free to contact us.</p>
<p>Note: Please do not reply to this email. It has been sent from an email account that is not monitored.</p>
<p><strong>Thanks </strong></p><p><strong></br>Team Abatera B2B </strong></p>
	</div>
@endsection

