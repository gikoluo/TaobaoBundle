<?php

/*
 * This file is part of the GikoSinaweiboBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Giko\TaobaoBundle\Services;

use Symfony\Component\Routing\RouterInterface;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\DependencyInjection\Container;

require "TopClient.php";

class Taobao
{
    private $appKey;
    private $appSecret;
    private $apiUrl;
    private $pid;
    /**
     * 
     * @var Giko\TaobaoBundle\Services\Taobao
     */
    private $client;

//     <argument key="app_key">%giko_taobao.app_key%</argument>
//     <argument key="app_secret">%giko_taobao.app_secret%</argument>
//     <argument key="api_url">%giko_taobao.api_url%</argument>
//     <argument key="pid">%giko_taobao.pid%</argument>
    
    public function __construct($app_key, $app_secret, $api_url, $pid)
    {
        $c = new TopClient();
        $c->appKey = $app_key;
        $c->appSecret = $app_secret;
        $c->apiUrl = $app_url;
        $c->pid = $pid;
        $this->client = $c;
    }
    
    public function getClient() {
    	return $this->client;
    }
    

    public function exec($request, $arguments = [])
    {
        include "request/{$request}.php";
        
        $req = new $request;
        foreach ($arguments as $k => $v) {
        	$func = Container::camelize($k);
        	$req->$func($v);
        }
        return $this->client->execute($req, $sessionKey);
    }
}