<?php
namespace GouuseCore\Rpcs\UserCenter;

use GouuseCore\Rpcs\BaseRpc;

/**
 * API SDK基类
 * @author zhangyubo
 *
 */
class Rpc extends BaseRpc
{
	//服务URI前缀
	protected $host_pre = '/transaction_center/';
	
	public function __construct()
	{
	}
}
