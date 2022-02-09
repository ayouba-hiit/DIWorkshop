<?php

namespace App\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class LoggerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        //$definitions = $container->getDefinitions();
        //foreach ($definitions as $id => $definition) {
        //    if($id === 'texter.sms') {
        //        $definition->addMethodCall('setLogger', [new Reference('logger')]);
        //    }
        //}

        $ids = $container->findTaggedServiceIds('with_logger');
        foreach ($ids as $id => $data) {
            $definition = $container->findDefinition($id);
            $definition->addMethodCall('setLogger', [new Reference('logger')]);
        }
    }
}