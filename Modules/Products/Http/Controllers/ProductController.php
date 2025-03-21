<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Dinhthang\FileUploader\Services\FileUploaderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\Models\Enums\AdminEnum;
use Modules\Base\Http\Traits\FilterBuilderTrait;
use Modules\Products\Http\Requests\ProductRequest;
use Modules\Products\Services\ProductService;

class ProductController extends Controller
{
    private $productService;
    use FilterBuilderTrait;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $this->setFilter($request, "id", "=");
        $this->setFilter($request, "status", "=");
        $this->setFilter($request, "name", "like");
        $this->setFilter($request, "category_id", "=");
        $this->setOrder($request, "updated_at", "desc");

        $filters = $this->getFilter();
        $orders  = $this->getOrder();

        $items      = $this->productService->getAllWith($filters, $orders, [ "category"]);
        $categories = DB::table("categories")->get();

        $viewData = [
            "query"      => $request->query(),
            "items"      => $items,
            "categories" => $categories
        ];

        return view("products::pages.products.index")->with($viewData);
    }

    public function create()
    {
        $categories = DB::table("categories")->where("status", 1)->get();

        $viewData = [
            "categories" => $categories
        ];

        return view("products::pages.products.create")->with($viewData);
    }

    public function edit($id)
    {
        $categories = DB::table("categories")->where("status", 1)->get();
        $item       = $this->productService->findByIDWith($id);

        if (!$item) {
            abort(404);
        }

        $viewData = [
            "categories" => $categories,
            "item"       => $item
        ];

        return view("products::pages.products.edit")->with($viewData);
    }

    public function store(ProductRequest $request)
    {
        $data             = $request->except("_token", "rdo_option");

        if ($request->has("image")) {
            $data["image"] = FileUploaderService::getInstance()
                                 ->setFolder("system")
                                 ->uploadOnlyFile($request->image)
                                 ->getUrlFileUpload()["data"];
        }

        $status = $this->productService->insert($data);

        if ($status) {
            toastr()->success("Thêm mới thành công", "Thành công");
        } else {
            toastr()->error("Thêm mới thất bại", "Thất bại");
        }

        if ($request->rdo_option == 1) {
            return redirect()->route("get.products.index");
        }

        return redirect()->back();
    }

    public function update(ProductRequest $request)
    {
        $data = $request->except("_token", "rdo_option", "id");
        $id   = $request->id;

        if ($request->has("image")) {
            $data["image"] = FileUploaderService::getInstance()
                                 ->setFolder("system")
                                 ->uploadOnlyFile($request->image)
                                 ->getUrlFileUpload()["data"];
        }

        $status = $this->productService->updateByID($id, $data);

        if ($status) {
            toastr()->success("Cập nhật thành công", "Thành công");
        } else {
            toastr()->error("Cập nhật thất bại", "Thất bại");
        }

        if ($request->rdo_option == 1) {
            return redirect()->route("get.products.index");
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
        $status = $this->productService->deleteByID($id);

        if ($status) {
            toastr()->success("Xóa thành công", "Thành công");
        } else {
            toastr()->error("Xóa thất bại", "Thất bại");
        }

        return redirect()->back();
    }
}