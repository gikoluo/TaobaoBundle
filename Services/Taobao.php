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



class Taobao
{
    private $appKey;
    private $appSecret;
    private $apiUrl;
    private $pid;
    private $libpath;
    /**
     * 
     * @var Giko\TaobaoBundle\Services\Taobao
     */
    private $client;

//     <argument key="app_key">%giko_taobao.app_key%</argument>
//     <argument key="app_secret">%giko_taobao.app_secret%</argument>
//     <argument key="api_url">%giko_taobao.api_url%</argument>
//     <argument key="pid">%giko_taobao.pid%</argument>
    
    public function __construct($app_key, $app_secret, $api_url, $pid, $libpath)
    {
    	$this->libpath = $libpath;
    	
    	include $this->libpath . "/TopClient.php";
    	include $this->libpath . "/RequestCheckUtil.php";
    	
        $c = new \TopClient();
        $c->appkey = $app_key;
        $c->secretKey = $app_secret;
        $c->apiUrl = $api_url;
        $c->pid = $pid;
        $c->format = 'json';
        $this->client = $c;
    }
    
    public function getClient() {
    	return $this->client;
    }
    

    public function exec($request, $arguments = [])
    {
        include $this->libpath . "/request/{$request}.php";
        
        $req = new $request;
        foreach ($arguments as $k => $v) {
        	$func = Container::camelize('set' . $k);
        	$req->$func($v);
        }
        return $this->client->execute($req);
    }
}