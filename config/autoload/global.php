<?php
return [
    'api-tools-content-negotiation' => [
        'selectors' => [],
    ],
    'db' => [
        'adapters' => [
            'mainDb' => [
                'charset' => 'utf8mb4',
                'database' => 'fintech',
                'driver' => 'PDO_Mysql',
                'hostname' => 'fintech-db',
                'port' => '3306',
                'username' => 'fintech',
                'password' => 'fintech',
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'oauth' => [
                'options' => [
                    'spec' => '%oauth%',
                    'regex' => '(?P<oauth>(/oauth))',
                ],
                'type' => 'regex',
            ],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authentication' => [
            'map' => [
                'Transactions\\V1' => 'oauth2',
            ],
        ],
    ],
];
