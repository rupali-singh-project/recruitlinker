<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\Auth;
use App\Models\company\CompanyJobQuestion;
use App\Models\Login;
use App\Models\company\CompanyJobs;
use Illuminate\Support\Facades\Crypt;
use App\Http\Traits\CustomUtils;
use App\Models\Companies;
use Carbon\Carbon;

class CompanyController extends Controller
{
    use Auth, CustomUtils;

    public function getAgreements(Request $request)
    {
        return view('bladeFiles.company.agreements');
    }

    public function updateAgreements(Request $request)
    {
        $currentUser = $this->getSessUser($request);
        DB::table('users')->where('id', $currentUser['id'])->update(['accepted_agreements' => '1']);
        return redirect('land')->with('success', 'Agreements accepted successfully');
    }

    public function getNewJobForm($id = '')
    {
        $jobQuestions = [];
        if ($id != '') {
            $jobsDtls = CompanyJobs::where('isActive', '1')->where('id', Crypt::decrypt($id))->first();
            $action = 'UPDATE';
            $jobQuestions = CompanyJobQuestion::where('job_id', Crypt::decrypt($id))->get();
        } else {
            $jobsDtls = [];
            $action = 'ADD';
        }

        $getSkills = DB::table('skills')->where('isActive', '1')->get();
        $getIndustry = DB::table('industry')->where('isActive', '1')->get();
        $jobProfileData = DB::table('job_category')->where('isActive', '1')->get();

        return view('bladeFiles.company.AddNewJob', [
            'jobsDtls' => $jobsDtls, 'action' => $action, 'id' => $id,
            'jobQuestions' => $jobQuestions, 'getSkills' => $getSkills, 'getIndustry' => $getIndustry, 'jobProfileData' => $jobProfileData
        ]);
    }

    public function addJobQuestion(Request $request)
    {
        $row = $request->input('row');
        $job_id = Crypt::decrypt($request->input('job_id'));
        for ($i = 0; $i < count($row); $i++) {
            if ($request->has('is_required_' . $row[$i]))
                $isRequired = '1';
            else
                $isRequired = '0';
            if ($request->input('row_key_id_' . $row[$i])) {
                CompanyJobQuestion::where('id', $request->input('row_key_id_' . $row[$i]))->update([
                    'question' => $request->input('question_' . $row[$i]),
                    'is_required' => $isRequired,
                    'job_id' => $job_id
                ]);
            } else {
                $newQuestion = new CompanyJobQuestion();
                $newQuestion->question = $request->input('question_' . $row[$i]);
                $newQuestion->is_required = $isRequired;
                $newQuestion->job_id = $job_id;
                $newQuestion->save();
            }
        }
        return response()->json(['status' => '1', 'msg' => 'Job questions added successfully']);
    }

    public function deleteJobQuestion(Request $request)
    {
        CompanyJobQuestion::where('id', $request->input('id'))->delete();
        return response()->json(['status' => '1', 'msg' => 'Job questions deleted successfully']);
    }

    public function createNewJobs(Request $request)
    {
        $sessUser = $this->getSessUser($request); //get current user id
        $updated_id = $request->input('updated_id');
        $company_id = $this->getUserCompanyId($sessUser['id']); // get company id from current user
        $data['updated_id'] = $request->input('updated_id');
        $data['company_id'] = $company_id;
        $data['job_title'] = $request->input('job_title');
        $data['job_desc'] = $request->input('job_desc');
        $data['salary'] = $request->input('salary');
        $data['status'] = 'CREATED';
        $data['currency'] = $request->input('currency');
        $data['skills'] = implode(',', $request->input('skills'));
        $data['job_deadline'] = $request->input('job_deadline');

        $data['email'] = $request->input('email');
        $data['phone'] = $request->input('phone');

        $data['industry_type'] = $request->input('industry_type');
        $data['employee_type'] = $request->input('employee_type');
        $data['opening'] = $request->input('opening');
        $data['experience_min'] = $request->input('experience_min');
        $data['experience_max'] = $request->input('experience_max');

        if ($company_id == 0) {
            return redirect()->back()->with('error', 'Error: Company id is required for creating a new job');
        }

        if ($updated_id == '') {
            $this->create_jobs($data);
            return redirect()->back();
        } else {
            $this->update_jobs($data);
            return redirect()->back();
        }
    }

