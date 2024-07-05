<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\Auth;
use App\Models\Login;
use App\Models\company\CompanyJobs;
use Illuminate\Support\Facades\Crypt;
use App\Http\Traits\CustomUtils;
use App\Models\User;
use App\Models\students\StudentJobMapping;

class AdminController extends Controller
{
    use Auth, CustomUtils;

    public function getUsersList(Request $request)
    {
        $user = $this->getSessUser($request);
        $getUserDetails = [
            'admins' => DB::table('users')->where('user_cat', 'Admin')->get(),
            'companies' => DB::table('users')->where('user_cat', 'Company')->get(),
            'students' => DB::table('users')->where('user_cat', 'Student')->get(),
        ];
        $getAdminCnt = DB::table('users')->where('user_cat', 'Admin')->count();
        $getCompanyCnt = DB::table('users')->where('user_cat', 'Company')->count();
        $getStudentCnt = DB::table('users')->where('user_cat', 'Student')->count();
        return view('bladeFiles.UsersList', [
            'getUserDetails' => $getUserDetails, 'getAdminCnt' => $getAdminCnt,
            'getCompanyCnt' => $getCompanyCnt, 'getStudentCnt' => $getStudentCnt
        ]);
    }

    public function getNewUsersForm($id = '')
    {
        if ($id != '')
            $userDtls = Login::where('isActive', '1')->where('id', Crypt::decrypt($id))->first();
        else
            $userDtls = [];
        return view('bladeFiles.AddNewUsers', ['userDtls' => $userDtls]);
    }

    public function createNewUser(Request $request)
    {
        $updated_id = $request->input('updated_id');
        $user_id = $request->input('user_id');
        $data['updated_id'] = $request->input('updated_id');
        $data['user_id'] = $request->input('user_id');
        $data['first_name'] = $request->input('first_name');
        $data['last_name'] = $request->input('last_name');
        $data['password'] = $request->input('password');
        $data['email_id'] = $request->input('email_id');
        $data['phone_no'] = $request->input('phone_no');
        $data['user_cat'] = $request->input('user_cat');
        if ($request->has('company'))
            $data['company'] = $request->input('company');
        if ($request->has('accessLevel'))
            $data['accessLevel'] = $request->input('accessLevel');
        if ($updated_id == '') {
            $userIdvalidation = User::where('userid', $user_id)->count();
            if ($userIdvalidation == 0) {
                $this->create_user($data);
                return redirect()->back();
            } else {
                return redirect()->back();
            }
        } else {
            $this->update_user($data);
            return redirect()->back();
        }
        // return response()->json(['status'=>1,'msg'=>'User Successfully Added']);
    }

    public function UpdateMultiNewUser(Request $request)
    {
        // dd("sdh");
        $IddataArr = $request->input('loginid');
        for ($i = 0; $i < count($IddataArr); $i++) {
            $idArr = $IddataArr[$i];
            $data['updated_id'] = $idArr;
            $data['user_id'] = $request->input('user_id')[$idArr];
            $data['first_name'] = $request->input('first_name')[$idArr];
            $data['last_name'] = $request->input('last_name')[$idArr];
            $data['password'] = $request->input('password')[$idArr];
            $data['email_id'] = $request->input('email_id')[$idArr];
            $data['user_cat'] = $request->input('user_cat')[$idArr];
            $data['active_status'] = $request->input('active_status')[$idArr];
            $data['phone_no'] = '';
            $this->update_user($data);
        }
        //return redirect()->back(); 
        return response()->json(['status' => 1, 'msg' => 'User Successfully Updated']);
    }

    public function DeleteMultiNewUser(Request $request)
    {
        $IddataArr = $request->input('loginid');
        for ($i = 0; $i < count($IddataArr); $i++) {
            $idArr = $IddataArr[$i];
            $data['updated_id'] = $idArr;
            $this->delete_user($data);
        }
        return response()->json(['status' => 1, 'msg' => 'User Successfully Deleted']);
    }

    public function getNewJobForm($id = '')
    {
        // if($id!='')
        //  $userDtls = Login::where('isActive','1')->where('id',Crypt::decrypt($id))->first();
        // else
        //  $userDtls = [];
        return view('bladeFiles.AddNewJob');
    }

    public function createNewJobs(Request $request)
    {
        $updated_id = $request->input('updated_id');
        $company_id = '1';
        $data['updated_id'] = $request->input('updated_id');
        $data['company_id'] = $company_id;
        $data['job_title'] = $request->input('job_title');
        $data['job_desc'] = $request->input('job_desc');
        $data['salary'] = $request->input('salary');
        $data['currency'] = $request->input('currency');
        $data['skills'] = $request->input('skills');
        $data['job_deadline'] = $request->input('job_deadline');
        if ($updated_id == '') {
            $this->create_jobs($data);
            return redirect()->back();
        } else {
            $this->update_jobs($data);
            return redirect()->back();
        }
    }

    public function getJobAssignPage(Request $request)
    {
        $getJobsDetails = CompanyJobs::select('company_jobs.*', 'companies.company_name', 'companies.company_logo')->join('companies', 'company_jobs.company_id', 'companies.id')->where('status', '<>', 'FINISHED')->get();
        $studentsList = User::where('user_cat', 'Student')->where('isActive', '1')->get();
        return view('bladeFiles.admin.assignJob', ['jobs' => $getJobsDetails, 'studentsList' => $studentsList]);
    }

    public function assignStudentsToJob(Request $request)
    {
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
        return response()->json(['status' => 1, 'msg' => 'Students have been assigned to job successfully']);
    }

    public function removeJobFromListing(Request $request, $jobId)
    {
        if ($request->input('action') == 'ADD') {
            CompanyJobs::where('id', $jobId)->update(['isActive' => '0']);
            return response()->json(['status' => 1, 'msg' => 'Job is added to listing.']);
        } else {
            CompanyJobs::where('id', $jobId)->update(['isActive' => '2']);
            return response()->json(['status' => 1, 'msg' => 'Job has been removed from listing.']);
        }
    }

    public function getMailSetting(Request $request)
    {
        $mailSetting = DB::table('mailSetting')->select('*')->first();
        return view("bladeFiles.admin.mailSetting", ['mailSetting' => $mailSetting]);
    }

    public function updateMailSetting(Request $request)
    {
        // if(DB::table('mailSetting')->)
        DB::table('mailSetting')->where('id', $id)->update([]);
    }
}
