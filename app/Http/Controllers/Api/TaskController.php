<?php

namespace App\Http\Controllers\Api;

use App\Facades\ApiJsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Requests\Api\TaskRequest;
use App\Http\Resources\Api\TaskResource;
use App\Services\TaskServiceInterface;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function __construct(
        private readonly TaskServiceInterface $taskService
    ) { }

    /**
     * Display a listing of the resource.
     */
    public function index(AuthRequest $authRequest)
    {
        $user = $authRequest->user();
        $resource = $this->taskService->getUserTasks($user?->id, $authRequest->get('paginated', 0));
        return ApiJsonResponse::successResponse($resource);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $user = $request->user();
        $resource = $this->taskService->createUserTask($user?->id, $request->validated());
        return ApiJsonResponse::successResponse($resource);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
    public function destroy(string $id)
    {
        //
    }
}
