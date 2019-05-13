<?php 

namespace WeiXin;

use WeiXin\BaseWeiXinService;

class enterprisePaymentService extends BaseWeiXinService
{
	/**
	 * 企业付款至零用钱接口地址
	 */
	protected $enterprisePayToPocketMoney = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';

	/**
	 * 查询企业付款至零用钱接口地址
	 */
	protected $queryEnterprisePayToPocketMoney = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/gettransferinfo';

	/**
	 * 企业付款至银行卡接口地址
	 */
	protected $enterprisePayToBank = 'https://api.mch.weixin.qq.com/mmpaysptrans/pay_bank';

	/**
	 * 查询企业付款至银行卡接口地址
	 */
	protected $queryEnterprisePayToBank = 'https://api.mch.weixin.qq.com/mmpaysptrans/query_bank';

	public function __construct ($appId = NULL, $mchId = NULL, $appKey = NULL, $certPath = NULL, $keyPath = NULL)
	{
		parent::__construct($appId, $mchId, $appKey, $certPath, $keyPath);	
	}

	/**
	 * 企业付款至零用钱
	 */
	public function enterprisePayToPocketMoney ($param = [])
	{
		if (empty($param))
		{
			return FALSE;
		}
		$param['mch_appid'] = $this->appId;
    $param['mchid'] = $this->mchId;
    $param['sign'] = $this->createSign($param);
    $xml = $this->arrayToXml($param);

    return $this->postXml($this->enterprisePayToPocketMoney, $xml);
	}

	/**
	 * 查询企业付款至零钱
	 */
	public function queryEnterprisePayToPocketMoney ($param = [])
	{
		if (empty($param))
		{
			return FALSE;
		}
		$param['mch_id'] = $this->mchId;
		$param['appid'] = $this->appId;
		$param['sign'] = $this->createSign($param);
		$xml = $this->arrayToXml($xml);

		return $this->postXml($this->queryEnterprisePayToPocketMoney, $xml);
	}

	/**
	 * 企业付款至银行卡
	 */
	public function enterprisePayToBank ($param = [])
	{

	}

	/**
	 * 查询企业付款至银行卡
	 */
	public function queryEnterprisePayToBank ($param = [])
	{

	}

}