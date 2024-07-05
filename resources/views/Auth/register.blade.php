<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Job Portal - Login</title>
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
                <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                <form method="POST" action="{{url('register')}}" class="pt-3">
                  <div class="row">
                    <div class="col pr-1">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-lg" id="exampleInputFirstname1" name="first_name" placeholder="First name" value="{{old('first_name')}}" autocomplete="off">
                        @if ($errors->has('first_name'))
                        <span class="text-danger text-left">{{ $errors->first('first_name') }}</span>
                        @endif
                      </div>
                    </div>
                    <div class="col pl-1">
                      <div class="form-group">
                        <input type="text" class="form-control form-control-lg" id="exampleInputUsername1" name="last_name" placeholder="Last name" value="{{old('last_name')}}" autocomplete="off">
                        @if ($errors->has('last_name'))
                        <span class="text-danger text-left">{{ $errors->first('last_name') }}</span>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="exampleInputUsername1" name="userid" placeholder="Username" value="{{old('userid')}}" autocomplete="off">
                    @if ($errors->has('userid'))
                    <span class="text-danger text-left">{{ $errors->first('userid') }}</span>
                    @endif
                  </div>

                  <div class="form-group">

                    <select class="form-control form-lg" name="user_cat" id="user_category" required>

                      <option value="">Select</option>
                      <option value="Company">Company</option>
                      <option value="Student">Candidate</option>
                    </select>
                    @if ($errors->has('user_cat'))
                    <span class="text-danger text-left">{{ $errors->first('user_cat') }}</span>
                    @endif
                  </div>

                  <div class="form-group d-none companyUserExtraInfoBox">
                    <input type="text" class="form-control" placeholder="Enter Company Name" name="company" />
                    @if ($errors->has('company'))
                    <span class="text-danger text-left">{{ $errors->first('company') }}</span>
                    @endif
                  </div>

                  <div class="form-group d-none companyUserExtraInfoBox">
                    <select name="accessLevel" id="" class="form-control form-lg">
                      <option value="0">Viewer(View Mode Only)</option>
                      <option value="1">Editor(Update Profile Only)</option>
                      <option value="2">Admin(Update Profile + Jobs Management)</option>
                    </select>
                    @if ($errors->has('accessLevel'))
                    <span class="text-danger text-left">{{ $errors->first('accessLevel') }}</span>
                    @endif
                  </div>

                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg" name="email" id="exampleInputEmail1" placeholder="Email" value="{{old('email')}}">
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
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="password_confirmation" placeholder="Confirm Password">
                    @if ($errors->has('password_confirmation'))
                    <span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                  </div>
                  <div class="mt-3">
                    @csrf
                    <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN UP</button>
                  </div>
                  <div class="text-center mt-4 font-weight-light">
                    Already have an account? <a href="{{url('login')}}" class="text-primary">Login</a>
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

  <script>
    $('#user_category').on('change', function(event) {
      if ($(this).val() == 'Company') {
        $('.companyUserExtraInfoBox').removeClass('d-none');
        $('#horizontalLine').removeClass('d-none');
      } else {
        $('.companyUserExtraInfoBox').addClass('d-none');
        $('#horizontalLine').addClass('d-none');
      }
    })
  </script>

  <!-- endinject -->
</body>

</html>