<?php

namespace Transactions\V1\Rest\CustomerTransaction;

use Customers\V1\Rest\Customer\CustomerMapper;
use Laminas\Db\Adapter\Adapter;
use phpDocumentor\Reflection\DocBlock\Tags\Param;

class CustomerTransactionMapper
{
    private const TABLE_NAME = 'fintech_customer_transaction';

    private Adapter $adapter;

    /**
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param CustomerTransactionEntity $entity
     * @return void
     */
    public function create(CustomerTransactionEntity $entity): void
    {
        $sql_query =
            "INSERT INTO `" . self::TABLE_NAME . "`
                (`type`, `customer_id`, `amount`, `source`)
             VALUES (:type, :customer_id, :amount, :source)";
        $transaction_id = $this->adapter->createStatement($sql_query, [
            ':type' => $entity->getType(),
            ':customer_id' => $entity->getCustomerId(),
            ':amount' => $entity->getAmount(),
            ':source' => $entity->getSource(),
        ])->execute()->getGeneratedValue();
        $entity->setTransactionId($transaction_id);
    }

    public function fetchAll(int $limit, int $offset, array $filters)
    {
        $sql_query = "
            SELECT
                SQL_CALC_FOUND_ROWS
                `transaction_id`,
                `type`,
                `amount`,
                `source`,
                `customers`.`customer_id`,
                @balance  := @balance + IF(`type` = 'withdrawal', -`amount`, `amount`)
            FROM `" . self::TABLE_NAME . "` AS `transaction`
            INNER JOIN `" . CustomerMapper::TABLE_NAME . "` AS `customers`
                ON (`transaction`.`customer_id` = `customers`.`customer_id`)
            WHERE `customers`.`customer_id` = :customer_id
            ORDER BY `transaction`.`transaction_id` DESC   
            LIMIT :limit OFFSET :offset";
        $this->adapter->createStatement('SET @balance  := 0')->execute();
        $data = $this->adapter->createStatement($sql_query, [
            ':limit' => $limit,
            ':offset' => $offset,
            ':customer_id' => $filters['customer_id']
        ])->execute()->getResource()->fetchAll(\PDO::FETCH_ASSOC);
        $data_count = $this->adapter->createStatement('SELECT FOUND_ROWS()')->execute()->getResource()->fetch(\PDO::FETCH_COLUMN);
        $balance = $this->adapter->createStatement('SELECT @balance')->execute()->getResource()->fetch(\PDO::FETCH_COLUMN);
        return [
            'data' => $data,
            'data_count' => $data_count,
            'balance' => $balance,
        ];
    }

}
