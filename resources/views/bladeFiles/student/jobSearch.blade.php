@extends('layouts.master')

@section('styles')
<style>
    .new {
        font-size: 12px;
    }

    .card {

        padding: 20px;
        border: none;


    }


    .active {

        background: #f6f7fb !important;
        border-color: #f6f7fb !important;
        color: #000 !important;
        font-size: 12px;

    }

    .inputs {

        position: relative;

    }

    .form-control {
        text-indent: 15px;
        border: none;
        height: 45px;
        border-radius: 0px;
        border-bottom: 1px solid #eee;
    }

    .form-control:focus {
        color: #495057;
        background-color: #fff;
        border-color: #eee;
        outline: 0;
        box-shadow: none;
        border-bottom: 1px solid blue;
    }


    .form-control:focus {
        color: blue;
    }

    .inputs i {

        position: absolute;
        top: 14px;
        left: 4px;
        color: #b8b9bc;
    }

    .star {

        height: 60px;
        width: 60px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #eee;
        margin-right: 10px;
        border-radius: 5px;

    }

    .time-text {

        font-size: 13px;
        color: #989898;
    }

    .dots {

        height: 7px;
        width: 7px;
        background-color: #eee;
        display: flex;
        border-radius: 50%;
        margin-left: 7px;
        margin-right: 7px;
    }

    .yellow {

        color: #ffab2e;
    }



    .blue {

        color: #6ecce6;
    }


    .content-text-2 {

        height: 40px;
        width: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        background-color: #e2f5fa;
        color: #6ecce6;
        font-weight: 700;

    }


    .dark-blue {

        color: #572ce8;
    }


    .content-text-3 {

        height: 40px;
        width: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        background-color: #572ce86b;
        color: #572ce8;
        font-weight: 700;

    }

    .job-box:hover {
        /* background-color: #dff9fb; */
        border-left: 4px solid #22a6b3;
    }
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
                        <!-- <h3 class="text-dark font-weight-bold mb-2">User Login Details!</h3> -->
                        <h6 class="text-right text-bold page-heading">Search Jobs</h6>

                        <h6 class="font-weight-normal">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{url('/land')}}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Search Jobs</li>
                                </ol>
                            </nav>
                        </h6>
                    </div>
                </div>
            </div>
            <div class="col-12">

                <div class="card">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Location</label>
                                <input type="text" name="location" id="location" class="form-control" placeholder="Enter location e.g. Delhi, ITO">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Experience</label>
                                <select name="" id="experience" class="form-control">
                                    <option value="F">Fresher</option>
                                    <option value="E1"> 1-3 Year</option>
                                    <option value="E2"> 3-5 Year</option>
                                    <option value="E3"> 5-7 Year</option>
                                    <option value="E4"> 7-10 Year</option>
                                    <option value="E5"> >10 Year</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Education</label>
                                <select name="" id="education" class="form-control">
                                    @foreach($educationCategory as $education)
                                    <option value="{{$education->code}}">{{$education->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Skills</label>
                                <select name="" id="skills" class="form-control">
                                    <option value="">Choose skills</option>
                                    @foreach($skills as $skill)
                                    <option value="{{$skill->skill_name}}">{{$skill->skill_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-0 inputs">
                        <i class="fa fa-search"></i>
                        <input type="text" class="form-control d-inline-block " style="width:85%" id="search_text" placeholder="Enter Job Title, Description or any keyword e.g. Full Stack Developer or Business Development Manager">
                        <button class="btn btn-warning d-inline" id="searchJobBtn">Search Jobs</button>
                    </div>
                    <div id="jobs_list_container" class="mt-3">

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
        placeholder: 'Select Candidate'
    });

    let current_page_number = 1;

    $(document).on('change', '#page_number_dropdown', function() {
        current_page_number = $(this).val();
        fetchJobs($(this).val());
    })

    fetchJobs(1);

    $('#searchJobBtn').on('click', function() {
        fetchJobs(1);
    })

    function fetchJobs(page_number) {
        $.ajax({
            url: "{{url('student/jobs/fetch')}}",
            method: "POST",
            data: {
                location: $('#location').val(),
                experience: $('#experience').val(),
                education: $('#education').val(),
                skills: $('#skills').val(),
                search_text: $('#search_text').val(),
                page_number: page_number
            },
            success: function(response) {
                if (response.status == 200) {
                    jobs_list_html = '<div>';
                    jobs_list = response.jobs;
                    if (jobs_list.length == 0) {
                        $('#jobs_list_container').html(`<div class="mt-2 text-secondary" style="border:2px dotted #bdc3c7">
                            <h2 class="text-center py-5 m-3">No Jobs Found! Try changing search filters.</h2>
                        </div>`);
                    } else {

                        for (var i = 0; i < jobs_list.length; i++) {
                            jobs_list_html += `
                            <div class="my-3 job-box">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex flex-row align-items-center">
                                        <span class="star">`;
                            if (jobs_list[i].company_logo != null)
                                jobs_list_html += `<img class="company-logo" src="{{asset('public/uploads/company/logo')}}/${jobs_list[i].company_logo}" style="width:60px;height:60px" alt="user">`;
                            else
                                jobs_list_html += `<img class="company-logo" src="{{asset('public/uploads/company/logo/default-logo.png')}}" style="width:60px;height:60px" alt="user">`;
                            jobs_list_html += `</span>
                                        <div class="d-flex flex-column">
                                            <span style="font-size:19px;font-weight:600;">${jobs_list[i].job_title}<i class="fas fa-check-circle text-success" style="font-size:12px;margin-left:5px;"></i></span>
                                            <span style="font-size:19px;overflow-y:hidden;display:inline-block;max-height:130px">${jobs_list[i].job_desc}</span>
                                            <div class="d-flex flex-row align-items-center time-text mt-2" style="font-size:15px">
                                                <small><b>Company</b> : ${jobs_list[i].company_name} </small>
                                                <span class="dots"></span>
                                                <small><b>Salary</b> : ${jobs_list[i].salary} ${jobs_list[i].currency}</small>
                                                <span class="dots"></span>
                                                <small><b>Skills</b> : ${jobs_list[i].skills}</small>
                                                <span class="dots"></span>
                                                <small><b>Last Date To Apply</b> : ${jobs_list[i].job_deadline}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2"> 
                                        `;
                            if (jobs_list[i].job_status == null || jobs_list[i].job_status == 'CREATED' || jobs_list[i].job_status == 'ASSIGNED')
                                jobs_list_html += `<a href="{{url('JobOverview')}}/${jobs_list[i].enc_id}" target="_blank" class="btn btn-sm btn-outline btn-outline-success text-nowrap" style="width:80px"><i class="fas fa-check-circle"></i>Apply`;
                            else
                                jobs_list_html += `<a href="{{url('JobOverview')}}/${jobs_list[i].enc_id}" target="_blank" class="btn btn-sm btn-outline btn-outline-primary text-nowrap" style="width:80px"><i class="fas fa-eye"></i>View`;
                            jobs_list_html += `</a>
                                        
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            `;

                        }
                        // PAGINATION
                        jobs_list_html += `<div class="text-center border"><button class="btn btn-sm btn-outline-primary mr-2"><i class="fas fa-chevron-circle-left" style="margin-right:5px"></i>Previous Page</button><select class="form-select form-sm d-inline-block" style="width:100px;margin:0 10px;" id="page_number_dropdown">`;
                        for (var j = 1; j <= response.total_pages; j++) {
                            jobs_list_html += `<option value="${j}"`
                            if (current_page_number == j) {
                                jobs_list_html += ' selected="selected"';
                            }
                            jobs_list_html += `>Page ${j}</option>`;
                        }
                        jobs_list_html += `</select><button class="btn btn-sm btn-outline-info ml-2">Next Page<i class="fas fa-chevron-circle-right ml-2" style="margin-left:5px"></i></button></div>`;
                        $('#jobs_list_container').html(jobs_list_html);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '' + response.msg + '',
                    });
                }
            }
        });
    }
</script>
@endsection