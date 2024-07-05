@extends('layouts.master')

@section('styles')
<style>
.select2-container {
  z-index: 1051; /* Set a higher z-index */
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
                    <h6 class="text-right text-bold page-heading">Job Applications</h6>

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
                <div class="card-body">
                  <form method="POST" action="{{url('admin/mail/setting/update')}}">
                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Host</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="host" id="exampleInputUsername2" placeholder="Username">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Mailer Type</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="mailer_type" value="smtp" placeholder="Email">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputMobile" class="col-sm-3 col-form-label">protocol</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="protocol" id="exampleInputMobile" placeholder="Mobile number">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Port</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="port" id="exampleInputPassword2" placeholder="Password">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Username</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="username" id="exampleInputPassword2" placeholder="Password">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Password</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="password" id="exampleInputPassword2" placeholder="Password">
                      </div>
                    </div>
                    

                    
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
            </div>

    <!-- modal code -->
    <div class="modal fade" id="assignJobFormModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body" >
            <form id="job_question_form">
              
              <button class="btn btn-sm btn-success" id="assignStudentsBtn">Assign Students</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endsection

  @section('scripts')
  <script>
    $.ajaxSetup({
      headers:{
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
      }
    })

    $('.select2').select2({
    });


    $('.rejectBtn').on('click', function(e){
      e.preventDefault();
      var studentId = $(this).data('studentid');
      $.ajax({    
        url:"{{url('admin/job/application/reject')}}",    
        method:"POST",    
        data: {
          job_id:job_id,
          student_id:studentId
        },
        success:function(response){
          if(response.status==1)
          {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: ''+response.msg+'',
            });
          }
        } 
      });
    })
  </script>
  @endsection
