<?php

namespace Ruudk\Payment\AdyenBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class RuudkPaymentAdyenExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $accountsDefinition = $container->getDefinition('ruudk_payment_adyen.accounts_factory');
        $accountsDefinition->setArguments(array($config['accounts']));

        $apiDefinition = $container->getDefinition('ruudk_payment_adyen.api');
        $apiDefinition->setArguments(array(
            $accountsDefinition,
            $config['test'],
            $config['timeout'],
        ));

        $methods = [];
        foreach ($config['accounts'] as $accountConfig) {
            $methods = array_merge($methods, $accountConfig['methods']);
        };
        $methods = array_unique($methods);

        foreach($methods AS $method) {
            $this->addFormType($container, $method);
        }

        /**
         * When iDeal is not enabled, remove the cache warmer.
         */
        if(!in_array('ideal', $methods)) {
            $container->removeDefinition('ruudk_payment_adyen.cache_warmer');
        }

        /**
         * When logging is disabled, remove logger and setLogger calls
         */
        if(false === $config['logger']) {
            $container->getDefinition('ruudk_payment_adyen.controller.notification')->removeMethodCall('setLogger');
            $container->getDefinition('ruudk_payment_adyen.plugin.default')->removeMethodCall('setLogger');
            $container->getDefinition('ruudk_payment_adyen.plugin.ideal')->removeMethodCall('setLogger');
            $container->removeDefinition('monolog.logger.ruudk_payment_adyen');
        }
    }

    protected function addFormType(ContainerBuilder $container, $method)
    {
        $adyenMethod = 'adyen_' . $method;

        $definition = new Definition();
        $definition->setClass('%ruudk_payment_adyen.form.adyen_type.class%');
        $definition->addArgument($adyenMethod);

        if($method === 'ideal') {
            $definition->setClass('%ruudk_payment_adyen.form.ideal_type.class%');
            $definition->addArgument('%kernel.cache_dir%');
        }

        $definition->addTag('payment.method_form_type');
        $definition->addTag('form.type', array(
            'alias' => $adyenMethod
        ));

        $container->setDefinition(
            sprintf('ruudk_payment_adyen.form.%s_type', $method),
            $definition
        );
    }
}
