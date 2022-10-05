<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class F1 extends AbstractMigration
{
    /**
     * Migrate Up
     * @return void
     */
    public function up(): void
    {
        if (! $this->hasTable('fintech_customer')) {
            $this->table('fintech_customer', ['id' => 'customer_id'])
                ->addColumn('name', 'string', [
                    'limit' => '255',
                ])
                ->addColumn('surname', 'string', [
                    'limit' => '255',
                ])
                ->addColumn('date_of_birth', 'date')
                ->addColumn('username', 'string', [
                    'limit' => '30',
                ])
                ->addColumn('password', 'string', [
                    'limit' => '100'
                ])
                ->addColumn('client_id', 'string', [
                    'limit' => '100',
                    'null' => true,
                ])
                ->addColumn('client_secret', 'string', [
                    'limit' => '100',
                    'null' => true,
                ])
                ->addIndex('username', [
                    'unique' => true,
                ])
                ->save();
        }
    }

    public function down()
    {
        if ($this->hasTable('fintech_customer')) {
            $this->table('fintech_customer')->drop()->save();
        }
    }
}
