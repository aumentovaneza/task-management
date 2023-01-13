<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class TaskController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(TaskResource::collection(Task::all()));
    }

    /**
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Task $task): JsonResponse
    {
        return response()->json(TaskResource::make($task));
    }

    /**
     * @param CreateTaskRequest $request
     * @return JsonResponse
     */
    public function create(CreateTaskRequest $request): JsonResponse
    {
        $requestData = array($request->safe()->all());
        $requestData['user_id'] = auth()->user->id;

        $newTask = Task::create($requestData);

        return response()->json(TaskResource::make($newTask));
    }

    /**
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return JsonResponse
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $requestData = array($request->safe()->all());
        $task->update($requestData);

        return response()->json(TaskResource::make($task), 201);

    }

    /**
     * @param Task $task
     * @return Response
     */
    public function delete(Task $task): Response
    {
        $task->delete();

        return response()->noContent()->setStatusCode(204);
    }
}
