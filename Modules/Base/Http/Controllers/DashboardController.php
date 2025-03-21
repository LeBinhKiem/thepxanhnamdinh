<?php

namespace Modules\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->month ?? now()->month;
        $year  = $request->year ?? now()->year;

        if ($month > 12 || $month < 1) {
            toastr()->error("Tháng phải lớn hơn 0 vầ nhỏ hơn 12");
            return redirect()->back();
        }
        if ($year > now()->year || $year < 1) {
            toastr()->error("Năm phải lớn hơn 0 vầ nhỏ hơn năm hiện tại");
            return redirect()->back();
        }

        $date = create_date_by_month_year($year, $month);

        $viewData              = $this->__getDataTab($date);
        $viewData["dataChart"] = $this->__getDataChart($date);

        $viewData["query"] = $request->query();

        return view('base::dash_board')->with($viewData);
    }

    private function __getDataTab($date)
{
    $userCreateInDay = $this->__queryGetTab("users", $date);
    $blogCreateInDay = $this->__queryGetTab("blogs", $date);
    $playerInDay     = $this->__queryGetPlayers(); // Sửa đổi để lấy tất cả cầu thủ
    $mediaInDay      = $this->__queryGetTab("medias", $date);
    $orderInDay    = $this->__queryGetTab("orders", $date);

    $orderTotalInDay = DB::table("orders")
        ->where("status", 2)
        ->whereBetween('created_at', [$date->startOfMonth()->toDateTimeString(), $date->endOfMonth()->toDateTimeString()])
        ->sum("total");

    $data = [
        "userCreateInDay" => $userCreateInDay,
        "blogCreateInDay" => $blogCreateInDay,
        "orderTotalInDay" => $orderTotalInDay,
        "playerInDay"     => $playerInDay, // Cập nhật biến này
        "mediaInDay"      => $mediaInDay,
        "orderInDay"    => $orderInDay,
    ];

    return $data;
}

private function __queryGetPlayers()
{
    return DB::table("players")
        ->count(); // Lấy toàn bộ số lượng cầu thủ
}

    private function __queryGetTab($table, $date, $active = false)
    {
        $data      = DB::table($table);
        $startDate = $date->startOfMonth()->toDateTimeString();
        $endDate   = $date->endOfMonth()->toDateTimeString();

        if ($active) {
            $data = $data->where("status", 1);
        }
        return $data
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
    }

    private function __getDataChart($date)
    {
        $startDate    = $date->startOfMonth()->toDateTimeString();
        $endDate      = $date->endOfMonth()->toDateTimeString();
        $monthCurrent = $date->month;
        $yearCurrent  = $date->year;
        $days         = [];

        for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $monthCurrent, $yearCurrent); $day++) {
            $days[] = $day;
        }

        $dataChartLineAccount = DB::table("users")
            ->selectRaw('DAY(created_at) as date, COUNT(id) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();


        $dataChartLineAccount = $this->__processDataChart($dataChartLineAccount, $days);


        $data = [
            "dataChartLineAccount" => $dataChartLineAccount,
            "yearCurrent"          => $yearCurrent,
            "monthCurrent"         => $monthCurrent,
        ];

        return $data;
    }

    private function __processDataChart($data, $keys)
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $data)) {
                $data[$key] = 0;
            }
        }

        ksort($data);

        return $data;
    }
}

