<?php
declare(strict_types=1);

namespace App\Services\Task;

use App\Collections\TaskCollection;
use App\Repositories\TaskRepository;

class IndexTaskService
{
    public function __construct(private TaskRepository $taskRepository)
    {
    }

    public function execute(): TaskCollection
    {

        return $this->taskRepository->getAll();
    }


}