<?php

namespace App\Services;

use App\Events\TaskStatusChanged;
use App\Models\Task;
use App\Repositories\TaskRepository;
use App\TaskStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Event;

class TaskService
{
    public function __construct(protected TaskRepository $repository) {}

    public function createTask(array $data): Task
    {
        $data['status'] = $data['status'] ?? TaskStatus::TODO->value;
        return $this->repository->create($data);
    }

    public function updateTask(Task $task, array $data): Task
    {
        if (isset($data['status'])) {
            $data['status'] = TaskStatus::from($data['status'])->value;
        }
        return $this->repository->update($task, $data);
    }

    public function changeStatus(Task $task, TaskStatus $newStatus): Task
    {
        $oldStatus = $task->getStatus();

        if ($oldStatus !== $newStatus) {
            $task->setStatus($newStatus);
            $this->repository->update($task, ['status' => $newStatus->value]);
            Event::dispatch(new TaskStatusChanged($task, $oldStatus, $newStatus));
        }

        return $task;
    }

    public function deleteTask(Task $task): bool
    {
        return $this->repository->delete($task);
    }

    public function listTasks(): Collection
    {
        return $this->repository->all();
    }

    public function findTask(int $id): ?Task
    {
        return $this->repository->find($id);
    }
}
