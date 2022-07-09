<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;




use \DB as DB;
use Selective\BasePath\BasePathMiddleware;

require  '../../vendor/autoload.php';


$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;


$app = new \Slim\App(['settings' => $config]);
$container = $app->getContainer();



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



$app->get(
    '/users/{id}',
    function (Request $request, Response $response, array $args) 
{
 $id = $request->getAttribute('id');

 $sql = "SELECT * FROM  users  WHERE id = $id";

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





$app->post('/users/add', function (Request $request, Response $response, array $args) {
  $data = $request->getParsedBody();
  $firstname = $data["firstname"];
  $lastname = $data["lastname"];
  $phone = $data["phone"];
  $password= $data["password"];
 
  $sql = "INSERT INTO users (firstname, lastname, phone, password) VALUES (:firstname, :lastname, :phone, :password)";
 
  try {
    $db = new Db();
    $conn = $db->connect();
   
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':password', $password);
 
    $result = $stmt->execute();
 
    $db = null;
    $response->getBody()->write(json_encode($result));
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