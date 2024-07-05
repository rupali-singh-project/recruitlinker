<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Http\Traits\CustomUtils;

class RegisterController extends Controller
{
    use CustomUtils;
    public function show_register()
    {
        $data = Hash::make('test');
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user_cat = $request->input('user_cat');
        if ($user_cat == 'Company') {
            $company = $request->input('company');
            $accessLevel = $request->input('accessLevel');
            if ($company == '') {
                return redirect('/register')->with('error', "Company name is required..");
            } elseif ($accessLevel == "") {
                return redirect('/register')->with('error', "Access level is required..");
            }
        }
        $user = User::create($request->validated());
        //dd($user_cat);
        if ($user_cat == 'Company') {
            // CREATE A COMPANY 
            $company_id = DB::table('companies')->insertGetId([
                'company_name' => $company
            ]);
            // MAP CURRENT USER TO COMPANY
            DB::table('user_company_mapping')->insert([
                'user_id' => $user->id,
                'accessLevel' => $accessLevel,
                'company_id' => $company_id
            ]);
        } else if ($user_cat == 'Student') {
            // CREATE A BASIC STUDENT PROFILE
            // dd($user->id);
            DB::table('student_profile')->insert([
                'student_id' => $user->id
            ]);
        }
        // send mail to user
        $data = ['userData' => $user, 'password' => $request->input('password'), 'datetime' => Carbon::now(), 'for' => 'student'];
        $mailData = [
            'to' => $user->email,
            'subject' => 'Account Confirmation | Jobscom',
            'bladeName' => 'emails.accountConfirm',
            'bladeData' => $data,
        ];
        $this->send_mail($mailData);
        // send mail to admin
        $adminUser = User::where('user_cat', 'Admin')->first();
        $data = ['userData' => $user, 'password' => $request->input('password'), 'datetime' => Carbon::now(), 'for' => 'admin', 'adminName' => $adminUser['first_name']];
        $mailData = [
            'to' => $adminUser->email,
            'subject' => 'Account Confirmation | Jobscom',
            'bladeName' => 'emails.accountConfirm',
            'bladeData' => $data,
        ];
        $this->send_mail($mailData);
        auth()->login($user);
        return redirect('/land')->with('success', "Account successfully registered.");
    }
}
