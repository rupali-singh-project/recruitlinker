<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use App\Models\Login;
use App\Models\company\CompanyJobs;
use App\Http\Controllers\AdminController;
use App\Models\User;

trait Auth
{

    public function create_user($user_data)
    {
        $newUser = new User();
        $newUser->userid = $user_data['user_id'];
        $newUser->first_name = $user_data['first_name'];
        $newUser->last_name = $user_data['last_name'];
        $newUser->password = $user_data['password'];
        $newUser->email = $user_data['email_id'];
        $newUser->phone = $user_data['phone_no'];
        $newUser->user_cat = $user_data['user_cat'];
        $newUser->save();

        if ($user_data['user_cat'] == 'Company') {
            // CREATE A COMPANY 
            $company_id = DB::table('companies')->insertGetId([
                'company_name' => $user_data['company']
            ]);
            // MAP CURRENT USER TO COMPANY
            DB::table('user_company_mapping')->insert([
                'user_id' => $newUser->id,
                'accessLevel' => $user_data['accessLevel'],
                'company_id' => $company_id
            ]);
        } else if ($user_data['user_cat'] == 'Student') {
            // CREATE A BASIC STUDENT PROFILE
            DB::table('student_profile')->insert([
                'student_id' => $newUser->id,
                'phone' => $user_data['phone_no']
            ]);
        }
        // SEND MAIL
        // user_data
        $data = ['user_data' => $user_data];
        $mailData = [
            'to' => $user_data['email'],
            'subject' => 'Account Activation | JobZilla',
            'bladeName' => 'emails.newUser',
            'bladeData' => $data,
        ];
        $this->send_mail($mailData);
    }

    public function update_user($user_data)
    {
        Login::where('id', $user_data['updated_id'])->update([
            'userid' => $user_data['user_id'],
            'first_name' => $user_data['first_name'],
            'last_name' => $user_data['last_name'],
            'password' => $user_data['password'],
            'phone' => $user_data['phone_no'],
            'user_cat' => $user_data['user_cat'],
            'isActive' => $user_data['active_status'],
        ]);
    }


    public function create_jobs($user_data)
    {
        $newJobs = new CompanyJobs();
        $newJobs->company_id = $user_data['company_id'];
        $newJobs->job_title = $user_data['job_title'];
        $newJobs->job_desc = $user_data['job_desc'];
        $newJobs->salary = $user_data['salary'];
        $newJobs->currency = $user_data['currency'];
        $newJobs->status = $user_data['status'];
        $newJobs->skills = $user_data['skills'];
        $newJobs->job_deadline = $user_data['job_deadline'];
        $newJobs->email = $user_data['email'];
        $newJobs->phone = $user_data['phone'];
        $newJobs->industry_type = $user_data['industry_type'];
        $newJobs->employee_type = $user_data['employee_type'];
        $newJobs->opening = $user_data['opening'];
        $newJobs->experience_min = $user_data['experience_min'];
        $newJobs->experience_max = $user_data['experience_max'];
        $newJobs->save();

        // SEND MAIL
        $adminUsers = DB::table('users')->where('user_cat', 'Admin')->get();
        foreach ($adminUsers as $user) {
            $data = ['user_data' => $user, 'job_data' => $user_data];
            $mailData = [
                'to' => $user->email,
                'subject' => 'New Job Created | ' . $user_data['job_title'],
                'bladeName' => 'emails.newJob',
                'bladeData' => $data,

            ];
            $this->send_mail($mailData);
        }
    }

    public function update_jobs($user_data)
    {
        CompanyJobs::where('id', $user_data['updated_id'])->update([
            'company_id' => $user_data['company_id'],
            'job_title' => $user_data['job_title'],
            'job_desc' => $user_data['job_desc'],
            'salary' => $user_data['salary'],
            'currency' => $user_data['currency'],
            'skills' => $user_data['skills'],
            'job_deadline' => $user_data['job_deadline'],
            'industry_type' => $user_data['industry_type'],
            'employee_type' => $user_data['employee_type'],
            'opening' => $user_data['opening'],
            'experience_min' => $user_data['experience_min'],
            'experience_mix' => $user_data['experience_max'],
        ]);
    }
}
