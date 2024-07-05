@extends('emails.base')

@section('content')
@if($content['bladeData']['for'] == 'student')
<h1>Dear {{ $content['bladeData']['userData']->first_name }} {{ $content['bladeData']['userData']->last_name ?? '' }},</h1>

<p>
    We are pleased to inform you that your account registration was successful. Welcome to our community!
</p>
@else
<h1>Dear {{ $content['bladeData']['adminName'] }},</h1>

<p>
    An account was created for user <b>{{ $content['bladeData']['userData']->first_name }} {{ $content['bladeData']['userData']->last_name ?? '' }}</b>.
</p>
@endif

<p>Account details are as follows:</p>
<ul>
    <li>Username: {{$content['bladeData']['userData']->userid}}</li>
    <li>Email Address: {{$content['bladeData']['userData']->email}}</li>
    <li>Password: {{$content['bladeData']['password']}}</li>
</ul>

<p>
    Thank you for choosing Jobscom. We look forward to serving you and providing you with a seamless experience.
</p>

<p>Best regards</p>
@endsection