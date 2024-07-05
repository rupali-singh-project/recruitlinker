@extends('layouts.master')

@section('styles')
<style>
  .select2-container {
    z-index: 1051;
    /* Set a higher z-index */
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
            <h6 class="text-right text-bold page-heading">Job Applications For <span class="badge text-dark"><a href="{{url('JobOverview/'.Crypt::encrypt($jobData->id))}}">{{$jobData->job_title}} </a></span></h6>

            <h6 class="font-weight-normal">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{url('/land')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Job Applications</li>
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
            <!-- <form action="" class="d-none border px-3 pb-1 pt-2 mb-2">
                    <div class="form-group d-inline-block">
                      <label for="" class="d-block">Education</label>
                      <select name="education" class="select2" style="width:240px" multiple>
                        @foreach($educationCategories as $education)
                        <option value="{{$education->code}}">{{$education->description}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group d-inline-block">
                      <label for="" class="d-block">Skills</label>
                      <select class="select2 form-control form-control-sm" style="width:200px" placeholder="Username" aria-label="Username" multiple>
                        @foreach($skillsCategories as $skill)
                          <option value="{{$skill->skill_name}}">{{$skill->skill_name}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group d-inline-block">
                      <label for="" class="d-block">Experience</label>
                      <select class="select2" style="width:200px" placeholder="Username" aria-label="Username">
                        <option value="*">Any</option>
                        <option value="Fresher">Fresher</option>
                        <option value="Experienced">Experienced</option>
                      </select>
                    </div>
                    <div class="form-group d-inline-block">
                      <label for="" class="d-block">Work Preference</label>
                      <select class="select2" style="width:200px" placeholder="Username" aria-label="Username">
                        <option value="">Any</option>
                        <option value="wfh">Work From Home</option>
                        <option value="wfo">Work From Office</option>
                        <option value="hybrid">Hybrid</option>
                      </select>
                    </div>
                    <div class="form-group d-inline-block">
                      <label for="" class="d-block">User Type</label>
                      <select class="select2" style="width:200px" placeholder="Username" aria-label="Username">
                        <option value="normal">Normal User</option>
                        <option value="premium">Premium</option>
                      </select>
                    </div>
                    <div class="form-group d-inline-block">
                      <label for="" class="d-block">City</label>
                      <input type="text" name="city" class="form-control form-control-sm" placeholder="eg. Mumbai, Pune etc.">
                    </div>
                    <button class="btn btn-sm btn-success">Apply Filters</button>
                  </form> -->
            <form class="form-sample" action="{{url('createNewJob')}}" method="POST">
              @csrf
              <div class="d-flex justify-content-around">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>S No.</th>
                      <th>Candidate Name</th>
                      <th>Profile Title</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Resume</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($applicationsList as $application)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td style="font-weight: bold;">{{$application->first_name}} {{$application->last_name}}</td>
                      <td>{{$application->profile_title}}</td>
                      <td>{{$application->email}}</td>

                      <td>{{$application->phone}}</td>
                      <td>
                        @if($application->resume)
                        <a href="{{asset('public/uploads/profile/resume/'.$application->resume)}}"><i class="fas fa-file-pdf text-danger"></i></a>
                        @else
                        <span class="text-secondary">N/A</span>
                        @endif
                      </td>
                      <td>
                        <span class="badge badge-danger">{{$application->jobStatus}} - {{$application->application_status}}</span>
                      </td>
                      <td>
                        @if($user_cat=='Admin' || $user_cat=='HR')
                        @if($application->jobStatus=='APPLIED')
                        <button type="button" data-studentid="{{$application->studentId}}" class="approveBtn btn btn-sm btn-success text-nowrap"><i class="fas fa-check-circle"></i> Approve</button>
                        <button type="button" data-studentid="{{$application->studentId}}" class="rejectBtn btn btn-sm btn-danger text-nowrap"><i class="fas fa-times-circle"></i> Reject</button>
                        @else
                        <button disabled class="approveBtn btn btn-sm btn-success text-nowrap"><i class="fas fa-check-circle"></i> Approve</button>
                        <button disabled class="rejectBtn btn btn-sm btn-danger text-nowrap"><i class="fas fa-times-circle"></i> Reject</button>
                        @endif
                        @endif

                        @if($user_cat=='Company')
                        @if($application->jobStatus =='INTERVIEWED')
                        @if($application->application_status !='Hired' && $application->application_status !='Rejected')
                        <button type="button" data-mappingid="{{Crypt::encrypt($application->mapping_id)}}" class="btn btn-info interview_status_update_btn"><i class="fas fa-edit"></i>Update Status</button>
                        @endif
                        @elseif($application->jobStatus!='INTERVIEWED')
                        <button type="button" data-mappingid="{{Crypt::encrypt($application->mapping_id)}}" class="btn btn-sm btn-success text-nowrap interview_schedule_btn" data-bs-toggle="modal" data-bs-target="#scheduleInterviewModal"><i class="fas fa-plus-circle"></i> Schedule Interview</button>
                        @endif

                        @endif

                        <button type="button" data-mappingid="{{Crypt::encrypt($application->mapping_id)}}" class="btn btn-warning interview_status_log_btn"><i class="fas fa-history"></i></button>
                        <a href="{{url('student/profile/view/'.Crypt::encrypt($application->studentId))}}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> View Profile</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- modal code -->
    <div class="modal fade" id="assignJobFormModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <form id="job_question_form">

              <button class="btn btn-sm btn-success" id="assignStudentsBtn">Assign Candidates</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="scheduleInterviewModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header py-2 bg-success text-light">
            Schedule Interview
          </div>
          <div class="modal-body">
            <form id="interview_schedule_form">
              @csrf
              <div class="form-group">
                <label for="">Interview Date & Time</label>
                <input type="datetime-local" name="datetime" class="form-control">
              </div>
              <div class="form-group">
                <label for="">Instructions</label>
                <textarea name="instructions" class="form-control" rows="10" placeholder="Enter your instructions here e.g. Please have a good internet connection while interviewing etc."></textarea>
              </div>
              <input type="hidden" name="job_mapping_id" id="job_mapping_id">
              <button class="btn btn-success">Schedule</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="updateJobInterviewStatusModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header py-2 bg-success text-light">
            Update Job Application Status
          </div>
          <div class="modal-body">
            <form id="interview_status_form">
              @csrf
              <div class="form-group">
                <label for="">Status</label>
                <select name="status" id="job_application_status" class="form-select">

                </select>
              </div>
              <div class="form-group">
                <label for="">Message</label>
                <textarea name="message" id="job_application_message" class="form-control" placeholder="Enter your message here.."></textarea>
              </div>
              <input type="hidden" name="job_mapping_id" id="update_job_mapping_id">
              <button class="btn btn-success">Update Status</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="updateJobInterviewLogsModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header py-2 bg-success text-light">
            Job Application Logs
          </div>
          <div class="modal-body">
            <table class="table table-md table-bordered">
              <thead>
                <tr>
                  <th class="text-nowrap">S No.</th>
                  <th class="text-nowrap">Created On</th>
                  <th>Status</th>
                  <th>Message</th>
                  <th class="text-nowrap">Created By</th>
                </tr>
              </thead>
              <tbody id="jobApplicationLogContainer">

              </tbody>
            </table>
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
        placeholder: "Select"
      });


      $('.approveBtn').on('click', function(e) {
        e.preventDefault();
        //alert("test");
        var job_id = {{$jobid}};
        //alert(job_id);
        var studentId = $(this).data('studentid');
        $.ajax({
          url: "{{url('admin/job/application/approve')}}",
          method: "POST",
          data: {
            job_id: job_id,
            student_id: studentId
          },
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
      $('.rejectBtn').on('click', function(e) {
        e.preventDefault();
        var job_id = {{$jobid}};
        var studentId = $(this).data('studentid');
        $.ajax({
          url: "{{url('admin/job/application/reject')}}",
          method: "POST",
          data: {
            job_id: job_id,
            student_id: studentId
          },
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
      $('.interview_schedule_btn').on('click', function() {
        $('#job_mapping_id').val($(this).data('mappingid'));
        $('#scheduleInterviewModal').modal('show');
      })
      $('#interview_schedule_form').on('submit', function(e) {
        e.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
          url: "{{url('admin/job/interview/schedule')}}",
          method: "POST",
          data: form_data,
          success: function(response) {
            if (response.status == 200) {
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '' + response.msg + '',
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '' + response.msg + '',
              }).then(() => {
                location.reload();
              });
            }
          }
        });
      })

      $('.interview_status_log_btn').on('click', function() {
        $.ajax({
          url: "{{url('student/job/application/log/fetch')}}/" + $(this).data('mappingid'),
          method: "GET",
          success: function(response) {
            if (response.status == 200) {
              $('#jobApplicationLogContainer').html(response.logs_html);
              $('#updateJobInterviewLogsModal').modal('show');
            }
          }
        });
      })
      $('.interview_status_update_btn').on('click', function() {
        $('#update_job_mapping_id').val($(this).data('mappingid'));
        $.ajax({
          url: "{{url('student/job/application/status/fetch')}}/" + $(this).data('mappingid'),
          method: "GET",
          success: function(response) {
            if (response.status == 200) {
              $('#job_application_status').html(response.options_list)
              $('#job_application_message').html(response.message)
              $('#updateJobInterviewStatusModal').modal('show');
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '' + response.msg + '',
              }).then(() => {
                location.reload();
              });
            }
          }
        });
      })
      $('#interview_status_form').on('submit', function(e) {
        e.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
          url: "{{url('student/job/application/status/update')}}",
          method: "POST",
          data: form_data,
          success: function(response) {
            if (response.status == 200) {
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '' + response.msg + '',
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '' + response.msg + '',
              });
            }
          }
        });
      })
    </script>
    @endsection