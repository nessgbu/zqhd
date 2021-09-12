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

/**
 * @title 首页
 * @controller api\controller\Index
 * @group Api
 */
class Index extends Api
{
    public function index()
    {
        return $this->fetch();
    }

    /**
     * @title 获取福灯数
     * @desc 获取用户单个福灯的数量
     * @author wyc
     * @url /api/Index/getlampnum
     * @method POST
     * @tag 首页 福灯数
     * @return name:list type:array desc:福灯数量
     * @return name:hengtong type:number desc:亨通灯数量
     * @return name:ankang type:number desc:安康灯数量
     * @return name:wishful type:number desc:如意灯数量
     * @return name:agreeable type:number desc:顺心灯数量
     * @return name:flourishing type:number desc:兴旺灯数量
     */
    public function getlampnum()
    {
    	// 获取当前用户
    	$uid = session('userid');
    	// 获取当前用户的灯的个数
    	$list['hengtong'] = Db::name('hengtong')
    		->where(array('uid'=>$uid,'status'=>1))
    		->count();
    	$list['ankang'] = Db::name('ankang')
    		->where(array('uid'=>$uid,'status'=>1))
    		->count();
        $list['wishful'] =  Db::name('wishful')
            ->where(array('uid'=>$uid,'status'=>1))
            ->count();
        $list['agreeable'] = Db::name('agreeable')
            ->where(array('uid'=>$uid,'status'=>1))
            ->count();
        $list['flourishing'] = Db::name('flourishing')
            ->where(array('uid'=>$uid,'status'=>1))
            ->count();
        $data = json_encode($list);
        $this->assign('data',$data);
        $this->assign('list',$list);
        return $this->fetch('collection/lamp');
    }

    /**
     * @title 获取等级以及奖品
     * @desc 获取等级，若是活动没有开始或是当前用户未曾合成兑换码，则等级为0，若是有兑换码，且参加活动的用户小于720人，则为第一等级；若是参与活动的用户在720和888人中间，则为第二等级；若是参与活动的用户在888人以上，则为第三等级
     * @author wyc
     * @url /api/Index/getgrade
     * @method POST
     * @tag 首页 福灯数
     * @return name:grade type:number desc:当前等级
     */
    public function getgrade()
    {
        // 判断当前用户是否合成兑换码
        $uid = session('userid');
        $sum = Db::name('exchange')->where(array('uid'=>$uid))->count();
        if ($sum) {
            // 获取所有拥有兑换码用户
            $count = Db::name('exchange')->group('uid')->count();
            // 根据用户判断其等级
            if ($count >= 888) {
                $grade = 3;
            }elseif ($count >= 720 && $count < 888) {
                $grade = 2;
            }elseif ($count >= 1 && $count < 720) {
                $grade = 1;
            }
        }else{
            $grade = 0;
        }
        $this->assign('grade',$grade);
        return $this->fetch('index/grade');
    }
    public function format(){
        return $this->fetch();
    }
    public function formattext(){
        $uid = session('userid');
        $this->assign('uid',$uid);
        return $this->fetch();
    }



}
