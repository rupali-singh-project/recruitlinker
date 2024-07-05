<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\CustomUtils;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    use CustomUtils;
    public function getStudentProfilePage(Request $request,$studentId='') {
        if($studentId==''){
            $currSessUser = $this->getSessUser($request);
            $studentId = $currSessUser['id'];
        }else{
            $studentId = Crypt::decrypt($studentId);
        }
        $data['userData'] = User::where('id',$studentId)->first();
        $data['personalDetails'] = DB::table('student_profile')->where('student_id',$studentId)->first();
        $data['educationsData'] = DB::table('student_educations')->where('student_id',$studentId)->get();
        $data['workExperienceData'] = DB::table('student_work_history')->where('student_id',$studentId)->get();
        $data['linksData'] = DB::table('student_external_links')->where('student_id',$studentId)->get();
        $data['certificationsData'] = DB::table('student_certificates')->where('student_id',$studentId)->get();
        return view('bladeFiles.student.viewProfile',$data);
    }

    public function getStudentProfileUpdatePage(Request $request) {
        $currSessUser = $this->getSessUser($request);
        $data['userData'] = User::where('id',$currSessUser['id'])->first();
        $data['personalDetails'] = DB::table('student_profile')->where('student_id',$currSessUser['id'])->first();
        $data['educationsData'] = DB::table('student_educations')->where('student_id',$currSessUser['id'])->get();
        $data['workExperienceData'] = DB::table('student_work_history')->where('student_id',$currSessUser['id'])->get();
        $data['certificationsData'] = DB::table('student_certificates')->where('student_id',$currSessUser['id'])->get();
        $data['linksType'] = $this->getLinksType();
        $data['linksData'] = DB::table('student_external_links')->where('student_id',$currSessUser['id'])->get();
        return view('bladeFiles.student.updateProfile',$data);
    }

    public function updateStudentPersonalProfile(Request $request) {
        $fieldsArray = [];
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $gender = $request->input('gender');
        $date_of_birth = $request->input('date_of_birth');
        $willing_to_relocate = $request->input('willing_to_relocate');
        $profile_title = $request->input('profile_title');
        $phone = $request->input('phone');
        $currSessUser = $this->getSessUser($request);
        if($request->has('profile_pic')) {
            $file = $request->file('profile_pic');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile'), $fileName);
            DB::table('users')->where('id',$currSessUser['id'])->update(['profile_pic'=>$fileName]);
        }
        DB::table('users')->where('id',$currSessUser['id'])->update([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone' => $phone,
            'email' => $email,
        ]);
        if($request->has('willling_to_relocate'))
            $willing_to_relocate = 1;
        else
            $willing_to_relocate = 1;
        $fieldsArray = [
            'phone' => $phone,
            'gender' => $gender,
            'date_of_birth' => $date_of_birth,
            'profile_title' => $profile_title,
            'willing_to_relocate'=>$willing_to_relocate
        ];
        if($request->has('resume')) {
            $file = $request->file('resume');
            $fileName = 'resume_'.time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile/resume'), $fileName);
            $fieldsArray['resume'] = $fileName;
        }
        if(DB::table('student_profile')->where('student_id',$currSessUser['id'])->exists()){
            DB::table('student_profile')->where('student_id',$currSessUser['id'])->update($fieldsArray);
        }else {
            $fieldsArray['student_id'] = $currSessUser['id'];
            DB::table('student_profile')->insert($fieldsArray);
        }
        return response()->json(['status'=>1,'msg'=>'Personal Details Updated Successfully']);
    }


    public function updateStudentEducationProfile(Request $request) {
        $rows_id = $request->input('row_id');
        $currSessUser = $this->getSessUser($request);
        for($i=0;$i<count($rows_id);$i++){
            if($request->has('isStudying_'.$rows_id[$i]))
                $isStudying = '1';
            else
                $isStudying = '0';
            if(DB::table('student_educations')->where('degree',$request->input('degree_'.$rows_id[$i]))->where('institute',$request->input('institute_'.$rows_id[$i]))->exists() ){
                $record_id = $request->get('row_key_id_'.$rows_id[$i]);
                DB::table('student_educations')->where('id',$record_id)->update([
                    'student_id' =>$currSessUser['id'],
                    'institute'=>$request->input('institute_'.$rows_id[$i]),
                    'degree'=>$request->input('degree_'.$rows_id[$i]),
                    'start_time'=>$request->input('start_date_'.$rows_id[$i]),
                    'end_time'=>$request->input('end_date_'.$rows_id[$i]),
                    'marks'=>$request->input('marks_'.$rows_id[$i]),
                    'isStudying'=>$isStudying
                ]);
            } else {
                DB::table('student_educations')->insert([
                    'student_id' =>$currSessUser['id'],
                    'institute'=>$request->input('institute_'.$rows_id[$i]),
                    'degree'=>$request->input('degree_'.$rows_id[$i]),
                    'start_time'=>$request->input('start_date_'.$rows_id[$i]),
                    'end_time'=>$request->input('end_date_'.$rows_id[$i]),
                    'marks'=>$request->input('marks_'.$rows_id[$i]),
                    'isStudying'=>$isStudying
                ]);
            }
        }
        return response()->json(['status'=>1,'msg'=>'Educational Details Saved.']);
    }

    public function updateStudentExperienceProfile(Request $request) {
        $rows_id = $request->input('row_id');
        $currSessUser = $this->getSessUser($request);
        for($i=0;$i<count($rows_id);$i++){
            if($request->has('isWorking_'.$rows_id[$i]))
                $isWorking = '1';
            else
                $isWorking = '0';
            if(DB::table('student_work_history')->where('company_name',$request->input('company_name_'.$rows_id[$i]))->where('job_title',$request->input('job_title_'.$rows_id[$i]))->where('start_time',$request->input('start_time_'.$rows_id[$i]))->where('student_id',$currSessUser['id'])->exists()){
                $record_id = $request->get('row_key_id_'.$rows_id[$i]);
                DB::table('student_work_history')->where('id',$record_id)->update([
                    'student_id' =>$currSessUser['id'],
                    'company_name'=>$request->input('company_name_'.$rows_id[$i]),
                    'job_title'=>$request->input('job_title_'.$rows_id[$i]),
                    'job_type'=>$request->input('job_type_'.$rows_id[$i]),
                    'start_time'=>$request->input('start_time_'.$rows_id[$i]),
                    'end_time'=>$request->input('end_time_'.$rows_id[$i]),
                    'job_summary'=>$request->input('job_summary_'.$rows_id[$i]),
                    'isWorking'=>$isWorking
                ]);
            } else {
                DB::table('student_work_history')->insert([
                    'student_id' =>$currSessUser['id'],
                    'company_name'=>$request->input('company_name_'.$rows_id[$i]),
                    'job_title'=>$request->input('job_title_'.$rows_id[$i]),
                    'job_type'=>$request->input('job_type_'.$rows_id[$i]),
                    'start_time'=>$request->input('start_time_'.$rows_id[$i]),
                    'end_time'=>$request->input('end_time_'.$rows_id[$i]),
                    'job_summary'=>$request->input('job_summary_'.$rows_id[$i]),
                    'isWorking'=>$isWorking
                ]);
            }
        }
        return response()->json(['status'=>1,'msg'=>'Work Experience Details Saved.']);
    }

    public function updateStudentCertificatesProfile(Request $request) {
        $rows_id = $request->input('row_id');
        $currSessUser = $this->getSessUser($request);

        for($i=0;$i<count($rows_id);$i++){
            $expiryTime = $request->input('expiry_'.$rows_id[$i]);
            $timeArray = explode('/',$expiryTime);
            $expiryMonth = trim($timeArray[0]);
            $expiryYear = trim($timeArray[1]);
            if($request->has('no_expiry_'.$rows_id[$i]))
                $no_expiry = '1';
            else
                $no_expiry = '0';
            if(DB::table('student_certificates')->where('certificate_name',$request->input('certificate_name_'.$rows_id[$i]))->where('certificate_issuer',$request->input('certificate_issuer_'.$rows_id[$i]))->where('student_id',$currSessUser['id'])->exists()){
                $record_id = $request->get('row_key_id_'.$rows_id[$i]);
                DB::table('student_certificates')->where('id',$record_id)->update([
                    'student_id' =>$currSessUser['id'],
                    'certificate_name'=>$request->input('certificate_name_'.$rows_id[$i]),
                    'certificate_issuer'=>$request->input('certificate_issuer_'.$rows_id[$i]),
                    'expiry_month'=>$expiryMonth,
                    'expiry_year'=>$expiryYear,
                    'no_expiry'=>$no_expiry
                ]);
            } else {
                DB::table('student_certificates')->insert([
                    'student_id' =>$currSessUser['id'],
                    'certificate_name'=>$request->input('certificate_name_'.$rows_id[$i]),
                    'certificate_issuer'=>$request->input('certificate_issuer_'.$rows_id[$i]),
                    'expiry_month'=>$expiryMonth,
                    'expiry_year'=>$expiryYear,
                    'no_expiry'=>$no_expiry
                ]);
            }
        }
        return response()->json(['status'=>1,'msg'=>'Certifications Details Saved.']);
    }
    public function updateStudentLinksDetails(Request $request) {
        $rows_id = $request->input('row_id');
        $currSessUser = $this->getSessUser($request);

        for($i=0;$i<count($rows_id);$i++){
            $linkName = $request->input('linkName_'.$rows_id[$i]);
            $linkValue = $request->input('link_'.$rows_id[$i]);
            
            if(DB::table('student_external_links')->where('link',$request->input('link_'.$rows_id[$i]))->exists()){
                $record_id = $request->get('row_key_id_'.$rows_id[$i]);
                DB::table('student_external_links')->where('id',$record_id)->update([
                    'linkName'=>$request->input('linkName_'.$rows_id[$i]),
                    'link'=>$request->input('link_'.$rows_id[$i]),
                    'isCustom'=>'0'
                ]);
            } else {
                DB::table('student_external_links')->insert([
                    'student_id' =>$currSessUser['id'],
                    'linkName'=>$request->input('linkName_'.$rows_id[$i]),
                    'link'=>$request->input('link_'.$rows_id[$i]),
                    'isCustom'=>'0'
                ]);
            }
        }
        return response()->json(['status'=>1,'msg'=>'Links Details Saved.']);
    }

    public function deleteEducationDetails($id) {
        DB::table('student_educations')->where('id',$id)->delete();
        return response()->json(['status'=>1,'msg'=>'Education Record Deleted Successfully']);
    }

    public function testMail()
    {
        $data = ['name'=>'manish'];
        $mailData = [
            'to'=>'manish.sh1985@gmail.com',
            'subject'=>'Test Mail',
            'bladeName'=>'emails.sample',
            'bladeData'=>$data,
            
        ];
        $this->send_mail($mailData);
    }
}
