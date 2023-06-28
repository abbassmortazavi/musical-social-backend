<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostStoreRequest;
use App\Services\Post\PostService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(protected PostService $service)
    {
    }

    /**
     * Display a listing of the resource.
     * @throws Exception
     */
    public function index()
    {
        try {
            return response()->json($this->service->index());
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
            return response()->json($exception->getMessage());
        }
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
    public function store(PostStoreRequest $request)
    {
        try {
            $this->service->store($request->all());
            return response()->json(['message' => 'Post Saved']);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     * @throws Exception
     */
    public function show(int $id)
    {
        try {
            return response()->json(['data' => $this->service->show($id)]);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
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
    public function update(Request $request, int $id)
    {
        try {
            return response()->json(['data' => $this->service->update($request->all(), $id)]);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $this->service->destroy($id);
            return response()->json(['message' => 'Post Deleted']);
        } catch (\Exception $exception) {
            report($exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function postByUser(int $id)
    {
        try {
            return response()->json(['data' => $this->service->postByUser($id)]);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }
}
