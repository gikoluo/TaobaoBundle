<?php

namespace Giko\TaobaoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
	
	/**
	 * Generates the configuration tree.
	 *
	 * @return TreeBuilder
	 */
	public function getConfigTreeBuilder()
	{
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('giko_taobao');
	
		$rootNode
		->validate()
		->always(function($v) {
			if (!empty($v['callback_url']) && !empty($v['callback_route'])) {
				throw new \Exception('You cannot configure a "callback_url", and a "callback_route" at the same time.');
			}
	
			return $v;
		})
		->end()
		->children()
		->scalarNode('libpath')->defaultValue("%kernel.root_dir%/../vendor/giko/taobao-bundle/Giko/TaobaoBundle/lib/")->end()
		->scalarNode('app_key')->isRequired()->cannotBeEmpty()->end()
		->scalarNode('app_secret')->isRequired()->cannotBeEmpty()->end()
		->scalarNode('pid')->defaultValue("mm_30471349_3307211_11185021")->end()
		->scalarNode('api_url')->defaultValue("gw.api.taobao.com")->end()
		->scalarNode('alias')->defaultNull()->end()
		->end()
		;
	
		return $treeBuilder;
	}
}
