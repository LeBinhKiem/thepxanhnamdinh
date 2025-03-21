<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = get_user() ?? null;

        if (empty($user)){
            Toastr::warning("Bạn cần đăng nhập để truy cập vào đường dẫn này","Yêu cầu truy cập");
            return  redirect()->route("get.auth_user.login");
        }

        if ($user->status == 0) {
            return  redirect()->route("get.user.viewLocked");
        }


        return $next($request);
    }
}
