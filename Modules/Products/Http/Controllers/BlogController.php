<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Dinhthang\FileUploader\Services\FileUploaderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Accounts\Models\Enums\AdminEnum;
use Modules\Base\Http\Traits\FilterBuilderTrait;
use Modules\Base\Models\Comment;
use Modules\Products\Http\Requests\BlogRequest;
use Modules\Products\Models\BLogs;
use Modules\Products\Services\BlogService;

class BlogController extends Controller
{
    private $blogServ;
    use FilterBuilderTrait;

    public function __construct(BlogService $blogService)
    {
        $this->blogServ = $blogService;
    }

    public function index(Request $request)
    {
        $this->setFilter($request, "id", "=");
        $this->setFilter($request, "admin_id", "=");
        $this->setFilter($request, "status", "=");
        $this->setFilter($request, "blog_category_id", "=");
        $this->setFilter($request, "title", "like");
        $this->setOrder($request, "updated_at");

        $filters = $this->getFilter();
        $orders = $this->getOrder();

        $dataView = $this->blogServ->getDataIndex($filters, $orders);
        $dataView["query"] = $request->query();

        return view("products::pages.blogs.index")->with($dataView);
    }

    public function create()
    {
        $viewData = $this->blogServ->getDataForm();;
        return view("products::pages.blogs.create")->with($viewData);
    }

    public function edit($id)
    {
        $viewData           = $this->blogServ->getDataForm();;
        $item               = $this->blogServ->findByIdWith($id);
        $viewData["item"]   = $item;
        $adminBlog          = $item->admin;
        $adminCurrent       = get_admin();

        if ($adminBlog->id != $adminCurrent->id && $adminCurrent->permission != AdminEnum::SUPER_ADMIN) {
            toastr()->warning("Bạn không có quyền sửa bài viết của người khác");
            return redirect()->route("get.blog.index");
        }

        return view("products::pages.blogs.edit")->with($viewData);
    }

    public function store(BlogRequest $request)
    {
        $data = $request->except("_token", "rdo_option");
        $data["admin_id"] = get_admin_id();

        if ($request->has("logo")) {
            $data["logo"] = FileUploaderService::getInstance()
                ->uploadOnlyFile($request->logo)
                ->getUrlFileUpload()["data"];
        }

        if (!empty($request->tag)) {
            $data["tag"] = $this->__renderTag($request->tag);
        }

        $data["slug"] = Str::slug($data["title"]);

        $reponse = $this->blogServ->insert($data);

        if ($reponse) {
            toastr()->success("Thêm mới thành công", "Thành công");
        } else {
            toastr()->error("Thêm mới thất bại", "Thất bại");
        }

        if ($request->rdo_option == 1) {
            return redirect()->route("get.blog.index");
        }

        return redirect()->back();
    }

    public function update(BlogRequest $request)
    {
        $data = $request->except("_token", "rdo_option", "id");
        $id = $request->id;
        $data["admin_id"] = get_admin_id();

        if ($request->has("logo")) {
            $data["logo"] = FileUploaderService::getInstance()
                ->uploadOnlyFile($request->logo)
                ->getUrlFileUpload()["data"];
        }

        if (!empty($request->tag)) {
            $data["tag"] = $this->__renderTag($request->tag);
        }
        $data["slug"] = Str::slug($data["title"]);

        $reponse = $this->blogServ->updateByID($id, $data);

        if ($reponse) {
            toastr()->success("Cập nhật thành công", "Thành công");
        } else {
            toastr()->error("Cập nhật thất bại", "Thất bại");
        }

        if ($request->rdo_option == 1) {
            return redirect()->route("get.blog.index");
        }

        return redirect()->back();
    }

    private function __renderTag($tag) {
        $tags = json_decode($tag, true);
        $tagString = "";
        foreach ($tags as $tag) {
            $tagString .= $tag["value"] . "|";
        }

        return rtrim($tagString, "|");
    }

    public function delete(Request $request)
    {
        $id             = $request->id;
        $item           = $this->blogServ->findByIdWith($id);
        $adminBlog      = $item->admin;
        $adminCurrent   = get_admin();

        if ($adminBlog->id != $adminCurrent->id && $adminCurrent->permission != AdminEnum::SUPER_ADMIN) {
            toastr()->warning("Bạn không có quyền xóa bài viết của người khác");
            return redirect()->route("get.blog.index");
        }

        $status = $this->blogServ->deleteByID($id);

        if ($status) {
            toastr()->success("Xóa thành công", "Thành công");
        } else {
            toastr()->error("Xóa thất bại", "Thất bại");
        }

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $this->setFilter($request, "tag", "like", "");
        $this->setFilter($request, "blog_category_id", "=");
        $this->setFilter([], "status", "=", 1);
        $this->setOrder($request, "created_at");

        $filters = $this->getFilter();
        $orders  = $this->getOrder();
        $query = $request->query();
        $items = $this->blogServ->getAllWith($filters, $orders, ["admin"]);
        $blogCategories = $this->blogServ->getBlogCategoríes();
        $viewData = [
            "items" => $items,
            "blogCategories" => $blogCategories,
            "query" => $query,
        ];

        return view("products::pages.blogs.search")->with($viewData);
    }
    public function detail(Request $request,$slug)
    {
        $item = BLogs::with("admin")->where("slug", $slug)->first();
        $itemsNew = BLogs::with("admin")->where("slug","!=", $slug)->orderBy('created_at','DESC')->limit(3)->get();

        $comment = Comment::where('blog_id',$item->id)->orderBy('id','DESC')->paginate(5);

        $viewData = [
            "item" => $item,
            "itemsNew" => $itemsNew,
            "comment" => $comment,
            "query" =>  $request->query(),
        ];

        return view("products::pages.blogs.blog_detail")->with($viewData);
    }
}