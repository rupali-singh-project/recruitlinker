@extends('emails.base')

@section('content')
<h1>Hello {{ $content['bladeData']['user_data']->first_name }},</h1>

<p>Congratulations! A new job has been created:</p>

<ul>
    <li><strong>Job Title:</strong> {{ $content['bladeData']['job_data']['job_title'] }}</li>
    <li><strong>Description:</strong> {!! $content['bladeData']['job_data']['job_desc'] !!}</li>
    <!-- Add more job details as needed -->
</ul>

<!-- <p>Thank you for using our platform!</p> -->

<p>Best regards</p>
@endsection