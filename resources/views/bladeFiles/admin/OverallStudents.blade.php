@extends('layouts.master')
@section('content')

<head>

    <style>
        body {
            background: #DCDCDC;
            margin-top: 20px;
        }

        .card-box {
            padding: 20px;
            border-radius: 3px;
            margin-bottom: 30px;
            background-color: #fff;
        }

        .social-links li a {
            border-radius: 50%;
            color: rgba(121, 121, 121, .8);
            display: inline-block;
            height: 30px;
            line-height: 27px;
            border: 2px solid rgba(121, 121, 121, .5);
            text-align: center;
            width: 30px
        }

        .social-links li a:hover {
            color: #797979;
            border: 2px solid #797979
        }

        .thumb-lg {
            height: 88px;
            width: 88px;
        }

        .img-thumbnail {
            padding: .25rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: .25rem;
            max-width: 100%;
            height: auto;
        }

        .text-pink {
            color: #ff679b !important;
        }

        .btn-rounded {
            border-radius: 2em;
        }

        .text-muted {
            color: #98a6ad !important;
        }

        h4 {
            line-height: 22px;
            font-size: 18px;
        }
    </style>
</head>
<!-- /.content-header -->
<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 mb-4 mb-xl-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <!-- <h3 class="text-dark font-weight-bold mb-2">User Login Details!</h3> -->
                        <h6 class="text-right text-bold page-heading">All Candidates Details</h6>

                        <h6 class="font-weight-normal">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{url('/land')}}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Candidates Details</li>
                                </ol>
                            </nav>
                        </h6>
                    </div>
                </div>
            </div>

            <!-- Small boxes (Stat box) -->
            <!-- end row -->
            <div class="row">
                <div class="col-12">
                    <form action="">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Job Categories</label>
                                    <select name="job_category" class="form-control form-control-sm d-inline-block" id="">
                                        <option value="">Select Job Category</option>
                                        @foreach($jobProfileData as $row)
                                        <option value="{{$row->title}}" @if($row->title == Request::input('job_category')) selected @endif>{{$row->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Creation Date</label>
                                    <div>
                                        <select name="job_post_month" style="width:170px;margin-right:5px" class="form-control form-control-sm d-inline-block" id="">
                                            <option value="">Select Month</option>
                                            @php
                                            $months = array(
                                            1 => "January",
                                            2 => "February",
                                            3 => "March",
                                            4 => "April",
                                            5 => "May",
                                            6 => "June",
                                            7 => "July",
                                            8 => "August",
                                            9 => "September",
                                            10 => "October",
                                            11 => "November",
                                            12 => "December"
                                            );
                                            @endphp
                                            @foreach($months as $monthNo=>$monthDesc)
                                            <option value="{{$monthNo}}" @if($monthNo==Request::input('job_post_month')) selected @endif>{{$monthDesc}}</option>
                                            @endforeach
                                        </select>
                                        <select name="job_post_year" style="width:170px" class="form-control form-control-sm d-inline-block" id="">
                                            <option value="">Select Year</option>
                                            @for($i=2022; $i<2030; $i++) <option value="{{$i}}" @if($i==Request::input('job_post_year')) selected @endif>{{$i}}</option>
                                                @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 d-flex justify-content-start align-items-center">
                                <span>
                                    <button class="btn btn-sm btn-primary">Filter</button>
                                    <a href="{{url('Students_view')}}" class="btn btn-sm btn-warning">Reset</a>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                @if(count($studentDtls)==0)
                <div class="col-12 p-2">
                    <div class="p-5 text-center" style="border:2px dotted #0ddbb9 !important">
                        <h2>No Candidates Found!</h2>
                    </div>
                </div>
                @endif
                @foreach($studentDtls as $studentData)
                @php $encId = Crypt::encrypt($studentData->user_id); @endphp
                <div class="col-lg-3">
                    <div class="text-center card-box">
                        <div class="member-card pt-2 pb-2">
                            <div class="thumb-lg member-thumb mx-auto">
                                @if($studentData->stu_image!='' && $studentData->stu_image!=null)
                                <img src="{{asset('public/uploads/company/logo/'.$studentData->stu_image)}}" class="rounded-circle img-thumbnail" alt="profile-image">
                                @else
                                <img src="{{asset('public/uploads/company/logo/default-logo.png')}}" class="rounded-circle img-thumbnail" alt="profile-image">
                                @endif

                            </div>
                            <div class="">
                                <h4><a href="{{url('student/profile/view/'.Crypt::encrypt($studentData->id))}}" class="text-info"><b>{{$studentData->first_name}} {{$studentData->last_name}}</b></a></h4>
                                <p class="text-muted">{{$studentData->profile_title ?? 'N/A'}} <span></span></p>
                            </div>
                            <ul class="social-links list-inline">
                                <li class="list-inline-item">
                                    <p class="text-muted">{{$studentData->gender}} <span>| </span>{{$studentData->marital_status}}<span>| </span>{{$studentData->religion}} </p>
                                </li>
                            </ul>
                            @if($studentData->resume=='')
                            <button type="button" class="btn btn-xs mt-3 btn-rounded waves-effect w-md waves-light" style="background-color:#E91E63;" disabled>
                                <a style="color:white;">
                                    Resume</a></button>
                            @else
                            <button type="button" class="btn btn-danger mt-3 btn-rounded waves-effect w-md waves-light">
                                <a href="{{asset('public/uploads/profile/resume/'.$studentData->resume)}}" style="color:white;">
                                   Resume</a></button>
                            @endif
                            <!--<div class="mt-4">
                            <div class="row">
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>{{$studentData->totalexperience}} Years</h4>
                                        <p class="mb-0 text-muted">Total Experience</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>{{$studentData->willing_to_relocate}}</h4>
                                        <p class="mb-0 text-muted">Willing To Relocate</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>{{$studentData->languages}}</h4>
                                        <p class="mb-0 text-muted">Languages</p>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- end col -->

            </div>



        </div>

        @endsection
        @section('scripts')


        @endsection