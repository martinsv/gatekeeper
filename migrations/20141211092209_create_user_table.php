<?php

use Phinx\Migration\AbstractMigration;

class CreateUserTable extends AbstractMigration
{
    /**
     * Migrate Up, create the user table
     */
    public function up()
    {
        $users = $this->table('users');
        $users->addColumn('username', 'string', array('limit' => 20))
              ->addColumn('password', 'string', array('limit' => 100))
              ->addColumn('email', 'string', array('limit' => 100))
              ->addColumn('first_name', 'string', array('limit' => 30))
              ->addColumn('last_name', 'string', array('limit' => 30))
              ->addColumn('status', 'string', array('limit' => 30, 'default' => 'active'))
              ->addColumn('created', 'datetime')
              ->addColumn('updated', 'datetime', array('default' => null))
              ->addIndex(array('username'), array('unique' => true))
              ->save();

        // Manually add these as there seems to be a bug in Phinx...
        $this->execute('alter table users add password_reset_code VARCHAR(100)');
        $this->execute('alter table users add password_reset_code_timeout DATETIME');
    }

    /**
     * Migrate Down, remove the user table
     */
    public function down()
    {
        $this->dropTable('users');
    }
}