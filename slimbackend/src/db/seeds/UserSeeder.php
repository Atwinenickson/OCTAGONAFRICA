<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
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
                'phone' => '0700988211',
                'password' => 'Qwerty@123'
            ],
            [
                'firstname'    => 'octagon',
                'lastname' => 'octagon',
                'phone' => '0700000000',
                'password' => 'Qwerty@123'
            ],
            [
                'firstname'    => 'Jacob',
                'lastname' => 'Omutuuze',
                'phone' => '0700988233',
                'password' => 'Qwerty@123'
            ]
        ];

        $user = $this->table('user');
        $user->insert($data)
              ->saveData();

        // empty the table
        // $users->truncate();
    }
}
