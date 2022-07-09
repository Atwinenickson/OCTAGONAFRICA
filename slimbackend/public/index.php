<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;
 use Monolog\Handler\StreamHandler;

require '../vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = 'localhost';
$config['db']['user']   = 'user';
$config['db']['pass']   = 'password';
$config['db']['dbname'] = 'exampleapp';

$app = new \Slim\App(['settings' => $config]);
$container = $app->getContainer();

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler('../logs/app.log');
    $logger->pushHandler($file_handler);
    return $logger;
};


$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};


$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new \PDO("sqlite:" .db/phpsqlite.db);
    if ($pdo != null)
    echo 'Connected to the SQLite database successfully!';
    else
    echo 'Whoops, could not connect to the SQLite database!';
    return $pdo;
};


$app->get('/users', function (Request $request, Response $response) {
    
    // $this->logger->addInfo("User list");
    $mapper = new UserMapper($this->db);
    $users = $mapper->getUsers();

    $response->getBody()->write(var_export($users, true));
    return $response;
});

$app->get('/user/{id}', function (Request $request, Response $response, $args) {
    $user_id = (int)$args['id'];
    $mapper = new UserMapper($this->db);
    $user = $mapper->getUserById($user_id);

    $response->getBody()->write(var_export($user, true));
    return $response;
});

$app->post('/user/new', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $user_data = [];
    $user_data['firstname'] = filter_var($data['firstname'], FILTER_SANITIZE_STRING);
    $user_data['lastname'] = filter_var($data['lastname'], FILTER_SANITIZE_STRING);
    $user_data['phone'] = filter_var($data['phone'], FILTER_SANITIZE_STRING);
    $user_data['password'] = filter_var($data['password'], FILTER_SANITIZE_STRING);
});

$app->run();