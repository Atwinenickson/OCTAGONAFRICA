<?php 

namespace Tests\Functional;

class indexApiTest extends BaseTestCase
{
    /**
     * @test
     */

     public function testUsersGetAll()
     {
        $response=$this->runApp('GET', '/users');
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 200);
        $result = json_decode($response->getBody(), true);
     }

     public function testUsersGetOne()
     {
        $response=$this->runApp('GET', '/users/1');
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 200);
        $result = json_decode($response->getBody(), true);
     }

     public function testUsersSignup()
     {
        $response=$this->runApp('POST', '/users/add');
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 200);
        $result = json_decode($response->getBody(), true);
     }

     public function testUsersLogin()
     {
        $response=$this->runApp('POST', '/login');
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 200);
        $result = json_decode($response->getBody(), true);
     }
}