@extends('emails.layout')
@section('message')

<div style="width: 100%;margin: 20px 0px;padding: 0px 20px">
		<p>
			<strong>Dear {{$technician_details['name']}},</strong>
		</p>
		<p>Greetings from Abaterab2b!</p>
 
<p>Your AbateraB2B Account has been successfully activated.</p>
 <p>Please find credentials below.</p>
<p>User ID : {{$technician_details['email']}}<br>
Password: <b>{{$technician_details['password']}}</b></p>
 <p>Your Account has been approved as a Cash Agent.</p>

 <p>For any further information or assistance please feel free to contact us.</p>
 <p>Note: Please do not reply to this email. It has been sent from an email account that is not monitored</p>
 <p><strong>Thanks </strong></p><p><strong></br>Team Abatera B2B </strong></p>	</div>


@endsection
