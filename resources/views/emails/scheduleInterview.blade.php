@extends('emails.base')

@section('content')
<h1>Dear {{ $content['bladeData']['userData']->first_name }},</h1>

<p>I trust this message finds you well. We have carefully reviewed your application for the {{ $content['bladeData']['jobData']->job_title }} position at ABC Pvt. Ltd. and are pleased to inform you that we would like to proceed with an interview.</p>

<p>Details of the interview are as follows:</p>

<ul>
    <li>Date: {{$content['bladeData']['jobMappingDetail']->interview_time ?? 'N/A'}}</li>
    <li>Instructions: {{$content['bladeData']['jobMappingDetail']->instructions ?? 'N/A'}}</li>
</ul>

<p>Please confirm your availability for the scheduled interview by replying to this email at your earliest convenience. In case the proposed date and time are not suitable, kindly let us know, and we will do our best to accommodate an alternative.</p>

<!-- <p>Thank you for using our platform!</p> -->

<p>Best regards</p>
@endsection