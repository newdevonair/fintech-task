<?php
namespace Customers\V1\Rest\Customer;

use Customers\V1\Service\OauthClient\OauthClientService;
use Laminas\ServiceManager\ServiceManager;

class CustomerResourceFactory
{
    public function __invoke(ServiceManager $serviceManager): CustomerResource
    {
        $mapper = new CustomerMapper(
            $serviceManager->get('mainDb'),
            $serviceManager->get(OauthClientService::class),
        );
        return new CustomerResource(
            $mapper,
            $serviceManager->get('Application')->getMvcEvent()->getParam('Laminas\ApiTools\ContentValidation\ParameterData')
        );
    }
}
