@extends('layouts.master')

@section('content')

<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-12 mb-4 mb-xl-0">
          <div class="d-flex align-items-center justify-content-between">
            <!-- <h3 class="text-dark font-weight-bold mb-2">User Login Details!</h3> -->
            <h6 class="text-right text-bold page-heading">Jobs Details</h6>

            <h6 class="font-weight-normal">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{url('/land')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Jobs Details</li>
                </ol>
              </nav>
            </h6>
          </div>
        </div>
      </div>

      <!-- END FIRST ROW -->
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form method="POST" id="UpdateUserDtlsForm">

                <div class="table-responsive">

                  <table class="table table-hover dark_header">
                    <thead>
                      <tr>
                        <th>S.NO.</th>
                        <th>Job Title</th>
                        <th>Industry Type</th>
                        <th>Employee Type</th>
                        <th>Opening</th>
                        <th>Salary</th>
                        <th>Experience (In Year)</th>
                        <th>Job Deadline</th>
                        <th>Status</th>
                        <th>Action
                        <th>
                      </tr>
                    </thead>
                    <tbody>
                      @php $i=1 @endphp
                      @foreach($getJobsDetails as $jobsDtls)
                      @php $encId = Crypt::encrypt($jobsDtls->id); @endphp
                      <tr>
                        <td class="text-center text-nowrap">{{$i}}.</td>
                        <td>{{$jobsDtls->job_title}}</td>
                        <td>{{$jobsDtls->industry_type}}</td>
                        <td>
                        @if($jobsDtls->employee_type=='Full-Time')   
                        <span class="badge" style="background-color:#58d8a3;">{{$jobsDtls->employee_type}}</span>
                        @else
                        <span class="badge" style="background-color:#f2a654;">{{$jobsDtls->employee_type}}</span>
                        @endif
                        
                        </td>
                        <td>{{$jobsDtls->opening}}</td>
                        <td>{{$jobsDtls->currency}} {{$jobsDtls->salary}}</td>
                        <td>{{$jobsDtls->experience_min}} - {{$jobsDtls->experience_max}} Years</td>
                        <td>{{$jobsDtls->job_deadline}}</td>
                        <td>
                          @if($jobsDtls->status=='Pending')
                          <button type="button" class="btn btn-xs btn-warning btn-rounded btn-fw">{{$jobsDtls->status}}</button>
                          @elseif($jobsDtls->status=='Approved')
                          <button type="button" class="btn btn-xs btn-success btn-rounded btn-fw">{{$jobsDtls->status}}</button>
                          @elseif($jobsDtls->status=='Rejected')
                          <button type="button" class="btn btn-xs btn-danger btn-rounded btn-fw">{{$jobsDtls->status}}</button>
                          @else
                          <button type="button" class="btn btn-xs btn-primary btn-rounded btn-fw">N/A</button>
                          @endif
                        </td>
                        <td>
                          <a href="{{url('AddNewJob/'.$encId)}}" class="text-danger">
                            <i class="mdi mdi-pencil"></i>
                          </a>
                          <!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">Click for demo<i class="mdi mdi-play-circle ml-1"></i></button> -->
                          <a href="{{url('admin/job/'.$jobsDtls->id.'/applications/view')}}" class="mdi mdi-eye" data-toggle="modal" data-target="#exampleModal1" style="color:#0ad7f7"></a>
                        </td>
                      </tr>
                      @php $i++; @endphp
                      @endforeach

                    </tbody>
                  </table>

                </div>

            </div>
            </form>
          </div>
        </div>

        <!-- MODEL START FROM HERE -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Modal body text goes here.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal Ends -->
        <!-- MODEL END HERE -->

        <script>
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          })

          $('.UpdateUserBtn').on('click', function(e) {
            e.preventDefault();
            alert("wegd");
            var action = $(this).data('action');
            let formData = new FormData($('#UpdateUserDtlsForm')[0]);
            formData.append('action', action);

            swal({
                title: "Are you sure?",
                text: 'Update this Data',
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {

                  $.ajax({
                    url: "{{url('admin/updateMultiNewUser')}}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                      if (response.status == '1') {
                        swal({
                            icon: 'success',
                            title: 'Success',
                            text: '' + response.msg + '',
                          })
                          .then((response) => {
                            location.reload();
                          });
                      } else {
                        swal({
                          icon: 'error',
                          title: 'Error',
                          text: '' + response.msg + '',
                        })

                      }
                    }
                  });

                }

              });

          })
        </script>
        <script>
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          })

          $('.DeleteUserBtn').on('click', function(e) {
            e.preventDefault();

            var action = $(this).data('action');
            swal({
                title: "Are you sure?",
                text: '' + action + ' this Data',
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {

                  $.ajax({
                    url: "{{url('admin/deleteMultiNewUser')}}",
                    type: "POST",
                    data: $('#UpdateUserDtlsForm').serialize() + '&action=' + action,

                    success: function(response) {
                      swal({
                          icon: 'success',
                          title: 'Success',
                          text: '' + response.msg + '',
                        })
                        .then((response) => {
                          location.reload();
                        });
                    }

                  });

                }
              });

          })
        </script>

        @endsection