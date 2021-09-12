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
// | 友情链接管理
// +----------------------------------------------------------------------
namespace app\test\controller;

use app\common\controller\Adminbase;
use app\test\model\Test as TestModel;
use think\Db;

/**
 * 模板样例-名单管理
 */
class Test extends Adminbase
{
    protected $modelClass = null;
    protected function initialize()
    {
        parent::initialize();
        $this->modelClass = new TestModel;
    }
    //名单列表
    public function index()
    {
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($page, $limit, $where) = $this->buildTableParames();
            $order = $this->request->param("order/s", "DESC");
            $sort = $this->request->param("sort", !empty($this->modelClass) && $this->modelClass->getPk() ? $this->modelClass->getPk() : 'id');
            $count = $this->modelClass->where($where)->order($sort, $order)->count();

            $data = $this->modelClass
                ->where($where)
                ->order($sort, $order)
                ->page($page, $limit)
                ->withAttr('image', function ($value, $data){
                    return get_file_path($value);
                })
                ->select();
            $result = ["code" => 0, 'count' => $count, 'data' => $data];
            return json($result);
        }
        return $this->fetch();
    }
    /**
     * 新增名单
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            //验证器
            $rule = [
                'name|名称' => 'require'
            ];
            $result = $this->validate($data, $rule);
            if (true !== $result) {
                $this->error($result);
            }
            if (!empty($data['terms']['name'])) {
                $data['termsid'] = $this->addTerms($data['terms']['name']);
            }
            $status = $this->modelClass->allowField(true)->save($data);
            if ($status) {
                $this->success("添加成功！", url("test/index"));
            } else {
                $this->error("添加失败！");
            }
        } else {
            $Terms = Db::name('Terms')->where(["module" => "test"])->select();
            $this->assign("Terms", $Terms);
            return $this->fetch();
        }
    }

    /**
     * 编辑名单
     */
    public function edit()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            //验证器
            $rule = [
                'name|网站名称' => 'require',
                'url|网站链接'  => 'require|url',
            ];
            $result = $this->validate($data, $rule);
            if (true !== $result) {
                $this->error($result);
            }
            if (!empty($data['terms']['name'])) {
                $data['termsid'] = $this->addTerms($data['terms']['name']);
            }
            $status = $this->modelClass->allowField(true)->save($data, ['id' => $data['id']]);
            if ($status) {
                $this->success("编辑成功！", url("links/index"));
            } else {
                $this->error("编辑失败！");
            }

        } else {
            $id   = $this->request->param('id', 0);
            $data = $this->modelClass->where(array("id" => $id))->find();
            if (!$data) {
                $this->error("该信息不存在！");
            }
            $Terms = Db::name('Terms')->where(["module" => "links"])->select();
            $this->assign("Terms", $Terms);
            $this->assign("data", $data);
            return $this->fetch();
        }

    }
}
