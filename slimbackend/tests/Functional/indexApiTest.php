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
        $this->assertSame($response->getStatusCode(), 401);
        $result = json_decode($response->getBody(), true);
     }

     public function testUsersGetOne()
     {
        $response=$this->runApp('GET', '/users/1');
        $this->assertSame($response->getStatusCode(), 200);
        $result = json_decode($response->getBody(), true);
     }

     public function testUsersSignup()
     {
        $response=$this->runApp('POST', '/users/add');
        $this->assertSame($response->getStatusCode(), 401);
        $result = json_decode($response->getBody(), true);
     }

     public function testUsersLogin()
     {
        $response=$this->runApp('POST', '/login');
        $this->assertSame($response->getStatusCode(), 500);
        $result = json_decode($response->getBody(), true);
     }
}