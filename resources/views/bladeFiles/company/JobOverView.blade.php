@extends('layouts.master')

@section('content')
<style>
    body {
        margin-top: 20px;
        background: #f7f8fa
    }

    .avatar-xxl {
        height: 7rem;
        width: 7rem;
    }

    .card {
        margin-bottom: 20px;
        -webkit-box-shadow: 0 2px 3px #eaedf2;
        box-shadow: 0 2px 3px #eaedf2;
    }

    .pb-0 {
        padding-bottom: 0 !important;
    }

    .font-size-16 {
        font-size: 16px !important;
    }

    .avatar-title {
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        background-color: #038edc;
        color: #fff;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        font-weight: 500;
        height: 100%;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        width: 100%;
    }

    .bg-soft-primary {
        background-color: rgba(3, 142, 220, .15) !important;
    }

    .rounded-circle {
        border-radius: 50% !important;
    }

    .nav-tabs-custom .nav-item .nav-link.active {
        color: #038edc;
    }

    .nav-tabs-custom .nav-item .nav-link {
        border: none;
    }

    .nav-tabs-custom .nav-item .nav-link.active {
        color: #038edc;
    }

    .avatar-group {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding-left: 12px;
    }

    .border-end {
        border-right: 1px solid #eff0f2 !important;
    }

    .d-inline-block {
        display: inline-block !important;
    }

    .badge-soft-danger {
        color: #f34e4e;
        background-color: rgba(243, 78, 78, .1);
    }

    .badge-soft-warning {
        color: #f7cc53;
        background-color: rgba(247, 204, 83, .1);
    }

    .badge-soft-success {
        color: #51d28c;
        background-color: rgba(81, 210, 140, .1);
    }

    .avatar-group .avatar-group-item {
        margin-left: -14px;
        border: 2px solid #fff;
        border-radius: 50%;
        -webkit-transition: all .2s;
        transition: all .2s;
    }

    .avatar-sm {
        height: 2rem;
        width: 2rem;
    }

    .nav-tabs-custom .nav-item {
        position: relative;
        color: #343a40;
    }

    .nav-tabs-custom .nav-item .nav-link.active:after {
        -webkit-transform: scale(1);
        transform: scale(1);
    }

    .nav-tabs-custom .nav-item .nav-link::after {
        content: "";
        background: #038edc;
        height: 2px;
        position: absolute;
        width: 100%;
        left: 0;
        bottom: -2px;
        -webkit-transition: all 250ms ease 0s;
        transition: all 250ms ease 0s;
        -webkit-transform: scale(0);
        transform: scale(0);
    }

    .badge-soft-secondary {
        color: #74788d;
        background-color: rgba(116, 120, 141, .1);
    }

    .badge-soft-secondary {
        color: #74788d;
    }

    .work-activity {
        position: relative;
        color: #74788d;
        padding-left: 5.5rem
    }

    .work-activity::before {
        content: "";
        position: absolute;
        height: 100%;
        top: 0;
        left: 66px;
        border-left: 1px solid rgba(3, 142, 220, .25)
    }

    .work-activity .work-item {
        position: relative;
        border-bottom: 2px dashed #eff0f2;
        margin-bottom: 14px
    }

    .work-activity .work-item:last-of-type {
        padding-bottom: 0;
        margin-bottom: 0;
        border: none
    }

    .work-activity .work-item::after,
    .work-activity .work-item::before {
        position: absolute;
        display: block
    }

    .work-activity .work-item::before {
        content: attr(data-date);
        left: -157px;
        top: -3px;
        text-align: right;
        font-weight: 500;
        color: #74788d;
        font-size: 12px;
        min-width: 120px
    }

    .work-activity .work-item::after {
        content: "";
        width: 10px;
        height: 10px;
        border-radius: 50%;
        left: -26px;
        top: 3px;
        background-color: #fff;
        border: 2px solid #038edc
    }
