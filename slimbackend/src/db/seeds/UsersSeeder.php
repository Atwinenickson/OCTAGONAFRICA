<?php


use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'firstname'    => 'atwine',
                'lastname' => 'nickson',
                'phone' => '0788888888',
                'password' => 'nick12345'
            ],
            [
                'firstname'    => 'octagon',
                'lastname' => 'octagon',
                'phone' => '0700000000',
                'password' => 'octagon12345'
            ],
            [
                'firstname'    => 'foo12345',
                'lastname' => 'foo12345',
                'phone' => '07009122344',
                'password' => 'foo12345'
            ],
            [
                'firstname'    => 'foo123456',
                'lastname' => 'foo123456',
                'phone' => '07005122344',
                'password' => 'foo123456'
            ]
        ];

        $users = $this->table('users');
        $users->insert($data)
              ->saveData();

        // empty the table
        // $users->truncate();
    }
}
