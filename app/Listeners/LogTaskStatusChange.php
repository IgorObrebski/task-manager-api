<?php

namespace App\Listeners;

use App\Events\TaskStatusChanged;
use Illuminate\Support\Facades\Log;

class LogTaskStatusChange
{
    public function handle(TaskStatusChanged $event)
    {
        Log::info("Task #{$event->task->getId()} status changed from {$event->oldStatus->value} to {$event->newStatus->value}");
    }
}
