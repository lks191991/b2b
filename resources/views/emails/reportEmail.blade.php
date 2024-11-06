@extends('emails.layout-other')
@section('message')
<div style="width: 100%;margin: 20px 0px;padding: 0px 20px">
		<p>
			<strong>Hello,</strong>
		</p>
 
 
<p>{!!$details['email_body']!!}<br></p>

 
	<p><strong>Thanks </strong></p><p><strong></br>Team Abatera B2B </strong></p>
	</div>
@endsection
