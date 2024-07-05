<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Job Portal</title>
  <!-- base:css -->
  <link rel="stylesheet" href="{{asset('public/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/vendors/base/vendor.bundle.base.css')}}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('public/assets/css/style.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('public/assets/images/favicon.png')}}" />
  <link rel="stylesheet" href="{{asset('public/assets/vendors/summernote/summernote.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/vendors/sweetalerts/dist/sweetalert2.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/css\maps\horizontal-layout-light/style.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" />

  <style>
    table.dark_header th {
      font-weight: bold;
    }

    .page-heading {
      color: #000;
      font-size: 20px;
    }
  </style>
  @yield('styles')
</head>

<body>
  <div class="horizontal-menu">
    <nav class="navbar top-navbar col-lg-12 col-12 p-0">
      <div class="container-fluid">
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
          <ul class="navbar-nav navbar-nav-left">
            <li class="nav-item ms-0 me-5 d-lg-flex d-none">
              <a href="#" class="nav-link horizontal-nav-left-menu"><i class="mdi mdi-format-list-bulleted"></i></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                <i class="mdi mdi-bell mx-0"></i>
                <span class="count bg-success">2</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-success">
                      <i class="mdi mdi-information mx-0"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">Application Error</h6>
                    <p class="font-weight-light small-text mb-0 text-muted">
                      Just now
                    </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-warning">
                      <i class="mdi mdi-settings mx-0"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">Settings</h6>
                    <p class="font-weight-light small-text mb-0 text-muted">
                      Private message
                    </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-info">
                      <i class="mdi mdi-account-box mx-0"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">New user registration</h6>
                    <p class="font-weight-light small-text mb-0 text-muted">
                      2 days ago
                    </p>
                  </div>
                </a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-bs-toggle="dropdown">
                <i class="mdi mdi-email mx-0"></i>
                <span class="count bg-primary">4</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="images/faces/face4.jpg" alt="image" class="profile-pic">
                  </div>
                  <div class="preview-item-content flex-grow">
                    <h6 class="preview-subject ellipsis font-weight-normal">David Grey
                    </h6>
                    <p class="font-weight-light small-text text-muted mb-0">
                      The meeting is cancelled
                    </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="images/faces/face2.jpg" alt="image" class="profile-pic">
                  </div>
                  <div class="preview-item-content flex-grow">
                    <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook
                    </h6>
                    <p class="font-weight-light small-text text-muted mb-0">
                      New product launch
                    </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="images/faces/face3.jpg" alt="image" class="profile-pic">
                  </div>
                  <div class="preview-item-content flex-grow">
                    <h6 class="preview-subject ellipsis font-weight-normal"> Johnson
                    </h6>
                    <p class="font-weight-light small-text text-muted mb-0">
                      Upcoming board meeting
                    </p>
                  </div>
                </a>
              </div>
            </li>

          </ul>
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo" href="index.html"><img src="{{asset('public/assets/images/job_logo.jpg')}}" alt="logo" /></a>
            <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{asset('public/assets/images/job_logo.jpg')}}" alt="logo2" /></a>
          </div>
          <ul class="navbar-nav navbar-nav-right">
            <!--<li class="nav-item dropdown  d-lg-flex d-none">
                  <button type="button" class="btn btn-inverse-primary btn-sm">Product </button>
                </li>-->
            <li class="nav-item d-lg-flex d-none">
              <span class="text-dark">
                {{$first_name}} {{$last_name}} @if($user_cat=='Company') <span class="text-secondary">[ {{$company_data->company_name }} ]</span>@endif
              </span>
            </li>
            <!-- <li class="nav-item dropdown d-lg-flex d-none">
                  <button type="button" class="btn btn-inverse-primary btn-sm">Settings</button>
                </li> -->
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                <span class="nav-profile-name"></span>
                <span class="online-status"></span>
                <img src="{{asset('public/assets/images/job_logo.jpg')}}" alt="profile" />
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">

                <a class="dropdown-item" href="{{route('logout.perform')}}">
                  <i class="mdi mdi-logout text-primary"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </div>
    </nav>
    <nav class="bottom-navbar">
      <div class="container">
        <ul class="nav page-navigation">
          <li class="nav-item">
            <a class="nav-link" href="{{url('/')}}">
              <i class="mdi mdi-file-document-box menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('Companies_view')}}">
              <i class="mdi mdi-file-document-box menu-icon"></i>
              <span class="menu-title">Companies</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('Students_view')}}">
              <i class="mdi mdi-file-document-box menu-icon"></i>
              <span class="menu-title">Students</span>
            </a>
          </li>
          @if($user_cat == 'Admin')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="mdi mdi-cube-outline menu-icon"></i>
              <span class="menu-title">User Management</span>
              <i class="menu-arrow"></i>
            </a>

            <div class="submenu">
              <ul>
                <li class="nav-item"><a class="nav-link" href="{{url('admin/AddNewUsers')}}">Add New User(A)</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('admin/UsersList')}}">List of Users(A)</a></li>
              </ul>
            </div>
          </li>
          @endif
          @if($user_cat == 'Company')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="mdi mdi-chart-areaspline menu-icon"></i>
              <span class="menu-title">Job Management</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="submenu">
              <ul>
                <li class="nav-item"><a class="nav-link" href="{{url('AddNewJob')}}">Add Jobs(for C/A)</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('JobsList')}}">List of Jobs(for C/A)</a></li>
              </ul>
            </div>
          </li>
          @endif

          @if($user_cat !='Admin')
          <li class="nav-item">
            <a @if($user_cat !='Student' ) href="{{url('company/profile/get/'.Crypt::encrypt($company_id))}}" @endif class="nav-link">
              <i class="mdi mdi-grid menu-icon"></i>
              <span class="menu-title">Manage Profile</span>
              <i class="menu-arrow"></i>
            </a>
            @if($user_cat =='Student')
            <div class="submenu">
              <ul>
                <li class="nav-item"><a class="nav-link" href="{{url('student/profile/view/'.Crypt::encrypt($userid))}}">View Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('student/profile/edit')}}">Update Resume</a></li>
              </ul>
            </div>
            @endif
          </li>
          @endif

          @if($user_cat != 'Company')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="mdi mdi-codepen menu-icon"></i>
              <span class="menu-title">Jobs Applications</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="submenu">
              <ul class="submenu-item">
                <li class="nav-item">
                  <a class="nav-link" @if($user_cat=='Admin' ) href="{{url('admin/jobs/view')}}" @elseif($user_cat=='Student' ) href="{{url('student/jobs/view')}}" @endif>
                    Jobs View
                  </a>
                </li>
                @if($user_cat == 'Student')
                <!-- <li class="nav-item">
                          <a class="nav-link" href="{{url('student/jobs/search')}}">Search Jobs</a>
                        </li> -->
                @endif
              </ul>
            </div>
          </li>
          @endif
          @if($user_cat == 'Admin')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="mdi mdi-cogs menu-icon"></i>
              <span class="menu-title">Settings</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="submenu">
              <ul class="submenu-item">

                <li class="nav-item">
                  <a class="nav-link" href="{{url('admin/mail/setting')}}">Email Setting</a>
                  <a class="nav-link" href="{{url('student/jobs/search')}}">Change Password</a>
                </li>
              </ul>
            </div>
          </li>
          @endif
        </ul>
      </div>
    </nav>
  </div>
  <!-- partial -->
  <div class="container-fluid page-body-wrapper">
    <div class="main-panel">


      @yield('content')
    </div>

  </div>
  <!-- content-wrapper ends -->

  <!-- partial:partials/_footer.html -->
  <footer class="footer">
    <div class="footer-wrap">
      <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <a href="https://srautomation.info/" target="_blank">Jobs Portal </a>2023</span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Designed by <a href="https://srautomation.info/" target="_blank"> SR Automation</a></span>
      </div>
    </div>
  </footer>
  <!-- partial -->
  </div>
  <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="{{asset('public/assets/vendors/base/vendor.bundle.base.js')}}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="{{asset('public/assets/js/template.js')}}"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <!-- End plugin js for this page -->
  <script src="{{asset('public/assets/vendors/chart.js/Chart.min.js')}}"></script>
  <script src="{{asset('public/assets/vendors/progressbar.js/progressbar.min.js')}}"></script>
  <script src="{{asset('public/assets/vendors/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js')}}"></script>
  <script src="{{asset('public/assets/vendors/justgage/raphael-2.1.4.min.js')}}"></script>
  <script src="{{asset('public/assets/vendors/justgage/justgage.js')}}"></script>
  <script src="{{asset('public/assets/js/jquery.cookie.js')}}" type="text/javascript"></script>
  <!-- Custom js for this page-->
  <script src="{{asset('public/assets/js/dashboard.js')}}"></script>
  <script src="{{asset('public/assets/vendors/summernote/summernote.min.js')}}"></script>
  <script src="{{asset('public/assets/vendors/sweetalerts/dist/sweetalert2.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- End custom js for this page-->
  <script>
    $(document).ready(function() {
      $('.summernote').summernote({

      });
    })
  </script>
  @yield('scripts')
</body>

</html>