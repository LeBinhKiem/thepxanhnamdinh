<?php

namespace Modules\Products\Enums;

class OrderEnum
{
    const CANCEL = -1;
    const WAITING_CONFIRM = 0;
    const CONFIRM = 1;
    const SUCCESS = 2;
    const FAILURE = 3;

    const ARR_STATUS = [
        self::CANCEL => [
            "text" => "Hủy đơn",
            "textBtn" => "Hủy đơn",
            "class" => "badge bg-warning",
        ],
        self::WAITING_CONFIRM => [
            "text" => "Chờ xác nhận",
            "textBtn" => "",
            "class" => "badge bg-light",
        ],
        self::CONFIRM => [
            "text" => "Xác nhận",
            "textBtn" => "Xác nhận đơn",
            "class" => "badge bg-primary",
        ],
        self::SUCCESS => [
            "text" => "Thành công",
            "textBtn" => "Hoàn thành đơn",
            "class" => "badge bg-success",
        ],
        self::FAILURE => [
            "text" => "Thất bại",
            "textBtn" => "Giao thất bại",
            "class" => "badge bg-danger",
        ],
    ];
}