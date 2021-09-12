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
 * @title 收集福灯获得兑换码
 * @controller api\controller\collection
 * @group Api
 */
class Collection extends Api
{
    public function index()
    {
        // 集灯首页
        return $this->fetch();
    }

    /**
     * @title 记录用户联系方式
     * @desc 用户联系方式存入
     * @author wyc
     * @url /api/Collection/setmobile
     * @method POST
     * @tag 联系方式
     * @param name:mobile type:string require:1 desc:用户联系方式
     * @return name:code type:number desc:状态码
     * @return name:msg type:string desc:文字解释
     */
    public function setmobile()
    {
        // 获取当前用户id
        $uid = session('userid');
        // 获取联系方式
        $mobile['mobile'] = input('post.mobile');
        if (!preg_match("/^1[34578]\d{9}$/", $mobile['mobile'])) {
            return json(['code' => 0, 'msg' => '手机号格式错误！']);
        }
        $mobile['update_time'] = time();
        $res = Db::name('users')->where(array('id'=>$uid))->update($mobile);
        if ($res) {
            // 获取成功
            return json(['code' => 1, 'msg' => '获取成功！']);
        }else{
            // 获取失败
            return json(['code' => 0, 'msg' => '获取失败！']);
        }
    }

    // 当前用户是否关注公众号
    public function isfollow($uid)
    {
        // 获取当前登录账户
        $user = Db::name('users')->where(array('id'=>$uid))->find();
        $res = wxGetUserFollowState($user['openid']);
        if($res->subscribe == 1){
            // 已关注公众号
            return true;
        }else{
            // 未关注公众号
            return false;
        }
    }

    /**
     * @title 合成抽奖码
     * @desc 五个福灯可集成一个兑换码
     * @author wyc
     * @url /api/Collection/synthesis
     * @method POST
     * @tag 合成 抽奖码
     * @return name:code type:number desc:状态码
     * @return name:msg type:string desc:文字解释
     * @return name:card type:string desc:合成的抽奖码
     * @return name:status type:string desc:是否录入联系方式(1=>已录入,2=>未录入)
     */
    public function synthesis()
    {
        $config = config('xcxconf');
        if (time() < strtotime($config['updatime'])) {
            return json(['code' => 0, 'msg' => '该功能暂未开启！']);
        }
        if (time() > strtotime($config['endtime'])) {
            return json(['code' => 0, 'msg' => '该活动已结束！']);
        }
    	// 获取当前用户
    	$uid = session('userid');
        // 判断是否关注公众号
        $follow = $this->isfollow($uid);
        if (!$follow) {
            // 未关注公众号
            return json(['code' => 400, 'msg' => '请先关注公众号！']);
        }
    	// 获取所有福灯数量
    	// 获取当前用户的灯的个数
        $hengtong = Db::name('hengtong')
            ->where(array('uid'=>$uid,'status'=>1))
            ->order('id asc')
            ->find();
        $ankang = Db::name('ankang')
            ->where(array('uid'=>$uid,'status'=>1))
            ->order('id asc')
            ->find();
        $wishful =  Db::name('wishful')
            ->where(array('uid'=>$uid,'status'=>1))
            ->order('id asc')
            ->find();
        $agreeable = Db::name('agreeable')
            ->where(array('uid'=>$uid,'status'=>1))
            ->order('id asc')
            ->find();
        $flourishing = Db::name('flourishing')
            ->where(array('uid'=>$uid,'status'=>1))
            ->order('id asc')
            ->find();
        // 若是每个灯笼个数足够，则可合成
        if ($hengtong && $ankang && $wishful && $agreeable && $flourishing) {
            $table['status'] = 2;
            $table['update_time'] = time();
            $hengtongdel = Db::name('hengtong')->where(array('id'=>$hengtong['id']))->update($table);
            $ankangdel = Db::name('ankang')->where(array('id'=>$ankang['id']))->update($table);
            $wishfuldel = Db::name('wishful')->where(array('id'=>$wishful['id']))->update($table);
            $agreeabledel = Db::name('agreeable')->where(array('id'=>$agreeable['id']))->update($table);
            $flourishingdel = Db::name('flourishing')->where(array('id'=>$flourishing['id']))->update($table);
            if ($hengtongdel && $ankangdel && $wishfuldel && $agreeabledel && $flourishingdel) {
                // 合成成功之后，产生随机兑换码
                $code['code'] = $this->randconvert();
                while (Db::name('exchange')->where(array('code'=>$code['code']))->find()) {
                    $code['code'] = $this->randconvert();
                }
                $code['uid'] = $uid;
                $code['time'] = time();
                $code['create_time'] = time();
                $code['update_time'] = time();
                $res = Db::name('exchange')->insertGetId($code);
                if ($res) {
                    $users = Db::name('users')->where(array('id'=>$uid))->find();
                    if ($users['mobile']) {
                        $status = 1;
                    }else{
                        $status = 0;
                    }
                    // 合成成功
                    return json(['code' => 1, 'msg' => '合成成功！', 'card' => $code['code'], 'status' => $status]);
                }else{
                    // 合成失败
                    return json(['code' => 0, 'msg' => '合成失败！']);
                }
            }else{
                // 合成失败
                return json(['code' => 0, 'msg' => '合成失败！']);
            }
        }else{
            // 若是灯笼数量不足，则不能合成
            return json(['code' => 0, 'msg' => '福灯数量不足，请先集福灯吧！']);
        }
        return $this->fetch();
    }

