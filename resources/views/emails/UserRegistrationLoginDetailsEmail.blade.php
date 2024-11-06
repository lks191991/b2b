@component('mail::message')
<h3> Hello {{ $user_details['first_name']}},</h3>
<p style="margin:0 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;">
	 Your MyQuip account MyQuip account has been created. 
    </p>
<p style="margin:10px 0 12px 0;font-size:14px;line-height:24px;font-family:Arial,sans-serif;">
    Here are the details :-<br>
	Email: {{$user_details['email']}}<br>
	Password: {{$user_details['password']}}
</p>
<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
