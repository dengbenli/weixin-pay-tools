<?php 

namespace WeiXin;

use WeiXin\BaseWeiXinInterface;

/**
 * 基础服务
 */
class BaseWeiXinService implements BaseWeiXinInterface
{
	/**
	 * 支付 app_id
	 */
	protected $appId;

	/**
	 * 支付 商户号
	 */
	protected $mchId;

	/**
	 * 支付 key
	 */
	protected $appKey;

	/**
	 * 证书 cert 路径
	 */
	protected $certPath;

	/**
	 * 证书 key 路径
	 */
	protected $keyPath;
		
	public function __construct ($appId = NULL, $mchId = NULL, $appKey = NULL, $certPath = NULL, $keyPath = NULL)
	{
			if (is_null($appId) || empty($appId))
			{
				die('appId undefined');
			}
			if (is_null($mchId) || empty($mchId))
			{
				die('mchId undefined');
			}
			if (is_null($appKey) || empty($appKey))
			{
				die('appKey undefined');
			}
			if (is_null($certPath) || empty($certPath))
			{
				die('certPath undefined');
			}
			if (is_null($keyPath) || empty($keyPath))
			{
				die('keyPath undefined');
			}

			$this->appId = $appId;
			$this->mchId = $mchId;
			$this->appKey = $appKey;
			$this->certPath = $certPath;
			$this->keyPath = $keyPath;
	}

	/**
	 * 生成 sign	
	 */
	public function createSign ($param = [])
	{
		if (empty($param))
		{
			return FALSE;
		}
		if (isset($param['sign']) || !empty($param['sign']))
		{
			unset($param['sign']);
		}
		ksort($param);
		$uri = http_build_query($param) . '&key=' . $this->appKey;
		$uri = $this->urlToZh($uri);

		return strtoupper(md5($uri));
	}

	/**
	 * 验证 sign       
	 */
	public function checkSign ($param = [])
	{
		if (empty($param))
		{
			return FALSE;
		}
		$sign = $this->createSign($param);
		if ($sign !== $param['sign'])
		{
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * 地址转中文
	 */
	public function urlToZh ($url = NULL)
	{
		return is_null($url) || empty($url) ? NULL : urldecode($url);
	}

	/**
	 * array 转 xml
	 */
	public function arrayToXml ($param = [])
	{
		if (empty($param))
		{
			return NULL;
		}
		$xml = "<xml>";
		ksort($param);
		foreach ($$param as $key => $value) 
		{
			if (is_numeric($value))
			{
				$xml .= "<" . $key . ">" . $value . "</" . $key . ">";
			} else {
				$xml .= "<" . $key . "><![CDATA[" . $value . "]]></" . $key . ">";
			}
		}
		$xml .= "</xml>";

		return $xml;
	}

	/**
	 * xml 转 array
	 */
	public function xmlToArray ($xml = NULL)
	{
		if (is_null($xml) || empty($xml))
		{
			return [];
		}
		libxml_disable_entity_loader(TRUE);
    $arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), TRUE);

    return $arr;
	}

	/**
	 * 发送 xml 请求
	 */
	public function postXml ($url = NULL, $xml = NULL) 
	{
		if (is_null($url) || is_null($xml) || empty($url) || empty($xml))
		{
			return FALSE;
		}

		$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($curl, CURLOPT_SSLCERTTYPE, 'PEM');
    curl_setopt($curl, CURLOPT_SSLCERT, $this->certPath);
    curl_setopt($curl, CURLOPT_SSLCERTPASSWD, $this->mchId);
    curl_setopt($curl, CURLOPT_SSLKEYTYPE, 'PEM');
    curl_setopt($curl, CURLOPT_SSLKEY, $this->keyPath);
    curl_setopt($curl, CURLOPT_SSLKEYPASSWD, $this->mchId);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($curl);

    curl_close($curl);

    return $this->xmlToArray($response);
	}

	/**
	 * 生成订单号
	 */
	public function createOrderNumber ()
	{

	}

}