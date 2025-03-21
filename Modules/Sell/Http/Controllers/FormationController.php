<?php

namespace Modules\Sell\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Products\Enums\PlayerEnum;

class FormationController extends Controller
{
    public function coaches()
    {
        $items    = DB::table("coaches")->get();
        $viewData = [
            "items"    => $items,
            "position" => "coaches",
        ];

        return view("sell::pages.fomation")->with($viewData);
    }

    public function player()
    {
        $items    = DB::table("players")->where("team", "=", PlayerEnum::TEAM[PlayerEnum::DOI1])->orderByRaw("FIELD(position, ?, ?, ?, ?)", array_values(PlayerEnum::POSITION))->get();
        $viewData = [
            "items"    => $items,
            "position" => "player",
        ];

        return view("sell::pages.fomation")->with($viewData);
    }
}