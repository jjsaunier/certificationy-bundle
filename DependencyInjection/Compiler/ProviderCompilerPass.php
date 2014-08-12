<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\CertyBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\Reference;

class ProviderCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('certy.certification.provider_registry')) {
            throw new ServiceNotFoundException('certy.certification.provider_registry');
        }

        $definition = $container->getDefinition('certy.certification.provider_registry');

        $taggedServices = $container->findTaggedServiceIds('certy.provider');

        foreach ($taggedServices as $id => $tagAttributes) {
            $definition->addMethodCall('addProvider', [
                new Reference($id)
            ]);
        }
    }
}
