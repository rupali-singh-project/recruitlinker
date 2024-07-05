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
        <div class="col-12 mb-4 mb-xl-0">
          <div class="d-flex align-items-center justify-content-between">
            <!-- <h3 class="text-dark font-weight-bold mb-2">User Login Details!</h3> -->
            <h6 class="text-right text-bold page-heading">Apply Job</h6>

            <h6 class="font-weight-normal">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{url('/land')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Apply Job</li>
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
            <section>
              <h4 class="mt-5 mb-4">{{$companyData->company_name}}</h4>
              <p>Location: {{$companyData->location}}</p>
              <p>Description: {{$companyData->company_desc}}</p>
              <p>Job Title: {{$jobData->job_title}}</p>
              <p>Job Description: {!! $jobData->job_desc !!}</p>
              <p>Salary : {{$jobData->salary}} {{$jobData->currency}}</p>
            </section>
            <form method="POST" action="{{url('job/'.$jobId.'/form/apply')}}">
              @csrf
              <div class="border-bottom border-secondary mb-2">
                @foreach($companySpecificQuestions as $question)
                <div class="form-group">
                  <input type="hidden" name="questionId[]" value="{{$question->id}}">
                  <label for="">{{$question->question}}</label>
                  <textarea class="form-control" name="question_{{$question->id}}" id="" placeholder=""></textarea>
                </div>
                @endforeach
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Profile</label>
                <select name="profile" id="" class="form-control">
                  <option value="1">Choose Profile</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Apply</button>
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