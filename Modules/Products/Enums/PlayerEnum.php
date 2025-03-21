<?php

namespace Modules\Products\Enums;

class PlayerEnum
{
    const TM ='Thủ môn';
    const HV  ='Hậu vệ';
    const TV ='Tiền vệ';
    const TĐ ='Tiền đạo';
    const POSITION = [
        self::TM    => "Thủ môn",
        self::HV  => "Hậu vệ",
        self::TV    => "Tiền vệ",
        self::TĐ  => "Tiền đạo",
    ];


    const DOI1    ='Đội hình 1';
    const DOITRE  ='Đội hình trẻ';
    const CHOMUON  ='Cho mượn';

    const TEAM = [
        self::DOI1    => "Đội hình 1",
        self::DOITRE  => "Đội hình trẻ",
        self::CHOMUON  => "Cho mượn",
    ];
}