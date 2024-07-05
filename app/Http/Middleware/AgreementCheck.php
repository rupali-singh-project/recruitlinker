<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgreementCheck
{
    public function handle(Request $request, Closure $next): Response
    {
        // $session_user = $request->user();
        // if ($session_user['accepted_agreements'] == '0') {
        //     if ($session_user['user_cat'] == 'Student') {
        //         return redirect(url('account/payment'));
        //     } else if ($session_user['user_cat'] == 'Company') {
        //         return redirect(url('account/agreements'));
        //     }
        // }
        return $next($request);
    }
}
