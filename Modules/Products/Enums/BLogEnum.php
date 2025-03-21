<?php

namespace Modules\Products\Enums;

class BLogEnum
{
    const STATUS_ACTIVE     = 1;
    const STATUS_NO_ACTIVE  = 0;

    const ARR_STATUS = [
        self::STATUS_ACTIVE     => "Hiển thị",
        self::STATUS_NO_ACTIVE  => "Không hiển thị",
    ];
}