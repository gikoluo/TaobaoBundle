<?php
/**
 * TOP API: alipay.user.account.get request
 * 
 * @author auto create
 * @since 1.0, 2013-05-26 16:46:20
 */
class AlipayUserAccountGetRequest
{
	
	private $apiParas = array();
	
	public function getApiMethodName()
	{
		return "alipay.user.account.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
