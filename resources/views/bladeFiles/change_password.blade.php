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
            <h6 class="text-right text-bold page-heading">Change Password</h6>

            <h6 class="font-weight-normal">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{url('/land')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                </ol>
              </nav>
            </h6>
          </div>
        </div>
      </div>
      <!-- START FIRST ROW -->
      @if(session()->has('error'))
      <div class="col-12 p-0">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {!!session()->get('error')!!}
          <button type="button" class="btn-bs-close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      @endif
      @if(session()->has('success'))
      <div class="col-12 p-0">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {!!session()->get('success')!!}
          <button type="button" class="btn-bs-close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      @endif
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <form class="form-sample" action="{{url('SavechangePassword')}}" method="POST">
              @csrf
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Old Password</label>
                    <div class="col-sm-10">

                      <input type="text" class="form-control" name="old_password" placeholder="Old Password" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">New Password</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="new_password" placeholder="New Password" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Confirm Password</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="confirm_password" placeholder="Confirm Password" />
                    </div>
                  </div>
                </div>
              </div>


              <div class="form-check form-check-flat form-check-primary">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input">
                  Remember me
                </label>
              </div>

              <button type="submit" class="btn btn-success mr-2">Submit</button>

              <button class="btn btn-light">Cancel</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    @endsection