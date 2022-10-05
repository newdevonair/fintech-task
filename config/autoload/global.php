<?php
return [
    'api-tools-content-negotiation' => [
        'selectors' => [],
    ],
    'db' => [
        'adapters' => [
            'mainDb' => [
                'charset' => '',
                'database' => '',
                'driver' => 'PDO_Mysql',
                'hostname' => '',
                'port' => '',
                'username' => '',
                'password' => '',
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
