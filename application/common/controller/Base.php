<?php
// +----------------------------------------------------------------------
// | Yzncms [ 御宅男工作室 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 http://yzncms.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 御宅男 <530765310@qq.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 公共控制模块
// +----------------------------------------------------------------------
namespace app\common\controller;

use think\Controller;

class Base extends Controller
{
	/**
     * 构造方法
     * @access public
     * @param Request $request Request 对象
     */
    public function __construct()
    {
    	parent::__construct(); //继承父类的构造函数
    }

    public function _initialize()
    {
    	
    }


    //空操作
    public function _empty()
    {
        $this->error('该页面不存在！');
    }

    // 生成随机兑换码
    public function randconvert()
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $randpwd = ''; 
        for ( $i = 0; $i < 10; $i++ ) 
        { 
            // 这里提供两种字符获取方式 
            // 第一种是使用 substr 截取$chars中的任意一位字符； 
            // 第二种是取字符数组 $chars 的任意元素 
            // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1); 
            $randpwd .= $chars[ mt_rand(0, strlen($chars) - 1) ]; 
        } 
        return $randpwd; 
    }

    
    public function test()
    {
        $config = config('xcxconf');
        $appid = $config['appid'];
        $secret = $config['secret'];
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
        dump($url);
        $jsonRes = curlGet($url);
        dump($jsonRes);
    }

}
