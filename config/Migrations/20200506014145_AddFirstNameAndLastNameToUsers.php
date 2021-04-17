<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddFirstNameAndLastNameToUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('first_name', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
            'after' => 'role',
            'comment' => '姓',
        ]);
        $table->addColumn('last_name', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
            'after' => 'first_name',
            'comment' => '名',
        ]);
        $table->update();
    }
}
