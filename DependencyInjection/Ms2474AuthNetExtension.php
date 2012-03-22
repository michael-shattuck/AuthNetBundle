<?php

namespace Ms2474\AuthNetBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class Ms2474AuthNetExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $processor     = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $container->setParameter('authorize_net.login_id', $config['login_id']);
        $container->setParameter('authorize_net.transaction_key', $config['transaction_key']);
        $container->setParameter('authorize_net.sandbox', $config['sandbox']);

        if (isset($config['log_file'])) {
            $container->setParameter('authorize_net.log_file', $config['log_file']);
        }
    }
}
