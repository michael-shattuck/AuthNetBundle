<?php

namespace Clamidity\AuthNetBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class ClamidityAuthNetExtension extends Extension
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
        $container->setParameter('authorize_net.secure', $config['secure']);
        $container->setParameter('authorize_net.customer_profile_class', $config['customer_profile_class']);
        $container->setParameter('authorize_net.payment_profile_class', $config['payment_profile_class']);
        $container->setParameter('authorize_net.shipping_address_class', $config['shipping_address_class']);
        $container->setParameter('authorize_net.transaction_class', $config['transaction_class']);

        if (isset($config['log_file'])) {
            $container->setParameter('authorize_net.log_file', $config['log_file']);
        }
    }
}
