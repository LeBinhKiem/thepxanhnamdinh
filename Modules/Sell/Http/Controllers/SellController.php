<?php

namespace Modules\Sell\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Base\Http\Controllers\VoteController;
use Modules\Base\Http\Traits\FilterBuilderTrait;
use Modules\Base\Http\Traits\FilterScopeTrait;
use Modules\Base\Http\Traits\ReponseTrait;
use Modules\Products\Enums\ProductEnum;
use Modules\Products\Models\Carts;
use Modules\Products\Models\Products;
use Modules\Sell\Http\Requests\PaymentRequest;
use Yoeunes\Toastr\Facades\Toastr;
use Modules\Sell\Services\cateServ;

use Stripe;
class SellController extends Controller
{
    private $cateServ;
    use FilterBuilderTrait;
    use FilterScopeTrait;
    use ReponseTrait;

    public function __construct(cateServ $cateServ)
    {
        $this->cateServ = $cateServ;
    }

    public function detail(Request $request, $id)
    {
        $item = Products::with("category")
            ->where("id", $id)
            ->where("status", ProductEnum::STATUS_ACTIVE)
            ->first();

        $currentCategoryId = Products::find($id)->category_id;
        $productsOther = Products::with("category")
            ->where("id", "!=", $id)
            ->where("status", ProductEnum::STATUS_ACTIVE)
            ->where("category_id", $currentCategoryId)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $query = $request->query();

        $vote = VoteController::getInstance()
            ->getDataVote(class_basename(Products::class), $item->id, $request->page ?? 1);

        if (!$item) {
            abort(404);
        }

        $viewData = [
            "item"          => $item,
            "vote"          => $vote,
            "query"         => $query,
            "productsOther" => $productsOther,
        ];
        return view("sell::pages.detail")->with($viewData);
    }

    public function cart(Request $request)
    {
        $carts = Carts::with("product")->where("user_id", get_user_id())->get();

        $viewData = [
            "carts" => $carts
        ];

        return view("sell::pages.cart")->with($viewData);
    }
    public function order()
    {
        $items = DB::table("orders")
        ->whereRaw('JSON_CONTAINS(product_json, \'{"user_id": ' . get_user_id() . '}\')')
        ->orderBy("created_at", "desc");

        $items = $this->scopeFilter($items);
        $items = $items->paginate(10);
        
        $viewData = [
            "items" => $items,
        ];
        return view("sell::pages.order")->with($viewData);
    }

    public function search(Request $request)
    {
        $this->setFilter($request, "name", "like");
        $this->setFilter($request, "category_id", "=");
        $this->setOrder($request, "created_at");

        $filters = $this->getFilter();
        $orders  = $this->getOrder();

        $items      = $this->cateServ->getAllWith($filters, $orders, ["category"]);
        $categories = DB::table("categories")->get();
        $viewData = [
            "categories" => $categories,
            "query"      => $request->query(),
            "items"      => $items,
        ];

        return view("sell::pages.search")->with($viewData);
    }

    public function insertCart(Request $request)
    {
        $data   = $request->except("_token");
        $userID = get_user_id();

        if (!$userID) {
            toastr()->warning("Bạn phải đăng nhập nếu muốn thêm giỏ hàng", "Cảnh báo");
            return redirect()->back();
        }

        $exist = DB::table("carts")
            ->where("user_id", $userID)
            ->where("product_id", $data["product_id"])
            ->first();

        if ($exist) {
            toastr()->warning("Sản phẩm đã có trong giỏ hàng", "Cảnh báo");
            return redirect()->back();
        }

        $data["user_id"]    = $userID;
        $data["created_at"] = now()->toDateTimeString();
        $data["updated_at"] = now()->toDateTimeString();
        $response           = DB::table("carts")->insert($data);

        if ($response) {
            toastr()->success("Thêm sản phẩm vào giỏ hàng thành công", "Thành công");
        } else {
            toastr()->error("Có lỗi xảy ra", "Lỗi");
        }

        return redirect()->back();
    }

    public function updateCart(Request $request)
    {
        $data   = $request->except("_token", "type");
        $userID = get_user_id();

        if (!$userID) {
            toastr()->warning("Bạn phải đăng nhập nếu muốn thêm giỏ hàng", "Cảnh báo");
            return redirect()->back();
        }
        if ($request->type == "update") {
            $data["updated_at"] = now()->toDateTimeString();

            $reponse = DB::table("carts")
                ->where("user_id", $userID)
                ->where("product_id", $data["product_id"])
                ->update($data);
        } else {
            $reponse = DB::table("carts")
                ->where("user_id", $userID)
                ->where("product_id", $data["product_id"])
                ->delete();
        }


        if (!$reponse) {
            return $this->reponseError();
        }

        return $this->reponseSucess();
    }
    public function checkout(Request $request)
    {
        $carts = Carts::with("product")->where("user_id", get_user_id())->get();
        if (!$carts) {
            abort(404);
        }

        $viewData = [
            "carts" => $carts,
            "user"  => get_user(),
        ];

        return view("sell::pages.checkout")->with($viewData);
    }
    public function payment(PaymentRequest $request)
    {
        $data = $request->except("_token");
        $id   = get_user_id();

        if (!$id) {
            abort(404);
        }

        $data["created_at"] = now()->toDateTimeString();
        $data["updated_at"] = now()->toDateTimeString();

        $reponse = DB::table("orders")->insert($data);

        if (!$reponse) {
        
            Toastr::error("Có lỗi xảy ra", "Lỗi");
            return redirect()->back();
        }

        $products = json_decode($data["product_json"], true);

        foreach ($products as $product) {
            DB::table("products")
                ->where("id", $product["id"])
                ->decrement("amount", $product["amount"]);
        }
        
        DB::table("carts")->where("user_id", get_user_id())->delete();

        Toastr::success("Đặt đơn hàng thành công", "Thành công");
        return redirect()->route("get.sell.index");
    }

    public function stripe($total)
    {
        $carts = Carts::with("product")->where("user_id", get_user_id())->get();
        if (!$carts) {
            abort(404);
        }

        $user  = get_user();
        return view('sell::pages.stripe',compact('total','user','carts'));
    }
    
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(PaymentRequest $request,$total)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $total,
                "currency" => "vnd",
                "source" => $request->stripeToken,
                "description" => "Thanh toán thành công" 
        ]);

        $data = $request->except(["_token", "stripeToken"]);;
        $id   = get_user_id();

        if (!$id) {
            abort(404);
        }

        $data["created_at"] = now()->toDateTimeString();
        $data["updated_at"] = now()->toDateTimeString();

        $reponse = DB::table("orders")->insert($data);

        if (!$reponse) {
        
            Toastr::error("Có lỗi xảy ra", "Lỗi");
            return redirect()->back();
        }

        $products = json_decode($data["product_json"], true);

        foreach ($products as $product) {
            DB::table("products")
                ->where("id", $product["id"])
                ->decrement("amount", $product["amount"]);
        }
        
        DB::table("carts")->where("user_id", get_user_id())->delete();

        toastr()->success("Thanh toán thành công", "Thành công");
        return redirect()->route("get.sell.index");
    }
}