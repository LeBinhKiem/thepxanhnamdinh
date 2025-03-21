<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Dinhthang\FileUploader\Services\FileUploaderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\Models\Enums\AdminEnum;
use Modules\Products\Services\PlayerService;
use Modules\Base\Http\Traits\FilterBuilderTrait;
use Modules\Products\Http\Requests\PlayerRequest;

class PlayerController extends Controller
{
    private $playerService;
    use FilterBuilderTrait;

    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }

    public function index(Request $request)
    {
        $this->setFilter($request, "id", "=");
        $this->setFilter($request, "name", "like");
        $this->setFilter($request, "team", "like");
        $this->setFilter($request, "position", "like");

        $this->setOrder($request, "updated_at", "desc");


        $filters = $this->getFilter();
        $orders  = $this->getOrder();

        $items = $this->playerService->getAllWith($filters, $orders);

        $viewData = [
            "query" => $request->query(),
            "items" => $items,
        ];

        return view("products::pages.players.index")->with($viewData);
    }

    public function create()
    {
        $viewData = [];

        return view("products::pages.players.create")->with($viewData);
    }

    public function edit($id)
    {
        $categories = DB::table("categories")->where("status", 1)->get();
        $item       = $this->playerService->findByIDWith($id);

        if (!$item) {
            abort(404);
        }

        $viewData = [
            "categories" => $categories,
            "item"       => $item
        ];

        return view("products::pages.players.edit")->with($viewData);
    }

    public function store(PlayerRequest $request)
    {
        $data              = $request->except("_token", "rdo_option", "birth_day_choose");
        $data["birth_day"] = date('Y-m-d H:i:s', strtotime($data["birth_day"]));
        if ($request->has("avatar")) {
            $data["avatar"] = FileUploaderService::getInstance()
                                  ->setFolder("system")
                                  ->uploadOnlyFile($request->avatar)
                                  ->getUrlFileUpload()["data"];
        }

        $status = $this->playerService->insert($data);

        if ($status) {
            toastr()->success("Thêm mới thành công", "Thành công");
        } else {
            toastr()->error("Thêm mới thất bại", "Thất bại");
        }

        if ($request->rdo_option == 1) {
            return redirect()->route("get.players.index");
        }

        return redirect()->back();
    }

    public function update(PlayerRequest $request)
    {
        $data              = $request->except("_token", "rdo_option", "id", "birth_day_choose");
        $data["birth_day"] = date('Y-m-d H:i:s', strtotime($data["birth_day"]));

        $id = $request->id;

        if ($request->has("avatar")) {
            $data["avatar"] = FileUploaderService::getInstance()
                                  ->setFolder("system")
                                  ->uploadOnlyFile($request->avatar)
                                  ->getUrlFileUpload()["data"];
        }

        $status = $this->playerService->updateByID($id, $data);

        if ($status) {
            toastr()->success("Cập nhật thành công", "Thành công");
        } else {
            toastr()->error("Cập nhật thất bại", "Thất bại");
        }

        if ($request->rdo_option == 1) {
            return redirect()->route("get.players.index");
        }

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $adminCurrent   = get_admin();

        if ($adminCurrent->permission != AdminEnum::SUPER_ADMIN) {
            toastr()->warning("Tài khoản của bạn không có quyền xóa");
            return redirect()->back();
        }
        
        $id     = $request->id;
        $status = $this->playerService->deleteByID($id);

        if ($status) {
            toastr()->success("Xóa thành công", "Thành công");
        } else {
            toastr()->error("Xóa thất bại", "Thất bại");
        }

        return redirect()->back();
    }
}