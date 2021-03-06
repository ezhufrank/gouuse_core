<?php
namespace GouuseCore\Libraries;

/**
 * 定义公共基础code
 * @author zhangyubo
 *
 */
class CodeLib
{
	const REQUEST_NOT_FOUND = 404;//访问地址不存在
	const REQUEST_METHOD_ERROR = 405;//请使用接口文档定义的请求方式调用
	const HTTP_ERROR = 500;//服务器内部错误
	
	const RPC_SERVER_ERR = 1000;//服务间通信异常
	
	const AUTH_FAILD = 1005104100;//登录失效，请重新登录
	const AUTH_TIMEOUT = 1005104101;//登录已过期，请重新登录
	const AUTH_REQUIRD = 1005104102;//请登录
	const AUTH_DENY = 1005104103;//无权访问
	const AUTH_ON_OTHER_CLIENT = 1005104104;//账号已在其他设备登录
	const AUTH_PARAM_ERROR = 1005104105;//参数不正确
	
	const NOT_INSTALLED_APP_ID = "1008000003";//没有安装该应用
	const APP_INFO_NOT_EXIST = 1008000018;//应用信息不存在

    const AUTH_COMPANY_DELETE = 1005304017;//已删除
    const AUTH_COMPANY_STOP = 1005304018;//已停用
    const AUTH_COMPANY_REVIEW = 1005304019;//审核中
    const AUTH_COMPANY_OVERDUE = 1005304020;//已过期
}