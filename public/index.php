<?php

use App\Controllers\TaskController;
use App\Repositories\EmptyTaskRepository;
use App\Repositories\MysqlTaskRepository;
use App\Repositories\TaskRepository;
use DI\ContainerBuilder;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use function DI\create;

require_once "../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ .'/../');
$dotenv->load();


$loader = new FilesystemLoader('../views/');
$twig = new Environment($loader);

session_start();

$containerBuilder = new ContainerBuilder;

$containerBuilder->addDefinitions([
    TaskRepository::class => create(MysqlTaskRepository::class),
]);

$container = $containerBuilder->build();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', [TaskController::class,'index']);
    $r->addRoute('POST', '/', [TaskController::class,'store']);
    $r->addRoute('POST', '/delete/{id:\d+}', [TaskController::class,'delete']);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo $twig->render('error.twig', ['errorCode' => 404,'errorText'=>'Not found']);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo $twig->render('error.twig', ['errorCode' => 405,'errorText'=>'Method not allowed']);
        break;
    case FastRoute\Dispatcher::FOUND:
        $controller = $routeInfo[1];
        $parameters = $routeInfo[2];

        $response = $container->call($controller, $parameters);

        switch (get_class($response)) {
            case 'App\ViewResponse':
                if (isset($_SESSION)) {
                    $twig->addGlobal('session', $_SESSION);
                }
                echo $twig->render($response->getViewName() . '.twig', $response->getData());
                unset($_SESSION['error']);
                unset($_SESSION['successful']);
                break;
            case 'App\RedirectResponse':
                header('Location: ' . $response->getLocation());
                break;
            default:
                echo $twig->render('error.twig', ['errorCode' => 'Ooops!','errorText'=>'Something went wrong.']);
        }
        break;
}