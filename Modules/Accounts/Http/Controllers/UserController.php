<?php

namespace Modules\Accounts\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\Http\Services\UserService;
use Modules\Accounts\Models\Enums\UserEnum;
use Modules\Base\Http\Traits\FilterBuilderTrait;

class UserController extends Controller
{
    private $userService;
    use FilterBuilderTrait;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $this->setFilter($request, "id", "=");
        $this->setFilter($request, "name", "like");
        $this->setFilter($request, "email", "like");
        $this->setFilter($request, "status", "=");
        $this->setOrder($request, "updated_at");

        $filters = $this->getFilter();
        $orders = $this->getOrder();

        $items = $this->userService->getAllWith($filters, $orders);
        $query = $request->query();

        $viewData = [
            "items" => $items,
            "query" => $query,
        ];

        return view("accounts::pages.user.index")->with($viewData);
    }

    public function lock(Request $request)
    {
        $reason = $request->reason;
        $id = $request->id;

        $data = [
            "user_id" => $id,
            "reason" => $reason,
            "created_at" => now()->toDateTimeString(),
            "updated_at" => now()->toDateTimeString(),
        ];

        $reponse = DB::table("reasons_lock_user")->insert($data);

        if ($reponse) {
            $this->userService->updateByID($id, ["status" => UserEnum::STATUS_UN_ACTIVE]);
        }else{
            toastr()->success("Khóa tài khoản thất bại", "Thất bại");
        }

        toastr()->success("Khóa tài khoản thành công", "Thành công");

        return redirect()->back();
    }

    public function unLock(Request $request)
    {
        $id = $request->id;
        $this->userService->updateByID($id, ["status" => UserEnum::STATUS_ACTIVE]);

        toastr()->success("Mở khóa tài khoản thành công", "Thành công");

        return redirect()->back();
    }
    public function detail($name = "")
    {
        if (empty($name)) {
            $name = get_user()["name"];
        }

        $dataView = $this->userService->getDataDetail($name);

        return view("base::pages.user.user_detail")->with($dataView);
    }
}