    public function getJobsList(Request $request)
    {
        $session_user = $this->getSessUser($request);
        $companyId = $this->getUserCompanyId($session_user['id']);
        $getJobsDetails = CompanyJobs::where('company_id', $companyId)->get();
        $getPendingJobsCnt = CompanyJobs::where('company_id', $companyId)->where('status', 'Pending')->count();
        $getApprovedJobsCnt = CompanyJobs::where('company_id', $companyId)->where('status', 'Approved')->count();
        $getRejectJobsCnt = CompanyJobs::where('company_id', $companyId)->where('status', 'Reject')->count();
        return view('bladeFiles.company.JobsList', [
            'getJobsDetails' => $getJobsDetails, 'getPendingJobsCnt' => $getPendingJobsCnt,
            'getApprovedJobsCnt' => $getApprovedJobsCnt, 'getRejectJobsCnt' => $getRejectJobsCnt
        ]);
    }


    // COMPANY PROFILE PAGE CODE

    public function getCompanyProfile(Request $request, $companyId)
    {
        if ($request->has('view_mode') && $request->get('view_mode') == 1)
            $isEditAccess = 0; //disable update feature
        else
            $isEditAccess = $this->getCompanyAccessRole($request); //check if user has edit access
        $companyId = Crypt::decrypt($companyId);
        $companyData = DB::table("companies")->where('id', $companyId)->first();
        $companyImages = DB::table('company_images')->where('company_id', $companyId)->get();
        return view('bladeFiles.company.Profile', ['companyData' => $companyData, 'companyImages' => $companyImages, 'isEditAccess' => $isEditAccess]);
    }

    public function updateCompanyCoverImage(Request $request)
    {
        $company_id = $request->input('company_id');
        if ($request->hasFile('cover-image')) {
            $coverImage = $request->file('cover-image');
            $coverImageFileName = time() . '_' . $coverImage->getClientOriginalName();
            $coverImage->move(public_path('uploads/company/cover'), $coverImageFileName);
            DB::table('companies')->where('id', $company_id)->update(['company_cover' => $coverImageFileName]);
            return response()->json(['message' => 'File uploaded successfully'], 200);
        }
        return response()->json(['message' => 'File upload failed'], 400);
    }
    public function updateCompanyLogo(Request $request)
    {
        $company_id = $request->input('company_id');
        if ($request->hasFile('logo-image')) {
            $coverImage = $request->file('logo-image');
            $coverImageFileName = time() . '_' . $coverImage->getClientOriginalName();
            $coverImage->move(public_path('uploads/company/logo'), $coverImageFileName);
            DB::table('companies')->where('id', $company_id)->update(['company_logo' => $coverImageFileName]);
            return response()->json(['message' => 'File uploaded successfully'], 200);
        }
        return response()->json(['message' => 'File upload failed'], 400);
    }
    public function updateCompanyInfo(Request $request)
    {
        $company_id = $request->input('company_id');
        if ($request->has('no_of_employee')) {
            $company_name = $request->input('company_name');
            $no_of_employee = $request->input('no_of_employee');
            $location = $request->input('location');
            DB::table('companies')->where('id', $company_id)->update(['company_name' => $company_name, 'total_employee' => $no_of_employee, 'location' => $location]);
            return response()->json(['message' => 'Company Info Updated Successfully'], 200);
        }
        return response()->json(['message' => 'Update Failed.'], 400);
    }
    public function updateCompanyAboutUsInfo(Request $request)
    {
        $company_id = $request->input('company_id');
        if ($request->has('company_description')) {
            $company_desc = $request->input('company_description');
            DB::table('companies')->where('id', $company_id)->update(['company_desc' => $company_desc]);
            return response()->json(['message' => 'Company Info Updated Successfully'], 200);
        }
        return response()->json(['message' => 'Update failed'], 400);
    }
    public function updateGalleryImage(Request $request)
    {
        $company_id = $request->input('company_id');
        if ($request->hasFile('gallery-image')) {
            $galleryImage = $request->file('gallery-image');
            $galleryImageFileName = time() . '_' . $galleryImage->getClientOriginalName();
            $galleryImage->move(public_path('uploads/company/images/posts'), $galleryImageFileName);
            $companyData = DB::table('companies')->select('company_images')->where('id', $company_id)->first();
            DB::table('company_images')->insert(['image_url' => $galleryImageFileName, 'company_id' => $company_id]);
            return response()->json(['message' => 'File uploaded successfully'], 200);
        }
        return response()->json(['message' => 'Update failed'], 400);
    }

    public function deleteGalleryImage(Request $request)
    {
        if ($request->has("ids")) {
            $ids = $request->input('ids');
            foreach ($ids as $id) {
                DB::table('company_images')->where('id', $id)->delete();
            }
            return response()->json(['message' => 'Delete']);
        } else {
            return response()->json(['message' => 'No Images Found!']);
        }
    }

