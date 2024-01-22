<?php
declare(strict_types=1);

namespace App\Services\Task;

use App\Models\Task;
use App\Repositories\TaskRepository;

class StoreTaskService
{
    public function __construct(private TaskRepository $taskRepository)
    {
    }

    public function execute(string $name, string $description): void
    {
        $task = new Task(
            $name,
            $description
        );

        $this->taskRepository->save($task);

    }

}