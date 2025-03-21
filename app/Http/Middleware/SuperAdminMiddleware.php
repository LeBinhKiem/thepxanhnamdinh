<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Accounts\Models\Enums\AdminEnum;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = get_admin();

        if ($user->permission == AdminEnum::NORMAL_ADMIN){
            toastr()->warning("Không có quyền truy cập","Thông báo");
            return  redirect()->back();
        }

        return $next($request);
    }
}