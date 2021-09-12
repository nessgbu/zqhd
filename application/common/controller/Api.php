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

use app\common\controller\Base;
use think\Db;
use think\Request;

class Api extends Base
{
	public $userinfo;
	/**
     * 构造方法
     * @access public
     * @param Request $request Request 对象
     */
    public function __construct(Request $request)
    {
    	parent::__construct(); //继承父类的构造函数
        $this->request = $request;
        // 控制器初始化
        $this->initialize();
    }

    /**
     * 初始化操作
     * @access protected
     */
    protected function initialize()
    {
        //移除HTML标签
        $this->request->filter('trim,strip_tags,htmlspecialchars');

        // 检测是否登录状态
        $this->islogin();
    }

    // 判断是否用户是否登录
    protected function islogin() {
    	// 当前登录用户
		$uid = session("userid");
        // $uid = 1;
		if($uid){
			$this->userinfo = Db::name('users')->where(array('id'=>$uid))->find();
			session("userid",$uid);
		}else{
			$userinfo = wxGetUserInfo();
			if($userinfo->openid == null){
				$this->redirect('index/index',array(), 5, '未获得微信信息正在重新获取...');
			}else{
				$sql = Db::name("users");
				$userdata = $sql->where(array("openid"=>$userinfo->openid))->find();
				if($userdata){
					session("userid",$userdata['id']);
					$users['id'] = $userdata['id'];
					$users['last_time'] = time();
					$users['update_time'] = time();
					$sql->where(array("openid"=>$userinfo->openid))->update($users);
				}else{
					$useradd['openid'] = $userinfo->openid;
					$useradd['nickname'] = $userinfo->nickname;
					$useradd['sex'] = $userinfo->sex;
					$useradd['country'] = $userinfo->country;
					$useradd['province'] = $userinfo->province;
					$useradd['city'] = $userinfo->city;
					$useradd['headimg'] = $userinfo->headimgurl;
					$useradd['last_time'] = time();
					$useradd['update_time'] = time();
					$useradd['create_time'] = time();
					$uid = $sql->insertGetId($useradd);
					if($uid){
						session("userid",$uid);
					}
				}
				$this->userinfo = $userdata;
				// 分享活动用户
    			// $pid = input('get.uid');
                $userid = session('userid');
                if ($pid != $userid) {
                    // $pid = 1;
                    // 获取灯笼
                    $this->getlamp($pid);
                }
			}
		}
	}

	// 分享之后获得福灯
    public function getlamp($pid)
    {
    	$uid = session('userid');
        $hengtong = Db::name('hengtong')->where(array('uid'=>$uid,'sharedid'=>$pid))->find();
        $ankang = Db::name('ankang')->where(array('uid'=>$uid,'sharedid'=>$pid))->find();
        $wishful = Db::name('wishful')->where(array('uid'=>$uid,'sharedid'=>$pid))->find();
        $agreeable = Db::name('agreeable')->where(array('uid'=>$uid,'sharedid'=>$pid))->find();
        $flourishing = Db::name('flourishing')->where(array('uid'=>$uid,'sharedid'=>$pid))->find();
        // 若是之前没有通过改用户获取到福灯，则随机获取福灯
        if (!$hengtong && !$ankang && !$wishful && !$agreeable && !$flourishing) {
            // 亨通灯7%        安康灯20%        如意灯3%        顺心灯30%        兴旺灯40%
            $table = '';
            $arr = array('hengtong'=>7,'ankang'=>20,'wishful'=>3,'agreeable'=>30,'flourishing'=>40);
            $arrsum = array_sum($arr);
            foreach ($arr as $key => $value) {
                $r = mt_rand(1,$arrsum);
                if ($r <= $value) {
                    $table = $key;
                }else{
                    $arrsum = max(0,$arrsum - $value);
                }
            }
            // 将获取到的福灯存入数据库
            $tables['uid'] = $uid;
            $tables['time'] = time();
            $tables['sharedid'] = $pid;
            $tables['create_time'] = time();
            $tables['update_time'] = time();
            Db::name($table)->insertGetId($tables);
            // 提醒pid
            $pusers = Db::name('users')->where(array('id'=>$pid))->find();
	        $data['open_id'] = $pusers['openid'];
	        $data['type'] = "0csgfxlT-oBhxXXl02RuynrfUob6-nZg97A4vkH1lhM";
	        $data['truckid'] = "http://zqhd.jctmj.cn/api/index/index.html";
	        $data['msg'] = array(
	        	'name' => array('value' => $pusers['nickname'],'color' => '#000000'),
	        	'remark' => array('value' => $table,'color' => '#000000'),
	        );
            sendTemplateMessage($data);
        }
    }
}
