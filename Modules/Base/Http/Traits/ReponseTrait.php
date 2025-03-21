<?php

namespace Modules\Base\Http\Traits;

trait ReponseTrait
{
    public function reponseSucess($message = "",$data = [])
    {
        $dataReponse = [
            "status"        => 1,
            "title"         => "Thành công",
            "message"       => $message,
            "data"          => $data,
        ];

        return $dataReponse;
    }
    public function reponseError($message = "",$data = [])
    {
        $dataReponse = [
            "status"        => 0,
            "title"         => "Thất bại",
            "message"       => $message,
            "data"          => $data,
        ];

        return $dataReponse;
    }
}