<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserLogoutRequest;
use App\Http\Requests\Auth\UserStoreRequest;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class AuthController extends Controller
{
    public function __construct(protected UserService $service)
    {
    }

    /**
     * @param UserStoreRequest $request
     * @return JsonResponse
     */
    public function register(UserStoreRequest $request)
    {
        try {
            return response()->json($this->service->register($request->all()), ResponseAlias::HTTP_OK);
        } catch (Throwable $exception) {
            return response()->json($exception->getMessage());
        }
    }

    /**
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function login(UserLoginRequest $request)
    {
        try {
            return response()->json($this->service->login($request->only('password','email')), ResponseAlias::HTTP_OK);
        } catch (Throwable $exception) {
            return response()->json($exception->getMessage());
        }
    }

    /**
     * @param UserLogoutRequest $request
     * @return JsonResponse
     */
    public function logout(UserLogoutRequest $request)
    {
        try {
            return response()->json($this->service->logout($request->all()), ResponseAlias::HTTP_OK);
        } catch (Throwable $exception) {
            return response()->json($exception->getMessage());
        }
    }
}
