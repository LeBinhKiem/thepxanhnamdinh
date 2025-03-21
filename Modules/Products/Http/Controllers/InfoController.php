<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Dinhthang\FileUploader\Services\FileUploaderService;
use Illuminate\Http\Request;
use Modules\Base\Http\Traits\FilterBuilderTrait;
use Modules\Products\Http\Requests\CoachRequest;
use Modules\Products\Http\Requests\InfoRequest;
use Modules\Products\Services\InfoService;

class InfoController extends Controller
{
    private $infoService;
    use FilterBuilderTrait;

    public function __construct(InfoService $infoService)
    {
        $this->infoService = $infoService;
    }

    public function index(Request $request)
    {
        $this->setFilter($request, "id", "=");
        $this->setFilter($request, "name", "like");

        $filters = $this->getFilter();
        $orders  = $this->getOrder();

        $item = $this->infoService->getFirst();

        $viewData = [
            "query" => $request->query(),
            "item" => $item,
        ];

        return view("products::pages.info.index")->with($viewData);
    }
    
    public function update(InfoRequest $request)
    {
        $data              = $request->except("_token", "id");
        $id = $request->id ?? 0;

        if ($request->has("logo")) {
            $data["logo"] = FileUploaderService::getInstance()
                                  ->setFolder("system")
                                  ->uploadOnlyFile($request->logo)
                                  ->getUrlFileUpload()["data"];
        }

        if (empty($id)) {
            $status = $this->infoService->insert($data);
        } else {
            $status = $this->infoService->updateByID($id, $data);
        }

        if ($status) {
            toastr()->success("Cập nhật thành công", "Thành công");
        } else {
            toastr()->error("Cập nhật thất bại", "Thất bại");
        }

        if ($request->rdo_option == 1) {
            return redirect()->route("get.info.index");
        }

        return redirect()->back();
    }
}