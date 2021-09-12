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
        mt_srand(10000000*(double)microtime());
        for ($i=0,$str = '',$lc = strlen($chars-1); $i < 10; $i++) { 
            $str .= $chars[mt_rand(0,$lc)];
        }
        return $str;
    }

}
