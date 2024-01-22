<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Collections\TaskCollection;
use App\Models\Task;

class EmptyTaskRepository implements TaskRepository
{
    protected TaskCollection $taskCollection;

    public function __construct()
    {
        $this->taskCollection = new TaskCollection([
            new Task('first task', 'description of first task', null,  1),
            new Task('second task', 'description of second task', null,  2),
            new Task('third task', 'description of third task', null,  3),
            new Task('fourth task', 'description of fourth task', null,  4),
        ]);
    }

    public function getById(string $id): ?Task
    {
        $tasks = $this->taskCollection->all();
        foreach ($tasks as $task) {
            if ($task->getId() == $id) {
                return $task;
            }
        }

        return null;
    }

    public function save(Task $task): void
    {
        // TODO: Implement save() method.
    }

    public function delete(Task $task): void
    {
        // TODO: Implement delete() method.
    }

    public function getAll(): TaskCollection
    {
        return $this->taskCollection;
    }
}