<?php

namespace Modules\Sell\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    public function index()
    {
        $items = DB::table("medias")
            ->orderBy("created_at", "desc")
            ->paginate(9);

        $viewData["items"] = $items;

        return view("sell::pages.media")->with($viewData);
    }
}