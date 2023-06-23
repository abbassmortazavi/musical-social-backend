<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Youtup\YoutupStoreRequest;
use App\Services\Youtup\YoutupService;
use Exception;
use Illuminate\Http\Request;

class YoutupController extends Controller
{
    public function __construct(protected YoutupService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @throws Exception
     */
    public function store(YoutupStoreRequest $request)
    {
        try {
            $this->service->store($request->all());
            return response()->json(['message' => 'Video Saved']);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * @throws Exception
     */
    public function show(int $userId)
    {
        try {
            return $this->service->show($userId);
        } catch (Exception $exception) {
            //throw new Exception($exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            return $this->service->destroy($id);
        } catch (Exception $exception) {
            //throw new Exception($exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }
}
