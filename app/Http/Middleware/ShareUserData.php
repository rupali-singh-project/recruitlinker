<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;
use App\Http\Traits\CustomUtils;
use Illuminate\Support\Facades\DB;

class ShareUserData
{
    use CustomUtils;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $session_user = $request->user();
        View::share('userid', $session_user['id']);
        View::share('username', $session_user['userid']);
        View::share('first_name', $session_user['first_name']);
        View::share('last_name', $session_user['last_name']);
        View::share('user_cat', $session_user['user_cat']);
        $companyId = $this->getUserCompanyId($session_user['id']);
        // dd($companyId);
        View::share('company_id', $companyId);
        $companyData = DB::table('companies')->where('id', $companyId)->first();

        View::share('company_data', $companyData);
        return $next($request);
    }
}
