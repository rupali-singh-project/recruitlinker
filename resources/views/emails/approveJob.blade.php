@extends('emails.base')

@section('content')
<h1>Hello {{ $content['bladeData']['userData']->first_name }},</h1>

<p>Admin has approved your job application.Now, your application will be sent to the company..</p>

<ul>
    <li><strong>Job Title:</strong> {{ $content['bladeData']['jobData']->job_title }}</li>
    <li><strong>Description:</strong> {!! $content['bladeData']['jobData']->job_desc !!}</li>
    <!-- Add more job details as needed -->
</ul>

<!-- <p>Thank you for using our platform!</p> -->

<p>Best regards</p>
@endsection