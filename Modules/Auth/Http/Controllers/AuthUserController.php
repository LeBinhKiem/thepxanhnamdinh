<?php

namespace Modules\Auth\Http\Controllers;

use App\Mail\EmailForgetPassword;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Services\AuthService;
use Modules\Base\Libs\SeoToolLib;
use Modules\Auth\Http\Requests\LoginUserRequest;
class AuthUserController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function vLogin()
    {
        return view('auth::user.login');
    }
    public function pLogin(LoginUserRequest $request)
    {
        $data       = $request->except("remember","_token");
        $remember   = $request->has("remember");

        $statusLogin = Auth::guard("user")->attempt($data, $remember);

        if ($statusLogin){
            toastr()->success("Đăng nhập thành công","Thông báo");

            return redirect()->route("get.sell.index");
        }
        toastr()->error("Tên tài khoản họăc mật khẩu không chính xác","Đăng nhập thất bại");

        return redirect()->back()->withInput();
    }
    public function vRegister()
    {
        return view('auth::user.register');
    }

    public function pRegister(RegisterRequest $request)
    {
        $reponse = $this->authService->register($request);

        if ($reponse) {
            toastr()->success("Đăng ký tài khoản thành công","Thông báo");

            return redirect()->route("get.auth_user.login");
        }
        toastr()->error("Đăng ký tài khoản thất bại","Thông báo");

        return redirect()->back()->withInput();
    }
    public function vForgetPassword()
    {
        return view('auth::user.forget_password');
    }
    public function pForgetPassword(Request $request)
    {
        $email = $request->email;

        $user = DB::table("users")
            ->where("email", $email)
            ->first();

        if (!$user) {
            toastr()->error("Tài khoản email chưa tồn tại trên hệ thống","Thất bại");
            return redirect()->back()->withInput();
        }

        $newPassword        = Str::random(8);
        $data["password"]   = bcrypt($newPassword);

        $reponse = DB::table("users")
            ->where("email", $email)
            ->update($data);

        if ($reponse){
            $emailData = [
                'nameMail' => "Lấy lại mật khẩu",
                'name' => $user->full_name,
                'password' => $newPassword,
                'account' => $user->name,
            ];

            Mail::to($email)->send(new EmailForgetPassword($emailData));
        }

        toastr()->success("Mật khẩu mới đã được gửi tới email: ". $email, "Thành công");

        return view('auth::user.forget_password');
    }

    public function logout()
    {
        Auth::guard("user")->logout();

        return redirect()->route("get.sell.index");
    }
}
