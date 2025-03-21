<?php

namespace Modules\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\Http\Services\UserService;
use Modules\Base\Http\Traits\FilterBuilderTrait;

class UserController extends Controller
{
    private $userService;
    use FilterBuilderTrait;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function detail($name = "")
    {
        if (empty($name)) {
            $name = get_user()["name"];
        }

        $dataView = $this->userService->getDataDetail($name);

        return view("base::pages.user.user_detail")->with($dataView);
    }

    public function vChangePassword()
    {
        return view("base::pages.user.user_change_password");
    }

    public function update(Request $request)
    {
        $respone = $this->userService->updateUser($request);

        if ($respone) {
            toastr()->success("Cập nhật thành công", "Thành công");
        } else {
            toastr()->error("Cập nhật thất bại", "Thất bại");
        }

        return redirect()->back();
    }

    public function pChangePassword(Request $request)
    {
        $respone = $this->userService->updatePassword($request);

        if ($respone) {
            toastr()->success("Cập nhật mật khẩu thành công", "Thành công");
        } else {
            toastr()->error("Mật khẩu cũ không trùng khớp", "Thất bại");

            return redirect()->back()->withInput();
        }
        return redirect()->back();
    }

    public function viewLocked()
    {
        $user = $this->userService->findByID(get_user_id());
        if ($user->status == 1) {
            return redirect()->route("get.sell.index");
        }

        $reasonLock = DB::table("reasons_lock_user")
            ->where("user_id", $user->id)
            ->orderBy("updated_at", "desc")
            ->first();

        $viewData = [
            "reasonLock" => $reasonLock,
        ];

        return view('auth::user.lock')->with($viewData);
    }
}