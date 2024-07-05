@extends('layouts.master')

@section('content')
<style>
  body {
    font-family: 'Ubuntu', sans-serif;
    font-weight: bold;
  }

  .select2-container {
    min-width: 400px;
  }

  .select2-results__option {
    padding-right: 20px;
    vertical-align: middle;
  }

  .select2-results__option:before {
    content: "";
    display: inline-block;
    position: relative;
    height: 20px;
    width: 20px;
    border: 2px solid #e9e9e9;
    border-radius: 4px;
    background-color: #fff;
    margin-right: 20px;
    vertical-align: middle;
  }

  .select2-results__option[aria-selected=true]:before {
    font-family: fontAwesome;
    content: "\f00c";
    color: #fff;
    background-color: #f77750;
    border: 0;
    display: inline-block;
    padding-left: 3px;
  }

  .select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #fff;
  }

  .select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #eaeaeb;
    color: #272727;
  }

  .select2-container--default .select2-selection--multiple {
    margin-bottom: 10px;
  }

  .select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
    border-radius: 4px;
  }

  .select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: #f77750;
    border-width: 2px;
  }

  .select2-container--default .select2-selection--multiple {
    border-width: 2px;
  }

  .select2-container--open .select2-dropdown--below {

    border-radius: 6px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);

  }

  .select2-selection .select2-selection--multiple:after {
    content: 'hhghgh';
  }

  /* select with icons badges single*/
  .select-icon .select2-selection__placeholder .badge {
    display: none;
  }

  .select-icon .placeholder {
    display: none;
  }

  .select-icon .select2-results__option:before,
  .select-icon .select2-results__option[aria-selected=true]:before {
    display: none !important;
    /* content: "" !important; */
  }

  .select-icon .select2-search--dropdown {
    display: none;
  }
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-12 mb-4 mb-xl-0">
          <div class="d-flex align-items-center justify-content-between">
            <!-- <h3 class="text-dark font-weight-bold mb-2">User Login Details!</h3> -->
            <h6 class="text-right text-bold page-heading">@if($action=='UPDATE') Update @else Add @endif Job</h6>

            <h6 class="font-weight-normal">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="{{url('/land')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">@if($action=='UPDATE') Update @else Add @endif Job</li>
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
            <form class="form-sample" action="{{url('createNewJob')}}" method="POST">
              @csrf
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Job Title</label>
                    <div class="col-sm-10">
                      <input type="hidden" value="{{$jobsDtls->id ??''}}" name="updated_id">
                      @php
                      if( $jobsDtls == null) {
                      $job_title = '';
                      } else {
                      $job_title = $jobsDtls->job_title;
                      }
                      @endphp
                      <select name="job_title" class="form-control form-control-lg d-inline-block" id="">
                        <option value="">Select Job Profile Title</option>
                        @foreach($jobProfileData as $row)
                        <option value="{{$row->title}}" @if($row->title == $job_title) selected @endif >{{$row->title}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" name="email" value="{{$jobsDtls->email  ??''}}" placeholder="Email" />
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Phone</label>
                    <div class="col-sm-9">
                      <input type="phone" class="form-control" name="phone" value="{{$jobsDtls->phone  ??''}}" placeholder="Phone" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Openings<strong style="color:red;">*</strong></label>
                    <div class="col-sm-9">
                      <input type="number" class="form-control" name="opening" min="1" value="{{$jobsDtls->opening  ??''}}" placeholder="Openings" required />
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Experience<strong style="color:red;">*</strong></label>
                    <div class="col-sm-4">

                      <input type="number" class="form-control" min="0" name="experience_min" value="{{$jobsDtls->experience_min  ?? 0}}" placeholder="Minium" required />
                    </div>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" min="0" name="experience_max" value="{{$jobsDtls->experience_max  ?? 0}}" placeholder="Maximum" required />

                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Industry Type<strong style="color:red;">*</strong></label>
                    <div class="col-sm-9">
                      <select class="form-control" name="industry_type" required>
                        <option value="">Select</option>
                        @foreach($getIndustry as $industryType)
                        <option value="{{$industryType->industry_type}}" @if(isset($jobsDtls->industry_type) && $jobsDtls->industry_type == $industryType->industry_type) selected @endif>{{$industryType->industry_type}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Employee Type<strong style="color:red;">*</strong></label>
                    <div class="col-sm-9">
                      <select class="form-control" name="employee_type" required>
                        <option value="">Select</option>
                        <option value="Full-Time" @if(isset($jobsDtls->employee_type) && $jobsDtls->employee_type =='Full-Time') selected @endif>Full-Time</option>
                        <option value="Part-Time" @if(isset($jobsDtls->employee_type) && $jobsDtls->employee_type=='Part-Time') selected @endif>Part-Time</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Job Description</label>
                    <div class="col-sm-10">

                      <textarea class="summernote" name="job_desc">{{$jobsDtls->job_desc ??''}}</textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Salary<strong style="color:red;">*</strong></label>
                    <div class="col-sm-9">
                      <input type="number" class="form-control" name="salary" min="5000" value="{{$jobsDtls->salary  ??''}}" placeholder="Salary" required />
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">currency<strong style="color:red;">*</strong></label>
                    <div class="col-sm-9">
                      <select class="form-control" name="currency" required>
                        <option value="">Select</option>
                        <option value="INR" @if(isset($jobsDtls->currency) && $jobsDtls->currency =='INR') selected @endif>INR</option>
                        <option value="CAD" @if(isset($jobsDtls->currency) && $jobsDtls->currency=='CAD') selected @endif>CAD</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">skills<strong style="color:red;">*</strong></label>
                    <div class="col-sm-9">
                      <div class="container">
                        <div class="row">
                          <select class="js-select2" multiple="multiple" name="skills[]" required>
                            @foreach($getSkills as $skillsDtls)
                            <option value="{{$skillsDtls->skill_name}}" @if($jobsDtls!=null && in_array($skillsDtls->skill_name,explode(',',$jobsDtls->skills)) )selected @endif>{{$skillsDtls->skill_name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Job Deadline<strong style="color:red;">*</strong></label>
                    <div class="col-sm-9">
                      <input type="date" class="form-control" name="job_deadline" value="{{$jobsDtls->job_deadline  ??''}}" placeholder="Job Deadline" required />
                    </div>
                  </div>
                </div>
              </div>




              @if($action=='UPDATE')
              <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#addJobQuestionModal">Add Question</button>
              @endif
              @if(isset($jobsDtls->id) && $jobsDtls->id!='')
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

    <!-- modal code -->
    <div class="modal fade" id="addJobQuestionModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Job-Specific Questions</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="job_question_form">
              @csrf
              <input type="hidden" name="job_id" value={{$id}}>
              <table class="table table-bordered" id="job_question_table">
                <tr>
                  <th></th>
                  <th>
                    Question
                  </th>
                  <th>required ?</th>
                </tr>
                @if(count($jobQuestions) && $action=='UPDATE')
                @foreach($jobQuestions as $question)
                <tr>
                  <td>
                    <input type="hidden" name="row[]" value="{{$loop->iteration}}">
                    <input type="hidden" name="row_key_id_{{$loop->iteration}}" value="{{$question['id']}}" />
                    <button type="button" class="btn btn-sm btn-info addRowBtn" data-id="{{$loop->iteration}}">Add</button>
                    <button type="button" class="btn btn-sm btn-danger delete_row_btn" data-id="{{$loop->iteration}}">X</button>
                  </td>
                  <td>
                    <input type="text" class="form-control" name="question_{{$loop->iteration}}" placeholder="Enter your job related question here." value="{{$question['question']}}">
                  </td>
                  <td>
                    <input type="checkbox" name="is_required_{{$loop->iteration}}" @if($question['is_required']) checked @endif>
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td>
                    <input type="hidden" name="row[]" value="1">
                    <input type="hidden" name="row_key_id" value="" />
                    <button type="button" class="btn btn-sm btn-info addRowBtn" data-id="1">Add</button>
                  </td>
                  <td>
                    <input type="text" class="form-control" name="question_1" placeholder="Enter your job related question here.">
                  </td>
                  <td>
                    <input type="checkbox" name="is_required_1">
                  </td>
                </tr>
                @endif
              </table>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="addQuestionBtn">Save Questions</button>
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
      $('.addRowBtn').on('click', function(e) {
        var id = $(this).data('id');
        $('#job_question_table').append(`<tr>
                  <td>
                  <input type="hidden" name="row[]" value="${id+1}">
                    <input type="hidden" name="row_key_id_${id+1}" value=""/>
                    <button type="button" class="btn btn-sm btn-info" data-id="${id+1}">Add</button>
                    <button type="button" class="btn btn-sm btn-danger" data-id="${id+1}">X</button>
                  </td>
                  <td>
                    <input type="text" class="form-control" name="question_${id+1}" placeholder="Enter your job related question here.">
                  </td>
                  <td>
                    <input type="checkbox" name="is_required_${id+1}">
                  </td>
                </tr>`);
      })
      $(document).on('click', '.delete_row_btn', function() {
        var id = $(this).data('id');
        var record_id = $('input[name="row_key_id_' + id + '"]').val();
        $.ajax({
          url: "{{url('company/job/questions/delete')}}",
          method: "POST",
          data: {
            id: record_id
          },
          success: function(response) {
            if (response.status == '1') {
              $(this).parent().parent().remove();
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '' + response.msg + '',
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
      });

      $('#addQuestionBtn').on('click', function() {
        $.ajax({
          url: "{{url('company/job/questions/add')}}",
          method: "POST",
          data: $('#job_question_form').serialize(),
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
      });
    </script>
    <script>
      $(".js-select2").select2({
        closeOnSelect: false,
        placeholder: "Placeholder",
        allowHtml: true,
        allowClear: true,
        tags: true // создает новые опции на лету
      });

      $('.icons_select2').select2({
        width: "100%",
        templateSelection: iformat,
        templateResult: iformat,
        allowHtml: true,
        placeholder: "Placeholder",
        dropdownParent: $('.select-icon'), //обавили класс
        allowClear: true,
        multiple: false
      });


      function iformat(icon, badge, ) {
        var originalOption = icon.element;
        var originalOptionBadge = $(originalOption).data('badge');

        return $('<span><i class="fa ' + $(originalOption).data('icon') + '"></i> ' + icon.text + '<span class="badge">' + originalOptionBadge + '</span></span>');
      }
    </script>
    @endsection