@extends('emails.base')

@section('content')
<h1>Hello {{ $content['bladeData']['adminData']->first_name }},</h1>

<p>Candidate <b>{{ $content['bladeData']['studentData']->first_name }}</b> has applied to a job.</p>

<ul>
    <li><strong>Job Title:</strong> {{ $content['bladeData']['job_data']->job_title }}</li>
    <li><strong>Description:</strong> {!! $content['bladeData']['job_data']->job_desc !!}</li>
    <!-- Add more job details as needed -->
</ul>

<!-- <p>Thank you for using our platform!</p> -->

<p>Best regards</p>
@endsection