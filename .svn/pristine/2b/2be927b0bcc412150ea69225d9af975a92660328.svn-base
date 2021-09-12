<?php
return [
    [
        //父菜单ID，NULL或者不写系统默认，0为顶级菜单
        "parentid"  => 0,
        //地址，[模块/]控制器/方法
        "route"     => "test/test/index1",
        //类型，1：权限认证+菜单，0：只作为菜单
        "type"      => 0,
        //状态，1是显示，0不显示（需要参数的，建议不显示，例如编辑,删除等操作）
        "status"    => 1,
        //名称
        "name"      => "模板样例",
        //图标
        "icon"      => "icon-draft-line",
        //备注
        "remark"    => "",
        //排序
        "listorder" => 1,
        //子菜单列表
        "child" => [
            [
                "route"  => "test/test/index2",
                "type"   => 1,
                "status" => 1,
                "name"   => "模板样例",
                "icon"   => "icon-draft-line",
                "child" => [
                    [
                        "route" => "test/test/index",
                        "type" => 0,
                        "status" => 1,
                        "name" => "名单管理",
                        "icon" => "icon-lianjie",
                        "child" => [
                            [
                                "route" => "test/test/add",
                                "type" => 1,
                                "status" => 0,
                                "name" => "添加",
                            ],
                            [
                                "route" => "test/test/edit",
                                "type" => 1,
                                "status" => 0,
                                "name" => "编辑",
                            ],
                            [
                                "route" => "test/test/del",
                                "type" => 1,
                                "status" => 0,
                                "name" => "删除",
                            ],
                            [
                                "route" => "test/test/multi",
                                "type" => 1,
                                "status" => 0,
                                "name" => "操作",
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
