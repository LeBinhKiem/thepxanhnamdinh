<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Accounts\Models\Enums\AdminEnum;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard("admin")->user();
        if (empty($user)){
            toastr()->warning("Yêu cầu đăng nhập", "Thông báo");
            return  redirect()->route("get.auth.login");
        }
        return $next($request);
    }
}
