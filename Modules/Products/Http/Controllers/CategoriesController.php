<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Base\Http\Traits\FilterBuilderTrait;
use Modules\Products\Http\Requests\CategoriesRequest;
use Modules\Products\Services\CategoriesService;

class CategoriesController extends Controller
{
    private $cateServ;
    use FilterBuilderTrait;

    public function __construct(CategoriesService $cateServ)
    {
        $this->cateServ = $cateServ;
    }

    public function index(Request $request)
    {

        $this->setFilter($request, "name", "like");
        $this->setFilter($request, "keyword", "like");
        $this->setFilter($request, "id", "=");
        $this->setFilter($request, "status", "!=","-1");
        $this->setFilter($request, "status", "=");

        $this->setOrder($request, "updated_at", "desc");

        $filters = $this->getFilter();
        $orders  = $this->getOrder();
        $items   = $this->cateServ->getAll($filters, $orders);

        $viewData = [
            "items" => $items,
            "query" => $request->query(),
        ];

        return view("products::pages.categories.index")->with($viewData);
    }

    public function create()
    {
        return view("products::pages.categories.create");
    }

    public function edit($id)
    {
        $item = $this->cateServ->findByID($id);

        if (!$item){
            abort(404);
        }

        $viewData["item"] = $item;

        return view("products::pages.categories.edit")->with($viewData);
    }

    public function store(CategoriesRequest $request)
    {
        $data = $request->except("_token", "rdo_option");

        $status       = $this->cateServ->insert($data);

        if ($status) {
            toastr()->success("Thêm mới thành công", "Thành công");
        } else {
            toastr()->error("Thêm mới thất bại", "Thất bại");
        }

        if ($request->rdo_option == 1) {
            return redirect()->route("get.categories.index");
        }

        return redirect()->back();
    }

    public function update(CategoriesRequest $request)
    {
        $data   = $request->except("_token", "rdo_option", "id");
        $id     = $request->id;

        $status = $this->cateServ->updateByID($id, $data);

        if ($status) {
            toastr()->success("Cập nhật thành công", "Thành công");
        } else {
            toastr()->error("Cập nhật thất bại", "Thất bại");
        }

        if ($request->rdo_option == 1) {
            return redirect()->route("get.categories.index");
        }

        return redirect()->back();
    }
}