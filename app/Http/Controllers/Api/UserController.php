<?php

namespace App\Http\Controllers\Api;

use App\Facades\ApiJsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Repositories\UserRepositoryInterface;
use App\Services\TaskServiceInterface;

class UserController extends Controller
{

    public function __construct(
        private readonly TaskServiceInterface $taskService,
        private readonly UserRepositoryInterface $userRepository
    ) { }

    public function tasks(UserRequest $request)
    {
        $user = $this->userRepository->findByEmailOrFail($request->get('email'));
        $resource = $this->taskService->getUserTasks($user->id, $request->get('paginated', 0));
        return ApiJsonResponse::successResponse($resource);
    }

}
