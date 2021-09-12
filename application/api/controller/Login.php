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
// | 全局验证码处理类
// +----------------------------------------------------------------------
namespace app\api\controller;

use app\common\controller\Api;
use think\Db;
use think\Request;

/**
 * @title 用户公众号授权
 * @controller api\controller\Login
 * @group Api
 */
class Login extends Api
{
    public function login()
    {
        dump('login');exit;
    }

    // 当前用户是否关注公众号
    public function isfollow()
    {
    	// 获取当前登录账户
    	$uid = session('userid');
    	$user = Db::name('users')->where(array('id'=>$uid))->find();
    	$res = wxGetUserFollowState($user['openid']);
        dump($res);exit;
        if($res->subscribe == 1){
        	if($user['type'] == 1){
        		// 没有的话，修改关注状态、添加积分。
                $data['type'] = 2;
                $ress = Db::name('users')->where('id',$uid)->update($data);
                if($ress){
                    //  添加，添加积分记录
                    $datas['userid'] = $user['id'];
                    $datas['score'] = 15;
                    $datas['type'] = 2;
                    $datas['create_time'] = time();
                    $ag_id = db('integral')->insertGetId($datas);
                    if($ag_id){
                        $user = db('user')->where('id',$user['id'])->find();
                    }
                }else{
                    return ajaxReturn(0,'关注公众号失败，请重新关注！');
                }
        	}
        }
    }

}
