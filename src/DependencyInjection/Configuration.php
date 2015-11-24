<?php

namespace Ruudk\Payment\AdyenBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ruudk_payment_adyen');

        $methods = array('ideal', 'mister_cash', 'direct_ebanking', 'giropay', 'credit_card');

        $rootNode
            ->children()
                ->arrayNode('accounts')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('merchant_account')
                                ->isRequired()
                            ->end()
                            ->scalarNode('skin_code')
                                ->isRequired()
                            ->end()
                            ->scalarNode('secret_key')
                                ->isRequired()
                            ->end()
                            ->scalarNode('shopper_locale')
                                ->defaultValue(null)
                            ->end()
                            ->fixXmlConfig('method')
                            ->arrayNode('methods')
                                ->defaultValue($methods)
                                ->prototype('scalar')
                                    ->validate()
                                        ->ifNotInArray($methods)
                                        ->thenInvalid('%s is not a valid method.')
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->booleanNode('test')
                    ->defaultTrue()
                    ->isRequired()
                ->end()
                ->booleanNode('logger')
                    ->defaultTrue()
                ->end()
                ->integerNode('timeout')
                    ->defaultValue(5)
                ->end()
        ->end()


        ;

        return $treeBuilder;
    }
}
