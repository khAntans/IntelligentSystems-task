<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Collections\TaskCollection;
use App\Models\Task;
use Carbon\Carbon;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Dotenv\Dotenv;

class MysqlTaskRepository implements TaskRepository
{
    private Connection $connection;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $connectionParams = [
            'dbname' => $_ENV['MYSQL_DB_NAME'],
            'user' => $_ENV['MYSQL_DB_USER'],
            'password' => $_ENV['MYSQL_DB_PASSWORD'],
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        ];

        $this->connection = DriverManager::getConnection($connectionParams);

    }

    public function getById(string $id): ?Task
    {
        $result = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('tasks')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAssociative();

        if (empty($result)) {
            return null;
        }

        return $this->buildModel($result);
    }

    private function buildModel(array $taskEntry): Task
    {
        return new Task(
            $taskEntry['task_name'],
            $taskEntry['task_description'],
            Carbon::create($taskEntry['created_at']) ?? Carbon::now(),
            (int)$taskEntry['id']
        );
    }

    public function save(Task $task): void
    {
        $this->insert($task);

    }

    private function insert(Task $task): void
    {
        $this->connection->createQueryBuilder()
            ->insert('tasks')
            ->values(
                [
                    'task_name' => ':name',
                    'task_description' => ':description'
                ]
            )->setParameters([
                'name' => $task->getName(),
                'description' => $task->getDescription(),
            ])->executeQuery();
    }

    public function getAll(): TaskCollection
    {
        $taskEntries = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('tasks')
            ->fetchAllAssociative();

        $collection = new TaskCollection();

        foreach ($taskEntries as $taskEntry) {
            $collection->add($this->buildModel($taskEntry));
        }
        return $collection;

    }

    public function delete(Task $task): void
    {

        $this->connection->delete('tasks', ['id' => $task->getId()]);

    }


}