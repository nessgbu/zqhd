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
use Think\Controller;

/**
 * @title 首页
 * @controller api\controller\Share
 * @group Api
 */
class Share extends Api
{
    public function indexpage()
    {
        $id = input('get.uid');
        // 获取用户信息
        $users = Db::name('users')
            ->where(array('id'=>$id))
            ->find();
        $this->assign('headimg',$headimg['headimg']);
        return $this->fetch('share/indexpage');
    }
    /**
     * @title 根据url中id 获取用户头像
     * @desc 分享页面获取用户头像
     * @author wyc
     * @url /api/Share/getUserHeadimg
     * @method POST
     * @tag 分享
     * @return name:headimg type:string desc:当前用户头像
     */
    public function share()
    {
    	// 获取当前用户
    	$uid = session('userid');
    	// 获取当前用户的头像
    	$headimg = Db::name('users')
    		->where(array('id'=>$uid))
    		->find();
        $this->assign('headimg',$headimg['headimg']);
        return $this->fetch('share/index');
    }

    /**
     * @title 用户分享活动参数
     * @desc 分享活动操作
     * @author wyc
     * @url /api/Share/index
     * @method POST
     * @tag 分享
     * @return name:shareTimelineTitle type:string desc:当前用户头像
     * @return name:shareAppTitle type:string desc:当前用户头像
     * @return name:shareAppDesc type:string desc:当前用户头像
     * @return name:baseimgurl type:string desc:当前用户头像
     * @return name:baseurl type:string desc:当前用户头像
     * @return name:signPackage type:array desc:内容
     */
    public function index()
    {
        // 分享活动用户
        $pid = input('param.id');
        $userid = session('userid');
        if ($pid && $userid) {
            if ($pid != $userid) {
                // 获取灯笼
                $this->getlamp($userid,$pid);
            }
        }
        // 获取当前域名
        $name = $_SERVER['HTTP_HOST'];
        require_once "../vendor/wxJsSdk/jssdk.php";
        $config = config('xcxconf');
        $jssdk = new \JSSDK($config['appid'], $config['secret']);
        $signPackage = $jssdk->GetSignPackage();

        // 获取到当前uid
        $data = input('param.');
        $headimg = Db::name('users')
            ->where(array('id'=>$data['id']))
            ->find();
        if ($pid == $userid) {
            $btn = 0;
        }else{
            $btn = 1;
        }
        //分享到朋友圈的标题
        $shareTimelineTitle = "中秋送福集灯";   
        //分享给好友的标题
        $shareAppTitle = "中秋送福集灯";
        //分享给好友的简述              
        $shareAppDesc = "您收到一份来自 索能达中国建筑与配电事业部 发来的中秋祝福！";
        //分享的图片地址
        $baseimgurl = 'http://'.$name.'/static/api/images/formatItem'.$data['bg'].'.png';
        //分享的访问地址
        $baseurl = url('api/Share/index','id='.$data['id'].'&bg='.$data['bg'].'&t='.$data['t'],'html',true);

        $this->assign('shareTimelineTitle',$shareTimelineTitle);
        $this->assign('shareAppTitle',$shareAppTitle);
        $this->assign('shareAppDesc',$shareAppDesc);
        $this->assign('baseimgurl',$baseimgurl);
        $this->assign('baseurl',$baseurl);
        $this->assign('btn',$btn);
        $this->assign('bg',(int)$data['bg']);
        $this->assign('t',(int)$data['t']);
        $this->assign('name',$name);
        $this->assign('signPackage',$signPackage);
        $this->assign('headimg',$headimg['headimg']);
        return $this->fetch('share/share');
    }


}