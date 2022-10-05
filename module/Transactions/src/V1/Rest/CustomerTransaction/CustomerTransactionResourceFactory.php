<?php
namespace Transactions\V1\Rest\CustomerTransaction;

use Laminas\ServiceManager\ServiceManager;

class CustomerTransactionResourceFactory
{
    /**
     * @param ServiceManager $serviceManager
     * @return CustomerTransactionResource
     */
    public function __invoke(ServiceManager $serviceManager): CustomerTransactionResource
    {
        $mapper = new CustomerTransactionMapper(
            $serviceManager->get('mainDb')
        );
        return new CustomerTransactionResource(
            $mapper,
            $serviceManager->get('Application')->getMvcEvent()->getParam('Laminas\ApiTools\ContentValidation\ParameterData')
        );
    }
}
