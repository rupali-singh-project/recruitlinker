@extends('layouts.master')

@section('styles')
<style>
  .card {
    box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
  }

  .card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0 solid rgba(0, 0, 0, .125);
    border-radius: 1rem;
  }

  .card-body {
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.5rem 1.5rem;
  }

  .avatar-text {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    background: #000;
    color: #fff;
    font-weight: 700;
  }

  .avatar {
    width: 3rem;
    height: 3rem;
  }

  .rounded-3 {
    border-radius: 0.5rem !important;
  }

  .mb-2 {
    margin-bottom: 0.5rem !important;
  }

  .me-4 {
    margin-right: 1.5rem !important;
  }

  .select2-container {
    z-index: 1051;
    /* Set a higher z-index */
  }

  /* ribbon styles */
  .ribbon-parent {
    position: relative;
  }

  .ribbon {
    width: auto;
    font-size: 12px;
    padding: 3px 5px;
    position: absolute;
    right: -10px;
    top: -10px;
    text-align: center;
    border-radius: 25px;
    transform: rotate(0deg);
    color: white;
    z-index: 100;
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
            <h6 class="text-right text-bold page-heading">Assign Job</h6>

            <h6 class="font-weight-normal">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{url('/land')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Assign Job</li>
                </ol>
              </nav>
            </h6>
          </div>
        </div>
      </div>
      <!-- START FIRST ROW -->
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body w-100" style="min-height: 450px;">
            @if(count($jobs)==0)
            <div class="col-12 p-0">
              <div class="p-5 text-center" style="border:2px dotted #0ddbb9 !important">
                <h2>No Jobs Found!</h2>
              </div>
            </div>
            @endif
            <form class="form-sample" action="{{url('createNewJob')}}" method="POST">
              @csrf
              <div class="">
                @foreach($jobs as $job)
                @php $encId = Crypt::encrypt($job->id); @endphp
                <div class="card mb-3">
                  <div class="card-body">
                    <div class="d-flex flex-column flex-lg-row">
                      @if($job->company_logo!='' && $job->company_logo!=null)
                      <img src="{{asset('public/uploads/company/logo/'.$job->company_logo)}}" class="img-fluid avatar-xxl rounded-circle rounded-3 me-4 mb-2" alt="" style="height:60px;width:60px;">
                      @else
                      <img src="{{asset('public/uploads/company/logo/default-logo.png')}}" class="img-fluid avatar-xxl rounded-circle rounded-3 me-4 mb-2" alt="" style="height:60px;width:60px;">
                      @endif

                      <div class="row flex-fill">
                        <div class="col-sm-5">
                          <h4 class="h5"><a href="{{url('JobOverview/'.$encId)}}">{{$job['company_name']}} - {{$job['job_title']}}</a></h4>
                          <p><span>Exp: {{$job['min_exp']}}-{{$job['max_exp']}} Years</span> <span>| Openings: {{$job['opening']}}</span> <span>| Posted On: {{$job['created_at']}}</span></p>
                          <span class="badge bg-secondary">Employee Type: {{$job['employee_type'] ?? 'N/A'}}</span>
                          <span class="badge bg-success">Location: {{$job['location'] ?? 'N/A'}} </span>
                        </div>
                        <div class="col-sm-4 py-2">
                          @foreach(explode(',',$job['skills']) as $skill)
                          <span class="badge bg-secondary">{{$skill}}</span>
                          @endforeach
                        </div>
                        <div class="col-sm-3 text-lg-end">
                          <a href="#" class="assignStudentForJobBtn btn btn-sm btn-outline btn-outline-info mb-0" id="" data-jobid="{{$job['id']}}" title="Assign candidates to this job">Assign</a>
                          <a href="{{url('admin/job/'.$job['id'].'/applications/view')}}" class="btn btn-sm btn-outline btn-outline-primary mb-0 " title="See candidates who applied to this job"><i class="fas fa-link"></i></a>
                          @if($job['isActive']!=2)
                          <a href="#" class="btn btn-sm btn-outline btn-outline-danger mb-0 listingActionBtn px-2" data-jobid="{{$job['id']}}" data-action="REMOVE" title="Add this job to listing"><i class="fas fa-eye-slash"></i></a>
                          @else
                          <button href="#" class="btn btn-sm btn-outline btn-outline-success mb-0 listingActionBtn" data-jobid="{{$job['id']}}" data-action="ADD" title="Remove this job from listing"><i class="fas fa-check"></i></button>
                          @endif
                          <a href="{{url('AddNewJob/'.$encId)}}" class="btn btn-sm btn-outline btn-outline-success" title="Edit this job">
                            <i class="fa fa-edit"></i>
                          </a>
                          <!-- <a href="#" class="btn btn-sm btn-primary">Apply</a> -->
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
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
              @csrf
              <p>Select Candidates</p>
              <input type="hidden" name="selected_job_id" value="" id="selected_job_id">
              <select name="students[]" class="form-control" multiple id="students_list">
                @foreach($studentsList as $student)
                <option value="{{$student->id}}">{{$student['first_name']}} {{$student['last_name']}} - [{{$student['userid']}}]</option>
                @endforeach
              </select>
              <button class="btn btn-sm btn-success" id="assignStudentsBtn">Assign Candidates</button>
            </form>
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
      $('.assignStudentForJobBtn').on('click', function() {
        $('#selected_job_id').val($(this).data('jobid'));
        $('#assignJobFormModal').modal('show');
      })

      $('.listingActionBtn').on('click', function(e) {
        e.preventDefault();
        var job_id = $(this).data('jobid');
        var action = $(this).data('action');
        $.ajax({
          url: "{{url('admin/job/')}}/" + job_id + "/listing/update",
          method: "GET",
          data: {
            action: action
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
              $('#assignJobFormModal').modal('hide');
            }
          }
        });
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
          beforeSend: function() {
            $('#assignJobFormModal').modal('hide');
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