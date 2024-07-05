<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API ROUTES FOR USER CREATION
Route::post('login', [ApiController::class, 'login']);
Route::post('register', [ApiController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('user/create', [ApiController::class, 'addUser']);
    Route::post('user/update', [ApiController::class, 'updateUser']);
    Route::get('user/get', [ApiController::class, 'getUsers']);
    Route::get('user/get/{id}', [ApiController::class, 'getUser']);
    Route::delete('user/delete/{id}', [ApiController::class, 'deleteUser']);

    // API ROUTES FOR HR
    Route::post('company/job/students/assign', [ApiController::class, 'assignStudentToJob']);
    Route::get('job/{jobid}/application/list', [ApiController::class, 'getJobApplication']);
    Route::post('job/application/action', [ApiController::class, 'actionOnJobApplication']);

    // API ROUTES FOR ADMIN ACTION ON STUDENTS
    Route::get('students/get', [ApiController::class, 'getStudents']);
    Route::get('student/{studentId}/job/{jobId}/status/get', [ApiController::class, 'getJobStatus']);
    Route::get('student/{studentId}/job/question/responses/get', [ApiController::class, 'getJobQuestionResponses']);
    Route::post('student/job/apply', [ApiController::class, 'applyJob']);
    Route::any('student/jobs/fetch', [ApiController::class, 'fetchJobs']);
    Route::get('student/profile/get/{studentId}', [ApiController::class, 'getStudentProfile']);
    Route::get('student/profile/{type}/fetch/{studentId}', [ApiController::class, 'getStudentProfileDataByType']);
    Route::post('student/profile/personal/info/update/{studentId}', [ApiController::class, 'updateStudentPersonalData']);
    Route::post('student/profile/education/update/{studentId}', [ApiController::class, 'updateStudentEducationData']);
    Route::post('student/profile/experience/update/{studentId}', [ApiController::class, 'updateStudentExperienceData']);
    Route::post('student/profile/certification/update/{studentId}', [ApiController::class, 'updateStudentCertificationData']);
    Route::get('student/jobs/fetch/{studentId}', [ApiController::class, 'fetchStudentJobs']);


    // API ROUTES FOR ADMIN ACTION ON COMPANIES
    Route::get('companies/recruiter/get', [ApiController::class, 'getRecruiters']);
    Route::post('companies/recruiter/update', [ApiController::class, 'updateCompaniesRecruiter']);
    Route::post('company/job/create', [ApiController::class, 'createJob']);
    Route::post('company/job/update', [ApiController::class, 'updateJob']);
    Route::get('company/job/get', [ApiController::class, 'getJobs']);
    Route::get('company/job/get/{companyId?}', [ApiController::class, 'getJobs']);
    Route::get('company/job/{id}/questions/get', [ApiController::class, 'getJobQuestions']);
    Route::get('company/job/{id}', [ApiController::class, 'getJob']);
    Route::post('company/job/interview/schedule', [ApiController::class, 'scheduleJobInterview']);
    Route::post('company/job/interview/status/update', [ApiController::class, 'updateJobApplicationStatus']);

    Route::get('companies/get/{id}', [ApiController::class, 'getCompany']);
    Route::get('companies/get', [ApiController::class, 'getCompanies']);
    Route::post('company/profile/update', [ApiController::class, 'updateCompanyProfile']);

    // API ROUTES FOR COMMON DATA
    Route::get('skills/get', [ApiController::class, 'getSkills']);
    Route::get('industry/get', [ApiController::class, 'getIndustries']);

    Route::post('create-payment-intent', [ApiController::class, 'createPaymentIntent']);
    Route::post('payment/status/update', [ApiController::class, 'confirmUserPayment']);
    Route::post('company/agreemnt/update/{userid}', [ApiController::class, 'updateCompanyUserAgreemnt']);
});
