<?php
return [
    'service_manager' => [
        'factories' => [
            \Customers\V1\Rest\Customer\CustomerResource::class => \Customers\V1\Rest\Customer\CustomerResourceFactory::class,
            \Customers\V1\Service\OauthClient\OauthClientService::class => \Customers\V1\Service\OauthClient\OauthClientFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'customers.rest.customer' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/customer[/:customer_id]',
                    'defaults' => [
                        'controller' => 'Customers\\V1\\Rest\\Customer\\Controller',
                    ],
                ],
            ],
            'customers.rpc.login' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => 'Customers\\V1\\Rpc\\Login\\Controller',
                        'action' => 'login',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'customers.rest.customer',
            1 => 'customers.rpc.login',
        ],
    ],
    'api-tools-rest' => [
        'Customers\\V1\\Rest\\Customer\\Controller' => [
            'listener' => \Customers\V1\Rest\Customer\CustomerResource::class,
            'route_name' => 'customers.rest.customer',
            'route_identifier_name' => 'customer_id',
            'collection_name' => 'customer',
            'entity_http_methods' => [
                0 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => 'page_size',
            'entity_class' => \Customers\V1\Rest\Customer\CustomerEntity::class,
            'collection_class' => \Customers\V1\Rest\Customer\CustomerCollection::class,
            'service_name' => 'Customer',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'Customers\\V1\\Rest\\Customer\\Controller' => 'HalJson',
            'Customers\\V1\\Rpc\\Login\\Controller' => 'Json',
        ],
        'accept_whitelist' => [
            'Customers\\V1\\Rest\\Customer\\Controller' => [
                0 => 'application/vnd.customers.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'Customers\\V1\\Rpc\\Login\\Controller' => [
                0 => 'application/vnd.customers.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
        ],
        'content_type_whitelist' => [
            'Customers\\V1\\Rest\\Customer\\Controller' => [
                0 => 'application/vnd.customers.v1+json',
                1 => 'application/json',
            ],
            'Customers\\V1\\Rpc\\Login\\Controller' => [
                0 => 'application/vnd.customers.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \Customers\V1\Rest\Customer\CustomerEntity::class => [
                'entity_identifier_name' => 'customer_id',
                'route_name' => 'customers.rest.customer',
                'route_identifier_name' => 'customer_id',
                'hydrator' => \Laminas\Hydrator\ClassMethodsHydrator::class,
            ],
            \Customers\V1\Rest\Customer\CustomerCollection::class => [
                'entity_identifier_name' => 'customer_id',
                'route_name' => 'customers.rest.customer',
                'route_identifier_name' => 'customer_id',
                'is_collection' => true,
            ],
        ],
    ],
    'api-tools-content-validation' => [
        'Customers\\V1\\Rest\\Customer\\Controller' => [
            'input_filter' => 'Customers\\V1\\Rest\\Customer\\Validator',
        ],
        'Customers\\V1\\Rpc\\Login\\Controller' => [
            'input_filter' => 'Customers\\V1\\Rpc\\Login\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Customers\\V1\\Rest\\Customer\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'max' => '255',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Laminas\Filter\HtmlEntities::class,
                        'options' => [],
                    ],
                ],
                'name' => 'name',
                'description' => 'Customer name',
                'field_type' => 'string',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'max' => '255',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                        'options' => [],
                    ],
                    1 => [
                        'name' => \Laminas\Filter\HtmlEntities::class,
                        'options' => [],
                    ],
                ],
                'name' => 'surname',
                'description' => 'Customer surname',
                'field_type' => 'string',
            ],
            2 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\Date::class,
                        'options' => [
                            'format' => 'Y-m-d',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'date_of_birth',
                'description' => 'Customer date of birth',
                'field_type' => 'date',
            ],
            3 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'max' => '30',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'username',
                'description' => 'Customer login username',
                'field_type' => 'string',
            ],
            4 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'max' => '30',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'password',
                'description' => 'Customer login password',
                'field_type' => 'string',
            ],
        ],
        'Customers\\V1\\Rpc\\Login\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'max' => '50',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'username',
                'description' => 'Customer usernmae',
                'field_type' => 'string',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'max' => '50',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'password',
                'description' => 'Customer password',
                'field_type' => 'string',
            ],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authorization' => [
            'Customers\\V1\\Rest\\Customer\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'Customers\\V1\\Rpc\\Login\\Controller' => \Customers\V1\Rpc\Login\LoginControllerFactory::class,
        ],
    ],
    'api-tools-rpc' => [
        'Customers\\V1\\Rpc\\Login\\Controller' => [
            'service_name' => 'Login',
            'http_methods' => [
                0 => 'POST',
            ],
            'route_name' => 'customers.rpc.login',
        ],
    ],
];
