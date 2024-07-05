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
                        <!-- <h3 class="text-dark font-weight-bold mb-2">User Login Details!</h3> -->
                        <h6 class="text-right text-bold page-heading">Your Jobs</h6>

                        <h6 class="font-weight-normal">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{url('/land')}}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Your Jobs</li>
                                </ol>
                            </nav>
                        </h6>
                    </div>
                </div>
            </div>
            <!-- START FIRST ROW -->
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body w-100">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="assigned-tab" data-bs-toggle="tab" data-bs-target="#assigned" type="button" role="tab" aria-controls="assigned" aria-selected="true">Assigned</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="self-applied-tab" data-bs-toggle="tab" data-bs-target="#self-applied" type="button" role="tab" aria-controls="self-applied" aria-selected="false">Self Applied</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="assigned" role="tabpanel" aria-labelledby="assigned-tab">
                                <div class="table-wrap">
                                    <table class="table table-bordered  table-responsive">
                                        <thead>
                                            <tr class="border">
                                                <th class="text-dark text-bold fw-600">Job</th>
                                                <th class="text-dark text-bold fw-600">Created On</th>
                                                <th class="text-dark text-bold fw-600">Opening</th>
                                                <th class="text-dark text-bold fw-600">Experience</th>
                                                <th class="text-dark text-bold fw-600">Salary</th>
                                                <th class="text-dark text-nowrap text-bold fw-600">Job Deadline</th>
                                                <th class="text-dark text-bold fw-600">Skills</th>
                                                <th class="text-dark text-bold fw-600">Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($assignedJobsData as $job)
                                            <tr class="align-middle alert" role="alert">

                                                <td class="w-25">
                                                    <div class="d-flex align-items-center">
                                                        <div class="img-container">
                                                            <img src="https://images.pexels.com/photos/2379005/pexels-photo-2379005.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" alt="" style="width:40px;height:auto !important">
                                                        </div>
                                                        <div class="ps-3">
                                                            <div class="fw-600 pb-1">{{$job['job_title']}}</div>
                                                            <!--<p class="m-0 text-grey text-left fs-09"><a href="{{url('company/profile/get/'.Crypt::encrypt($job['company_id']))}}">{{$job['company_name']}}</a></p>-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="fw-600 text-muted px-3">{{$job['created_at'] }}</div>
                                                </td>
                                                <td>
                                                    <div class="fw-600 text-muted px-3">{{$job['opening'] }}</div>
                                                </td>
                                                <td>
                                                    <div class="fw-600 text-muted px-3">{{$job['experience_min'] }} - {{$job['experience_max'] }} Years</div>
                                                </td>
                                                <!-- <td >{{$job['created_at']}}</td> -->
                                                <td class="text-nowrap px-2"><span class="badge badge-info">{{$job['salary']}} {{$job['currency']}}</span></td>
                                                <td class="text-danger font-bold">{{date('d-M-Y',strtotime($job['job_deadline']))}}</td>
                                                <td>
                                                    @foreach(explode(",",$job['skills']) as $skill)
                                                    <span class="badge badge-success">{{$skill}}</span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if($job['jobStatus'] == 'INTERVIEWED')
                                                    <span class="badge badge-danger">Interview - {{$job['current_job_status']}}</span>
                                                    @else
                                                    {!! app('App\Http\Controllers\StudentController')->getStatusBadge($job['jobStatus']) !!}

                                                    @endif
                                                </td>
                                                <td class="text-nowrap">
                                                    @if($job['is_applied']=='1')
                                                    <a href="{{url('JobOverview/'.Crypt::encrypt($job['id']))}}" class="text-nowrap btn btn-success btn-sm" title="See Application"><i class="fas fa-eye"></i></a>
                                                    @else
                                                    <a href="{{url('JobOverview/'.Crypt::encrypt($job['id']))}}" class="text-nowrap btn btn-sm btn-warning"><i class="fas fa-check-circle"></i>Apply</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="self-applied" role="tabpanel" aria-labelledby="self-applied-tab">
                                <div class="table-wrap">
                                    <table class="table table-borderless table-responsive">
                                        <thead>
                                            <tr class="border">
                                                <th></th>
                                                <th class="text-muted fw-600">Job</th>
                                                <th class="text-muted fw-600">Job Description</th>
                                                <th class="text-muted fw-600">Created On</th>
                                                <th class="text-muted fw-600">Salary</th>
                                                <th class="text-muted fw-600">Job Deadline</th>
                                                <th class="text-muted fw-600">Skills</th>
                                                <th class="text-muted fw-600">Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($selfAppliedJobsData as $job)
                                            <tr class="align-middle alert" role="alert">
                                                <td class="text-nowrap">
                                                    <input type="checkbox" id="check">
                                                    <div class="btn btn-danger btn-xs p-1" data-bs-dismiss="alert">
                                                        <span class="fas fa-times"></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="img-container">
                                                            <img src="https://images.pexels.com/photos/2379005/pexels-photo-2379005.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" alt="">
                                                        </div>
                                                        <div class="ps-3">
                                                            <div class="fw-600 pb-1">{{$job['job_title']}}</div>
                                                            <p class="m-0 text-grey fs-09">Company: xyz</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="w-25">
                                                    <div class="fw-600">{!! $job['job_desc'] !!}</div>
                                                </td>
                                                <td>{{$job['created_at']}}</td>
                                                <td class="text-nowrap px-2">{{$job['salary']}} {{$job['currency']}}</td>
                                                <td class="w-25">{{$job['job_deadline']}}</td>
                                                <td class="w-25">{{$job['skills']}}</td>
                                                <td>
                                                    <div class="d-inline-flex align-items-center active">
                                                        <div class="circle"></div>
                                                        <div class="ps-2">Active</div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- modal code -->
        <div class="modal fade" id="assignJobFormModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">

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

            $('#assignStudentsBtn').on('click', function(e) {
                e.preventDefault();
                var job_id = $('#selected_job_id').val();
                $.ajax({
                    url: "{{url('admin/job/assignStudent')}}",
                    method: "POST",
                    data: {
                        job_id: job_id,
                        student_ids: $('#students_list').val()
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: '' + response.msg + '',
                            });
                            $('#assignJobFormModal').modal('hide');
                        }
                    }
                });
            })
        </script>
        @endsection