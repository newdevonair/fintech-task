<?php

namespace Customers\V1\Rest\Customer;

use Application\Models\GlobalHelper;
use Customers\V1\Service\OauthClient\OauthClientService;
use GuzzleHttp\Client;
use Laminas\Crypt\Password\Bcrypt;
use Laminas\Db\Adapter\Adapter;
use PDO;
use PHPUnit\Util\Exception;

class CustomerMapper
{
    public const TABLE_NAME = 'fintech_customer';
    private Adapter $adapter;
    private OauthClientService $oauthClientService;

    /**
     * @param Adapter $adapter
     * @param OauthClientService $oauthClientService]
     */
    public function __construct(Adapter $adapter, OauthClientService $oauthClientService)
    {
        $this->adapter = $adapter;
        $this->oauthClientService = $oauthClientService;
    }

    /**
     * @param CustomerEntity $entity
     * @return void
     */
    public function create(CustomerEntity $entity): void
    {
        $sql_query = "INSERT INTO `" . self::TABLE_NAME . "`
                (`name`, `surname`, `date_of_birth`, `username`, `password`)
            VALUES
                (:name,
                :surname,
                :date_of_birth,
                :username,
                :password
                )";
        $this->adapter->getDriver()->getConnection()->beginTransaction();
        try {
            $customer_id = $this->adapter->createStatement($sql_query, [
                ':name' => $entity->getName(),
                ':surname' => $entity->getSurname(),
                ':date_of_birth' => $entity->getDateOfBirth(),
                ':username' => $entity->getUsername(),
                ':password' => GlobalHelper::encryptBcrypt($entity->getPassword()),
            ])->execute()->getGeneratedValue();
            $entity->setCustomerId((int) $customer_id);
            $oauth_data = $this->oauthClientService->generateAccess($entity->getCustomerId());
            $sql_query = "UPDATE `" . self::TABLE_NAME . "`
                SET `client_id` = :client_id, `client_secret` = :client_secret
                WHERE `customer_id` = :customer_id";
            $this->adapter->createStatement($sql_query, [
                ':client_id' => $oauth_data['client_id'],
                ':client_secret' => $oauth_data['client_secret'],
                ':customer_id' => $customer_id,
            ])->execute();
            $this->adapter->getDriver()->getConnection()->commit();
        } catch (\Throwable $t) {
            $this->adapter->getDriver()->getConnection()->rollback();
            throw new Exception('Can not execute user create query', 500, $t);
        }
    }

    /**
     * @param array $login_data
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function login(array $login_data): array
    {
        $sql_query = "SELECT `client_id`, `client_secret`, `password`
            FROM `" . self::TABLE_NAME . "`
            WHERE `username` = :username";
        $user_data = $this->adapter->createStatement($sql_query, [
            ':username' => $login_data['username'],
        ])->execute()->getResource()->fetch(PDO::FETCH_ASSOC);
        if (empty($user_data)) {
            return [];
        }
        if (GlobalHelper::verifyBcrypt($login_data['password'], $user_data['password'])) {
            $data = $this->getAccessToken($user_data['client_id'], $user_data['client_secret']);
        }
        return [];
    }

    /**
     * @param string $client_id
     * @param string $clint_secret
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getAccessToken(string $client_id, string $clint_secret): array
    {
        $client = new Client([
            // On cas of live application, we can set it in config or take from database
            'base_uri' => 'http://fintech.test:8001/',
        ]);
        $data = $client->request(
            'POST',
            'oauth',
            [
                'body' => json_encode([
                    'grant_type' => 'client_credentials',
                ]),
                'auth' => [
                    $client_id,
                    $clint_secret
                ],
            ]
        );
        if ($data->getStatusCode() == 200) {
            return json_decode($data->getBody(), 1);
        }
        return [];
    }
}
