<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Base\Http\Traits\FilterBuilderTrait;
use Modules\Products\Http\Requests\BLogCategoriesRequest;
use Modules\Products\Services\BLogCategoriesService;

class BlogCattegoriesController extends Controller
{
    private $blogCateServ;
    use FilterBuilderTrait;

    public function __construct(BLogCategoriesService $blogCategoriesService)
    {
        $this->blogCateServ = $blogCategoriesService;
    }

    public function index(Request $request)
    {
        $this->setFilter($request, "id", "=");
        $this->setFilter($request, "name", "like");
        $this->setFilter($request, "status", "like");
        $this->setOrder($request, "updated_at");

        $filters = $this->getFilter();
        $orders = $this->getOrder();

        $items = $this->blogCateServ->getAllWith($filters, $orders);
        $query = $request->query();

        $viewData = [
            "items" => $items,
            "query" => $query
        ];

        return view("products::pages.blog_categories.index")->with($viewData);
    }

    public function create()
    {
        $this->setFilter(null, "parent_id", "=",0);
        $filters = $this->getFilter();

        $parentCategories = $this->blogCateServ->getAll($filters);

        $viewData = [
            "parentCategories" => $parentCategories,
        ];

        return view("products::pages.blog_categories.create")->with($viewData);
    }

    public function edit($id)
    {
        $item = $this->blogCateServ->findByID($id);

        if (!$item){
            abort(404);
        }

        $this->setFilter(null, "parent_id", "=",0);
        $filters = $this->getFilter();

        $parentCategories = $this->blogCateServ->getAll($filters);

        $viewData = [
            "parentCategories" => $parentCategories,
            "item" => $item
        ];

        return view("products::pages.blog_categories.edit")->with($viewData);
    }

    public function store(BLogCategoriesRequest $request)
    {
        $datas  = $request->except("_token", "rdo_option");

        $reponse = $this->blogCateServ->insert($datas);

        if ($reponse) {
            toastr()->success("Thêm mới thành công", "Thành công");
        } else {
            toastr()->error("Thêm mới thất bại", "Thất bại");
        }

        if ($request->rdo_option == 1) {
            return redirect()->route("get.blog_categories.index");
        }

        return redirect()->back();
    }

    public function update(BLogCategoriesRequest $request)
    {
        $datas  = $request->except("_token", "rdo_option","id");
        $id     = $request->id;

        $reponse = $this->blogCateServ->updateByID($id, $datas);

        if ($reponse) {
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