@extends('emails.layout')
@section('message')
<div style="width: 100%;margin: 20px 0px;padding: 0px 20px">
		<p>
			<strong>Hello,</strong>
		</p>
		<p>New Agency Registered.</p>
 
<p> Here are the details.</p>
 
<p>Agency: {{$technician_details['company']}}<br>
	Agent Name: {{$technician_details['name']}}<br>
	Email: {{$technician_details['email']}}<br>
	
	Address: {{$technician_details['address']}}  {{$technician_details['address_two']}}<br>
	{{$technician_details['city']}}<br>
	{{$technician_details['state']}}<br>
	{{$technician_details['country']}}<br>
	Mobile No: {{$technician_details['agency_mobile']}}<br>
	Email ID: {{$technician_details['agency_email']}}<br>
</p>


 
	<p><strong>Thanks </strong></p><p><strong></br>Team Abatera B2B </strong></p>
	</div>
@endsection
