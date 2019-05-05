<?php 

namespace WeiXin;

interface WeiXinInterface
{
	/**
	 * 生成 sign
	 */
	public function createSign ($param = []);

	/**
	 * 验证 sign
	 */
	public function checkSign ($param = []);

	/**
	 * 地址转中文
	 */
	public function urlToZh ($url = NULL);

	/**
	 * 数组转 xml
	 */
	public function arrayToXml ($param = []);

	/**
	 * XML 转数组
	 */
	public function xmlToArray ($xml = NULL);

	/**
	 * 发送请求
	 */
	public function postXml ($url = NULL, $xml = NULL);
}