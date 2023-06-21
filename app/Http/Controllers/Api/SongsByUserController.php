<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\Request;

class SongsByUserController extends Controller
{
    public function __construct(protected UserService $service)
    {
    }

    /**
     * Display a listing of the resource.
     * @throws Exception
     */
    public function index(int $userId)
    {
        try {
            $user = $this->service->show($userId);
            return response()->json($user->load('songs'));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }
}
