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
}