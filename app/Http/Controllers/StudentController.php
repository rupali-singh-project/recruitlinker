<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\students\StudentJobMapping;
use App\Models\company\CompanyJobs;
use App\Http\Traits\CustomUtils;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    use CustomUtils;
    public function getStudentJobView(Request $request)
    {
        $currentStudentId = $this->getSessUser($request)['id'];
        $assignedJobsData = CompanyJobs::join('student_job_mappings', 'company_jobs.id', '=', 'student_job_mappings.job_id')->select('company_jobs.*', 'student_job_mappings.is_applied', 'student_job_mappings.jobStatus')
            ->addSelect(['company_name' => DB::table('companies')->select('company_name')->whereColumn('id', 'company_jobs.company_id')])
            ->addSelect(['current_job_status' => DB::table('student_job_logs')->select('status')->whereColumn('job_mapping_id', 'student_job_mappings.id')->orderBy('student_job_logs.id', 'DESC')->limit(1)])
            ->where('student_id', $currentStudentId)
            ->where('student_job_mappings.is_assigned', '1')
            ->get();
        $selfAppliedJobsData = CompanyJobs::join('student_job_mappings', 'company_jobs.id', '=', 'student_job_mappings.job_id')
            ->select('company_jobs.*', 'student_job_mappings.jobStatus')
            ->addSelect(['company_name' => DB::table('companies')->select('company_name')->whereColumn('id', 'company_jobs.company_id')])
            ->addSelect(['current_job_status' => DB::table('student_job_logs')->select('status')->whereColumn('job_mapping_id', 'student_job_mappings.id')->orderBy('student_job_logs.id', 'DESC')->limit(1)])
            ->where('student_id', $currentStudentId)
            ->where('student_job_mappings.is_assigned', '0')
            ->get();
        return view('bladeFiles/student/jobsView', ['assignedJobsData' => $assignedJobsData, 'selfAppliedJobsData' => $selfAppliedJobsData]);
    }

    public function getJobForm(Request $request, $jobId)
    {
        $jobData = CompanyJobs::where('id', $jobId)->first();
        $companyData = DB::table('companies')->where('id', $jobData['company_id'])->first();
        $companySpecificQuestions = DB::table('company_job_questions')->where('job_id', $jobData['id'])->get();
        return view('bladeFiles/student/jobForm', ['jobData' => $jobData, 'companyData' => $companyData, 'companySpecificQuestions' => $companySpecificQuestions, 'jobId' => $jobId]);
    }

    public function applyForJob(Request $request, $id)
    {
        $currentStudentId = $this->getSessUser($request)['id'];
        $profileId = $request->input('profile');
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
            foreach ($questionIds as $questionId) {
                DB::table('job_question_response')->insert([
                    'question_id' => $questionId,
                    'student_id' => $currentStudentId,
                    'response' => $request->input('question_' . $questionId)
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
        return redirect()->back()->with('success', 'Applied to job successfully.');
    }


    public function seeJobApplications(Request $request, $jobid)
    {
        $sessUserCategory = $this->getSessUser($request)['user_cat'];
        $jobData = DB::table('company_jobs')->select('job_title', 'id')->where('id', $jobid)->first();
        $educationCategories = DB::table('education_category')->select('*')->get();
        $skillsCategories = DB::table('skills')->select('*')->get();
        $applicationsList = CompanyJobs::join('student_job_mappings', 'company_jobs.id', 'student_job_mappings.job_id')
            ->join('users', 'student_job_mappings.student_id', 'users.id')
            ->select('company_jobs.*', 'student_job_mappings.id as mapping_id', 'student_job_mappings.jobStatus', 'student_job_mappings.is_applied', 'users.first_name', 'users.last_name', 'users.id as studentId')
            ->addSelect(['resume' => DB::table('student_profile')->select('resume')->whereColumn('student_id', 'studentId')])
            ->addSelect(['profile_title' => DB::table('student_profile')->select('profile_title')->whereColumn('student_id', 'studentId')])
            ->addSelect(['phone' => DB::table('student_profile')->select('phone')->whereColumn('student_id', 'studentId')])
            ->addSelect(['application_status' => DB::table('student_job_logs')->select('status')->whereColumn('job_mapping_id', 'student_job_mappings.id')->orderBy('student_job_logs.id', 'DESC')->limit(1)])
            ->where('job_id', $jobid);
        if ($sessUserCategory == 'Company') {
            $applicationsList = $applicationsList->whereIn('jobStatus', ['APPROVED', 'INTERVIEWED']);
        }
        $applicationsList = $applicationsList->get();
        return view('bladeFiles.admin.jobApplications', ['jobData' => $jobData, 'applicationsList' => $applicationsList, 'jobid' => $jobid, 'educationCategories' => $educationCategories, 'skillsCategories' => $skillsCategories]);
    }

    public function approveJobApplication(Request $request)
    {
        $job_id = $request->input('job_id');
        $student_id = $request->input('student_id');
        DB::table('student_job_mappings')->where('job_id', $job_id)->where('student_id', $student_id)->update([
            'jobStatus' => 'APPROVED'
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
        $this->send_mail($mailData);
        return response()->json(['status' => 1, 'msg' => 'Job application approved successfully']);
    }

    public function rejectJobApplication(Request $request)
    {
        $job_id = $request->input('job_id');
        $student_id = $request->input('student_id');
        DB::table('student_job_mappings')->where('job_id', $job_id)->where('student_id', $student_id)->update([
            'jobStatus' => 'REJECTED'
        ]);
        // SEND MAIL
        $jobData = DB::table('company_jobs')->where('id', $job_id)->first();
        $userData = DB::table('users')->where('id', $student_id)->first();
        $data = ['jobData' => $jobData, 'userData' => $userData];
        $mailData = [
            'to' => $userData->email,
            'subject' => 'Job Application Rejected | ' . $jobData->job_title,
            'bladeName' => 'emails.rejectJob',
            'bladeData' => $data,

        ];
        $this->send_mail($mailData);
        return response()->json(['status' => 1, 'msg' => 'Job application rejected successfully']);
    }

    public function getStudentJobSearchView(Request $request)
    {
        $educationCategory = DB::table('education_category')->where('isActive', '1')->get();
        $skills = DB::table('skills')->where('isActive', '1')->get();
        return view("bladeFiles/student/jobSearch", ['educationCategory' => $educationCategory, 'skills' => $skills]);
    }


    public function fetchJobs(Request $request)
    {
        $perPageRecord = 5;
        $jobs = [];
        $sessUser = $this->getSessUser($request);
        $student_id = $sessUser['id'];
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
        $jobsCount = $this->addJobSearchCondition($request, $jobsDataQry);
        $jobsDataQry = $this->apply_pagination($request, $jobsDataQry, 5);
        $jobs = $jobsDataQry->get();
        foreach ($jobs as $job) {
            $job->enc_id = Crypt::encrypt($job->id);
        }
        return response()->json(['status' => '200', 'count' => $jobsCount, 'jobs' => $jobs, 'total_pages' => $total_pages]);
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


    public function getStudents_view(Request $request, $id = '')
    {
        $studentDtls = StudentProfile::select('student_profile.*', 'users.*')->join('users', 'users.id', '=', 'student_profile.student_id');
        if ($request->has('job_category') && $request->input('job_category') != '') {
            $studentDtls = $studentDtls->where('student_profile.profile_title', $request->input('job_category'));
        }
        if ($request->has('job_post_month') && $request->input('job_post_month') > 0) {
            $studentDtls = $studentDtls->where(DB::raw('MONTH(users.created_at)'), $request->input('job_post_month'));
        }
        if ($request->has('job_post_year') && $request->input('job_post_year') > 0) {
            $studentDtls = $studentDtls->where(DB::raw('YEAR(users.created_at)'), $request->input('job_post_year'));
        }
        $studentDtls = $studentDtls->get();

        $jobProfileData = DB::table('job_category')->where('isActive', '1')->get();
        return view('bladeFiles.admin.OverallStudents', ['studentDtls' => $studentDtls, 'jobProfileData' => $jobProfileData]);
    }
}
