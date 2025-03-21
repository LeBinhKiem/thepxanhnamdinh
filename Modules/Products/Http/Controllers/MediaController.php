<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Dinhthang\FileUploader\Services\FileUploaderService;
use Illuminate\Http\Request;
use Modules\Accounts\Models\Enums\AdminEnum;
use Modules\Base\Http\Traits\FilterBuilderTrait;
use Modules\Products\Http\Requests\MediaRequest;
use Modules\Products\Services\MediaService;

class MediaController extends Controller
{
    private $mediaService;
    use FilterBuilderTrait;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function index(Request $request)
    {
        $this->setFilter($request, "id", "=");
        $this->setFilter($request, "title", "like");
        $this->setOrder($request, "updated_at", "desc");

        $filters = $this->getFilter();
        $orders  = $this->getOrder();

        $items = $this->mediaService->getAllWith($filters, $orders);

        $viewData = [
            "query" => $request->query(),
            "items" => $items,
        ];

        return view("products::pages.medias.index")->with($viewData);
    }

    public function create()
    {
        $viewData = [];

        return view("products::pages.medias.create")->with($viewData);
    }

    public function edit($id)
    {
        $item = $this->mediaService->findByIDWith($id);

        if (!$item) {
            abort(404);
        }

        $viewData = [
            "item" => $item
        ];

        return view("products::pages.medias.edit")->with($viewData);
    }

    public function store(MediaRequest $request)
    {
        $data              = $request->except("_token", "rdo_option");

        if ($request->has("image")) {
            $data["image"] = FileUploaderService::getInstance()
                                  ->setFolder("system")
                                  ->uploadOnlyFile($request->image)
                                  ->getUrlFileUpload()["data"];
        }

        $status = $this->mediaService->insert($data);

        if ($status) {
            toastr()->success("Thêm mới thành công", "Thành công");
        } else {
            toastr()->error("Thêm mới thất bại", "Thất bại");
        }

        if ($request->rdo_option == 1) {
            return redirect()->route("get.medias.index");
        }

        return redirect()->back();
    }

    public function update(MediaRequest $request)
    {
        $data              = $request->except("_token", "rdo_option", "id");

        $id = $request->id;

        if ($request->has("image")) {
            $data["image"] = FileUploaderService::getInstance()
                                  ->setFolder("system")
                                  ->uploadOnlyFile($request->image)
                                  ->getUrlFileUpload()["data"];
        }

        $status = $this->mediaService->updateByID($id, $data);

        if ($status) {
            toastr()->success("Cập nhật thành công", "Thành công");
        } else {
            toastr()->error("Cập nhật thất bại", "Thất bại");
        }

        if ($request->rdo_option == 1) {
            return redirect()->route("get.medias.index");
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
        $status = $this->mediaService->deleteByID($id);

        if ($status) {
            toastr()->success("Xóa thành công", "Thành công");
        } else {
            toastr()->error("Xóa thất bại", "Thất bại");
        }

        return redirect()->back();
    }
}