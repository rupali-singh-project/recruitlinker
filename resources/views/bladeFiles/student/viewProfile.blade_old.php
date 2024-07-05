@extends('layouts.master')

@section('styles')
<style>
table tr:first-child{
    
    background: rgb(6,66,137);
background: linear-gradient(90deg, rgba(6,66,137,1) 0%, rgba(201,0,255,1) 100%);
color:white;

}
#mainProfileCard{
    background: rgb(6,66,137);
background: linear-gradient(90deg, rgba(6,66,137,1) 0%, rgba(201,0,255,1) 100%);
color:white;
}

#linksContainer{
    border:none;
    border-left:8px solid;
    border-image: linear-gradient(90deg, rgba(6,66,137,1) 0%, rgba(201,0,255,1) 100%);
    border-image-slice: 1;

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
                    <h6 class="text-right text-bold page-heading">View Profile</h6>

                    <h6 class="font-weight-normal">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{url('/land')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Profile</li>
                        </ol>
                        </nav>
                    </h6>
                  </div>
                </div>
              </div>
            <!-- START FIRST ROW -->
            <div class="container-fluid">
                <div class="main-body">
                    <div class="row gutters-sm">
                        <div class="col-md-4 mb-3">
                        <div class="card" id="mainProfileCard">
                            <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{asset('public/uploads/profile/'.$userData['profile_pic'])}}" alt="Profile Pic" class="rounded-circle" width="150">
                                <div class="mt-3">
                                <h4>{{$userData['first_name']}} {{$userData['last_name']}}
                                @if($personalDetails->gender=='M')
                                <span class='text-info' style='font-size:12.5px'>(Male)</span>
                                @elseif($personalDetails->gender=='F') 
                                <span class='text-info' style='font-size:12.5px'>(Female)</span>
                                @else
                                <span class='text-info' style='font-size:12.5px'>(Others)</span>
                                @endif
                                </h4>
                                <p class=" mb-1">{{$personalDetails->phone}} | {{$userData['email']}}</p>
                                <p class=" font-size-sm text-underline"><b>Address : </b> {{$personalDetails->street_address}}</p>
                                
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="card mt-3" id="linksContainer">
                            <h4 class="mt-2 mb-3 border-bottom border-success text-dark py-1 p-3">Important Links</h4>
                            <ul class="list-group list-group-flush">
                            @foreach($linksData as $link)
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">{{$link->linkName}}</h6>
                                    <span class="text-secondary"><a href="{{$link->link}}"><i class="fas fa-eye mr-3"></i>View</a></span>
                                </li>
                            @endforeach
                            </ul>
                        </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body p-2">
                                    
                                    <h4 class="mt-2 mb-3 border-bottom border-danger text-dark py-1 pl-3">Education</h4>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Institute</th>
                                            <th>Degree</th>
                                            <th>Duration</th>
                                            <th>Degree</th>
                                            <th>Marks</th>
                                        </tr>
                                        @if(count($educationsData) > 0)
                                            @foreach($educationsData as $education)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$education->institute}}</td>
                                                <td>{{$education->degree}}</td>
                                                <td>{{$education->start_time}} - 
                                                    @if($education->isStudying)
                                                        Current
                                                    @else
                                                    {{$education->end_time}}
                                                    @endif
                                                </td>
                                                <td>{{$education->marks}}</td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="" class='text-center'>No Records Found.</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body p-2">
                                    
                                    <h4 class="mt-2 mb-3 border-bottom border-warning text-dark py-1 pl-3">Experience</h4>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Job Title</th>
                                            <th>Job Type</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Job Summary</th>
                                        </tr>
                                        @if(count($workExperienceData) > 0)
                                            @foreach($workExperienceData as $experience)
                                            <tr>
                                                <td>{{$experience->company_name}}</td>
                                                <td>{{$experience->job_title}}</td>
                                                <td>{{$experience->job_type}}</td>
                                                <td>{{$experience->start_time}} - 
                                                    @if($experience->end_time)
                                                        Current
                                                    @else
                                                    {{$experience->end_time}}
                                                    @endif
                                                </td>
                                                <td>{{$experience->job_summary}}</td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="" class='text-center'>No Records Found.</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body p-2">
                                    
                                    <h4 class="mt-2 mb-3 border-bottom border-info text-dark py-1 pl-3">Certifications</h4>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Certificate Name</th>
                                            <th>Certificate Issuer</th>
                                            <th>Certificate Expiry</th>
                                        </tr>
                                        @if(count($certificationsData) > 0)
                                            @foreach($certificationsData as $certifications)
                                            <tr>
                                                <td>{{$certifications->certificate_name}}</td>
                                                <td>{{$certifications->certificate_issuer}}</td>
                                                <td>
                                                    @if($certifications->no_expiry=='1')
                                                    No Expiry
                                                    @else
                                                    {{$certifications->expiry_month}}/{{$certifications->expiry_year}}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="" class='text-center'>No Records Found.</td>
                                            </tr>
                                        @endif
                                    </table>
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
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
        })
        $('.select2').select2({
            width:200,
            placeholder: 'Select Students'
        });
    </script>
  @endsection
