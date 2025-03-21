<?php

namespace Modules\Accounts\Http\Services;

use Dinhthang\FileUploader\Services\FileUploaderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Accounts\Models\Users;
use Modules\Base\Http\Services\BaseService;

class UserService extends BaseService
{
    protected $modelName = "users";

    public function getAllWith($filters = [], $orders = [], $limit = 20)
    {
        $data = Users::with("reasonLock");
        $data = $this->scopeFilterAndSort($data, $filters, $orders);
        $data = $data->paginate($limit);

        return $data;
    }

    public function getDataDetail($name)
    {
        $user = DB::table("users")
            ->where("name", $name)
            ->first();

        if (!$user) {
            abort(404);
        }

        $userCurrent = get_user();

        if ($user->name == $userCurrent->name) {
            $user->isOwn = true;
        } else {
            $user->isOwn = false;
        }

        $data = [
            "user" => $user
        ];

        return $data;
    }

    public function updateUser($request)
    {
        $data = $request->except("_token");
        $id   = get_user_id();

        if ($request->has("logo")) {
            $data["logo"] = FileUploaderService::getInstance()
                                ->uploadOnlyFile($request->logo)
                                ->getUrlFileUpload()["data"];
        }
        $data["updated_at"] = now()->toDateTimeString();

        $status = DB::table("users")
            ->where("id", $id)
            ->update($data);

        return $status;
    }

    public function updatePassword($request)
    {
        $user        = get_user();
        $oldPassword = $request->old_password ?? "";
        $newPassword = $request->new_password ?? "";
        // $newPasswordAgain = $request->new_password_again ?? "";


        if (!Hash::check($oldPassword, $user->password)) {
            return false;
        }

        $dataPassword["password"] = bcrypt($newPassword);

        return DB::table("users")
            ->where("id", $user->id)
            ->update($dataPassword);
    }
}