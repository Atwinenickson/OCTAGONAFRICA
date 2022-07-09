<?php

use Phinx\Migration\AbstractMigration;

class UsersTable extends AbstractMigration
{
    public function up()
    {
    

        $users_table = $this->table('users');
        $users_table->addColumn('firstname', 'text')
            ->addColumn('lastname', 'text')
            ->addColumn('phone', 'text')
            ->addColumn('password', 'text')
            ->create();

    }

    public function down() {
        $this->dropTable('users');
    }
}