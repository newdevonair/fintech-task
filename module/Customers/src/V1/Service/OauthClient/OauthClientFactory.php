<?php

namespace Customers\V1\Service\OauthClient;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class OauthClientFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return OauthClientService
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): OauthClientService
    {
        return new OauthClientService(
            $container->get('mainDb'),
        );
    }
}
