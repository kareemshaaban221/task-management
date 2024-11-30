<?php

namespace App\Http\Controllers\Api;

use App\Facades\ApiJsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Requests\Api\TaskAssignRequest;
use App\Http\Requests\Api\TaskRequest;
use App\Http\Requests\Api\TaskUpdateRequest;
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

    public function assign(TaskAssignRequest $request)
    {
        $resource = $this->taskService->assignUserTask($request->validated('user_email'), $request->validated());
        return ApiJsonResponse::successResponse($resource);
    }

    /**
     * Display the specified resource.
     */
    public function show(AuthRequest $authRequest, string $taskId)
    {
        $user = $authRequest->user();
        $resource = $this->taskService->getUserTaskById($user?->id, $taskId);
        return ApiJsonResponse::successResponse($resource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, string $taskId)
    {
        $user = $request->user();
        $resource = $this->taskService->updateUserTask($user?->id, $taskId, $request->validated());
        return ApiJsonResponse::successResponse($resource);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuthRequest $authRequest, string $taskId)
    {
        $user = $authRequest->user();
        $this->taskService->deleteUserTask($user?->id, $taskId);
        return ApiJsonResponse::noContentResponse();
    }
}