</style>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 mb-4 mb-xl-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <!-- <h3 class="text-dark font-weight-bold mb-2">User Login Details!</h3> -->
                        <h6 class="text-right text-bold page-heading">Jobs Overview</h6>

                        <h6 class="font-weight-normal">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{url('/land')}}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Jobs Overview</li>
                                </ol>
                            </nav>
                        </h6>
                    </div>
                </div>
            </div>


            <!-- profile code start from here -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.2.96/css/materialdesignicons.min.css" integrity="sha512-LX0YV/MWBEn2dwXCYgQHrpa9HJkwB+S+bnBpifSOTO1No27TqNMKYoAn6ff2FBh03THAzAiiCwQ+aPX+/Qt/Ow==" crossorigin="anonymous" referrerpolicy="no-referrer" />

            <div class="row">
                @if(session()->has('error'))
                <div class="col-12 p-0">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {!!session()->get('error')!!}
                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                @endif
                @if(session()->has('success'))
                <div class="col-12 p-0">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {!!session()->get('success')!!}
                        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                @endif
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body pb-0">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <div class="text-center border-end">
                                    @if($user_cat=='Student') 
                                       <img src="{{asset('public/assets/images/job_logo.jpg')}}" class="img-fluid avatar-xxl rounded-circle" alt="">
                                        <h4 class="text-primary font-size-20 mt-3 mb-2">SoftechAI</h4>
                                        <h5 class="text-muted font-size-13 mb-0">https://softechai.info/</h5>
                                    @else
                                        <img src="{{asset('public/assets/images/job_logo.jpg')}}" class="img-fluid avatar-xxl rounded-circle" alt="">
                                        <h4 class="text-primary font-size-20 mt-3 mb-2">{{$jobsDtls->company_name}}</h4>
                                        <h5 class="text-muted font-size-13 mb-0">{{$jobsDtls->website_link}}</h5>
                                
                                    @endif
                                        <br>
                                    </div>
                                </div><!-- end col -->

                                <div class="col-md-9">
                                    <div class="ms-3">
                                        <div>
                                            <h4 class="card-title mb-2">{{$jobsDtls->job_title}}</h4>
                                            <p class="mb-0 text-muted">Posted On : &nbsp;{{$jobsDtls->created_at}}</p>
                                        </div>
                                        <div class="row my-4">
                                            <div class="col-md-12">
                                                <div>
                                                    <p class="text-muted mb-2 fw-medium"><i class="mdi mdi-email-outline me-2"></i>{{$jobsDtls->email}}
                                                    </p>
                                                    <p class="text-muted fw-medium mb-0"><i class="mdi mdi-phone-in-talk-outline me-2"></i>{{$jobsDtls->phone}}
                                                    </p>
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->


                                    </div>
                                </div><!-- end col -->
                            </div><!-- end row -->
                        </div><!-- end card body -->
                    </div><!-- end card -->

                    <div class="card">
                        <div class="tab-content p-4">
                            <div class="tab-pane active show" id="tasks-tab" role="tabpanel">
                                <h4 class="card-title mb-4">Roles & Responsibility</h4>

                                <div class="row">
                                    <div class="col-xl-12">
                                        {!!$jobsDtls->job_desc!!}

                                    </div><!-- end col -->
                                </div><!-- end row -->
                            </div><!-- end tab pane -->
                        </div>
                    </div><!-- end card -->

                    <div class="card">
                        <div class="tab-content p-4">
                            <div class="tab-pane active show" id="tasks-tab" role="tabpanel">
                                <h4 class="card-title mb-4">Company Questions</h4>
                                <div class="row">
                                    <div class="col-12 ">
                                        <form method="POST" action="{{url('job/'.$jobsDtls->job_key_id.'/form/apply')}}">
                                            @csrf
                                            <div class="border-bottom border-secondary mb-2">
                                                @foreach($companySpecificQuestions as $question)
                                                @if(!$isStudentApplied)
                                                <div class="form-group">
                                                    <input type="hidden" name="questionId[]" value="{{$question->id}}">
                                                    <label for=""><i class="fas fa-chevron-circle-right text-primary text-small"></i>{{$question->question}} @if($question->is_required) <span class="text-danger">(Required)</span> @endif</label>
                                                    <textarea class="form-control" name="question_{{$question->id}}" id="" placeholder="" @if($question->is_required) required @endif></textarea>
                                                </div>
                                                @else
                                                <div class="form-group">
                                                    <label for=""><i class="fas fa-chevron-circle-right text-primary text-small"></i>{{$question->question}} </label>
                                                    <p class="border p-2">{{$question->response}}</p>
                                                </div>
                                                @endif
                                                @endforeach
                                            </div>
                                            <!-- <div class="form-group">
                            <label for="exampleInputPassword1">Profile</label>
                            <select name="profile" id="" class="form-control">
                                <option value="1">Choose Profile</option>
                            </select>
                            </div> -->
                                            @if(!$isStudentApplied)
                                            <button type="submit" class="btn btn-primary">Apply</button>
                                            @endif
                                        </form>
                                    </div><!-- end col -->
                                </div><!-- end row -->
                            </div><!-- end tab pane -->
                        </div>
                    </div><!-- end card -->



                </div><!-- end col -->

                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="pb-2">
                                <h4 class="card-title mb-3">Job Details</h4>


                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Experience</th>
                                                <td>{{$jobsDtls->min_exp}}- {{$jobsDtls->max_exp}} Years</td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <th scope="row">Openings</th>
                                                <td>{{$jobsDtls->opening}}</td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <th scope="row">Salary</th>
                                                <td>Upto {{$jobsDtls->currency}}{{$jobsDtls->salary}}</td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <th scope="row">Location</th>
                                                <td>{{$jobsDtls->location}}</td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <th scope="row">Industry Type</th>
                                                <td>{{$jobsDtls->industry_type}}</td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <th scope="row">Employee Type</th>
                                                <td>{{$jobsDtls->employee_type}}</td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <th scope="row">Job Deadline</th>
                                                <td>{{$jobsDtls->job_deadline}}</td>
                                            </tr><!-- end tr -->
                                        </tbody><!-- end tbody -->
                                    </table><!-- end table -->
                                </div>
                            </div>
                            <hr>
                            <div class="pt-2">
                                <h4 class="card-title mb-4">Required Skills</h4>
                                <div class="d-flex gap-2 flex-wrap">
                                    @if($jobsDtls->skills=='' || count(explode(",",$jobsDtls->skills)) == 0)
                                    No Specific Skill Required
                                    @else
                                    @foreach(explode(",",$jobsDtls->skills) as $skill)
                                    <span class="badge badge-soft-secondary p-2">{{$skill}}</span>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div><!-- end cardbody -->
                    </div><!-- end card -->




                </div><!-- end col -->
            </div>

            <!-- profile code end here -->



        </div>
    </div>
</div>
<!-- START FIRST ROW -->

<!-- MODEL END HERE -->


@endsection