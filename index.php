<?php


    session_start();


use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use League\Plates\Engine;

require_once 'vendor/autoload.php';


$builder = new DI\ContainerBuilder();

$builder->addDefinitions([
    PDO::class => function() {
        $driver = 'mysql';
        $host = 'localhost';
        $dbName = 's';
        $userName = 'root';
        $password = '';
        return new PDO($driver . ":host=" . $host . ";dbname=" . $dbName, $userName, $password);
    },
    QueryFactory::class => function(){
        return new QueryFactory('mysql');
    },
    Engine::class => function(){
        return new Engine('App/view');
    },
    Auth::class => function($container){
        return new Auth($container->get('PDO'));
    }
]);

$container = $builder->build();



$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\controllers\LoginpageControl', 'lookForm']);
    $r->addRoute('POST', '/', ['App\controllers\LoginpageControl', 'login']);
    $r->addRoute('GET', '/users', ['App\controllers\UserspageControl', 'get']);
    $r->addRoute('GET', '/auth', ['App\controllers\AuthPageControl', 'lookForm']);
    $r->addRoute('POST', '/auth', ['App\controllers\AuthPageControl', 'registration']);
    $r->addRoute('GET', '/verify', ['App\controllers\VerifypageControl', 'verify']);
    $r->addRoute('POST', '/verify', ['App\controllers\VerifypageControl', 'verifyEmail']);
    $r->addRoute('GET', '/login', ['App\controllers\LoginpageControl', 'lookForm']);
    $r->addRoute('POST', '/login', ['App\controllers\LoginpageControl', 'login']);
    $r->addRoute('GET', '/edit', ['App\controllers\EditpageControl', 'lookForm']);
    $r->addRoute('POST', '/edit', ['App\controllers\EditpageControl', 'editInformation']);
    $r->addRoute('GET', '/create', ['App\controllers\CreateUserpageControl', 'lookForm']);
    $r->addRoute('POST', '/create', ['App\controllers\CreateUserpageControl', 'createUser']);
    $r->addRoute('GET', '/avatar', ['App\controllers\AvatarpageControl', 'lookForm']);
    $r->addRoute('POST', '/avatar', ['App\controllers\AvatarpageControl', 'uploadPhoto']);
    $r->addRoute('GET', '/profile', ['App\controllers\ProfilepageControl', 'lookForm']);
    $r->addRoute('GET', '/security', ['App\controllers\SecuritypageControl', 'lookForm']);
    $r->addRoute('POST', '/security', ['App\controllers\SecuritypageControl', 'changePass']);
    $r->addRoute('GET', '/status', ['App\controllers\StatuspageControl', 'lookForm']);
    $r->addRoute('POST', '/status', ['App\controllers\StatuspageControl', 'changeStatus']);
    $r->addRoute('GET', '/logout', ['App\controllers\LogoutpageControl', 'logout']);
    $r->addRoute('GET', '/delete', ['App\controllers\DeletepageControl', 'delete']);
    // {id} must be a number (\d+)
    $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
    // The /{title} suffix is optional
    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo 'Такой страницы нет';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo 'не тот запрос';
        break;
    case FastRoute\Dispatcher::FOUND:
//        $handler = $routeInfo[1];
//
//        $controller = new $handler[0];
//        d($controller);die;
//        $vars = $routeInfo[2];
//        d($routeInfo[1], $routeInfo[2]);die;
        $container->call($routeInfo[1], $routeInfo[2]);
//    call_user_func([$container,$handler[1]],$vars);
        // ... call $handler with $vars
        break;
}

