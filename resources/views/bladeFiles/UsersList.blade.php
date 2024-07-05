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
            <h6 class="text-right text-bold page-heading">User Login Details </h6>

            <h6 class="font-weight-normal">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{url('/land')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">User Details</li>
                </ol>
              </nav>
            </h6>
          </div>
        </div>
      </div>
      <!-- START FIRST ROW -->
      <div class="row">
        <div class="col-6 flex-column d-flex stretch-card">
          <div class="row flex-grow">
            <div class="col-sm-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body p-2">

                  <div class="row">
                    <div class="row pt-3 mt-md-1">
                      <div class="col-md-4 col-sm-12">
                        <div class="d-flex flex-column purchase-detail-legend align-items-center" style="max-width:100px;">
                          <div id="circleProgress1" class="p-2"></div>
                          <div>
                            <p class="font-weight-medium text-dark text-small">Active HR</p>
                            <h3 class="font-weight-bold text-dark text-center  mb-0">{{$getAdminCnt}}</h3>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4 col-sm-12">
                        <div class="d-flex flex-column  purchase-detail-legend align-items-center" style="max-width:100px;">
                          <div id="circleProgress2" class="p-2"></div>
                          <div>
                            <p class="font-weight-medium text-dark text-small">Active Company</p>
                            <h3 class="font-weight-bold text-dark text-center  mb-0">{{$getCompanyCnt}}</h3>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4 col-sm-12">
                        <div class="d-flex flex-column  purchase-detail-legend align-items-center" style="max-width:100px;">
                          <div id="circleProgress3" class="p-2"></div>
                          <div>
                            <p class="font-weight-medium text-dark text-small">Active Candidate</p>
                            <h3 class="font-weight-bold text-dark text-center  mb-0">{{$getStudentCnt}}</h3>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-4 flex-column d-flex stretch-card">
          <div class="row flex-grow">
            <div class="col-sm-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">

                  <div class="row">
                    <div class="row pt-3 mt-md-1">
                      <div class="col-md-6 col-sm-12">
                        <div class="d-flex purchase-detail-legend align-items-center" style="max-width:150px;">
                          <div>
                            <p class="font-weight-medium text-dark text-small align-items-center">Total Active</p>
                            <h3 class="font-weight-bold text-dark align-items-center mb-0">{{$getActiveUsersCnt}}</h3>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6 col-sm-12">
                        <div class="d-flex purchase-detail-legend align-items-center" style="max-width:150px;">

                          <div>
                            <p class="font-weight-medium text-dark text-small align-items-center">Total In Active</p>
                            <h3 class="font-weight-bold text-dark align-items-center mb-0">{{$getInActiveUsersCnt}}</h3>
                          </div>
                        </div>
                      </div>


                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-2 flex-column d-flex stretch-card">
          <div class="row flex-grow">
            <div class="col-sm-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div>
                    <h3 class="font-weight-bold text-dark  mb-0 text-center">Total Users</h3>
                    <br>
                    <h1 class="font-weight-bold text-dark  mb-0 text-center">{{$totalUsrs}}</h3>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


      </div>

      <!-- END FIRST ROW -->
      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body p-3">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Human Resource</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Companies</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Candidate</button>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <form method="POST" id="AdminUpdateUserDtlsForm">

                    <button type="button" class="btnbtn-sm btn-success AdminUpdateUserBtn">
                      <i class="mdi mdi-pen"></i>
                    </button>
                    <button type="button" class="btn-danger AdminDeleteUserBtn">
                      <i class="mdi mdi-delete"></i>
                    </button>
                    <div class="table-responsive">
                      <table class="table table-hover dark_header">
                        <thead>
                          <tr>
                            <th>S.NO.</th>
                            <th>User ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <!-- <th>Phone</th> -->
                            <th>User Category</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php $i=1 @endphp
                          @foreach($getUserDetails['admins'] as $userDtls)
                          @php $encId = Crypt::encrypt($userDtls->id); @endphp
                          <tr>
                            <td class="d-flex align-items-center">{{$i}}.
                              <div class="form-check form-check-flat form-check-success">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input" name="loginid[]" value="{{$userDtls->id}}">
                                </label>

                              </div>
                              <!--<a href="{{url('admin/AddNewUsers/'.$encId)}}" class="mdi mdi-table-edit" style="color:#46c35f"></a>-->
                            </td>
                            <td>{{$userDtls->userid}}
                              <input type="hidden" name="user_id[{{$userDtls->id}}]" value="{{$userDtls->userid}}">
                            </td>
                            <td>
                              <input type="text" class="form-control" name="first_name[{{$userDtls->id}}]" value="{{$userDtls->first_name}}">
                            </td>
                            <td>
                              <input type="text" class="form-control" name="last_name[{{$userDtls->id}}]" value="{{$userDtls->last_name}}">
                            </td>

                            <td>
                              <input type="text" class="form-control" name="email_id[{{$userDtls->id}}]" value="{{$userDtls->email}}">
                            </td>
                            <!-- <td>{{$userDtls->phone}}</td> -->
                            <td>
                              <select class="form-control" name="user_cat[{{$userDtls->id}}]">
                                <option value="">Select</option>
                                <option value="HR" @if(isset($userDtls->user_cat) && $userDtls->user_cat =='HR') selected @endif>Human Resource</option>
                                <option value="Company" @if(isset($userDtls->user_cat) && $userDtls->user_cat=='Company') selected @endif>Company</option>
                                <option value="Student" @if(isset($userDtls->user_cat) && $userDtls->user_cat=='Student') selected @endif>Candidate</option>
                              </select>
                            </td>
                            <td>
                              <select class="form-control" name="active_status[{{$userDtls->id}}]">
                                <option value="">Select</option>
                                <option value="1" @if(isset($userDtls->isActive) && $userDtls->isActive =='1') selected @endif>Active</option>
                                <option value="0" @if(isset($userDtls->isActive) && $userDtls->isActive=='0') selected @endif>In-Active</option>
                              </select>

                            </td>
                          </tr>
                          @php $i++; @endphp
                          @endforeach

                        </tbody>
                      </table>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                  <form method="POST" id="CompanyUpdateUserDtlsForm">

                    <button type="button" class="btnbtn-sm btn-success CompanyUpdateUserBtn">
                      <i class="mdi mdi-pen"></i>
                    </button>
                    <button type="button" class="btn-danger CompanyDeleteUserBtn">
                      <i class="mdi mdi-delete"></i>
                    </button>
                    <div class="table-responsive">
                      <table class="table table-hover dark_header">
                        <thead>
                          <tr>
                            <th>S.NO.</th>
                            <th>User ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <!-- <th>Phone</th> -->
                            <th>User Category</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php $i=1 @endphp
                          @foreach($getUserDetails['companies'] as $userDtls)
                          @php $encId = Crypt::encrypt($userDtls->id); @endphp
                          <tr>
                            <td class="d-flex align-items-center">{{$i}}.
                              <div class="form-check form-check-flat form-check-success">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input" name="loginid[]" value="{{$userDtls->id}}">
                                </label>

                              </div>
                              <!--<a href="{{url('admin/AddNewUsers/'.$encId)}}" class="mdi mdi-table-edit" style="color:#46c35f"></a>-->
                            </td>
                            <td>{{$userDtls->userid}}
                              <input type="hidden" name="user_id[{{$userDtls->id}}]" value="{{$userDtls->userid}}">
                            </td>
                            <td>
                              <input type="text" class="form-control" name="first_name[{{$userDtls->id}}]" value="{{$userDtls->first_name}}">
                            </td>
                            <td>
                              <input type="text" class="form-control" name="last_name[{{$userDtls->id}}]" value="{{$userDtls->last_name}}">
                            </td>

                            <td>
                              <input type="text" class="form-control" name="email_id[{{$userDtls->id}}]" value="{{$userDtls->email}}">
                            </td>
                            <!-- <td>{{$userDtls->phone}}</td> -->
                            <td>
                              <select class="form-control" name="user_cat[{{$userDtls->id}}]">
                                <option value="">Select</option>
                                <option value="HR" @if(isset($userDtls->user_cat) && $userDtls->user_cat =='HR') selected @endif>Human Resource</option>
                                <option value="Company" @if(isset($userDtls->user_cat) && $userDtls->user_cat=='Company') selected @endif>Company</option>
                                <option value="Student" @if(isset($userDtls->user_cat) && $userDtls->user_cat=='Student') selected @endif>Candidate</option>
                              </select>
                            </td>
                            <td>
                              <select class="form-control" name="active_status[{{$userDtls->id}}]">
                                <option value="">Select</option>
                                <option value="1" @if(isset($userDtls->isActive) && $userDtls->isActive =='1') selected @endif>Active</option>
                                <option value="0" @if(isset($userDtls->isActive) && $userDtls->isActive=='0') selected @endif>In-Active</option>
                              </select>

                            </td>
                          </tr>
                          @php $i++; @endphp
                          @endforeach

                        </tbody>
                      </table>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                  <form method="POST" id="StudentUpdateUserDtlsForm">

                    <button type="button" class="btnbtn-sm btn-success StudentUpdateUserBtn">
                      <i class="mdi mdi-pen"></i>
                    </button>
                    <button type="button" class="btn-danger StudentDeleteUserBtn">
                      <i class="mdi mdi-delete"></i>
                    </button>
                    <div class="table-responsive">
                      <table class="table table-hover dark_header">
                        <thead>
                          <tr>
                            <th>S.NO.</th>
                            <th>User ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <!-- <th>Phone</th> -->
                            <th>User Category</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php $i=1 @endphp
                          @foreach($getUserDetails['students'] as $userDtls)
                          @php $encId = Crypt::encrypt($userDtls->id); @endphp
                          <tr>
                            <td class="d-flex align-items-center">{{$i}}.
                              <div class="form-check form-check-flat form-check-success">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input" name="loginid[]" value="{{$userDtls->id}}">
                                </label>

                              </div>
                              <!--<a href="{{url('admin/AddNewUsers/'.$encId)}}" class="mdi mdi-table-edit" style="color:#46c35f"></a>-->
                            </td>
                            <td>{{$userDtls->userid}}
                              <input type="hidden" name="user_id[{{$userDtls->id}}]" value="{{$userDtls->userid}}">
                            </td>
                            <td>
                              <input type="text" class="form-control" name="first_name[{{$userDtls->id}}]" value="{{$userDtls->first_name}}">
                            </td>
                            <td>
                              <input type="text" class="form-control" name="last_name[{{$userDtls->id}}]" value="{{$userDtls->last_name}}">
                            </td>

                            <td>
                              <input type="text" class="form-control" name="email_id[{{$userDtls->id}}]" value="{{$userDtls->email}}">
                            </td>
                            <!-- <td>{{$userDtls->phone}}</td> -->
                            <td>
                              <select class="form-control" name="user_cat[{{$userDtls->id}}]">
                                <option value="">Select</option>
                                <option value="HR" @if(isset($userDtls->user_cat) && $userDtls->user_cat =='HR') selected @endif>Human Resource</option>
                                <option value="Company" @if(isset($userDtls->user_cat) && $userDtls->user_cat=='Company') selected @endif>Company</option>
                                <option value="Student" @if(isset($userDtls->user_cat) && $userDtls->user_cat=='Student') selected @endif>Candidate</option>
                              </select>
                            </td>
                            <td>
                              <select class="form-control" name="active_status[{{$userDtls->id}}]">
                                <option value="">Select</option>
                                <option value="1" @if(isset($userDtls->isActive) && $userDtls->isActive =='1') selected @endif>Active</option>
                                <option value="0" @if(isset($userDtls->isActive) && $userDtls->isActive=='0') selected @endif>In-Active</option>
                              </select>
                            </td>
                          </tr>
                          @php $i++; @endphp
                          @endforeach

                        </tbody>
                      </table>
                    </div>
                  </form>
                </div>
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

  $('.AdminUpdateUserBtn').on('click', function() {

    var action = $(this).data('action');
    let formData = new FormData($('#AdminUpdateUserDtlsForm')[0]);
    formData.append('action', action);

    Swal.fire({
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
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '' + response.msg + '',
                  })
                  .then((response) => {
                    location.reload();
                  });
              } else {
                Swal.fire({
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
  $('.CompanyUpdateUserBtn').on('click', function() {

    var action = $(this).data('action');
    let formData = new FormData($('#CompanyUpdateUserDtlsForm')[0]);
    formData.append('action', action);

    Swal.fire({
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
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '' + response.msg + '',
                  })
                  .then((response) => {
                    location.reload();
                  });
              } else {
                Swal.fire({
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
  $('.StudentUpdateUserBtn').on('click', function() {

    var action = $(this).data('action');
    let formData = new FormData($('#StudentUpdateUserDtlsForm')[0]);
    formData.append('action', action);

    Swal.fire({
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
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '' + response.msg + '',
                  })
                  .then((response) => {
                    location.reload();
                  });
              } else {
                Swal.fire({
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

  $('.AdminDeleteUserBtn').on('click', function(e) {
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
            data: $('#AdminUpdateUserDtlsForm').serialize() + '&action=' + action,

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
  $('.CompanyDeleteUserBtn').on('click', function(e) {
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
            data: $('#CompanyUpdateUserDtlsForm').serialize() + '&action=' + action,

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
  $('.StudentDeleteUserBtn').on('click', function(e) {
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
            data: $('#StudentUpdateUserDtlsForm').serialize() + '&action=' + action,

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