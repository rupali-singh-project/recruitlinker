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
            @if($user_cat == 'Admin')
            <h6 class="text-right text-bold page-heading">Add New User</h6>
            @endif
            @if($user_cat == 'HR')
            <h6 class="text-right text-bold page-heading">Add New Candidate</h6>
            @endif

            <h6 class="font-weight-normal">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{url('/land')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Add New User</li>
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
            <form class="form-sample" action="{{url('admin/createNewUser')}}" method="POST">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">User ID</label>
                    <div class="col-sm-9">
                      <input type="hidden" value="{{$userDtls->id ??''}}" name="updated_id">
                      <input type="text" class="form-control" name="user_id" value="{{$userDtls->userid ??''}}" placeholder="User ID" />
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">First Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="first_name" value="{{$userDtls->first_name  ??''}}" placeholder="First Name" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Last Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="last_name" value="{{$userDtls->last_name  ??''}}" placeholder="Last Name" />
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="password" value="{{$userDtls->password  ??''}}" placeholder="Password" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" name="email_id" value="{{$userDtls->email_id  ??''}}" placeholder="Email" />
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Phone</label>
                    <div class="col-sm-9">
                      <input type="phone" class="form-control" name="phone_no" value="{{$userDtls->phone  ??''}}" placeholder="Phone" />
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">User Category</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="user_cat" id="user_category" required>
                        @if($user_cat == 'Admin')
                        <option value="">Select</option>
                        <option value="HR" @if(isset($userDtls->user_cat) && $userDtls->user_cat =='HR') selected @endif>Human Resource</option>
                        <option value="Company" @if(isset($userDtls->user_cat) && $userDtls->user_cat=='Company') selected @endif>Company</option>
                        @endif
                        <option value="Student" @if(isset($userDtls->user_cat) && $userDtls->user_cat=='Student') selected @endif>Candidate</option>
                      </select>
                    </div>
                  </div>
                </div>
                <!-- <div class="col-md-6 d-none" id="adminSubCat">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">User Sub Category</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="user_subcat" id="user_subcategory" >
                            <option value="">Select</option>
                              <option value="Admin" @if(isset($userDtls->user_subcat) && $userDtls->user_subcat =='Admin') selected @endif>Admin</option>
                              <option value="Human Resource" @if(isset($userDtls->user_subcat) && $userDtls->user_subcat=='HR') selected @endif>Human Resource</option>
                            </select>
                          </div>
                        </div>
                      </div>-->
              </div>
              <hr id="horizontalLine" class="my-0 d-none">
              <div class="row d-none pt-1" id="companyUserExtraInfoBox">
                <div class="col-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Company Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" placeholder="Enter Company Name" name="company" />
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Access Level</label>
                    <div class="col-sm-9">
                      <select name="accessLevel" id="" class="form-control">
                        <option value="0">Viewer(View Mode Only)</option>
                        <option value="1">Editor(Update Profile Only)</option>
                        <option value="2">Admin(Update Profile + Jobs Management)</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>


              @if(isset($userDtls->id) && $userDtls->id!='')
              <button type="submit" class="btn btn-success mr-2">Update</button>
              @else
              <button type="submit" class="btn btn-success mr-2">Submit</button>
              @endif
              <button class="btn btn-light">Cancel</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    @endsection

    @section('scripts')
    <script>
      $('#user_category').on('change', function(event) {
        if ($(this).val() == 'Company') {
          $('#companyUserExtraInfoBox').removeClass('d-none');
          $('#horizontalLine').removeClass('d-none');
        } else {
          $('#companyUserExtraInfoBox').addClass('d-none');
          $('#horizontalLine').addClass('d-none');
        }
      })
    </script>
    <!--<script>
    $('#user_category').on('change',function(event){
      if($(this).val()=='Admin'){
        $('#adminSubCat').removeClass('d-none');
      }else{
        $('#adminSubCat').addClass('d-none');
      }
    })
  </script>-->
    @endsection
