<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            return response()->json($this->service->update($request->all(), $id), ResponseAlias::HTTP_OK);
        } catch (Throwable $exception) {
            return response()->json($exception->getMessage());
        }
    }

}
