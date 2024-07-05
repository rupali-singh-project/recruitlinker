<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use App\Models\Login;
use App\Models\company\CompanyJobs;
use App\Http\Controllers\AdminController;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

trait CustomUtils
{

    public function isPaymentPending($request)
    {
        $session_user = $this->getSessUser($request);
        $paymentRecord = '';
    }

    public function getSessUser($request)
    {
        $session_user = $request->user();
        // dump($session_user);
        return [
            'id' => $session_user['id'],
            'userid' => $session_user['userid'],
            'first_name' => $session_user['first_name'],
            'last_name' => $session_user['last_name'],
            'user_cat' => $session_user['user_cat'],
        ];
    }

    public function getLinksType()
    {
        return ['Twitter', 'LinkedIn', 'Facebook', 'Instagram', 'Github', 'Dribbble', 'Behance', 'Custom'];
    }

    public function getUserCompanyId($employeeId)
    {
        $userCompanyMapping = DB::table('user_company_mapping')->where('user_id', $employeeId)->first();
        if ($userCompanyMapping != null)
            return $userCompanyMapping->company_id;
        else
            return 0;
    }

    public function getCompanyAccessRole($request)
    {
        $currSessUser = $this->getSessUser($request);
        if ($currSessUser['user_cat'] == 'Admin')
            return 1;
        else if ($currSessUser['user_cat'] == 'Student')
            return 0;
        else {
            $currentUserId = $currSessUser['id'];
            $userCompanyMappingData = DB::table('user_company_mapping')->where('user_id', $currentUserId)->first();
            //0:Viewer,1:Editor,2:Admin
            if ($userCompanyMappingData != null && in_array($userCompanyMappingData->accessLevel, [1, 2]))
                return 1;
            else
                return 0;
        }
    }

    public function send_mail($mailData)
    {
        if (!isset($mailData['attachments']))
            $mailData['attachments'] = [];
        Mail::to($mailData['to'])->send(new SendMail($mailData));
        //check mails at https://mailtrap.io/signin
    }

    public function getStatusBadge($statusCode)
    {
        if ($statusCode == 'APPROVED') {
            return "<span class='badge' style='background-color:green;color:white;'>Approved</span>";
        } else if ($statusCode == 'REJECTED') {
            return "<span class='badge' style='background-color:red;color:white;'>Rejected</span>";
        }
        if ($statusCode == 'ASSIGNED') {
            return "<span class='badge' style='background-color:purple;color:white;'>Assigned</span>";
        }
        if ($statusCode == 'APPLIED') {
            return "<span class='badge' style='background-color:yellow;color:black;'>Applied</span>";
        }
        if ($statusCode == 'INTERVIEWED') {
            return "<span class='badge' style='background-color:cyan;color:black;'>Interview</span>";
        }
        // ADD MORE STATUS HERE
    }

    public function getJobStatusOptions($option = '')
    {
        return '<optgroup label="No Of Rounds">
        <option ' . ($option == 'First Round' ? ' selected ' : '') . 'value="First Round">First Round</option>
        <option ' . ($option == 'Second Round' ? ' selected ' : '') . 'value="Second Round">Second Round</option>
        <option ' . ($option == 'Third Round' ? ' selected ' : '') . 'value="Third Round">Third Round</option>
        <option ' . ($option == 'Fourth Round' ? ' selected ' : '') . 'value="Fourth Round">Fourth Round</option>
        <option ' . ($option == 'Fifth Round' ? ' selected ' : '') . 'value="Fifth Round">Fifth Round</option>
        <option ' . ($option == 'Final Round' ? ' selected ' : '') . 'value="Final Round">Final Round</option>
      </optgroup>
      <optgroup label="Typical Rounds">
        <option ' . ($option == 'Phone Interview' ? ' selected ' : '') . 'value="Phone Interview">Phone Interview</option>
        <option ' . ($option == 'Technical Round' ? ' selected ' : '') . 'value="Technical Round">Technical Round</option>
        <option ' . ($option == 'Peer Round' ? ' selected ' : '') . 'value="Peer Round">Peer Round</option>
      </optgroup>
      <optgroup label="Other">
        <option ' . ($option == 'Background Check' ? ' selected ' : '') . 'value="Background Check">Background Check</option>
        <option ' . ($option == 'Hired' ? ' selected ' : '') . 'value="Hired">Hired</option>
        <option ' . ($option == 'Rejected' ? ' selected ' : '') . 'value="Rejected">Rejected</option>
      </optgroup>';
    }

    public function getExperienceRange($experienceCode)
    {
        if ($experienceCode == 'F')
            return ['min' => 0, 'max' => 0];
        if ($experienceCode == 'E1')
            return ['min' => 1, 'max' => 3];
        if ($experienceCode == 'E2')
            return ['min' => 3, 'max' => 5];
        if ($experienceCode == 'E3')
            return ['min' => 5, 'max' => 7];
        if ($experienceCode == 'E4')
            return ['min' => 7, 'max' => 10];
        if ($experienceCode == 'E5')
            return ['min' => 10, 'max' => 100];
    }
}
