<?php

namespace Modules\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Base\Http\Traits\FilterBuilderTrait;
use Modules\Base\Http\Traits\FilterScopeTrait;
use Modules\Products\Enums\OrderEnum;
use Yoeunes\Toastr\Facades\Toastr;

class OrderController extends Controller
{
    use FilterBuilderTrait;
    use FilterScopeTrait;

    public function index(Request $request)
    {
        $query = $request->query();
        $this->setFilter($request, "id", "=");
        $this->setFilter($request, "name", "like");
        $this->setFilter($request, "status", "=");

        $filter = $this->getFilter();

        $items = DB::table("orders")
            ->orderBy("created_at", "desc");

        $items = $this->scopeFilter($items, $filter);
        $items = $items->paginate(20);

        $viewData = [
            "query" => $query,
            "items" => $items,
        ];

        return view("products::pages.orders.index")->with($viewData);
    }

    public function update(Request $request)
    {
        $id           = $request->id;
        $statusUpdate = $request->status;

        $item = DB::table("orders")
            ->where("id", $id)
            ->first();

        $products = json_decode($item->product_json, true);

     if ($statusUpdate == OrderEnum::CANCEL) {
            foreach ($products as $product) {
                DB::table("products")
                    ->where("id", $product["id"])
                    ->increment("amount", $product["amount"]);
            }
        }

        DB::table("orders")->where("id", $id)->update([
            "status"     => $statusUpdate,
            "updated_at" => now()->toDateTimeString(),
        ]);

        Toastr::success("Cập nhật trạng thái thành công", "Thành công");

        return \redirect()->back();
    }

    public function detail($id)
    {
        $item = DB::table("orders")->where("id", $id)->first();
        if (!$item) {
            abort(404);
        }

        $viewData["order"] = $item;

        return view("products::pages.orders.detail")->with($viewData);
    }
}