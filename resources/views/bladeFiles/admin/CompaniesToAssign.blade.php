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



      <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body p-3">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Not Assigned</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Assigned</button>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <form method="POST" id="AdminUpdateUserDtlsForm">

                    <button type="button" class="btnbtn-sm btn-success AssignRecuiterBtn">
                      <i class="mdi mdi-pen"></i>
                    </button>
                  
                    <div class="table-responsive">
                      <table class="table table-hover dark_header">
                        <thead>
                          <tr>
                            <th>S.NO.</th>
                            <th>Company Name</th>
                            <th>No. of Employee</th>
                            <th>Location</th>
                            <th>Recruiters</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php $i=1 @endphp
                          @foreach($getCompanyDetails['not_assigned'] as $userDtls)
                          @php $encId = Crypt::encrypt($userDtls->id); @endphp
                          <tr>
                            <td class="d-flex align-items-center">{{$i}}.
                              <div class="form-check form-check-flat form-check-success">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input" name="loginid[]" value="{{$userDtls->id}}">
                                </label>

                              </div>
                              
                            </td>
                           
                            <td>
                             {{$userDtls->company_name}}
                            </td>
                            <td>
                             {{$userDtls->total_employee}}
                            </td>

                            <td>
                              {{$userDtls->location}}
                            </td>
                      
                            <td>
                              <select class="form-control" name="assignRecruiter[{{$userDtls->id}}]">
                                <option value="">Select</option>
                                @foreach($recruitersList as $recruiters)
                                @php $recruitersName = $recruiters->first_name.' '.$recruiters->last_name;
                              
                                @endphp
                                 <option value="{{$recruiters->id}}" @if(isset($userDtls->assignedTo) && $userDtls->assignedTo =='Admin') selected @endif>{{$recruiters->first_name}} {{$recruiters->last_name}}</option>
                                @endforeach
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
                            <th>Company Name</th>
                            <th>No. of Employee</th>
                            <th>Location</th>
                            <th>Recruiters</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php $i=1 @endphp
                          @foreach($getCompanyDetails['assigned'] as $userDtls)
                          @php $encId = Crypt::encrypt($userDtls->id); @endphp
                          <tr>
                            <td class="d-flex align-items-center">{{$i}}.
                              <div class="form-check form-check-flat form-check-success">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input" name="loginid[]" value="{{$userDtls->id}}">
                                </label>

                              </div>
                             
                            </td>
                         
                            <td>
                            {{$userDtls->company_name}}
                            </td>
                            <td>
                            {{$userDtls->total_employee}}
                            </td>

                            <td>
                            {{$userDtls->location}}
                            </td>
                           <td>{{$userDtls->assignedTo}}</td> 
                            
                          </tr>
                          @php $i++; @endphp
                          @endforeach

                        </tbody>
                      </table>
                    </div>
                  </form>
                </div>
                
@endsection
@section('scripts')
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  })

  $('.AssignRecuiterBtn').on('click', function() {

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
            url: "{{url('admin/updateAssignTo')}}",
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

@endsection