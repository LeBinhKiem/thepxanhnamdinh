<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Dinhthang\FileUploader\Services\FileUploaderService;
use Illuminate\Http\Request;
use Modules\Base\Http\Traits\FilterBuilderTrait;
use Modules\Products\Http\Requests\CoachRequest;
use Modules\Products\Services\CoachService;
use Modules\Accounts\Models\Enums\AdminEnum;

class CoachController extends Controller
{
    private $coachService;
    use FilterBuilderTrait;

    public function __construct(CoachService $coachService)
    {
        $this->coachService = $coachService;
    }

    public function index(Request $request)
    {
        $this->setFilter($request, "id", "=");
        $this->setFilter($request, "name", "like");
        $this->setFilter($request, "position", "like");
        $this->setOrder($request, "updated_at", "desc");

        $filters = $this->getFilter();
        $orders  = $this->getOrder();

        $items = $this->coachService->getAllWith($filters, $orders);

        $viewData = [
            "query" => $request->query(),
            "items" => $items,
        ];

        return view("products::pages.coaches.index")->with($viewData);
    }

    public function create()
    {
        $viewData = [];

        return view("products::pages.coaches.create")->with($viewData);
    }

    public function edit($id)
    {
        $item = $this->coachService->findByIDWith($id);

        if (!$item) {
            abort(404);
        }

        $viewData = [
            "item" => $item
        ];

        return view("products::pages.coaches.edit")->with($viewData);
    }

    public function store(CoachRequest $request)
    {
        $data              = $request->except("_token", "rdo_option", "birth_day_choose");
        $data["birth_day"] = date('Y-m-d H:i:s', strtotime($data["birth_day"]));
        if ($request->has("avatar")) {
            $data["avatar"] = FileUploaderService::getInstance()
                                  ->setFolder("system")
                                  ->uploadOnlyFile($request->avatar)
                                  ->getUrlFileUpload()["data"];
        }

        $status = $this->coachService->insert($data);

        if ($status) {
            toastr()->success("Thêm mới thành công", "Thành công");
        } else {
            toastr()->error("Thêm mới thất bại", "Thất bại");
        }

        if ($request->rdo_option == 1) {
            return redirect()->route("get.coaches.index");
        }

        return redirect()->back();
    }

    public function update(CoachRequest $request)
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

        $status = $this->coachService->updateByID($id, $data);

        if ($status) {
            toastr()->success("Cập nhật thành công", "Thành công");
        } else {
            toastr()->error("Cập nhật thất bại", "Thất bại");
        }

        if ($request->rdo_option == 1) {
            return redirect()->route("get.coaches.index");
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
        $status = $this->coachService->deleteByID($id);

        if ($status) {
            toastr()->success("Xóa thành công", "Thành công");
        } else {
            toastr()->error("Xóa thất bại", "Thất bại");
        }

        return redirect()->back();
    }
}