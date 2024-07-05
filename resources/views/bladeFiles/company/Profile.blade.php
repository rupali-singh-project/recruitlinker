@extends('layouts.master')

@section('styles')
<style>
  .horizontal-line {
    height: 1px !important;
    background: rgb(8, 6, 137);
    background: linear-gradient(90deg, rgba(8, 6, 137, 1) 40%, rgba(201, 0, 255, 1) 100%);
    color: white !important;
  }

  .card-no-border .card {
    border-color: #d7dfe3;
    border-radius: 4px;
    margin-bottom: 30px;
    -webkit-box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);
    box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05)
  }

  .card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem
  }

  .pro-img {
    margin-top: -80px;
    margin-bottom: 20px;
  }

  #company-logo-container {
    position: relative;
    display: inline-block;
  }

  #upload-logo-btn {
    position: absolute;
    top: 0;
    right: 15px;
  }

  .little-profile .pro-img img {
    width: 170px;
    height: 170px;
    background: white;
    -webkit-box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    border-radius: 100%;
    position: relative;
  }

  #company-cover-image-box {
    position: relative;
  }

  #cover-image-upload-btn {
    position: absolute;
    top: 0;
    right: 5px;
  }

  #about-image-container {
    height: 300px;
    background-size: cover;
    background-position: center;
    background-color: #ccc;
  }

  #about-text-container {
    /* color:#000; */
    font-size: 20px;
    text-align: left;
  }

  .gallery-img {
    width: 33% !important;
    padding: 5px !important;
    position: relative;
    border: 1px solid #eee;
  }

  .gallery-img .photo_checkbox {
    position: absolute;
    top: 0;
    left: 0;
  }

  .gallery-img img {
    width: 100% !important;
  }

  #company-info-number-container {
    position: relative
  }

  #company-info-number-btn {
    width: 35px;
    padding: 0;
    position: absolute;
    top: 0;
    right: 0;
    background-color: #fff;
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
            <h6 class="text-right text-bold page-heading">Company Profile
              @if($user_cat!='Student')
              @if(Request::input('view_mode')==1)
              <a href="{{url()->current()}}"><i class="fas fa-chevron-circle-left"></i>Back To Edit Mode</a>
              @else
              <a href="{{url()->current()}}?view_mode=1" title="See this page in view mode"><i class="fas fa-eye"></i></a>
              @endif
              @endif
            </h6>
            <h6 class="font-weight-normal">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{url('/land')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Add Job</li>
                </ol>
              </nav>
            </h6>
          </div>
        </div>
      </div>
      <div class="row gutters-sm">
        <div class="col-md-12">
          <!-- Column -->
          <div class="card" id="company-cover-image-box">
            @if($companyData->company_cover!='' && $companyData->company_cover!=null)
            <img classs="card-img-top" src="{{asset('public/uploads/company/cover/'.$companyData->company_cover)}}" height="260" alt="Card image cap">
            @else
            <img classs="card-img-top" src="{{asset('public/uploads/company/cover/default-cover-image.png')}}" height="260" alt="Card image cap">
            @endif
            @if($isEditAccess==1)
            <button class="btn btn-sm btn-light mt-2" data-bs-toggle="modal" data-bs-target="#upload-cover-image-modal" id="cover-image-upload-btn"><i class="fas fa-upload"></i></button>
            @endif
            <div class="card-body little-profile text-center">
              <div class="pro-img">
                <div id="company-logo-container">
                  @if($companyData->company_logo!='' && $companyData->company_logo!=null)
                  <img src="{{asset('public/uploads/company/logo/'.$companyData->company_logo)}}" alt="user">
                  @else
                  <img src="{{asset('public/uploads/company/logo/default-logo.png')}}" alt="user">
                  @endif
                  @if($isEditAccess==1)
                  <button id="upload-logo-btn" data-bs-toggle="modal" data-bs-target="#upload-logo-image-modal" class="btn btn-sm btn-light"><i class="fas fa-upload"></i></button>
                  @endif
                </div>
              </div>
              <form action="" id="company-info-form">
                @if($isEditAccess==1)
                <input type="text" class="form-control" name="company_name" placeholder="Enter company name" value="{{$companyData->company_name}}">
                @else
                <h2 class="m-b-0 text-dark text-bold">{{$companyData->company_name}}</h2>
                @endif
                <hr class='horizontal-line'>
                @csrf
                <input type="hidden" name="company_id" value="{{$company_id}}">

                <div class="row text-center my-4" id="company-info-number-container">
                  @if($isEditAccess==1)
                  <button class="btn" id="company-info-number-btn"><i class="fas fa-edit"></i></button>
                  @endif
                  <div class="col-lg-4 col-md-4 m-t-20">
                    <h2 style="font-family:inherit;font-weight:300;" class="m-b-0 text-dark d-flex justify-content-center align-items-center">
                      @if($isEditAccess==1)
                      <input type="text" name="no_of_employee" class="form-control" style="width:150px" placeholder="No. Of Employees" value="{{$companyData->total_employee}}">
                      @else
                      {{$companyData->total_employee}}
                      @endif
                    </h2>
                    <h4 class="text-bold text-info font-22">
                      <i class="fas fa-user-circle mr-2" style="margin-right:4px !important"></i>No. of employees
                    </h4>
                  </div>

                  <div class="col-lg-4 col-md-4 m-t-20">
                    <h2 style="font-family:inherit;font-weight:300;" class="m-b-0 text-dark d-flex justify-content-center align-items-center">
                      @if($isEditAccess==1)
                      <input type="text" name="location" class="form-control" placeholder="Enter Location" style="width:130px" value="{{$companyData->location}}">
                      @else
                      {{$companyData->location}}
                      @endif
                    </h2>
                    <h4 class="text-bold text-danger font-22">
                      <i class="fas fa-user-circle mr-2" style="margin-right:4px !important"></i>
                      Location
                    </h4>
                  </div>
                  <div class="col-lg-4 col-md-4 m-t-20">
                    <h2 style="font-family:inherit;font-weight:300;" class="m-b-0 text-dark d-flex justify-content-center align-items-center">
                      <!-- <input type="text" name="no_of_employee" class="form-control" style="width:100px"> -->
                      26
                    </h2>
                    <h4 class="text-bold text-success font-22">
                      <i class="fas fa-user-circle mr-2" style="margin-right:4px !important"></i>
                      Total Hirings
                    </h4>
                  </div>
                </div>
              </form>
              <hr class='horizontal-line'>

              <!-- ABOUT US SECTION -->
              <h3 class="text-dark" style="margin:60px auto"><span>About Us</span></h3>
              <div id="about-us-container" class="row my-4">
                <div class="col-6" id="about-image-container" style="background-image:url('{{asset('public/uploads/company/images/about/default-about.jpg')}}')">

                </div>
                <div class="col-6 font-light" id="about-text-container">
                  <form action="" id="about-us-form">
                    @csrf
                    <input type="hidden" name="company_id" value="{{$company_id}}">
                    @if($isEditAccess==1)
                    <textarea name="company_description" class="summernote" rows="19" style="border:1px solid #0ddbb9" placeholder="Enter Company description...">{{$companyData->company_desc}}</textarea>
                    <button class="btn btn-success mt-1"><i class="fas fa-edit"></i></button>
                    @else
                    {!! $companyData->company_desc !!}
                    @endif

                  </form>
                </div>
              </div>
              <!-- Gallery SEction -->
              <h3 class="text-dark" style="margin:60px auto"><span>Gallery</span></h3>
              @if(count($companyImages)==0)
              <div class="p-5" style="border:2px dotted #0ddbb9">
                <p>No Images Found.</p>
                @if($isEditAccess==1)
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#upload-gallery-image-modal"><i class="fas fa-plus mr-3"></i>Upload Images</button>
                @endif
              </div>
              @else
              <div>
                @if($isEditAccess==1)
                <button type="button" class="btn btn-sm btn-danger" id="delete-gallery-image-btn"><i class="fas fa-trash"></i></button>
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#upload-gallery-image-modal"><i class="fas fa-plus"></i></button>
                @endif
              </div>
              @endif
              <form action="">
                <div class="gallery-container d-flex justify-content-around align-items-center flex-wrap ">
                  @foreach($companyImages as $image)
                  <div class="gallery-img">
                    @if($isEditAccess==1)
                    <input type="checkbox" class="photo_checkbox" name="photo_name[]" value="{{$image->id}}">
                    @endif
                    <img src="{{asset('public/uploads/company/images/posts/'.$image->image_url)}}" height="250" alt="">
                  </div>
                  @endforeach
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

<!-- MODAL STARTS FROM HERE -->
<div class="modal fade" id="upload-cover-image-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload Cover Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="cover-image-form">
          @csrf
          <input type="hidden" name="company_id" value="{{$company_id}}">
          <input type="file" name="cover-image">
          <button class="btn btn-sm btn-success">Upload</button>
        </form>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="upload-logo-image-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload Logo Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="logo-image-form">
          @csrf
          <input type="hidden" name="company_id" value="{{$company_id}}">
          <input type="file" name="logo-image">
          <button class="btn btn-sm btn-success">Upload</button>
        </form>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="upload-gallery-image-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload Gallery Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="gallery-image-form">
          @csrf
          <input type="hidden" name="company_id" value="{{$company_id}}">
          <input type="file" name="gallery-image">
          <button class="btn btn-sm btn-success">Upload</button>
        </form>
      </div>

    </div>
  </div>
</div>
<!-- MODAL STARTS ENDS HERE -->
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    $('#cover-image-form').on('submit', function(event) {
      event.preventDefault(); // Prevent default form submission
      var formData = new FormData(this);
      $.ajax({
        url: '{{url("company/profile/cover/image/update")}}',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Upload Successful!',
          }).then(() => {
            location.reload();
          });
        },
        error: function(xhr, status, error) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Upload failed: ' + error,
          });
        }
      });
    });
    $('#logo-image-form').on('submit', function(event) {
      event.preventDefault(); // Prevent default form submission
      var formData = new FormData(this);
      $.ajax({
        url: '{{url("company/profile/logo/image/update")}}',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Upload Successful!',
          }).then(() => {
            location.reload();
          });
        },
        error: function(xhr, status, error) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Upload failed: ' + error,
          });
        }
      });
    });
    $('#company-info-form').on('submit', function(event) {
      event.preventDefault(); // Prevent default form submission
      var formData = new FormData(this);
      $.ajax({
        url: '{{url("company/profile/info/update")}}',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Update Successful!',
          }).then(() => {
            location.reload();
          });
        },
        error: function(xhr, status, error) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Update failed: ' + error,
          });
        }
      });
    });
    $('#about-us-form').on('submit', function(event) {
      event.preventDefault(); // Prevent default form submission
      var formData = new FormData(this);
      $.ajax({
        url: '{{url("company/profile/aboutus/update")}}',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Upload Successful!',
          }).then(() => {
            location.reload();
          });
        },
        error: function(xhr, status, error) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Upload failed: ' + error,
          });
        }
      });
    });
    $('#gallery-image-form').on('submit', function(event) {
      event.preventDefault(); // Prevent default form submission
      var formData = new FormData(this);
      $.ajax({
        url: '{{url("company/profile/gallery/add")}}',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Upload Successful!',
          }).then(() => {
            location.reload();
          });
        },
        error: function(xhr, status, error) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Upload failed: ' + error,
          });
        }
      });
    });
    $('#delete-gallery-image-btn').on('click', function(event) {
      var checkboxValues = [];
      $('.photo_checkbox:checked').each(function() {
        checkboxValues.push($(this).val());
      });

      $.ajax({
        url: '{{url("company/profile/gallery/delete")}}',
        type: 'POST',

        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          ids: checkboxValues
        },

        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Delete Successful!',
          }).then(() => {
            location.reload();
          });
        },
        error: function(xhr, status, error) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Delete failed: ' + error,
          });
        }
      });
    });



  });
</script>
@endsection
