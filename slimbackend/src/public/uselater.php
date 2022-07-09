<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


use \DB as DB;
// use Psr\Http\Message\ResponseInterface as Response;
// use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;

require  '../../vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(['settings' => $config]);
$container = $app->getContainer();




$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new \PDO("sqlite:" .db/phpsqlite.db);
    if ($pdo != null)
    echo 'Connected to the SQLite database successfully!';
    else
    echo 'Whoops, could not connect to the SQLite database!';
    return $pdo;
};



$app->get('/users', function() {
    $pdo = new PDO('sqlite:/home/atwine/nickson/Work/Vue/octagon/slimbackend/src/db/users.sqlite3');
    // if ($pdo != null)
    // echo 'Connected to the SQLite database successfully!';
    // else
    // echo 'Whoops, could not connect to the SQLite database!';

    $result = $pdo ->query("SELECT * FROM users");
    foreach($result as $row)
    {
        $data[] = $row;
        // print $row['phone'] . "\n";
        // print json_encode($row);
        // print json_encode($data);
    }
    echo json_encode($result);
   
});


$app->get('/users', function (Request $request, Response $response) {
    $sql = "SELECT * FROM users";
   
    try {
      $db = new Db();
      $conn = $db->connect();
      $stmt = $conn->query($sql);
      $users = $stmt->fetchAll(PDO::FETCH_OBJ);
      $db = null;
     
      $response->getBody()->write(json_encode($users));
      return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(200);
    } catch (PDOException $e) {
      $error = array(
        "message" => $e->getMessage()
      );
   
      $response->getBody()->write(json_encode($error));
      return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(500);
    }
   });
$app->run();