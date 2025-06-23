<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $task->fill($data);
        $task->save();

        return $task;
    }

    public function find(int $id): ?Task
    {
        return Task::find($id);
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }

    public function all(): Collection
    {
        return Task::all();
    }
}
