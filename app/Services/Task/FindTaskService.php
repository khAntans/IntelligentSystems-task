<?php
declare(strict_types=1);

namespace App\Services\Task;

use App\Models\Task;
use App\Repositories\TaskRepository;

class FindTaskService
{
    public function __construct(private TaskRepository $taskRepository)
    {
    }

    public function execute(string $id): ?Task
    {

        return $this->taskRepository->getById($id);

    }

}