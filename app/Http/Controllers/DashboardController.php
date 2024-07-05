<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\CustomUtils;
use App\Models\company\CompanyJobs;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use CustomUtils;
    public function show_dashboard(Request $request)
    {
        $currentUser = $this->getSessUser($request);

        $dashboardData['total_companies'] = DB::table('companies')->count();
        $dashboardData['total_students'] = DB::table('users')->where('user_cat','Student')->count();
        $dashboardData['total_hr'] = DB::table('users')->where('user_cat','HR')->count();

        $dashboardData['total_users'] = DB::table('users')->count();
        $dashboardData['total_jobs'] = DB::table('company_jobs')->count();
        $dashboardData['total_jobs_active'] = DB::table('company_jobs')->where('isActive','1')->count();
        $dashboardData['total_jobs_inactive'] = DB::table('company_jobs')->where('isActive','0')->count();
        $dashboardData['paid_student_count'] = DB::table('users')->where('accepted_agreements','1')->where('user_cat','Student')->count();
        $dashboardData['unpaid_student_count'] = DB::table('users')->where('accepted_agreements','0')->where('user_cat','Student')->count();
        $dashboardData['paid_company_count'] = DB::table('users')->where('accepted_agreements','1')->where('user_cat','HR')->count();
        $dashboardData['unpaid_company_count'] = DB::table('users')->where('accepted_agreements','0')->where('user_cat','HR')->count();
        $companySizeChart = DB::table('companies')
            ->selectRaw('SUM(CASE WHEN total_employee >= 1 AND total_employee <= 5 THEN 1 ELSE 0 END) AS employees_1_5,
            SUM(CASE WHEN total_employee > 5 AND total_employee <= 20 THEN 1 ELSE 0 END) AS employees_5_20,
            SUM(CASE WHEN total_employee > 20 AND total_employee <= 50 THEN 1 ELSE 0 END) AS employees_20_50,
            SUM(CASE WHEN total_employee > 50 AND total_employee <= 100 THEN 1 ELSE 0 END) AS employees_50_100,
            SUM(CASE WHEN total_employee > 100 THEN 1 ELSE 0 END) AS employees_100_plus')
            ->first();
        $dashboardData['companySizeChart'] = $companySizeChart;

        $trendingJobs = CompanyJobs::join('student_job_mappings', 'company_jobs.id', 'student_job_mappings.job_id')
            ->select('job_title', DB::raw('count(company_jobs.id) as total'))
            ->groupBy('job_title')->limit(4)->get();
        $dashboardData['trendingJobs'] = $trendingJobs;

        $mostHiringByCompanies = Db::table('companies')->join('student_job_mappings', 'companies.id', 'student_job_mappings.job_id')
            ->select('company_name', DB::raw('count(companies.id) as total'))
            ->where('student_job_mappings.jobStatus', 'HIRED')
            ->groupBy('company_name')->limit(4)->get();
        $dashboardData['mostHiringByCompanies'] = $mostHiringByCompanies;

        $studentStatus = Db::table('student_job_mappings')->select('jobStatus',DB::raw('count(jobStatus) as total'))->groupBy('jobStatus')->get();
        $dashboardData['studentStatus'] = $studentStatus;

        $companyWiseJobs = Db::table('companies')->join('company_jobs','companies.id','company_jobs.company_id')
        ->select('company_name',DB::raw('count(company_jobs.id) as total'))
        ->groupBy('companies.company_name')->limit(10)->get();
        
        $dashboardData['companyWiseJobs'] = $companyWiseJobs;

       
        return view('bladeFiles/dashboard',$dashboardData);        

    }
}
