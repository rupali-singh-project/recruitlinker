@extends('emails.base')

@section('content')
@if($content['bladeData']['for'] =='student')
<h1>Dear {{ $content['bladeData']['userData']->first_name }},</h1>
<p>We are writing to confirm that we have successfully received your payment for Jobscomm premium account. Thank you for your prompt payment.</p>
@else
<h1>Dear {{ $content['bladeData']['adminName'] }},</h1>
<p>We are writing to confirm that we have successfully received payment from <b>{{ $content['bladeData']['userData']->first_name }} {{ $content['bladeData']['userData']->last_name }}</b> for Jobscomm premium account.</p>
@endif
<ul>
    <li><strong>Payment Amount:</strong> {{ $content['bladeData']['amount'] }}</li>
    <li><strong>Payment Date:</strong> {!! $content['bladeData']['payment_time'] !!}</li>
    <li><strong>Payment Method:</strong> Card </li>
    <li><strong>Transaction Id:</strong> {!! $content['bladeData']['payment_id'] !!}</li>
    <!-- Add more job details as needed -->
</ul>

<p>Best regards</p>
@endsection