    /**
     * @title 获取我的抽奖码列表
     * @desc 获取我所合成的所有的抽奖码
     * @author wyc
     * @url /api/Collection/setexchange
     * @method POST
     * @tag 合成 抽奖码
     * @return name:list type:array desc:抽奖码列表
     */
    public function setexchange()
    {
        // 获取到当前uid
        $uid = session('userid');
        // 获取我的所有的抽奖码
        $data = Db::name('exchange')
            ->where(array('uid'=>$uid))
            ->select();
        if ($data) {
            foreach ($data as $key => $value) {
                $list[] = $value['code'];
            }
        }
        $this->assign('list',$list);
        return $this->fetch('code');
    }

    /**
     * @title 相同的三个福灯换取一个其他的福灯
     * @desc 获取我所合成的所有的抽奖码
     * @author wyc
     * @url /api/Collection/swaplamp
     * @method POST
     * @tag 合成 抽奖码
     * @param name:swap type:string require:1 desc:三个灯笼(亨通灯=>hengtong,安康灯=>ankang,如意灯=>wishful,顺心灯=>agreeable,兴旺灯=>flourishing)
     * @param name:lamp type:string require:1 desc:合成的一个灯笼(亨通灯=>hengtong,安康灯=>ankang,如意灯=>wishful,顺心灯=>agreeable,兴旺灯=>flourishing)
     * @return name:code type:number desc:状态码
     * @return name:msg type:string desc:文字解释
     */
    public function swaplamp()
    {
        $config = config('xcxconf');
        if (time() < strtotime($config['updatime'])) {
            return json(['code' => 0, 'msg' => '该功能暂未开启！']);
        }
        if (time() > strtotime($config['endtime'])) {
            return json(['code' => 0, 'msg' => '该活动已结束！']);
        }
        // 获取当前的用户
        $uid = session('userid');
        // 获取三个灯笼
        $swaplamp = input('post.swap');
        // 获取被兑换灯笼
        $lamp = input('post.lamp');
        $count = Db::name($swaplamp)
            ->where(array('uid'=>$uid))
            ->count();
        if ($count < 3) {
            // 灯笼数量不足，无法换取
            return json(['code' => 0, 'msg' => '福灯数量不足，请先集福灯吧！']);
        }
        // 取消原来的信息
        $table['status'] = 2;
        $table['update_time'] = time();
        $swapdal = Db::name($swaplamp)
            ->where(array('uid'=>$uid,'status'=>1))
            ->order('id asc')
            ->limit(3)
            ->update($table);
        
        $lamps['uid'] = $uid;
        $lamps['time'] = time();
        $lamps['sharedid'] = $uid;
        $lamps['create_time'] = time();
        $lamps['update_time'] = time();
        $res = Db::name($lamp)->insertGetId($lamps);
        if ($res && $swaplamp) {
            // 兑换成功
            return json(['code' => 1, 'msg' => '兑换成功！']);
        }else{
            // 兑换失败
            return json(['code' => 0, 'msg' => '兑换失败！']);
        }
    }


    

}