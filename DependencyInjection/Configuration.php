<?php

namespace Ms2474\AuthNetBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('authorize_net');
        $rootNode
            ->children()
                ->scalarNode('login_id')->defaultNull()->end()
                ->scalarNode('transaction_key')->defaultNull()->end()
                ->booleanNode('sandbox')->defaultValue(true)->end()
                ->scalarNode('log_file')->defaultValue(false)->end()
            ->end();

        return $treeBuilder;
    }
}
