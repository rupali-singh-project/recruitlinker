@extends('emails.base')

@section('content')
@if($content['bladeData']['for'] != 'student')
<h1>Dear {{ $content['bladeData']['adminName'] }},</h1>
@endif
<p>
    A new user has been registered.
</p>

<p>Account details are as follows:</p>

<ul>
    <li>Name: {{ $content['bladeData']['userData']->first_name }} {{ $content['bladeData']['userData']->last_name ?? '' }}</li>
    <li>Username: {{$content['bladeData']['userData']->userid}}</li>
    <li>Email Address: {{$content['bladeData']['userData']->email}}</li>
    <li>Password: {{$content['bladeData']['password']}}</li>
</ul>

<p>
    Thank you for choosing Jobscom. We look forward to serving you and providing you with a seamless experience.
</p>

<p>Best regards</p>
@endsection