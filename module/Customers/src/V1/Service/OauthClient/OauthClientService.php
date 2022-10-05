<?php

namespace Customers\V1\Service\OauthClient;

use Application\Models\GlobalHelper;
use Laminas\Db\Adapter\Adapter;
use PDO;

class OauthClientService
{
    private const CLINT_TABLE = 'oauth_clients';
    private const ACCESS_TOKEN_TABLE = 'oauth_access_tokens';

    private Adapter $adapter;



    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param string $client_id
     * @param int $user_id
     * @return array|string[]
     */
    public function generateAccess(int $user_id): array
    {
        $sql_query = "INSERT INTO `" . self::CLINT_TABLE . "`
                (`client_id`, `client_secret`, `redirect_uri`, `user_id`)
                VALUES 
                (:client_id, :client_secret, :redirect_uri, :user_id)";
        $client_id = $this->getRandomString(12);
        $client_secret = $this->getRandomString(16);
        $this->adapter->createStatement($sql_query, [
            ':client_id' => $client_id,
            ':client_secret' => GlobalHelper::encryptBcrypt($client_secret),
            ':redirect_uri' => '',
            ':user_id' => $user_id,
        ])->execute();
        return [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
        ];
    }

    private function getRandomString(int $bytes): string
    {
        return bin2hex(random_bytes($bytes));
    }

    /**
     * @param string $client_id
     * @param int $user_id
     * @return array
     */
    private function getDataByUserId(string $client_id, int $user_id): array
    {
        $sql_query = "SELECT `client_id` 
            FROM `" . self::CLINT_TABLE . "`
            WHERE `client_id` = :client_id AND `user_id` = :user_id";
        $data = $this->adapter->createStatement($sql_query, [
            ':client_id' => $client_id,
            ':user_id' => $user_id
        ])->execute()->getResource()->fetch(PDO::FETCH_COLUMN);
        return $data ?: [];
    }
}
