<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/data/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/data/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => 'fintech-db',
            'name' => 'fintech',
            'user' => 'fintech',
            'pass' => 'fintech',
            'port' => '3306',
            'charset' => 'utf8',
        ],
    ],
    'version_order' => 'creation'
];
