<?php
namespace Customers\V1\Rpc\Login;

use Customers\V1\Rest\Customer\CustomerMapper;
use Customers\V1\Service\OauthClient\OauthClientService;
use Laminas\ServiceManager\ServiceManager;

class LoginControllerFactory
{
    /**
     * @param ServiceManager $serviceManager
     * @return LoginController
     */
    public function __invoke(ServiceManager $serviceManager): LoginController
    {
        $mapper = new CustomerMapper(
            $serviceManager->get('mainDb'),
            $serviceManager->get(OauthClientService::class),
        );
        return new LoginController(
            $mapper,
            $serviceManager->get('Application')->getMvcEvent()->getParam('Laminas\ApiTools\ContentValidation\ParameterData')
        );
    }
}
