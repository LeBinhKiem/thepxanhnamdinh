<?php

namespace Modules\Auth\Services;

use Modules\Auth\Repositories\AuthRepository;

class AuthService
{
    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register($request){
        $data = $request->except("_token");
        $data["password"] = bcrypt($data["password"]);
        $response = $this->authRepository->register($data);

        return $response;
    }
}
