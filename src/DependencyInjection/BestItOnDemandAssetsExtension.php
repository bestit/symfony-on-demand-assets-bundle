<?php

namespace BestIt\OnDemandAssetsBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Loads the config for the bundle.
 *
 * @author lange <lange@bestit-online.de>
 * @package BestIt\OnDemandAssetsBundle
 * @subpackage DependencyInjection
 * @version $id$
 */
class BestItOnDemandAssetsExtension extends Extension
{
    /**
     * Loads the bundle config.
     *
     * @param array $configs
     * @param ContainerBuilder $container
     *
     * @return void
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // setup configuration
        $configuration = $this->processConfiguration(new Configuration(), $configs);

        // load services
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
        $container->setParameter('best_it.on_demand_assets_bundle.css_path', $configuration['css']['path']);
        $container->setParameter('best_it.on_demand_assets_bundle.js_path', $configuration['js']['path']);
    }
}
