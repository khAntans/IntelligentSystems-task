<?php
declare(strict_types=1);

namespace App\Services\Task;

use App\Models\Task;
use App\Repositories\TaskRepository;

class DeleteTaskService
{
    public function __construct(private TaskRepository $taskRepository)
    {
    }

    public function execute(Task $task): void
    {

        $this->taskRepository->delete($task);


    }

}