<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Song\SongStoreRequest;
use App\Models\Song;
use App\Services\song\PostService;
use App\Services\song\SongService;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function __construct(protected SongService $service)
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
     * @throws \Exception
     */
    public function store(Request $request)
    {
        try {
            $this->service->store($request->all());
            return response()->json(['message' => 'Song Saved']);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Song $song)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Song $song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Song $song)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id, int $userId)
    {
        try {
            $this->service->destroy($id, $userId);
            return response()->json(['message' => 'Song Deleted']);
        } catch (\Exception $exception) {
            report($exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }
}
