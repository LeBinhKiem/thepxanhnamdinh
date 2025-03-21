<?php

namespace Modules\Accounts\Models\Enums;

class AdminEnum
{
    const MALE      = 0;
    const FEMALE    = 1;
    const SEX_OTHER = 2;

    const ARR_SEX = [
        self::MALE      => "Nam",
        self::FEMALE    => "Nữ",
        self::SEX_OTHER => "Khác",
    ];


    const PASSWORD_DEFAULT = "12345678";

    const SUPER_ADMIN = 0;
    const NORMAL_ADMIN = 1;

    const STATUS_ACTIVE = 1;
    const STATUS_UN_ACTIVE = 0;

    const ARR_STATUS = [
        self::STATUS_ACTIVE => "Hoạt động",
        self::STATUS_UN_ACTIVE => "Dừng hoạt động",
    ];
}