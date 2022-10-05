<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class F2 extends AbstractMigration
{
    /**
     * Migrate Up
     * @return void
     */
    public function up(): void
    {
        if (! $this->hasTable('fintech_customer_transaction')) {
            $this->table('fintech_customer_transaction', [
                'id' => 'transaction_id'
            ])
            ->addColumn('type', 'enum', [
                'values' => ['deposit', 'withdrawal'],
            ])
            ->addColumn('customer_id', 'integer')
            ->addColumn('amount', 'decimal', [
                'precision' => 15,
                'scale' => 2
            ])
            ->addColumn('source', 'enum', [
                'values' => [
                    'bank_account',
                    'credit_card'
                ]
            ])
            ->addForeignKey('customer_id', 'fintech_customer', 'customer_id', [
                'update' => 'CASCADE',
                'delete' => 'RESTRICT'
            ])->save();
        }
    }

    /**
     * @return void
     */
    public function down()
    {
        if ($this->hasTable('fintech_customer_transaction')) {
            $this->table('fintech_customer_transaction')->drop()->save();
        }
    }
}
