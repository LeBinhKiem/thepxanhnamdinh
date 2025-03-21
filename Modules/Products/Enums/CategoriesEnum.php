<?php

namespace Modules\Products\Enums;

class CategoriesEnum
{
    const STATUS_ACTIVE     = 1;
    const STATUS_NO_ACTIVE  = 0;
    const ARR_STATUS = [
        self::STATUS_ACTIVE     => "Đang hoạt động",
        self::STATUS_NO_ACTIVE  => "Dừng hoạt động",
    ];
}