<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use App\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService) {}

    public function store(Request $request)
    {
        try {
            $task = $this->taskService->createTask($request->all());
            return response()->json($task, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function update(Request $request, int $id)
    {
        $task = $this->taskService->findTask($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        try {
            $task = $this->taskService->updateTask($task, $request->all());
            return response()->json($task);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function changeStatus(Request $request, int $id)
    {
        $task = $this->taskService->findTask($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        try {
            $status = TaskStatus::from($request->get('status'));

            $task = $this->taskService->changeStatus($task,$status);
            return response()->json($task);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy(int $id)
    {
        $task = $this->taskService->findTask($id);

        if (!$task) {
            return response()->json([], 204);
        }

        $this->taskService->deleteTask($task);

        return response()->json([], 204);
    }

    public function index()
    {
        $tasks = $this->taskService->listTasks();

        return response()->json($tasks);
    }

}
