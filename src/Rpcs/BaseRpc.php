<?php
namespace GouuseCore\Rpcs;

use Ixudra\Curl\Facades\Curl;

use Log;
use Illuminate\Support\Facades\Auth;

/**
 * API SDK基类
 * @author zhangyubo
 *
 */
class BaseRpc
{

    private static $current_member_id;
    private static $user;
    private static $company_info;

    public function preData()
    {
        if (empty(self::$_urrent_member_id)) {
            self::$user = Auth::user();
            self::$current_member_id = self::$user['member_id'];
            self::$company_info = app()['gouuse_company_info'];
        }
    }
     
    public function postOutside($url, $header = [], $data = [])
    {
    	Log::info('API URL: '.date('Y-m-d H:i:s') .' '. $url);
           $result = Curl::to($url)
           ->withHeaders($header)
           ->withData($data)
           ->post();
           Log::info('API data: '.print_r($data, true));
           return $this->buildResult($result);
    }
     
    public function post($url, $header = [], $data = [])
    {
    	Log::info('API URL: '.date('Y-m-d H:i:s') .' '. $url);
        $this->preData();
        $header[] = 'GOUUSE-INSIDE: '.time();
        if (self::$current_member_id) {
            $header[] = 'CURRENT-MEMBER-ID:' . self::$current_member_id;
            $header[] = 'CURRENT-MEMBER-NAME:' . self::$user['member_name'];
            $header[] = 'CURRENT-COMPANY-ID:' . self::$user['company_id'];
            $header[] = 'CURRENT-MEMBER-INFO:' . json_encode(self::$user);
            $header[] = 'CURRENT-COMPANY-INFO:' . json_encode(self::$company_info);
        }

        $result = Curl::to($url)
        ->withHeaders($header)
        ->withData($data)
        ->post();
        Log::info('API data: '.print_r($data, true));
        return $this->buildResult($result);
    }

    /**
     * parse数据 json to array
     * @param unknown $result
     * @return number[]|string[]|mixed
     */
    public function buildResult($result)
    {
        Log::info('API Result: '.$result);
        $result = json_decode($result, true);
         
        if (empty($result)) {
            $result = array();
            $result['code'] = 1;
            $result['err_desc'] = '通信失败请稍后重试';
        }
        return $result;
    }
}
