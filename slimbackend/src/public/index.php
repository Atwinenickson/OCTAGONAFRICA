<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
// use \Slim\Http\Response as Response;

use Slim\Factory\AppFactory;


use Chadicus\Slim\OAuth2\Middleware;
use Chadicus\Slim\OAuth2\Routes;

use Slim\Http;
use Slim\Views;
use OAuth2\Storage;
use OAuth2\GrantType;




// import the sqlite database instance
use \DB as DB;

use Selective\BasePath\BasePathMiddleware;

require  '/home/atwine/nickson/Work/Vue/octagon/slimbackend/vendor/autoload.php';


$pdo = new \PDO('sqlite:' . __DIR__ . '/slim_oauth2.db');
$storage = new Storage\Pdo($pdo);

$server = new OAuth2\Server(
  $storage,
  [
      'access_lifetime' => 3600,
  ],
  [
      new GrantType\ClientCredentials($storage),
      new GrantType\AuthorizationCode($storage),
  ]
);

$app = new Slim\App([]);

$renderer = new Views\PhpRenderer( __DIR__ . '/vendor/chadicus/slim-oauth2-routes/templates');


$app->map(['GET', 'POST'], Routes\Authorize::ROUTE, new Routes\Authorize($server, $renderer))->setName('authorize');
$app->post(Routes\Token::ROUTE, new Routes\Token($server))->setName('token');
$app->map(['GET', 'POST'], Routes\ReceiveCode::ROUTE, new Routes\ReceiveCode($renderer))->setName('receive-code');

$authorization = new Middleware\Authorization($server, $app->getContainer());




// get all routes that need cors settings
$app->options('/{routes:.+}', function ($request, $response, $args) {
  return $response;
});


// enable cors on the required methods
$app->add(function ($req, $res, $next) {
  $response = $next($req, $res);
  return $response
          ->withHeader('Access-Control-Allow-Origin', '*')
          ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
          ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});





// get all users
$app->get('/users', function (Request $request, Response $response) {
    $sql = "SELECT * FROM user";
   
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
     //return all users, no scope required
   }) ->add($authorization);

// get a specific user
$app->get(
    '/users/{id}',
    function (Request $request, Response $response, array $args) 
{
 $id = $request->getAttribute('id');

 $sql = "SELECT * FROM  user  WHERE id = $id";

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




// add users to the database
$app->post('/users/add', function (Request $request, Response $response, array $args) {
  $data = $request->getParsedBody();
  $firstname = $data['firstname'];
  $lastname = $data['lastname'];
  $phone = $data['phone'];
  $password= $data['password'];

  // Hash password when user enters data
  $password = password_hash($password, PASSWORD_DEFAULT);
 
  $sql = "INSERT INTO user (firstname, lastname, phone, password) VALUES (:firstname, :lastname, :phone, :password)";

    
  try {
    $db = new Db();
    $conn = $db->connect();
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':password', $password);
 
    $result = $stmt->execute();
 
    $responseMessage = json_encode(["success"=>true,"response"=>"User added Successfully"]);
    $response->getBody()->write($responseMessage);
    return   $response
      ->withHeader('content-type', 'application/json')
      ->withStatus(200);
  } catch (PDOException $e) {
    $responseMessage = json_encode(["success"=>false,"response"=>"Sorry, User with phone already exists in the system"]);
    $response->getBody()->write($responseMessage);
    return   $response
      ->withHeader('content-type', 'application/json')
      ->withStatus(200);
 
   
  }


 });



 // user login functionality. Generate basic random token
$app->post('/login', function (Request $request, Response $response, array $args) {
  $data = $request->getParsedBody();
  $phone = $data["phone"];
  $userpassword= $data["password"];
 
  $sql = "SELECT * FROM  user WHERE phone = '$phone'";

  try {
    $db = new Db();
    $conn = $db->connect();
    $stmt = $conn->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);
    
    $db = null;
    $responseMessage = 'User Added Successfully';

    // $hashed = password_verify($userpassword, $users[0] -> password);


    if ($users){

      // Verify user entered password and the hashed password value
      if (password_verify($userpassword, $users[0] -> password)){
        
        // return $this->response->withJson(array("user" =>$users[0]))

        $responseMessage = json_encode(["success"=>true,"response"=>$responseMessage, "User"=>$users[0]]);
        $response->getBody()->write($responseMessage);
        return   $response
       ->withHeader('content-type', 'application/json')
       ->withStatus(200);
       // -> withHeader('Authorization', 'Bearer ' . $token);
      }
      else{
        $responseMessage = json_encode(["error"=>false,"response"=>"Wrong Password. Please enter a new password"]);
        $response->getBody()->write($responseMessage);
        return   $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(200);
  
      }

    } 

    else {
      $responseMessage = json_encode(["error"=>false,"response"=>"Wrong username and Password. Please enter the right credentials."]);
      $response->getBody()->write($responseMessage);
      return   $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(200);
    }

  } catch (PDOException $e) {
    $error = array(
      "message" => $e->getMessage()
    );
  }
 });

// Catch-all route to serve a 404 Not Found page if none of the routes match
// NOTE: make sure this route is defined last
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
  $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
  return $handler($req, $res);
});

$app->run();