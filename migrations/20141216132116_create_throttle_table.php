<?php

use Phinx\Migration\AbstractMigration;

class CreateThrottleTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $throttle = $this->table('throttle');
        $throttle->addColumn('user_id', 'integer')
              ->addColumn('attempts', 'integer')
              ->addColumn('status', 'string')
              ->addColumn('last_attempt', 'datetime')
              ->addColumn('status_change', 'datetime')
              ->addColumn('created', 'datetime')
              ->addColumn('updated', 'datetime', array('default' => null))
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('throttle');
    }
}