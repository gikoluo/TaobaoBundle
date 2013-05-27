<?php

namespace Giko\TaobaoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class GikoTaobaoExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
    	$processor = new Processor();
    	$configuration = new Configuration();
    	$config = $processor->processConfiguration($configuration, $configs);
    	
    	$this->loadDefaults($container);
    	
    	if (isset($config['alias'])) {
    		$container->setAlias($config['alias'], 'giko_taobao.service');
    	}
    	
    	foreach (array('libpath', 'app_key', 'app_secret', 'api_url', 'pid') as $attribute) {
    		if (isset($config[$attribute])) {
    			$container->setParameter('giko_taobao.'.$attribute, $config[$attribute]);
    		}
    	}
    	$path = $config['libpath'];
    	set_include_path(get_include_path() . PATH_SEPARATOR . $path);
    }
    
    /**
     * @codeCoverageIgnore
     */
    protected function loadDefaults($container)
    {
    	$loader = new XmlFileLoader($container, new FileLocator(array(__DIR__.'/../Resources/config', __DIR__.'/Resources/config')));
    
    	foreach ($this->resources as $resource) {
    		$loader->load($resource);
    	}
    }
}
