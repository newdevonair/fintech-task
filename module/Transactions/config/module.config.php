<?php
return [
    'service_manager' => [
        'factories' => [
            \Transactions\V1\Rest\CustomerTransaction\CustomerTransactionResource::class => \Transactions\V1\Rest\CustomerTransaction\CustomerTransactionResourceFactory::class,
        ],
    ],
    'validators' => [
        'factories' => [
            \Transactions\V1\Validator\SourceValidator\SourceValidator::class => \Transactions\V1\Validator\SourceValidator\SourceValidatorFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'transactions.rest.customer-transaction' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/customer-transaction[/:transaction_id]',
                    'defaults' => [
                        'controller' => 'Transactions\\V1\\Rest\\CustomerTransaction\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'transactions.rest.customer-transaction',
        ],
    ],
    'api-tools-rest' => [
        'Transactions\\V1\\Rest\\CustomerTransaction\\Controller' => [
            'listener' => \Transactions\V1\Rest\CustomerTransaction\CustomerTransactionResource::class,
            'route_name' => 'transactions.rest.customer-transaction',
            'route_identifier_name' => 'transaction_id',
            'collection_name' => 'customer_transaction',
            'entity_http_methods' => [
                0 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => 'page_size',
            'entity_class' => \Transactions\V1\Rest\CustomerTransaction\CustomerTransactionEntity::class,
            'collection_class' => \Transactions\V1\Rest\CustomerTransaction\CustomerTransactionCollection::class,
            'service_name' => 'CustomerTransaction',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'Transactions\\V1\\Rest\\CustomerTransaction\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Transactions\\V1\\Rest\\CustomerTransaction\\Controller' => [
                0 => 'application/vnd.transactions.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Transactions\\V1\\Rest\\CustomerTransaction\\Controller' => [
                0 => 'application/vnd.transactions.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \Transactions\V1\Rest\CustomerTransaction\CustomerTransactionEntity::class => [
                'entity_identifier_name' => 'transaction_id',
                'route_name' => 'transactions.rest.customer-transaction',
                'route_identifier_name' => 'transaction_id',
                'hydrator' => \Laminas\Hydrator\ClassMethodsHydrator::class,
            ],
            \Transactions\V1\Rest\CustomerTransaction\CustomerTransactionCollection::class => [
                'entity_identifier_name' => 'transaction_id',
                'route_name' => 'transactions.rest.customer-transaction',
                'route_identifier_name' => 'transaction_id',
                'is_collection' => true,
            ],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authorization' => [
            'Transactions\\V1\\Rest\\CustomerTransaction\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
    'api-tools-content-validation' => [
        'Transactions\\V1\\Rest\\CustomerTransaction\\Controller' => [
            'POST' => 'Transactions\\V1\\Rest\\CustomerTransaction\\Validator',
            'GET' => 'Transactions\\V1\\Rest\\CustomerTransaction\\Validator\Get',
        ],
    ],
    'input_filter_specs' => [
        'Transactions\\V1\\Rest\\CustomerTransaction\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\InArray::class,
                        'options' => [
                            'haystack' => [
                                0 => 'deposit',
                                1 => 'withdrawal',
                            ],
                            'message' => 'Oops@ Invalid type provided. Allowed options are (deposit|withdrawal)',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringToLower::class,
                        'options' => [],
                    ],
                ],
                'name' => 'type',
                'description' => 'Transaction type',
                'field_type' => 'string',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Transactions\V1\Validator\SourceValidator\SourceValidator::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'source',
                'description' => 'Customer transaction source',
                'field_type' => 'string',
            ],
            2 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Laminas\Validator\Between::class,
                        'options' => [
                            'max' => '9999999999999.99',
                            'min' => '0',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'amount',
                'description' => 'Transaction amount',
                'field_type' => 'string',
            ],
        ],
        'Transactions\\V1\\Rest\\CustomerTransaction\\Validator\Get' => [
            0 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\InArray::class,
                        'options' => [
                            'haystack' => [
                                0 => 'EUR',
                                1 => 'CHF',
                                2 => 'USD',
                            ],
                            'message' => 'Oops@ Invalid type provided. Allowed options are (EUR|CHF|USD)',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringToUpper::class,
                        'options' => [],
                    ],
                ],
                'name' => 'currency',
                'description' => 'Transaction currency',
                'field_type' => 'string',
            ],
        ],
    ],
];
