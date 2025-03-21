<?php

namespace Modules\Sell\Http\Controllers;

use App\Http\Controllers\Controller;

class IntroduceController extends Controller
{
    public function index() {
        return view("sell::pages.introduce");
    }
}