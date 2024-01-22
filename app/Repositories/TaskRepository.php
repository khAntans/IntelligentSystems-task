<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Collections\TaskCollection;
use App\Models\Task;

interface TaskRepository
{

    public function save(Task $task): void;

    public function delete(Task $task): void;

    public function getAll(): TaskCollection;

}