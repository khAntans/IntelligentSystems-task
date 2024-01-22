<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Task;
use App\RedirectResponse;
use App\Response;
use App\Services\Task\DeleteTaskService;
use App\Services\Task\FindTaskService;
use App\Services\Task\IndexTaskService;
use App\Services\Task\StoreTaskService;
use App\ViewResponse;
use Respect\Validation\Validator as v;

class TaskController
{
    public function __construct(
        protected IndexTaskService  $indexTaskService,
        protected StoreTaskService  $storeTaskService,
        protected FindTaskService   $findTaskService,
        protected DeleteTaskService $deleteTaskService)
    {
    }


    public function index(): Response
    {

        $collection = $this->indexTaskService->execute();
        return new ViewResponse('index', ['tasks' => $collection]);

    }

    private function checkIfIsSet(string $id): ?Task
    {
        $task = $this->findTaskService->execute($id);
        if (empty($task)) {
            $_SESSION['error'] = "Task with id = $id doesn't exist. ";
            return null;
        }
        return $task;
    }

    public function create(): Response
    {
        return new ViewResponse('create');
    }

    public function store(): Response
    {

        $validTitle = v::notBlank()->stringVal()->length(3,120)->validate($_POST['task_name']);
        $validDescription = v::stringVal()->validate($_POST['task_description']);

        if (!$validTitle && !$validDescription) {
            $_SESSION['error'] = 'Failed to add! Invalid name and description inputs!';
            return new RedirectResponse('/');
        }
        if (!$validTitle) {
            $_SESSION['error'] = 'Failed to add! Invalid name input!';
            return new RedirectResponse('/');
        }
        if (!$validDescription) {
            $_SESSION['error'] = 'Failed to add! Invalid description input!';
            return new RedirectResponse('/');
        }

        $title = $_POST['task_name'];
        $description = $_POST['task_description'];


        $this->storeTaskService->execute($title, $description);

        $_SESSION['successful'] = "New task has been successfully added!";

        return new RedirectResponse('/');

    }

    public function delete(string $id): Response
    {

        $id = (string)$id ?? $_POST['id'];

        $foundTask = $this->checkIfIsSet($id);

        if (!$foundTask) {

            return new RedirectResponse('/');
        }


        $_SESSION['successful'] = "Task with id $id has been deleted";

        $this->deleteTaskService->execute($foundTask);

        return new RedirectResponse('/');
    }

}