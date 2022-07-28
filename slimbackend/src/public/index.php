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



//set up storage for oauth2 server
$storage = new Storage\Memory(
  [
      'client_credentials' => [
          'administrator' => [
              'client_id' => 'administrator',
              'client_secret' => 'password'
          ],
          'octagon-client' => [
              'client_id' => 'octagon-client',
              'client_secret' => 'p4ssw0rd'
          ],
      ],
  ]
);

// create the oauth2 server
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


// create a global config object for the application
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$config['determineRouteBeforeAppMiddleware'] = true;

// instatiate the basic application with the config settings for the app
$app = new \Slim\App(['settings' => $config]);


$renderer = new Views\PhpRenderer( __DIR__ . '/vendor/chadicus/slim-oauth2-routes/templates');

$app->map(['GET', 'POST'], Routes\Authorize::ROUTE, new Routes\Authorize($server, $renderer))->setName('authorize');
$app->post(Routes\Token::ROUTE, new Routes\Token($server))->setName('token');
$app->map(['GET', 'POST'], Routes\ReceiveCode::ROUTE, new Routes\ReceiveCode($renderer))->setName('receive-code');

// create the authorization middlware
$authMiddleware = new Middleware\Authorization($server, $app->getContainer());


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
     //return all users, no scope required
   }) ->add($authMiddleware);
// });

// get a specific user
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




// add users to the database
$app->post('/users/add', function (Request $request, Response $response, array $args) {
  $data = $request->getParsedBody();
  $firstname = $data['firstname'];
  $lastname = $data['lastname'];
  $phone = $data['phone'];
  $password= $data['password'];
 
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



 // user login functionality. Generate basic random token
$app->post('/login', function (Request $request, Response $response, array $args) {
  $data = $request->getParsedBody();
  $phone = $data["phone"];
  $userpassword= $data["password"];
 
  $sql = "SELECT * FROM  users WHERE phone = '$phone'";

  try {
    $db = new Db();
    $conn = $db->connect();
    $stmt = $conn->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);
    // $user = reset($stmt->fetchAll(PDO::FETCH_OBJ));
    
    $db = null;

 

  // print_r($users[0] -> password);

    if ($users){

      if ($users[0] -> password === $userpassword){
        
        return $this->response->withJson(array("user" =>$users[0]))
       ->withHeader('content-type', 'application/json')
       ->withStatus(200);
       // -> withHeader('Authorization', 'Bearer ' . $token);
      }
      else{
        
        return $this->response->withJson(array("error"=>"Wrong password. Try with right password"))
        ->withHeader('content-type', 'application/json')
        ->withStatus(401);
  
      }

    } 

    else {
      $response->withJson(array("error"=>"User Not Found...Try with right phone and password"));
      return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(400);
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