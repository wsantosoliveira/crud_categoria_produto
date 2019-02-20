<?php

namespace CodeShopping\Http\Controllers\API;

use CodeShopping\Http\Controllers\Controller;
use CodeShopping\Http\Resources\UserResource;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Status;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $this->validateLogin($request);
        $credentials = $this->credentials($request);
        $token = \JWTAuth::attempt($credentials);

        return response()->json($token ? ["token" => $token] : ["error" => \Lang::get("auth.failed")], $token ? Status::HTTP_OK : Status::HTTP_BAD_REQUEST);
    }

    public function logout()
    {
        \Auth::guard("api")->logout();
        return response()->json([], Status::HTTP_NO_CONTENT);
    }

    public function me()
    {
        return new UserResource(\Auth::guard("api")->user());
    }

    public function refresh()
    {
        $token = \Auth::guard("api")->refresh();
        return response()->json(["token" => $token], Status::HTTP_OK);
    }
}
