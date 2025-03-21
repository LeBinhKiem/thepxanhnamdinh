<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\LoginRequest;
use Monolog\Handler\IFTTTHandler;
use App\Mail\EmailForgetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\Accounts\Models\Enums\AdminEnum;
class AuthAdminController extends Controller
{
    public function vLogin()
    {
        return view('auth::admin.login');
    }

    public function pLogin(LoginRequest $request)
    {
        $data       = $request->except("remember","_token");
        $remember   = $request->has("remember");

        $statusLogin = Auth::guard("admin")->attempt($data, $remember);

        if ($statusLogin){
            $user = Auth::guard("admin")->user();
        
            if ($user->status == AdminEnum::STATUS_UN_ACTIVE) {
                Auth::guard("admin")->logout();
                toastr()->warning("Tài khoản này đã bị dừng hoạt động", "Thông báo");
                return redirect()->route("get.auth.login");
            }
            
            toastr()->success("Đăng nhập thành công","Thông báo");
            return redirect()->route("get.home.index");
        }
        toastr()->error("Tên tài khoản họăc mật khẩu không chính xác","Đăng nhập thất bại");

        return redirect()->back()->withInput();
    }
    public function vRegister()
    {
        return view('auth::admin.register');
    }

    public function logOut(){
        Auth::guard("admin")->logout();

        return redirect()->route("get.auth.login");
    }

    public function vForgetPassword()
    {
        return view('auth::admin.forget_password');
    }

    public function pForgetPassword(Request $request)
    {
        $email = $request->email;

        $admin = DB::table("admins")
            ->where("email", $email)
            ->first();

        if (!$admin) {
            toastr()->error("Tài khoản email chưa tồn tại trên hệ thống","Thất bại");
            return redirect()->back()->withInput();
        }

        $newPassword        = Str::random(8);
        $data["password"]   = bcrypt($newPassword);

        $reponse = DB::table("admins")
            ->where("email", $email)
            ->update($data);

        if ($reponse){
            $emailData = [
                'nameMail' => "Lấy lại mật khẩu",
                'name' => $admin->name,
                'password' => $newPassword,
                'account' => $admin->email,
            ];

            Mail::to($email)->send(new EmailForgetPassword($emailData));
        }

        toastr()->success("Mật khẩu mới đã được gửi tới email: ". $email, "Thành công");

        return view('auth::admin.forget_password');
    }
}
