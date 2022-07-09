<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UsersTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
    

        $users_table = $this->table('users');
        $users_table->addColumn('firstname', 'text', ['limit' => 25])
            ->addColumn('lastname', 'text', ['limit' => 25])
            ->addColumn('phone', 'text', ['limit' => 10])
            ->addColumn('password', 'text')
            ->addIndex(['phone', 'password'], ['unique' => true])
            ->create();

    }

    public function down() {
        $this->dropTable('users');
    }
}
