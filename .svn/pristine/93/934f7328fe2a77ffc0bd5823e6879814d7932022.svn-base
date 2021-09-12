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
        // 获取当前域名
        $name = $_SERVER['HTTP_HOST'];
        require_once "../vendor/wxJsSdk/jssdk.php";
        $config = config('xcxconf');
        $jssdk = new \JSSDK($config['appid'], $config['secret']);
        $signPackage = $jssdk->GetSignPackage();

        // 获取到当前uid
        $uid = input('get.id');
        $headimg = Db::name('users')
            ->where(array('id'=>$uid))
            ->find();
        //分享到朋友圈的标题
        $shareTimelineTitle = "中秋集灯活动";   
        //分享给好友的标题
        $shareAppTitle = "中秋集灯活动";
        //分享给好友的简述              
        $shareAppDesc = "参与送福集灯活动，定制索能达中秋福灯祝福卡通过微信分享，祝福卡每被一位朋友打开，送出祝福的您将随机获得一盏“福灯”，用于参加抽奖活动。";
        //分享的图片地址
        $baseimgurl = 'http://zqhd.jctmj.cn/static/api/images/formatItem1.png';
        //分享的访问地址
        $baseurl = 'http://zqhd.jctmj.cn/api/Share/index?id='.$uid;

        $this->assign('shareTimelineTitle',$shareTimelineTitle);
        $this->assign('shareAppTitle',$shareAppTitle);
        $this->assign('shareAppDesc',$shareAppDesc);
        // $this->assign('baseimgurl',$baseimgurl);
        // $this->assign('baseurl',$baseurl);
        $this->assign('uid',$uid);
        $this->assign('name',$name);
        $this->assign('signPackage',$signPackage);
        $this->assign('headimg',$headimg['headimg']);
        return $this->fetch('share/share');
    }


}