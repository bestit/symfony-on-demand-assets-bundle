<?php

namespace BestIt\OnDemandAssetsBundle\DependencyInjection;

use RuntimeException;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * Configuration for BestItOnDemandAssetsBundle.
 *
 * @package BestIt\OnDemandAssetsBundle
 * @subpackage DependencyInjection
 * @author Tim Kellner <tim.kellner@bestit-online.de>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     * @throws RuntimeException
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();

        $builder
            ->root('best_it_on_demand_assets')
            ->children()
            ->arrayNode('css')
            ->children()
            ->scalarNode('path')
            ->info('path to compiled css file')
            ->isRequired()
            ->end()
            ->end()
            ->end()
            ->arrayNode('js')
            ->children()
            ->scalarNode('path')
            ->info('path to compiled js file')
            ->isRequired()
            ->end()
            ->end()
            ->end();

        return $builder;
    }
}
