<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\CertyBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\Reference;

class BuilderCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('certy.certification.builder')) {
            throw new ServiceNotFoundException('certy.certification.builder');
        }

        $definition = $container->getDefinition('certy.certification.builder');

        $taggedServices = $container->findTaggedServiceIds('certy.builder_pass');

        foreach ($taggedServices as $id => $tagAttributes) {
            $definition->addMethodCall('addBuilderPass', array(
                new Reference($id)
            ));
        }
    }
}