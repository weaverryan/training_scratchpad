<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OverrideLoggerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $loggerDefinition = $container->findDefinition('logger');

        $loggerDefinition->addMethodCall(
            'debug',
            ['The logger has been initialized']
        );
    }
}
