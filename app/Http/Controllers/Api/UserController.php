<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Services\ImageService;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller
{
    public function __construct(protected UserService $service)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            return response()->json($this->service->show($id), ResponseAlias::HTTP_OK);
        } catch (Throwable $exception) {
            return response()->json($exception->getMessage());
        }
    }

    /**
     * @param UserUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request, int $id)
    {
        try {

            return response()->json($this->service->update($request->all(), $id), ResponseAlias::HTTP_OK);
        } catch (Throwable $exception) {
            return response()->json($exception->getMessage());
        }
    }

}
