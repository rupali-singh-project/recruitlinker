<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Closure;

class LoginCheck
{
    public function handle($request, Closure $next)
    {
        $session_user = $request->user();
        if ($session_user['accepted_agreements'] == '1') {
            if (in_array($request->path(), ['account/agreements', 'account/payment'])) {
                return redirect(url('land'));
            }
        }
        return $next($request);
    }
}
