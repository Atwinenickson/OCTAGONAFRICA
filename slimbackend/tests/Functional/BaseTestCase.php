<?php

namespace Tests\Functional;
use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;

class BaseTestCase extends TestCase
{
    public function runApp($requestMethod, $requestUri, $requestData = null)
    {
        //create a mock environment for testing with

        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
            );

        //Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);

        // Add request data if available
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        //Set up a response object
        $response = new Response();
        $app = new App();
        require '/home/atwine/nickson/Work/Vue/octagon/slimbackend/src/public/index.php';

        //Process the application
        $response = $app->process($request, $response);

        //Return the response
        return $response;
    }
}
