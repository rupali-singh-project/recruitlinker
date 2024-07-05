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
                        <h6 class="text-right text-bold page-heading">All Companies Details</h6>

                        <h6 class="font-weight-normal">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{url('/land')}}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Companies Details</li>
                                </ol>
                            </nav>
                        </h6>
                    </div>
                </div>
            </div>

            <!-- Small boxes (Stat box) -->
            <!-- end row -->
            <div class="row">
                @if(count($allCompanyDtls)==0)
                <div class="col-12 p-2">
                    <div class="p-5 text-center" style="border:2px dotted #0ddbb9 !important">
                        <h2>No Companies Found!</h2>
                    </div>
                </div>
                @endif
                @foreach($allCompanyDtls as $companyDtls)
                @php $encId = Crypt::encrypt($companyDtls->user_id); @endphp
                <div class="col-lg-3">
                    <div class="text-center card-box">
                        <div class="member-card pt-2 pb-2">
                            <div class="thumb-lg member-thumb mx-auto">
                                @if($companyDtls->company_logo!='' && $companyDtls->company_logo!=null)
                                <img src="{{asset('public/uploads/company/logo/'.$companyDtls->company_logo)}}" class="rounded-circle img-thumbnail" alt="profile-image">
                                @else
                                <img src="{{asset('public/uploads/company/logo/default-logo.png')}}" class="rounded-circle img-thumbnail" alt="profile-image">
                                @endif
                            </div>
                            <div class="">
                                <h4>{{$companyDtls->company_name}}</h4>
                                <p class="text-muted">
                                   
                                </p>
                            </div>
                            <!--
                            <ul class="social-links list-inline">
                                <li class="list-inline-item"><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" target="_blank" href="{{$companyDtls->facebook_id}}" data-original-title="Facebook"><i class="mdi mdi-facebook"></i></a></li>
                                <li class="list-inline-item"><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" target="_blank" href="{{$companyDtls->twitter_id}}" data-original-title="Twitter"><i class="mdi mdi-twitter"></i></a></li>
                                <li class="list-inline-item"><a title="" data-placement="top" data-toggle="tooltip" class="tooltips" target="_blank" href="{{$companyDtls->linkedin_id}}" data-original-title="Skype"><i class="mdi mdi-linkedin"></i></a></li>
                            </ul>
                            -->
                    
                            <span class="badge badge-danger">Active</span>
                          
                            <span class="badge badge-success">   <a href="{{url('company/profile/get/'.Crypt::encrypt($companyDtls->id))}}"><i class="mdi mdi-eye" style="color:green;"></i></a>
    </span>
                            
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- end col -->

            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-12">
                    <div class="text-right">
                        {!! $allCompanyDtls->links()!!}
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div>

        @endsection
        @section('scripts')


        @endsection
