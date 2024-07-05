<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\Auth;
use Illuminate\Support\Facades\Auth as AuthFacade;
use App\Http\Traits\CustomUtils;
use App\Models\company\CompanyJobs;
use App\Models\students\StudentJobMapping;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class ApiController extends Controller
{
    use Auth, CustomUtils;

    public function addUser(Request $request)
    {
        $response = [
            'status' => true,
            'message' => "User Created successfully!",
            'newUser' => []
        ];
        if (!$request->has('email_id')) {
            $response['message'] = 'Email id is required';
            return response()->json($response, 400); //409-conflict error
        }
        if (!$request->has('password')) {
            $response['message'] = 'Password is required';
            return response()->json($response, 400); //409-conflict error
        }
        if (!$request->has('user_id')) {
            $response['message'] = 'Username is required';
            return response()->json($response, 400); //409-conflict error
        }
        if (User::where('email', $request->input('email_id'))->exists()) {
            $response['message'] = 'User already exists with this email address';
            return response()->json($response, 409); //409-conflict error
        }
        $data['user_id'] = $request->input('user_id');
        $data['first_name'] = $request->input('first_name');
        $data['last_name'] = $request->input('last_name');
        $data['password'] = $request->input('password');
        $data['email_id'] = $request->input('email_id');
        $data['phone_no'] = $request->input('phone_no');
        $data['user_cat'] = $request->input('user_cat');
        $data['user_subcat'] = $request->input('user_subcat');
        $data['sess_user'] = $request->input('sess_user_id'); //session user from mobile server
        if ($request->has('company'))
            $data['company'] = $request->input('company');
        if ($request->has('accessLevel'))
            $data['accessLevel'] = $request->input('accessLevel');
        $newUser = $this->create_user($data);
        $response['newUser'] = $newUser;
        return response()->json($response, 201); //201-record created
    }

    public function updateUser(Request $request)
    {
        // dd($request->input());
        $response = [
            'status' => true,
            'message' => "User Updated Successfully!",
            'user' => []
        ];
        if (!$request->has('id')) {
            $response['message'] = 'Id is required';
            return response()->json($response, 200); //409-conflict error
        }
        if (!$request->has('password')) {
            $response['message'] = 'Password is required';
            return response()->json($response, 200); //409-conflict error
        }
        if (!$request->has('user_id')) {
            $response['message'] = 'Username is required';
            return response()->json($response, 200); //409-conflict error
        }
        $data['updated_id'] = $request->input('id');
        $data['user_id'] = $request->input('user_id');
        $data['first_name'] = $request->input('first_name');
        $data['last_name'] = $request->input('last_name');
        $data['password'] = $request->input('password');
        $data['active_status'] = $request->input('activeStatus');
        $data['phone_no'] = $request->input('phone_no');
        $data['user_cat'] = $request->input('user_cat');
        $data['user_subcat'] = $request->input('user_subcat');
        $data['sess_user'] = $request->input('sess_user_id'); //session user from mobile server
        if ($request->has('company'))
            $data['company'] = $request->input('company');
        if ($request->has('accessLevel'))
            $data['accessLevel'] = $request->input('accessLevel');
        $this->update_user($data);
        $response['user'] = User::where('id', $request->has('id'))->first();
        return response()->json($response, 200); //201-record created
    }

    public function getUsers(Request $request)
    {
        $response = [
            'status' => true,
            'message' => "User fetched successfully!",
            'users' => [],
            'key' => $request->input('user_cat')
        ];
        if (strtolower($request->input('user_cat')) == 'hr')
            $user_cat = 'HR';
        else if (strtolower($request->input('user_cat')) == 'companies')
            $user_cat = 'Company';
        else
            $user_cat = 'Student';
        $response['users'] = User::where('user_cat', $user_cat)->get();
        return response()->json($response, 201); //201-record created
    }

    public function getUser(Request $request, $id)
    {
        $response = [
            'status' => true,
            'message' => "User fetched successfully!",
            'user' => [],
        ];
        $response['user'] = User::where('id', $id)->first();
        if (User::where('id', $id)->exists()) {
            $userMapping = DB::table('user_company_mapping')->where('user_id', $id)->first();
            if ($userMapping) {
                $response['user']['access_level'] = $userMapping->accessLevel;
                $company_id = $userMapping->company_id;
                $companyData = DB::table('companies')->where('id', $company_id)->first();
                if ($companyData) {
                    $response['user']['company_name'] = $companyData['company_name'];
                }
            }
        }
        return response()->json($response, 200); //201-record created
    }
    public function deleteUser(Request $request, $id)
    {
        $response = [
            'status' => true,
            'message' => "User deleted successfully!",
            'user' => [],
        ];
        $response['user'] = User::where('id', $id)->first();
        User::where('id', $id)->delete();
        return response()->json($response, 200); //201-record created
    }

    public function getRecruiters(Request $request)
    {
        $response = [
            'status' => true,
            'message' => "Recruiters fetched and companies successfully!",
            'companies' => [],
            'recruiters' => [],
        ];
        $response['companies'] = DB::table('companies')->select('*')->get();
        $response['recruiters'] = DB::table('users')->where('user_cat', 'HR')->where('isActive', '1')->get();
        return response()->json($response, 200);
    }

    public function updateCompaniesRecruiter(Request $request)
    {
        $response = [
            'status' => true,
            'message' => "Companies Recruiter updated successfully!"
        ];
        $companyData = $request->input('data');
        foreach ($companyData as $data) {
            $company_id = $data['company_id'];
            $recruiter_id = $data['recruiter_id'];
            DB::table('companies')->where('id', $company_id)->update(['recruiter_id' => $recruiter_id]);
        }
        return response()->json($response, 200);
    }

    public function getCompany(Request $request, $company_id)
    {
        $response = [
            'status' => true,
            'message' => "Company data fetched successfully!",
            'company' => []
        ];
        $company = DB::table('companies')->select('*')->where('id', $company_id)->first();
        if ($company != null) {
            $company->media_images = DB::table('company_images')->where('company_id', $company_id)->get();
            if ($company->media_images != null) {
                foreach ($company->media_images as $companyImage)
                    $companyImage->image_url = asset('public/uploads/company/images/posts/' . $companyImage->image_url);
            }
            if ($company->company_logo != null)
                $company->company_logo = asset('public/uploads/company/logo/' . $company->company_logo);
            else
                $company->company_logo = asset('public/uploads/company/logo/default-logo.png');

            if ($company->company_cover != '')
                $company->company_cover = asset('public/uploads/company/cover/' . $company->company_cover);
            else
                $company->company_cover = asset('public/uploads/company/cover/default-cover-image.png');
            $response['company'] = $company;
        }
        return response()->json($response, 200);
    }

    public function getCompanies(Request $request)
    {
        $response = [
            'status' => true,
            'message' => "Companies fetched successfully!",
            'companies' => []
        ];
        $response['companies'] = DB::table('companies')->select('*')->get();
        foreach ($response['companies'] as $company) {
            if ($company->company_logo == null || $company->company_logo == '') {
                $company->company_logo = asset('public/uploads/company/logo/default-logo.png');
            }
        }
        return response()->json($response, 200);
    }

    public function getStudents(Request $request)
    {
        $response = [
            'status' => true,
            'message' => "Students fetched successfully!",
            'students' => []
        ];
        $response['students'] = DB::table('users')->leftJoin('student_profile', 'users.id', 'student_profile.student_id')->select('users.*', 'student_profile.profile_title')->where('users.user_cat', 'Student')->get();
        foreach ($response['students'] as $student) {
            if ($student->profile_pic == null || $student->profile_pic == '') {
                $student->profile_pic = asset('public/uploads/company/logo/default-logo.png');
            }
        }
        return response()->json($response, 200);
    }

    // COMMON ROUTES
    public function getSkills(Request $request)
    {
        $response = [
            'status' => true,
            'message' => "Skills fetched successfully!",
            'skills' => []
        ];
        $response['skills'] = DB::table('skills')->select('*')->get();
        return response()->json($response, 200);
    }
    public function getIndustries(Request $request)
    {
        $response = [
            'status' => true,
            'message' => "Industries fetched successfully!",
            'industries' => []
        ];
        $response['industries'] = DB::table('industry')->select('*')->get();
        return response()->json($response, 200);
    }

    public function createJob(Request $request)
    {
        $response = [
            'status' => true,
            'message' => "New job created successfully!",
            'job' => []
        ];
        $sessUser = $request->input('user_id');
        $company_id = $this->getUserCompanyId($sessUser); // get company id from current user
        $data['company_id'] = $company_id;
        $data['job_title'] = $request->input('job_title');
        $data['job_desc'] = $request->input('job_desc');
        $data['salary'] = $request->input('salary');
        $data['status'] = 'CREATED';
        $data['currency'] = $request->input('currency');
        $data['skills'] = is_array($request->input('skills')) ? implode(',', $request->input('skills')) : $request->input('skills');
        $data['job_deadline'] = $request->input('job_deadline');

        $data['email'] = $request->input('email');
        $data['phone'] = $request->input('phone');

        $data['industry_type'] = $request->input('industry_type');
        $data['employee_type'] = $request->input('employee_type');
        $data['opening'] = $request->input('opening');
        $data['experience_min'] = $request->input('experience_min');
        $data['experience_max'] = $request->input('experience_max');

        if ($company_id == 0) {
            $data['msg'] = 'Company id is required for creating a new job';
            return response()->json($response, 200);
        }

        $data['job'] = $this->create_jobs($data);
        return response()->json($response, 200);
    }

    public function updateJob(Request $request)
    {
        $response = [
            'status' => true,
            'message' => "Job updated successfully!",
            'job' => []
        ];
        $sessUser = $request->input('user_id');
        $company_id = $this->getUserCompanyId($sessUser); // get company id from current user
        $data['company_id'] = $company_id;
        $data['updated_id'] = $request->input('jobId');
        $data['job_title'] = $request->input('job_title');
        $data['job_desc'] = $request->input('job_desc');
        $data['salary'] = $request->input('salary');
        $data['status'] = 'UPDATED';
        $data['currency'] = $request->input('currency');
        $data['skills'] = is_array($request->input('skills')) ? implode(',', $request->input('skills')) : $request->input('skills');
        $data['job_deadline'] = $request->input('job_deadline');

        $data['email'] = $request->input('email');
        $data['phone'] = $request->input('phone');

        $data['industry_type'] = $request->input('industry_type');
        $data['employee_type'] = $request->input('employee_type');
        $data['opening'] = $request->input('opening');
        $data['experience_min'] = $request->input('experience_min');
        $data['experience_max'] = $request->input('experience_max');

        if ($company_id == 0) {
            $data['msg'] = 'Company id is required for updating job details';
            return response()->json($response, 200);
        }

        $data['job'] = $this->update_jobs($data);
        return response()->json($response, 200);
    }

    public function getJobs(Request $request, $companyId = '')
    {
        $response = [
            'status' => true,
            'message' => "Jobs fetched successfully!",
            'jobs' => []
        ];
        $response['jobs'] = DB::table('company_jobs')->select('*')
            ->addSelect(['total_applications' => DB::table('student_job_mappings')->select(DB::raw('count(id) as total'))->whereColumn('job_id', 'company_jobs.id')])
            ->addSelect(['company_logo' => DB::table('companies')->select('company_logo')->whereColumn('id', 'company_jobs.company_id')]);
        if ($companyId != '')
            $response['jobs'] = $response['jobs']->where('company_id', $companyId);
        if ($request->input('filter_by') == 'LATEST') {
            $response['jobs'] = $response['jobs']->orderBy('created_at', 'DESC');
        }
        if ($request->input('filter_by') == 'LATEST') {
            $response['jobs'] = $response['jobs']->orderBy('created_at', 'DESC');
        }
        $response['jobs'] = $response['jobs']->get();
        return response()->json($response, 200);
    }
    public function getJob(Request $request, $jobId)
    {
        $response = [
            'status' => true,
            'message' => "Industries fetched successfully!",
            'job' => []
        ];
        $response['job'] = DB::table('company_jobs')->select('*')->where('id', $jobId)->first();
        return response()->json($response, 200);
    }

    public function getJobStatus(Request $request, $candidate_id, $jobId)
    {
        $response = [
            'status' => true,
            'message' => "Job application status fetched successfully!",
            'jobStatus' => []
        ];
        $response['jobStatus'] = DB::table('student_job_mappings')->select('*')->where('job_id', $jobId)->where('student_id', $candidate_id)->first();
        return response()->json($response, 200);
    }

    public function getJobQuestions(Request $request, $jobId)
    {
        $response = [
            'status' => true,
            'message' => "Job questions fetched successfully!",
            'jobQuestions' => []
        ];
        $response['jobQuestions'] = DB::table('company_job_questions')->select('*')->where('job_id', $jobId)->get();
        return response()->json($response, 200);
    }
    public function getJobQuestionResponses(Request $request, $studentId)
    {
        $response = [
            'status' => true,
            'message' => "Job questions response fetched successfully!",
            'jobResponses' => []
        ];
        $jobResponses = [];
        $jobResponsesData = DB::table('job_question_response')->select('*')->where('student_id', $studentId)->get();
        foreach ($jobResponsesData as $jobResponse)
            $jobResponses[$jobResponse->question_id] = $jobResponse->response;
        $response['jobResponses'] = $jobResponses;
        return response()->json($response, 200);
    }

    public function updateCompanyProfile(Request $request)
    {
        $response = [
            'status' => true,
            'message' => "Company profile updated successfully!",
            'job' => []
        ];
        $company_id = $request->input('company_id');
        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image');
            $coverImageFileName = time() . '_' . $coverImage->getClientOriginalName();
            $coverImage->move(public_path('uploads/company/cover'), $coverImageFileName);
            DB::table('companies')->where('id', $company_id)->update(['company_cover' => $coverImageFileName]);
        }
        if ($request->hasFile('logo_image')) {
            $coverImage = $request->file('logo_image');
            $coverImageFileName = time() . '_' . $coverImage->getClientOriginalName();
            $coverImage->move(public_path('uploads/company/logo'), $coverImageFileName);
            DB::table('companies')->where('id', $company_id)->update(['company_logo' => $coverImageFileName]);
        }
        if ($request->has('no_of_employee')) {
            $company_name = $request->input('company_name');
            $no_of_employee = $request->input('no_of_employee');
            $location = $request->input('location');
            DB::table('companies')->where('id', $company_id)->update(['company_name' => $company_name, 'total_employee' => $no_of_employee, 'location' => $location]);
        }
        if ($request->has('company_description')) {
            $company_desc = $request->input('company_description');
            DB::table('companies')->where('id', $company_id)->update(['company_desc' => $company_desc]);
        }
        if ($request->hasFile('gallery_image')) {
            $galleryImage = $request->file('gallery_image');
            $galleryImageFileName = time() . '_' . $galleryImage->getClientOriginalName();
            $galleryImage->move(public_path('uploads/company/images/posts'), $galleryImageFileName);
            DB::table('company_images')->insert(['image_url' => $galleryImageFileName, 'company_id' => $company_id]);
        }
        return response()->json($response, 200);
    }

    public function assignStudentToJob(Request $request)
    {
        $response = [
            'status' => true,
            'message' => "Students assigned to job successfully!",
        ];
        $job_id = $request->input('job_id');
        $job_id = $request->input('job_id');
        $student_ids = $request->input('student_ids');
        foreach ($student_ids as $student_id) {
            if (StudentJobMapping::where('job_id', $job_id)->where('student_id', $student_id)->doesntExist()) {
                $newJobMapping = new StudentJobMapping();
                $newJobMapping->student_id =  $student_id;
                $newJobMapping->job_id =  $job_id;
                $newJobMapping->jobStatus =  'ASSIGNED';
                $newJobMapping->profile_id =  null;
                $newJobMapping->is_assigned = '1';
                $newJobMapping->save();
                // SEND MAIL NOTIFICATION
                $jobData = DB::table('company_jobs')->where('id', $job_id)->first();
                $userData = DB::table('users')->where('id', $student_id)->first();
                $data = ['jobData' => $jobData, 'userData' => $userData];
                $mailData = [
                    'to' => $userData->email,
                    'subject' => 'New Job Assigned | ' . $jobData->job_title,
                    'bladeName' => 'emails.assignJob',
                    'bladeData' => $data,

                ];
                $this->send_mail($mailData);
            }
        }
        return response()->json($response, 200);
    }

    public function applyJob(Request $request)
    {
        $response = [
            'status' => true,
            'message' => "Applied successfully!",
        ];
        $id = $request->input('jobId');
        $currentStudentId = $request->input('candidateId');
        $questionIds = $request->input('questionId');
        // If user applied by itself
        if (DB::table('student_job_mappings')->where('job_id', $id)->where('student_id', $currentStudentId)->doesntExist()) {
            DB::table('student_job_mappings')
                ->where('job_id', $id)
                ->where('student_id', $currentStudentId)
                ->update(['is_applied' => '1', 'jobStatus' => 'APPLIED']);
            $newJobMapping = new StudentJobMapping();
            $newJobMapping->student_id =  $currentStudentId;
            $newJobMapping->job_id =  $id;
            $newJobMapping->jobStatus =  'APPLIED';
            $newJobMapping->profile_id =  null;
            $newJobMapping->is_assigned = '1';
            $newJobMapping->save();
        } else { // If HR assigned job to student
            DB::table('student_job_mappings')
                ->where('job_id', $id)
                ->where('student_id', $currentStudentId)
                ->update(['is_applied' => '1', 'jobStatus' => 'APPLIED']);
        }
        if ($request->has('questionId')) {
            foreach ($questionIds as $questionId => $questionResponse) {
                DB::table('job_question_response')->insert([
                    'question_id' => $questionId,
                    'student_id' => $currentStudentId,
                    'response' => $questionResponse
                ]);
            }
        }
        // SEND MAIl
        $adminUsers = DB::table('users')->where('user_cat', 'Admin')->get();
        $jobData = DB::table('company_jobs')->where('id', $id)->first();
        $studentData = DB::table('users')->where('id', $currentStudentId)->first();
        foreach ($adminUsers as $user) {
            $data = ['adminData' => $user, 'job_data' => $jobData, 'studentData' => $studentData];
            $mailData = [
                'to' => $user->email,
                'subject' => 'Job Application | ' . $jobData->job_title,
                'bladeName' => 'emails.jobApply',
                'bladeData' => $data,
            ];
            $this->send_mail($mailData);
        }
        return response()->json($response, 200);
    }

    public function getJobApplication(Request $request, $jobid)
    {
        $sessUserCategory = $request->input('user_cat');
        $jobData = DB::table('company_jobs')->select('job_title', 'id')->where('id', $jobid)->first();
        $educationCategories = DB::table('education_category')->select('*')->get();
        $skillsCategories = DB::table('skills')->select('*')->get();
        $applicationsList = DB::table('company_jobs')->join('student_job_mappings', 'company_jobs.id', 'student_job_mappings.job_id')
            ->join('users', 'student_job_mappings.student_id', 'users.id')
            ->select('company_jobs.*', 'company_jobs.id as jobId', 'student_job_mappings.id as mapping_id', 'student_job_mappings.jobStatus', 'student_job_mappings.is_applied', 'users.first_name', 'users.last_name', 'users.id as studentId')
            ->addSelect(['resume' => DB::table('student_profile')->select('resume')->whereColumn('student_id', 'studentId')])
            ->addSelect(['profile_title' => DB::table('student_profile')->select('profile_title')->whereColumn('student_id', 'studentId')])
            ->addSelect(['phone' => DB::table('student_profile')->select('phone')->whereColumn('student_id', 'studentId')])
            ->addSelect(['application_status' => DB::table('student_job_logs')->select('status')->whereColumn('job_mapping_id', 'student_job_mappings.id')->orderBy('student_job_logs.id', 'DESC')->limit(1)])
            ->where('job_id', $jobid);
        if ($sessUserCategory == 'Company') {
            $applicationsList = $applicationsList->whereIn('jobStatus', ['APPROVED', 'INTERVIEWED']);
        }
        $applicationsList = $applicationsList->get();
        Log::info($applicationsList);
        return response()->json(['status' => true, 'message' => 'Job applications fetched successfully.', 'jobData' => $jobData, 'applicationsList' => $applicationsList, 'jobid' => $jobid, 'educationCategories' => $educationCategories, 'skillsCategories' => $skillsCategories]);
    }

    public function actionOnJobApplication(Request $request)
    {
        $job_id = $request->input('job_id');
        $student_id = $request->input('student_id');
        if ($request->input('action') == 'approve')
            $jobStatus = 'APPROVED';
        else
            $jobStatus = 'REJECTED';
        DB::table('student_job_mappings')->where('job_id', $job_id)->where('student_id', $student_id)->update([
            'jobStatus' => $jobStatus
        ]);
        // SEND MAIL
        $jobData = DB::table('company_jobs')->where('id', $job_id)->first();
        $userData = DB::table('users')->where('id', $student_id)->first();
        $data = ['jobData' => $jobData, 'userData' => $userData];
        $mailData = [
            'to' => $userData->email,
            'subject' => 'Job Application Approved | ' . $jobData->job_title,
            'bladeName' => 'emails.approveJob',
            'bladeData' => $data,

        ];
        // $this->send_mail($mailData);
        return response()->json(['status' => 1, 'message' => 'Job application approved successfully'], 200);
    }

    public function scheduleJobInterview(Request $request)
    {
        Log::info($request->input());
        $job_mapping_id = $request->input('job_mapping_id');
        $instructions = $request->input('instructions');
        $interviewTime = $request->input('datetime');
        DB::table('student_job_mappings')->where('id', $job_mapping_id)->update([
            'instructions' => $instructions,
            'interview_time' => $interviewTime,
            'jobStatus' => 'INTERVIEWED',
        ]);
        // SEND MAIL
        $jobMappingDetail = DB::table('student_job_mappings')->where('id', $job_mapping_id)->first();

        $jobData = DB::table('company_jobs')->where('id', $jobMappingDetail->job_id)->first();
        $userData = DB::table('users')->where('id', $jobMappingDetail->student_id)->first();
        $data = ['jobData' => $jobData, 'userData' => $userData, 'jobMappingDetail' => $jobMappingDetail];
        $mailData = [
            'to' => $userData->email,
            'subject' => 'Job Interview Scheduled | ' . $jobData->job_title,
            'bladeName' => 'emails.scheduleInterview',
            'bladeData' => $data,

        ];
        // $this->send_mail($mailData);
        return response()->json(['status' => true, 'message' => 'Job interview scheduled successfully.'], 200);
    }

    public function updateJobApplicationStatus(Request $request)
    {
        $currentUser = 'DEMO COMPANY';
        $job_mapping_id = $request->input('job_mapping_id');
        DB::table('student_job_logs')->insert([
            'job_mapping_id' => $job_mapping_id,
            'created_on' => Carbon::now(),
            'status' => $request->input('status'),
            'message' => $request->input('message'),
            'created_by' => 'ADMIN'
        ]);
        // SEND MAIL NOTIFICATION
        $jobMappingData = DB::table('student_job_mappings')->where('id', $job_mapping_id)->first();
        if ($jobMappingData != null) {
            $jobData = DB::table('company_jobs')->where('id', $jobMappingData->job_id)->first();
            $userData = DB::table('users')->where('id', $jobMappingData->student_id)->first();
            $data = [
                'action_by' => $currentUser, 'jobData' => $jobData, 'status' => $request->input('status'), 'message' => $request->input('message'), 'userData' => $userData
            ];
            $mailData = [
                'to' => $userData->email,
                'subject' => 'Job Application Status Update | ' . $jobData->job_title,
                'bladeName' => 'emails.applicationStatusUpdate',
                'bladeData' => $data,
            ];
            // $this->send_mail($mailData);
        }
        return response()->json(['status' => 200, 'message' => 'Job application status updated successfully'], 200);
    }

    // AUTH FUNCTIONS
    public function login(Request $request)
    {
        Log::info($request->input());
        if (AuthFacade::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = AuthFacade::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            if ($user['profile_pic'] != '') {
                $user['profile_pic'] =  asset('public/uploads/profile/' . $user['profile_pic']);
            }
            $user['companyId'] = $this->getUserCompanyId($user['id']);
            $success['user'] =  $user;
            $response = [
                'success' => true,
                'data'    => $success,
                'message' => 'User login successfully.',
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'message' => 'Unauthorised',
            ];
            $response['data'] = ['error' => 'Unauthorised'];
            return response()->json($response, 200);
        }
    }

    public function register(Request $request)
    {
        $response = [
            'success' => true,
            'message' => 'User registered successfully.',
        ];

        $user_cat = $request->input('user_cat');
        if ($user_cat == 'Company') {
            $company = $request->input('company');
            $accessLevel = $request->input('accessLevel');
            if ($company == '') {
                $response['message'] = "Company name is required..";
                return response()->json($response, 200);
            } elseif ($accessLevel == "") {
                $response['message'] = "Access level is required..";
                return response()->json($response, 200);
            }
        }

        $userData = $request->input();
        $user = User::create($userData);

        if ($user_cat == 'Company') {
            $company_id = DB::table('companies')->insertGetId([
                'company_name' => $company
            ]);
            DB::table('user_company_mapping')->insert([
                'user_id' => $user->id,
                'accessLevel' => $accessLevel,
                'company_id' => $company_id
            ]);
        } else if ($user_cat == 'Student') {
            DB::table('student_profile')->insert([
                'student_id' => $user->id
            ]);
        }

        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
        return response()->json($response, 200);
    }
    // public function register(Request $request)
    // {
    //     $response = [
    //         'success' => true,
    //         'message' => 'User registered successfully.',
    //     ];
    //     $validator = Validator::make($request->all(), [
    //         'first_name' => 'required',
    //         'last_name' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required',
    //         'userid' => 'required'
    //         // 'c_password' => 'required|same:password',
    //     ]);
    //     if ($validator->fails()) {
    //         $response['message'] = $validator->errors();
    //         return response()->json($response, 200);
    //     }
    //     $input = $request->all();
    //     $input['password'] = bcrypt($input['password']);
    //     $user = User::create($input);
    //     $success['token'] =  $user->createToken('MyApp')->plainTextToken;
    //     $success['name'] =  $user->name;
    //     return response()->json($response, 200);
    // }

    public function fetchJobs(Request $request)
    {
        $perPageRecord = 5;
        $jobs = [];
        $student_id = $request->input('student_id');
        $jobsCountQry = DB::table('company_jobs')
            ->join('companies', 'company_jobs.company_id', 'companies.id')
            ->select('company_jobs.id')
            ->where('company_jobs.isActive', '1');
        $jobsCountQry = $this->addJobSearchCondition($request, $jobsCountQry);
        $jobsCount = $jobsCountQry->count();
        $total_pages = ceil($jobsCount / $perPageRecord);
        $jobsDataQry = DB::table('company_jobs')
            ->join('companies', 'company_jobs.company_id', 'companies.id')
            ->select('company_jobs.*', 'companies.company_name', 'companies.company_logo')
            ->addSelect(['job_status' => DB::table('student_job_mappings')->select('jobStatus')->whereColumn('job_id', 'company_jobs.id')->where('student_id', $student_id)->limit(1)])
            ->where('company_jobs.isActive', '1');
        $jobsDataQry = $this->addJobSearchCondition($request, $jobsDataQry);
        $jobsDataQry = $this->apply_pagination($request, $jobsDataQry, 5);
        $jobs = $jobsDataQry->get();
        foreach ($jobs as $job) {
            $job->enc_id = Crypt::encrypt($job->id);
            if ($job->company_logo != null)
                $job->company_logo = asset('public/uploads/company/logo/' . $job->company_logo);
            else
                $job->company_logo = asset('public/uploads/company/logo/default-logo.png');
        }
        return response()->json(['status' => true, 'message' => 'Jobs fetced successfully.', 'count' => $jobsCount, 'jobs' => $jobs, 'total_pages' => $total_pages], 200);
    }

    public function addJobSearchCondition($request, $jobsDataQry)
    {
        if ($request->has('location') && $request->input('location') != '')
            $jobsDataQry = $jobsDataQry->where('company_jobs.location', '=', $request->input('location'));
        if ($request->has('experience') && $request->input('experience') != '') {
            $experienceRange = $this->getExperienceRange($request->input('experience'));
            $jobsDataQry = $jobsDataQry->where(function ($q) use ($experienceRange) {
                $q->where('company_jobs.experience_min', '>=', $experienceRange['min']);
                // orWhere('company_jobs.experience_max', '<', $experienceRange['max']);
            });
        }
        if ($request->has('education') && $request->input('education') != '') {
            // $jobsDataQry = $jobsDataQry->where('company_jobs.education', '=', $request->input('education'));
        }
        if ($request->has('skills') && $request->input('skills') != '')
            $jobsDataQry = $jobsDataQry->whereIn('company_jobs.skills', explode(",", $request->input('skills')));
        // if ($request->has('work_type') && $request->input('work_type') != '')
        //     $jobsDataQry = $jobsDataQry->where('company_jobs.work_type', '=', $request->input('work_type'));
        if ($request->has('search_text') && $request->input('search_text') != '')
            $jobsDataQry = $jobsDataQry->where(function ($q) use ($request) {
                $q->where('company_jobs.job_title', 'LIKE', "%" . $request->input('search_text') . "%")->orWhere('company_jobs.job_desc', 'LIKE', "%" . $request->input('search_text') . "%");
            });
        return $jobsDataQry;
    }

    public function apply_pagination($request, $qry, $perPageRecord = 10)
    {
        if ($request->has('page_number') && $request->input('page_number') != 1) {
            $page_number = $request->input('page_number');
            $offset = ($page_number - 1) * $perPageRecord + 1;
            $qry = $qry->offset($offset)->limit($perPageRecord)->get();
        } else
            $qry = $qry->offset(0)->limit($perPageRecord);
        return $qry;
    }

    public function getStudentProfile(Request $request, $studentId)
    {
        $response = [
            'success' => true,
            'data'    => [],
            'message' => 'Student profile fetched successfully.',
        ];
        $data['userData'] = User::where('id', $studentId)->first();
        if ($data['userData'] != null) {
            if ($data['userData']['profile_pic'] != '' && $data['userData']['profile_pic'] != null)
                $data['userData']['profile_pic'] = asset('public/uploads/company/logo/' . $data['userData']['profile_pic']);
            else
                $data['userData']['profile_pic'] = asset('public/uploads/company/logo/default-logo.png');
        }
        $data['personalDetails'] = DB::table('student_profile')->where('student_id', $studentId)->first();
        $data['educationsData'] = DB::table('student_educations')->where('student_id', $studentId)->get();
        $data['workExperienceData'] = DB::table('student_work_history')->where('student_id', $studentId)->get();
        $data['linksData'] = DB::table('student_external_links')->where('student_id', $studentId)->get();
        $data['certificationsData'] = DB::table('student_certificates')->where('student_id', $studentId)->get();
        $response['data'] = $data;
        return response()->json($response, 200);
    }

    public function getStudentProfileDataByType(Request $request, $type, $studentId)
    {
        $response = [
            'success' => true,
            'data'    => [],
            'message' => 'Student profile fetched successfully.',
        ];
        if ($type == 'PERSONAL') {
            $data['personalDetails'] = DB::table('student_profile')->where('student_id', $studentId)->first();
        } else if ($type == 'EDUCATION') {
            $data['educationsData'] = DB::table('student_educations')->where('student_id', $studentId)->get();
            $counter = 1;
            foreach ($data['educationsData'] as $record) {
                $record->rowId = $counter;
                $counter++;
            }
        } else if ($type == 'EXPERIENCE') {
            $data['workExperienceData'] = DB::table('student_work_history')->where('student_id', $studentId)->get();
            $counter = 1;
            foreach ($data['workExperienceData'] as $record) {
                $record->rowId = $counter;
                $counter++;
            }
        } else if ($type == 'CERTIFICATE') {
            $data['certificationsData'] = DB::table('student_certificates')->where('student_id', $studentId)->get();
        } else if ($type == 'LINKS') {
            $data['linksData'] = DB::table('student_external_links')->where('student_id', $studentId)->get();
        }
        $response['data'] = $data;
        return response()->json($response, 200);
    }

    public function updateStudentPersonalData(Request $request, $studentId)
    {
        Log::info($request->input());
        $response = [
            'success' => true,
            'data'    => [],
            'message' => 'Student profile updated successfully.',
        ];
        $fieldsArray = [];
        $profile_title = $request->input('profile_title');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $gender = $request->input('gender');
        $date_of_birth = Carbon::parse($request->input('date_of_birth'));
        $willing_to_relocate = $request->input('willing_to_relocate');
        $phone = $request->input('phone');
        $address = $request->input('address');
        if ($request->has('profile_pic')) {
            $file = $request->file('profile_pic');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile'), $fileName);
            DB::table('users')->where('id', $studentId)->update(['profile_pic' => $fileName]);
        }
        DB::table('users')->where('id', $studentId)->update([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $phone,
            'email' => $email,
        ]);
        if ($request->has('willling_to_relocate'))
            $willing_to_relocate = 1;
        else
            $willing_to_relocate = 1;
        $fieldsArray = [
            'profile_title' => $profile_title,
            'phone' => $phone,
            'gender' => $gender,
            'date_of_birth' => $date_of_birth,
            'street_address' => $address,
            'profile_title' => $profile_title,
            'willing_to_relocate' => $willing_to_relocate
        ];
        if ($request->has('resume')) {
            $file = $request->file('resume');
            $fileName = 'resume_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile/resume'), $fileName);
            $fieldsArray['resume'] = $fileName;
        }
        if (DB::table('student_profile')->where('student_id', $studentId)->exists()) {
            DB::table('student_profile')->where('student_id', $studentId)->update($fieldsArray);
        } else {
            $fieldsArray['student_id'] = $studentId;
            DB::table('student_profile')->insert($fieldsArray);
        }
        return response()->json($response, 200);
    }

    public function updateStudentEducationData(Request $request, $studentId)
    {
        $response = [
            'success' => true,
            'data'    => [],
            'message' => 'Student profile updated successfully.',
        ];
        $educationRecords = $request->input('educationRecords');
        for ($i = 0; $i < count($educationRecords); $i++) {
            try {
                $startTimeDateObj = Carbon::parse($educationRecords[$i]['start_time']);
                $startTime = $startTimeDateObj->format('Y-m-d');
                $endTimeDateObj = Carbon::parse($educationRecords[$i]['end_time']);
                $endTime = $endTimeDateObj->format('Y-m-d');
            } catch (\Exception $e) {
                $message['message'] = 'Invalid date format';
                return response()->json($response, 200);
            }
            if (isset($educationRecords[$i]['id']) || DB::table('student_educations')->where('student_id', $studentId)->where('degree', $educationRecords[$i]['degree'])->where('institute', $educationRecords[$i]['institute'])->exists()) {
                $record_id = $educationRecords[$i]['id'];
                DB::table('student_educations')->where('id', $record_id)->update([
                    'student_id' => $studentId,
                    'institute' => $educationRecords[$i]['institute'],
                    'degree' => $educationRecords[$i]['degree'],
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'marks' => $educationRecords[$i]['marks'],
                    'isStudying' => $educationRecords[$i]['isStudying']
                ]);
            } else {
                DB::table('student_educations')->insert([
                    'student_id' => $studentId,
                    'institute' => $educationRecords[$i]['institute'],
                    'degree' => $educationRecords[$i]['degree'],
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'marks' => $educationRecords[$i]['marks'],
                    'isStudying' => $educationRecords[$i]['isStudying']
                ]);
            }
        }
        return response()->json($response, 200);
    }

    public function updateStudentExperienceData(Request $request, $studentId)
    {
        $response = [
            'success' => true,
            'data'    => [],
            'message' => 'Student profile updated successfully.',
        ];
        $educationRecords = $request->input('experienceRecords');
        for ($i = 0; $i < count($educationRecords); $i++) {
            try {
                $startTimeDateObj = Carbon::parse($educationRecords[$i]['start_time']);
                $startTime = $startTimeDateObj->format('Y-m-d');
                $endTimeDateObj = Carbon::parse($educationRecords[$i]['end_time']);
                $endTime = $endTimeDateObj->format('Y-m-d');
            } catch (\Exception $e) {
                $message['message'] = 'Invalid date format';
                return response()->json($response, 200);
            }
            if (isset($educationRecords[$i]['id']) && DB::table('student_work_history')->where('id', $educationRecords[$i]['id'])->exists()) {
                $record_id = $educationRecords[$i]['id'];
                DB::table('student_work_history')->where('id', $record_id)->update([
                    'student_id' => $studentId,
                    'company_name' => $educationRecords[$i]['company_name'],
                    'job_title' => $educationRecords[$i]['job_title'],
                    'job_type' => $educationRecords[$i]['job_type'],
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'job_summary' => $educationRecords[$i]['job_summary'],
                    'isWorking' => $educationRecords[$i]['isWorking']
                ]);
            } else {
                DB::table('student_work_history')->insert([
                    'student_id' => $studentId,
                    'company_name' => $educationRecords[$i]['company_name'],
                    'job_title' => $educationRecords[$i]['job_title'],
                    'job_type' => $educationRecords[$i]['job_type'],
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'job_summary' => $educationRecords[$i]['job_summary'],
                    'isWorking' => $educationRecords[$i]['isWorking']
                ]);
            }
        }
        return response()->json($response, 200);
    }

    public function updateStudentCertificationData(Request $request, $studentId)
    {
        $response = [
            'success' => true,
            'data'    => [],
            'message' => 'Student profile updated successfully.',
        ];
        $certificationRecord = $request->input('certificationRecords');
        for ($i = 0; $i < count($certificationRecord); $i++) {
            if (isset($certificationRecord[$i]['id']) && DB::table('student_certificates')->where('id', $certificationRecord[$i]['id'])->exists()) {
                $record_id = $certificationRecord[$i]['id'];
                DB::table('student_certificates')->where('id', $record_id)->update([
                    'student_id' => $studentId,
                    'certificate_name' => $certificationRecord[$i]['certificate_name'],
                    'certificate_issuer' => $certificationRecord[$i]['certificate_issuer'],
                    'expiry_month' => $certificationRecord[$i]['expiry_month'],
                    'expiry_year' => $certificationRecord[$i]['expiry_year'],
                    'no_expiry' => $certificationRecord[$i]['no_expiry']
                ]);
            } else {
                DB::table('student_certificates')->insert([
                    'student_id' => $studentId,
                    'certificate_name' => $certificationRecord[$i]['certificate_name'],
                    'certificate_issuer' => $certificationRecord[$i]['certificate_issuer'],
                    'expiry_month' => $certificationRecord[$i]['expiry_month'],
                    'expiry_year' => $certificationRecord[$i]['expiry_year'],
                    'no_expiry' => $certificationRecord[$i]['no_expiry']
                ]);
            }
        }
        return response()->json($response, 200);
    }

    public function createPaymentIntent(Request $request)
    {
        $user_id = $request->input('user_id');
        Stripe::setApiKey('sk_test_51HY3ZHIGb51k0BVe58P8ENOOhtQGrneRnFwuiNP7hfp6xr1OgfrtJDyHqV9k6gVhXs5mqEjIndjr4auHqlWhwn7N00v35rMQNw');

        $amount = $request->input('amount');
        $currency = 'inr';  // Set your currency here

        $paymentIntent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => $currency
        ]);
        DB::table('user_payment_details')->insert([
            'user_id' => $user_id,
            'transaction_time' => Carbon::now(),
            'payment_status' => 'in_progress', // or succeeded
            'payment_id' => $paymentIntent->client_secret,
            'ip_address' => $request->ip(),
            'source' => '1'
        ]);
        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
        ]);
    }

    public function confirmUserPayment(Request $request)
    {
        $response = [
            'success' => true,
            'message' => 'Payment status updated successfully.'
        ];
        $user_id = $request->input('user_id');
        DB::table('users')->where('id', $user_id)->update(['accepted_agreements' => '1']);
        return response()->json($response, 200);
    }

    public function fetchStudentJobs(Request $request, $currentStudentId)
    {
        $response = [
            'status' => true,
            'message' => "Jobs fetched successfully!",
            'jobs' => [],
        ];
        $jobsData = CompanyJobs::join('student_job_mappings', 'company_jobs.id', '=', 'student_job_mappings.job_id')->select('company_jobs.*', 'student_job_mappings.is_applied', 'student_job_mappings.jobStatus')
            ->addSelect(['company_name' => DB::table('companies')->select('company_name')->whereColumn('id', 'company_jobs.company_id')])
            ->addSelect(['company_logo' => DB::table('companies')->select('company_logo')->whereColumn('id', 'company_jobs.company_id')])
            ->addSelect(['current_job_status' => DB::table('student_job_logs')->select('status')->whereColumn('job_mapping_id', 'student_job_mappings.id')->orderBy('student_job_logs.id', 'DESC')->limit(1)])
            ->where('student_id', $currentStudentId);
        if ($request->input('jobType') == 'Assigned Jobs')
            $jobsData = $jobsData->where('student_job_mappings.is_assigned', '1');
        else
            $jobsData = $jobsData->where('student_job_mappings.is_assigned', '0');
        $response['jobs'] = $jobsData->get();
        foreach ($response['jobs'] as $job) {
            if ($job->company_logo != null)
                $job->company_logo = asset('public/uploads/company/logo/' . $job->company_logo);
            else
                $job->company_logo = asset('public/uploads/company/logo/default-logo.png');
        }
        return response()->json($response, 201); //201-record created
    }

    public function updateCompanyUserAgreemnt(Request $request, $userId)
    {
        $response = [
            'status' => true,
            'message' => "Company user agreement updated successfully!"
        ];
        if ($request->input('agreement_status') == 1)
            $accepted_agreement = '1';
        else
            $accepted_agreement = '0';

        DB::table('users')->where('id', $userId)->update(['accepted_agreements' => $accepted_agreement]);
        return response()->json($response, 200); //201-record created
    }
}
