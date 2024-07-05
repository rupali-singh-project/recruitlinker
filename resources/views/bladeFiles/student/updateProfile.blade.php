@extends('layouts.master')

@section('styles')
<style>

</style>

@endsection

@section('content')
<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 mb-4 mb-xl-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <!-- <h3 class="text-light font-weight-bold mb-2">User Login Details!</h3> -->
                        <h6 class="text-right text-bold page-heading">Update Profile</h6>

                        <h6 class="font-weight-normal">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{url('/land')}}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Update Profile</li>
                                </ol>
                            </nav>
                        </h6>
                    </div>
                </div>
            </div>
            <!-- START FIRST ROW -->
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between">
                            <span class="">Personal Details</span>
                            <span><button class="btn btn-sm btn-success" id="personalDetailFormBtn"><i class="fas fa-check-circle"></i>Update</button></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="form-sample" id="personalDetailForm">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label">Profile Title</label>
                                        <div class="col-sm-11">

                                            <select name="profile_title" class="form-control form-control-lg d-inline-block" id="">
                                                <option value="">Select Job Category</option>
                                                @foreach($jobProfileData as $row)
                                                <option value="{{$row->title}}" @if($row->title == $personalDetails->profile_title) selected @endif>{{$row->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Profile Image</label>
                                        <div class="col-sm-9">
                                            @if($userData['profile_pic'])
                                            <span class="w-25">
                                                <img src="{{asset('public/uploads/profile/'.$userData['profile_pic'])}}" style="height: 40px;width:100px">
                                            </span>
                                            @endif

                                            <input type="file" name="profile_pic" class="form-control d-inline-block @if($userData['profile_pic']) w-75 @else w-100 @endif">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Upload Resume</label>
                                        <div class="col-sm-9">

                                            <input type="file" name="resume" class="form-control d-inline-block">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">First Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="first_name" class="form-control" value="{{$userData['first_name']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Last Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="last_name" class="form-control" value="{{$userData['last_name']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Gender</label>
                                        <div class="col-sm-9">
                                            <select name="gender" class="form-control mt-2">
                                                <option value="M" @if($personalDetails->gender=='M') selected @endif>Male</option>
                                                <option value="F" @if($personalDetails->gender=='F') selected @endif>Female</option>
                                                <option value="O" @if($personalDetails->gender=='O') selected @endif>Others</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Date of Birth</label>
                                        <div class="col-sm-9">
                                            <input type="date" name="date_of_birth" class="form-control" placeholder="dd/mm/yyyy" value="{{$personalDetails->date_of_birth}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-nowrap">Willing to relocate ?</label>
                                        <div class="col-sm-9 pt-3">
                                            <input type="checkbox" style="margin-left:20px" name="willing_to_relocate" @if($personalDetails->willing_to_relocate=='1') checked @endif><span class="mr-3">Yes, I am.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Phone</label>
                                        <div class="col-sm-9 pt-3">
                                            <input type="text" name="phone" class="form-control" value="{{$personalDetails->phone}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-nowrap">Street Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="address" class="form-control" placeholder="Enter street address" value="{{$personalDetails->street_address}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" name="email" placeholder="Enter email" class="form-control" value="{{$userData['email']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">City</label>
                                        <div class="col-sm-9 pt-3">
                                            <input type="text" name="phone" class="form-control" value="{{$personalDetails->phone}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between">
                            <span class="">Educational Details</span>
                            <span><button class="btn btn-sm btn-success" id="educationDetailFormBtn"><i class="fas fa-check-circle"></i>Update</button></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="form-sample" id="educationDetailForm">
                            <table class="table table-bordered" id="educationTableContainer">
                                <tr>
                                    <th></th>
                                    <th>Degree/Course</th>
                                    <th>Institue</th>
                                    <th>Start time</th>
                                    <th>End time</th>
                                    <th>Marks</th>
                                </tr>
                                @if(count($educationsData) > 0)
                                @foreach($educationsData as $education)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success addRowBtn" data-rowid="1"><i class="fas fa-plus"></i></button>
                                        <button type="button" class="btn btn-sm btn-outline-danger deleteEducationRecord" data-id="{{$education->id}}"><i class="fas fa-trash"></i></button>
                                        <input type="hidden" name="row_id[]" value="{{$loop->iteration}}">
                                        <input type="hidden" name="row_key_id_{{$loop->iteration}}" value="{{$education->id}}">
                                    </td>
                                    <td>
                                        <select name="degree_1" id="" class="form-control">
                                            <option value="TEN" @if($education->degree =='TEN') selected @endif>10th</option>
                                            <option value="TWELVE" @if($education->degree =='TWELVE') selected @endif>12th</option>
                                            <!-- <option value="DIP" @if($education->degree =='') selected @endif>Diploma</option> -->
                                            <option value="BA" @if($education->degree =='BA') selected @endif>BA</option>
                                            <option value="MA" @if($education->degree =='MA') selected @endif>MA</option>
                                            <option value="BSC" @if($education->degree =='BSC') selected @endif>BSC</option>
                                            <option value="BCA" @if($education->degree =='BCA') selected @endif>BCA</option>
                                            <option value="BTECH" @if($education->degree =='BTECH') selected @endif>BTECH</option>
                                            <option value="BCOM" @if($education->degree =='BCOM') selected @endif>BCOM</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" placeholder="Enter institure name" name="institute_{{$loop->iteration}}" value="{{$education->institute}}"></td>
                                    <td><input type="date" class="form-control" name="start_date_{{$loop->iteration}}" value="{{$education->start_time}}"></td>
                                    <td>
                                        <input type="date" class="form-control" name="end_date_{{$loop->iteration}}" value="{{$education->end_time}}">
                                        <input type="checkbox" name="isStudying_{{$loop->iteration}}" @if($education->isStudying =='1') checked @endif> I am currently studying.
                                    </td>
                                    <td><input type="text" class="form-control" name="marks_{{$loop->iteration}}" placeholder="Enter your marks or GPA" value="{{$education->marks}}"></td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success addRowBtn" data-rowid="1"><i class="fas fa-plus"></i></button>
                                        <input type="hidden" name="row_id[]" value="1">
                                    </td>
                                    <td>
                                        <select name="degree_1" id="" class="form-control">
                                            <option value="TEN">10th</option>
                                            <option value="TWELVE">12th</option>
                                            <!-- <option value="DIP">Diploma</option> -->
                                            <option value="BA">BA</option>
                                            <option value="MA">MA</option>
                                            <option value="BSC">BSC</option>
                                            <option value="BCA">BCA</option>
                                            <option value="BTECH">BTECH</option>
                                            <option value="BCOM">BCOM</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" placeholder="Enter institure name" name="institute_1"></td>
                                    <td><input type="date" class="form-control" name="start_date_1"></td>
                                    <td>
                                        <input type="date" class="form-control" name="end_date_1">
                                        <input type="checkbox" name="isStudying_1"> I am currently studying.
                                    </td>
                                    <td><input type="text" class="form-control" name="marks_1" placeholder="Enter your marks or GPA"></td>
                                </tr>
                                @endif
                            </table>
                        </form>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between">
                            <span class="">Work Experience Details</span>
                            <span><button class="btn btn-sm btn-success" id="experienceDetailFormBtn"><i class="fas fa-check-circle"></i>Update</button></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="form-sample" id="experienceDetailForm">
                            <table class="table table-bordered" id="experienceTableContainer">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Company Name</th>
                                        <th>Job Title</th>
                                        <th>Job Type</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Job Summary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($workExperienceData) > 0)
                                    @foreach($workExperienceData as $experience)
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-success addExperienceRowBtn" data-rowid="1"><i class="fas fa-plus"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-danger deleteExperienceRecord" data-id="{{$experience->id}}"><i class="fas fa-trash"></i></button>
                                            <input type="hidden" name="row_id[]" value="{{$loop->iteration}}">
                                            <input type="hidden" name="row_key_id_{{$loop->iteration}}" value="{{$experience->id}}">
                                        </td>
                                        <td><input type="text" class="form-control" placeholder="Enter company name" name="company_name_{{$loop->iteration}}" value="{{$experience->company_name}}"></td>
                                        <td><input type="text" class="form-control" name="job_title_{{$loop->iteration}}" value="{{$experience->job_title}}"></td>
                                        <td>
                                            <select name="job_type_{{$loop->iteration}}" id="" class="form-control" style="width:100px">
                                                <option value="inoffice" @if($experience->job_type=='inoffice') selected @endif >In-Office</option>
                                                <option value="remote" @if($experience->job_type=='remote') selected @endif>Work From Home</option>
                                                <option value="hybrid" @if($experience->job_type=='hybrid') selected @endif>Hybrid</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="start_time_{{$loop->iteration}}" value="{{$experience->start_time}}">
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="end_time_{{$loop->iteration}}" value="{{$experience->end_time}}">
                                            <input type="checkbox" name="isWorking_{{$loop->iteration}}" @if($experience->isWorking =='1') checked @endif> Currently Working Here.
                                        </td>
                                        <td><textarea class="form-control" name="job_summary_{{$loop->iteration}}" placeholder="Enter your job summary">{{$experience->job_summary}} </textarea></td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-success addExperienceRowBtn" data-rowid="1"><i class="fas fa-plus"></i></button>
                                            <input type="hidden" name="row_id[]" value="1">
                                        </td>
                                        <td><input type="text" class="form-control" placeholder="Enter company name" name="company_name_1" value=""></td>
                                        <td><input type="text" class="form-control" name="job_title_1"></td>
                                        <td>
                                            <select name="job_type_1" id="" class="form-control" style="width:100px">
                                                <option value="inoffice">In-Office</option>
                                                <option value="remote">Work From Home</option>
                                                <option value="hybrid">Hybrid</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="start_time_1">
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="end_time_1">
                                            <input type="checkbox" name="isWorking_1"> Currently Working Here.
                                        </td>
                                        <td><textarea class="form-control" name="job_summary_1" placeholder="Enter your job summary"></textarea></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-8">
                        <!-- STUDENT CERTIFICATIONS -->
                        <div class="card mt-2">
                            <div class="card-header bg-white">
                                <div class="d-flex justify-content-between">
                                    <span class="">Certification/Courses Details</span>
                                    <span><button class="btn btn-sm btn-success" id="certificationsDetailFormBtn"><i class="fas fa-check-circle"></i>Update</button></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <form class="form-sample" id="certificationsDetailForm">
                                    <table class="table table-bordered" id="certificationsTableContainer">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Certificate Name</th>
                                                <th>Certificate Issuer</th>
                                                <th>Certificate Expiry</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($certificationsData) > 0)
                                            @foreach($certificationsData as $certifications)
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-success addCertificationRowBtn" data-rowid="1"><i class="fas fa-plus"></i></button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger deleteExperienceRecord" data-id="{{$certifications->id}}"><i class="fas fa-trash"></i></button>
                                                    <input type="hidden" name="row_id[]" value="{{$loop->iteration}}">
                                                    <input type="hidden" name="row_key_id_{{$loop->iteration}}" value="{{$certifications->id}}">
                                                </td>
                                                <td><input type="text" class="form-control" placeholder="Enter certificate name e.g. SAA" name="certificate_name_{{$loop->iteration}}" value="{{$certifications->certificate_name}}"></td>
                                                <td><input type="text" class="form-control" name="certificate_issuer_{{$loop->iteration}}" value="{{$certifications->certificate_issuer}}" placeholder="Certificate Issuer e.g. AWS"></td>
                                                <td>
                                                    <input type="text" id="expiry" name="expiry_{{$loop->iteration}}" placeholder="MM / YY" class="form-control" maxlength="7" value="{{$certifications->expiry_month}}/{{$certifications->expiry_year}}">
                                                    <input type="checkbox" name="no_expiry_1" @if($certifications->no_expiry=='1') selected @endif> No expiration
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-success addCertificationRowBtn" data-rowid="1"><i class="fas fa-plus"></i></button>
                                                    <input type="hidden" name="row_id[]" value="1">
                                                </td>
                                                <td><input type="text" class="form-control" placeholder="Enter certificate name e.g. SAA" name="certificate_name_1" value=""></td>
                                                <td><input type="text" class="form-control" name="certificate_issuer_1" value="" placeholder="Certificate Issuer e.g. AWS"></td>
                                                <td>
                                                    <input type="text" name="expiry_1" id="expiry" placeholder="MM / YY" class="form-control" maxlength="7">
                                                    <input type="checkbox" name="no_expiry_1"> No expiration
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 p-0">
                        <div class="card mt-2">
                            <div class="card-header bg-white">
                                <div class="d-flex justify-content-between">
                                    <span class="">External Links</span>
                                    <span><button class="btn btn-sm btn-success" id="externalLinkFormBtn"><i class="fas fa-check-circle"></i>Update</button></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <form class="form-sample" id="externalLinkForm">
                                    <table class="table table-bordered" id="linksTableContainer">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Link Type</th>
                                                <th>Link</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($linksData) > 0)
                                            @foreach($linksData as $link)
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-success addLinkRow" data-rowid="1"><i class="fas fa-plus"></i></button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger deleteLinkRecord" data-id="{{$link->id}}"><i class="fas fa-trash"></i></button>
                                                    <input type="hidden" name="row_id[]" value="{{$loop->iteration}}">
                                                    <input type="hidden" name="row_key_id_{{$loop->iteration}}" value="{{$link->id}}">
                                                </td>
                                                <td>
                                                    <select name="linkName_{{$loop->iteration}}" class="form-control" id="">
                                                        @foreach($linksType as $type)
                                                        <option value="{{$type}}">{{$type}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="link_{{$loop->iteration}}" class="form-control" value="{{$link->link}}">
                                                </td>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-success addLinkRow" data-rowid="1"><i class="fas fa-plus"></i></button>
                                                    <input type="hidden" name="row_id[]" value="1">
                                                </td>
                                                <td>
                                                    <select name="linkName_1" class="form-control" id="">
                                                        @foreach($linksType as $type)
                                                        <option value="{{$type}}">{{$type}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" name="custom_link_1" value="" class="d-none form-control mt-1">
                                                </td>
                                                <td>
                                                    <input type="text" name="link_1" class="form-control">
                                                </td>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    $('.select2').select2({
        width: 200,
        placeholder: 'Select Candidates'
    });
    $('#assignStudentForJobBtn').on('click', function() {
        $('#selected_job_id').val($(this).data('jobid'));
        $('#assignJobFormModal').modal('show');
    })

    $('#personalDetailFormBtn').on('click', function(e) {
        e.preventDefault();
        var formData = new FormData($('#personalDetailForm')[0]);
        $.ajax({
            url: "{{url('student/profile/personal/update')}}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '' + response.msg + '',
                    });
                }
            }
        });
    })

    $('#educationDetailFormBtn').on('click', function(e) {
        e.preventDefault();
        var formData = new FormData($('#educationDetailForm')[0]);
        $.ajax({
            url: "{{url('student/profile/education/update')}}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '' + response.msg + '',
                    });
                }
            }
        });
    })

    $('#experienceDetailFormBtn').on('click', function(e) {
        e.preventDefault();
        var formData = new FormData($('#experienceDetailForm')[0]);
        $.ajax({
            url: "{{url('student/profile/workSummary/update')}}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '' + response.msg + '',
                    });
                }
            }
        });
    })

    $('#certificationsDetailFormBtn').on('click', function(e) {
        e.preventDefault();
        var formData = new FormData($('#certificationsDetailForm')[0]);
        $.ajax({
            url: "{{url('student/profile/certification/update')}}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '' + response.msg + '',
                    });
                }
            }
        });
    })

    $('#externalLinkFormBtn').on('click', function(e) {
        e.preventDefault();
        var formData = new FormData($('#externalLinkForm')[0]);
        $.ajax({
            url: "{{url('student/profile/links/update')}}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '' + response.msg + '',
                    });
                }
            }
        });
    })

    $('.deleteEducationRecord').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            url: "{{url('student/profile/education/delete')}}" + '/' + id,
            method: "GET",
            success: function(response) {
                if (response.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '' + response.msg + '',
                    }).then(() => {
                        location.reload();
                    });
                }
            }
        });
    })
    $(document).on('click', '.deleteRowBtn', function(e) {
        $(this).parent().parent().remove();
    })
    $('.addRowBtn').on('click', function() {
        var id = parseInt($(this).data('id'));
        var html = `<tr>
                        <td>
                            <button type="button" class="btn btn-sm btn-success addRowBtn" data-rowid="${id+1}"><i class="fas fa-plus"></i></button>
                            <button type="button" class="btn btn-sm btn-danger deleteRowBtn" data-rowid="${id+1}"><i class="fas fa-trash"></i></button>
                            <input type="hidden" name="row_id[]" value="${id+1}">
                        </td>
                        <td>
                            <select name="degree_${id+1}" id="" class="form-control">
                                <option value="TEN">10th</option>
                                <option value="TWELVE">12th</option>
                                <!-- <option value="DIP">Diploma</option> -->
                                <option value="BA">BA</option>
                                <option value="MA">MA</option>
                                <option value="BSC">BSC</option>
                                <option value="BCA">BCA</option>
                                <option value="BTECH">BTECH</option>
                                <option value="BCOM">BCOM</option>
                            </select>
                        </td>
                        <td><input type="text"  class="form-control" placeholder="Enter institure name" name="institute_${id+1}"></td>
                        <td><input type="date" class="form-control" name="start_date_${id+1}"></td>
                        <td>
                            <input type="date" class="form-control" name="end_date_${id+1}">
                            <input type="checkbox" name="isStudying_${id+1}"> I am currently studying.
                        </td>
                        <td><input type="text" class="form-control" name="marks_${id+1}" placeholder="Enter your marks or GPA"></td>
                    </tr>`;
        $('#educationTableContainer').append(html);
    })
    $('.addExperienceRowBtn').on('click', function() {
        var id = parseInt($(this).data('id'));
        var html = `
            <tr>
                <td>
                    <button type="button" class="btn btn-sm btn-success addExperienceRowBtn" data-rowid="${id+1}"><i class="fas fa-plus"></i></button>
                    <input type="hidden" name="row_id[]" value="${id+1}">
                    <button type="button" class="btn btn-sm btn-danger deleteRowBtn" data-rowid="${id+1}"><i class="fas fa-trash"></i></button>

                </td>
                <td><input type="text"  class="form-control" placeholder="Enter company name" name="company_name_${id+1}" value=""></td>
                <td><input type="text" class="form-control" name="job_title_${id+1}" ></td>
                <td>
                    <select name="job_type_${id+1}" class="form-control" style="width:100px">
                        <option value="inoffice">In-Office</option>
                        <option value="remote">Work From Home</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                </td>
                <td>
                    <input type="date" class="form-control" name="start_time_${id+1}" >
                </td>
                <td>
                    <input type="date" class="form-control" name="end_time_${id+1}" >
                    <input type="checkbox" name="isWorking_${id+1}"> Currently Working Here.
                </td>
                <td><textarea class="form-control" name="job_summary_${id+1}" placeholder="Enter your job summary"></textarea></td>
            </tr>
        `;
        $('#experienceTableContainer tbody').append(html);
    })
    $('.addCertificationRowBtn').on('click', function() {
        var id = parseInt($(this).data('id'));
        var html = `
            <tr>
                <td>
                    <button type="button" class="btn btn-sm btn-success addCertificationRowBtn" data-rowid="${id+1}"><i class="fas fa-plus"></i></button>
                    <input type="hidden" name="row_id[]" value="${id+1}">
                    <button type="button" class="btn btn-sm btn-danger deleteRowBtn" data-rowid="${id+1}"><i class="fas fa-trash"></i></button>

                </td>
                <td><input type="text"  class="form-control" placeholder="Enter certificate name e.g. SAA" name="certificate_name_${id+1}" value=""></td>
                <td><input type="text" class="form-control" name="certificate_issuer_${id+1}" value="" placeholder="Certificate Issuer e.g. AWS"></td>
                <td>
                    <input type="text" name="expiry_${id+1}" id="expiry" placeholder="MM / YY" class="form-control" maxlength="7">
                    <input type="checkbox" name="no_expiry_${id+1}"> No expiration
                </td>
            </tr>
        `;
        $('#certificationsTableContainer tbody').append(html);
    })
    $('.addLinkRow').on('click', function() {
        var id = parseInt($(this).data('id'));
        var html = `
            <tr>
                <td>
                    <button type="button" class="btn btn-sm btn-success addLinkRow" data-rowid="${id+1}"><i class="fas fa-plus"></i></button>
                    <input type="hidden" name="row_id[]" value="${id+1}">
                </td>
                <td>
                    <select name="linkName_${id+1}" class="form-control" id="">
                        @foreach($linksType as $type)
                            <option value="{{$type}}">{{$type}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="link_${id+1}" class="form-control" ></td>
                </td>
            </tr>
        `;
        $('#linksTableContainer tbody').append(html);
    })
</script>
@endsection