<?php

namespace App\Events;

use App\Models\Task;
use App\TaskStatus;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskStatusChanged
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Task $task,
        public TaskStatus $oldStatus,
        public TaskStatus $newStatus,
    ) {}
}
