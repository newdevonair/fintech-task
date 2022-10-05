<?php

namespace Transactions\V1\Validator\SourceValidator;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class SourceValidatorFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return SourceValidator
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): SourceValidator
    {
        $options ??= [];
        $options['validator_plugin_manager'] = $container->get('ValidatorManager');
        return new SourceValidator($options);
    }
}
