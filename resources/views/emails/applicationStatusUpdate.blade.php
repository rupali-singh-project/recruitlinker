@extends('emails.base')

@section('content')
<h1>Hello {{ $content['bladeData']['userData']->first_name }},</h1>

<p> {{$content['bladeData']['action_by']}} has updated your job application status.</p>

@if($content['bladeData']['status'] == 'Hired')
<p><b>You are hired!</b></p>
@else
<p><strong>Interview Round :</strong> {{ $content['bladeData']['status'] }}</p>
@endif
<p>{!! $content['bladeData']['message'] !!}</p>

<!-- <p>Thank you for using our platform!</p> -->

<p>Best regards</p>
@endsection