    public function jobsOverview(Request $request, $id = '')
    {
        $currentUser = $this->getSessUser($request);
        $jobsDtls = CompanyJobs::select('company_jobs.*', 'company_jobs.id as job_key_id', 'companies.*')->join('companies', 'companies.id', '=', 'company_jobs.company_id')->where('company_jobs.id', Crypt::decrypt($id))->first();
        $studentJobStatus = DB::table('student_job_mappings')->where('student_id', $currentUser['id'])->where('job_id', $jobsDtls['job_key_id'])->first();
        if ($currentUser['user_cat'] == 'Student' && $studentJobStatus != null && in_array($studentJobStatus->jobStatus, ['APPLIED', 'REJECTED', 'APPROVED', 'INTERVIEWED'])) {
            $isStudentApplied = true;
            $companySpecificQuestions = DB::table('company_job_questions')->leftJoin('job_question_response', 'company_job_questions.id', 'job_question_response.question_id')->where('job_id', $jobsDtls['job_key_id'])->where('job_question_response.student_id', $currentUser['id'])->get();
        } else {
            $isStudentApplied = false;
            $companySpecificQuestions = DB::table('company_job_questions')->where('job_id', $jobsDtls['job_key_id'])->get();
        }
        return view('bladeFiles.company.JobOverview', ['jobsDtls' => $jobsDtls, 'companySpecificQuestions' => $companySpecificQuestions, 'isStudentApplied' => $isStudentApplied]);
    }

    public function getCompanies_view(Request $request, $id = '')
    {
        $companyDtls = Companies::where('company_name', '!=', '');
        // foreach($companyDtls as $company_User){
        //    $company_User_id =  $company_User->user_id;
        // }
        if ($this->getSessUser($request)['user_cat'] == 'HR')
            $companyDtls  = $companyDtls->where('recruiter_id', $this->getSessUser($request)['id']);
        $companyDtls  = $companyDtls->paginate(8);
        return view('bladeFiles.company.OverallCompanies', ['allCompanyDtls' => $companyDtls]);
    }

    public function scheduleJobInterview(Request $request)
    {
        $job_mapping_id = Crypt::decrypt($request->input('job_mapping_id'));
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
        $this->send_mail($mailData);
        return response()->json(['status' => 200, 'msg' => 'Job interview scheduled successfully.']);
    }

    public function updateJobApplicationStatus(Request $request)
    {
        $currentUser = $this->getSessUser($request);
        $job_mapping_id = Crypt::decrypt($request->input('job_mapping_id'));
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
                'action_by' => $currentUser['userid'], 'jobData' => $jobData, 'status' => $request->input('status'), 'message' => $request->input('message'), 'userData' => $userData
            ];
            $mailData = [
                'to' => $userData->email,
                'subject' => 'Job Application Status Update | ' . $jobData->job_title,
                'bladeName' => 'emails.applicationStatusUpdate',
                'bladeData' => $data,
            ];
            $this->send_mail($mailData);
        }
        return response()->json(['status' => 200, 'msg' => 'Job application status updated successfully']);
    }

    public function getJobApplicationStatus(Request $request, $job_mapping_id)
    {
        $jobMappingId = Crypt::decrypt($job_mapping_id);
        $jobLogData = DB::table('student_job_mappings')->join('student_job_logs', 'student_job_mappings.id', 'student_job_logs.job_mapping_id')->select('status', 'message')->where('student_job_mappings.id', $jobMappingId)->orderBy('student_job_logs.id', 'DESC')->first();
        if ($jobLogData == null) {
            $optionsList = $this->getJobStatusOptions();
            $message = '';
        } else {
            $optionsList = $this->getJobStatusOptions($jobLogData->status);
            $message = $jobLogData->message;
        }
        return response()->json(['status' => '200', 'options_list' => $optionsList, 'message' => $message]);
    }

    public function getJobApplicationLogs(Request $request, $job_mapping_id)
    {
        $job_mapping_id = Crypt::decrypt($job_mapping_id);
        $html_output = '';
        $logsData = DB::table('student_job_logs')->where('job_mapping_id', $job_mapping_id)->get();
        $counter = 1;
        foreach ($logsData as $data) {
            $html_output .= "<tr>
                <td>$counter</td>
                <td class='text-nowrap'>$data->created_on</td>
                <td><span class='badge badge-info'>$data->status</span></td>
                <td class='w-75'>$data->message</td>
                <td>$data->created_by</td>
            </tr>";
            $counter++;
        }
        return response()->json(['status' => 200, 'logs_html' => $html_output]);
    }
}
