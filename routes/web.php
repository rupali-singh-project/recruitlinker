<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ROUTES FOR NON-AUTHENTICATED USERS
Route::group(['middleware' => ['guest']], function () {
    Route::get('/register', [RegisterController::class, 'show_register'])->name('register.show');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.perform');
    Route::get('/login', [LoginController::class, 'show_login'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
});


// ROUTES FOR AUTHENTICATED USERS
Route::group(['middleware' => ['auth', 'shareUserData', 'LoginCheck']], function () {
    Route::get('account/agreements', 'App\Http\Controllers\CompanyController@getAgreements')->name('getAgreements');
    Route::get('account/agreements/update', 'App\Http\Controllers\CompanyController@updateAgreements')->name('getAgreements');
    Route::get('account/payment', 'App\Http\Controllers\PaymentController@checkout')->name('checkout');
    Route::post('/session', 'App\Http\Controllers\PaymentController@session')->name('session');
    Route::get('/success', 'App\Http\Controllers\PaymentController@success')->name('success');
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout.perform');
});
Route::group(['middleware' => ['auth', 'shareUserData', 'agreementCheck']], function () {

    Route::get('/', [DashboardController::class, 'show_dashboard'])->name('land');
    Route::get('/land', [DashboardController::class, 'show_dashboard'])->name('land');
    Route::any('admin/UsersList', [AdminController::class, 'getUsersList']);
    Route::any('admin/createNewUser', [AdminController::class, 'createNewUser']);
    Route::get('admin/AddNewUsers/{id?}', [AdminController::class, 'getNewUsersForm']);
    Route::any('admin/createNewUser', [AdminController::class, 'createNewUser']);
    Route::any('admin/updateMultiNewUser', [AdminController::class, 'UpdateMultiNewUser']);
    Route::any('admin/deleteMultiNewUser', [AdminController::class, 'DeleteMultiNewUser']);
    Route::any('admin/jobs/view', [AdminController::class, 'getJobAssignPage']);
    Route::post('admin/job/assignStudent', [AdminController::class, 'assignStudentsToJob']);
    Route::get('admin/job/{jobid}/listing/update', [AdminController::class, 'removeJobFromListing']);
    Route::get('admin/mail/setting', [AdminController::class, 'getMailSetting']);
    Route::post('admin/mail/setting/update', [AdminController::class, 'updateMailSetting']);

    Route::any('admin/CompaniesToAssign', [AdminController::class, 'getCompaniesToBeAssigned']);
    Route::any('admin/updateAssignTo', [AdminController::class, 'UpdateAssignedRecruiter']);


    Route::get('AddNewJob/{id?}', [CompanyController::class, 'getNewJobForm']);
    Route::any('createNewJob', [CompanyController::class, 'createNewJobs']);
    Route::any('JobsList', [CompanyController::class, 'getJobsList']);
    Route::post('company/job/questions/add', [CompanyController::class, 'addJobQuestion']);
    Route::post('company/job/questions/delete', [CompanyController::class, 'deleteJobQuestion']);
    Route::get('company/profile/get/{id}', [CompanyController::class, 'getCompanyProfile']);
    Route::post('company/profile/cover/image/update', [CompanyController::class, 'updateCompanyCoverImage']);
    Route::post('company/profile/logo/image/update', [CompanyController::class, 'updateCompanyLogo']);
    Route::post('company/profile/info/update', [CompanyController::class, 'updateCompanyInfo']);
    Route::post('company/profile/aboutus/update', [CompanyController::class, 'updateCompanyAboutUsInfo']);
    Route::post('company/profile/gallery/add', [CompanyController::class, 'updateGalleryImage']);
    Route::post('company/profile/gallery/delete', [CompanyController::class, 'deleteGalleryImage']);
    Route::post('admin/job/interview/schedule', [CompanyController::class, 'scheduleJobInterview']);
    Route::any('JobOverview/{id?}', [CompanyController::class, 'jobsOverview']);
    Route::any('Companies_view', [CompanyController::class, 'getCompanies_view']);


    Route::any('profile', [ProfileController::class, 'getProfile']);
    Route::any('profile/update', [ProfileController::class, 'updateProfile']);

    Route::any('Students_view', [StudentController::class, 'getStudents_view']);
    Route::get('student/jobs/search', [StudentController::class, 'getStudentJobSearchView']);
    Route::post('student/jobs/fetch', [StudentController::class, 'fetchJobs']);
    Route::any('student/jobs/view', [StudentController::class, 'getStudentJobView']);
    Route::any('job/{jobid}/form', [StudentController::class, 'getJobForm']);
    Route::post('job/{jobid}/form/apply', [StudentController::class, 'applyForJob']);
    Route::get('admin/job/{jobid}/applications/view', [StudentController::class, 'seeJobApplications']);
    Route::post('admin/job/application/approve', [StudentController::class, 'approveJobApplication']);
    Route::post('admin/job/application/reject', [StudentController::class, 'rejectJobApplication']);

    Route::get('student/profile/view/{id}', [ProfileController::class, 'getStudentProfilePage']);
    Route::get('student/profile/edit', [ProfileController::class, 'getStudentProfileUpdatePage']);
    Route::post('student/profile/personal/update', [ProfileController::class, 'updateStudentPersonalProfile']);
    Route::post('student/profile/education/update', [ProfileController::class, 'updateStudentEducationProfile']);
    Route::post('student/profile/workSummary/update', [ProfileController::class, 'updateStudentExperienceProfile']);
    Route::post('student/profile/certification/update', [ProfileController::class, 'updateStudentCertificatesProfile']);
    Route::get('student/profile/education/delete/{id}', [ProfileController::class, 'deleteEducationDetails']);
    Route::post('student/profile/links/update', [ProfileController::class, 'updateStudentLinksDetails']);

    Route::post('student/job/application/status/update', [CompanyController::class, 'updateJobApplicationStatus']);
    Route::get('student/job/application/status/fetch/{job_mapping_id}', [CompanyController::class, 'getJobApplicationStatus']);
    Route::get('student/job/application/log/fetch/{job_mapping_id}', [CompanyController::class, 'getJobApplicationLogs']);
    Route::get('/send-mail', [ProfileController::class, 'testMail']);

    Route::any('changePassword', [AdminController::class, 'getChangePassForm']);
    Route::any('SavechangePassword', [AdminController::class, 'SaveChangePassForm']);

    Route::any('testing', function () {
        return view('emails.base');
    });
});
