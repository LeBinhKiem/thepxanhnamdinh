<?php

namespace Modules\Accounts\Models\Enums;

class UserEnum
{
    const STATUS_ACTIVE = 1;
    const STATUS_UN_ACTIVE = 0;

    const ARR_STATUS = [
        self::STATUS_ACTIVE => "Hoạt động",
        self::STATUS_UN_ACTIVE => "Dừng hoạt động",
    ];

    const configTab = [
        [
            "text" => "Tài khoản",
            "route" => "get.user.profile",
            "icon" => "fa-solid fa-user"
        ],
        [
            "text" => "Đổi mật khẩu",
            "route" => "get.user.change_password",
            "icon" => "fa-solid fa-user-shield"
        ],

    ];
}