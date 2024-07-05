<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Recruit Linker - Login</title>
  <!-- base:css -->
  <link rel="stylesheet" href="{{asset('public/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/vendors/base/vendor.bundle.base.css')}}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('public/assets/css/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('public/assets/images/recruit-linker-logo.jpg')}}" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="main-panel">
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <div class="brand-logo">
                  <img src="{{asset('public/assets/images/recruit-linker-logo.jpg')}}" alt="logo">
                </div>
                <h4>Login to continue.</h4>
                <div class="mt-1">
                  @include('layouts.common.messages')
                </div>
                <form method="POST" action="{{route('login.perform')}}" class="pt-3">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="userid" placeholder="Enter username or email" autocomplete="off">
                    @if ($errors->has('userid'))
                      <span class="text-danger text-left">{{ $errors->first('userid') }}</span>
                    @endif
                    @if ($errors->has('email'))
                      <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                    @endif
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="password" placeholder="Password">
                    @if ($errors->has('password'))
                      <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                    @endif
                  </div>
                  <div class="mt-3">
                    @csrf
                    <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Login</button>
                    <button type="button" class="btn btn-block btn-google auth-form-btn">
                      <i class="mdi mdi-google me-2"></i>Sign In with google
                    </button>
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input">
                        Keep me signed in
                      </label>
                    </div>
                    <a href="#" class="auth-link text-black">Forgot password?</a>
                  </div>
                  <div class="text-center mt-4 font-weight-light">
                    Don't have an account? <a href="{{route('register.show')}}" class="text-primary">Create</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="{{asset('public/assets/vendors/base/vendor.bundle.base.js')}}"></script>
  <!-- endinject -->
  <!-- inject:js -->
  
    <script src="{{asset('public/assets/js/template.js')}}"></script>
  <!-- endinject -->
</body>

</html>
