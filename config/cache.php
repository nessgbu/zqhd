<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 缓存设置
// +----------------------------------------------------------------------

return [
    // 复合缓存类型
    'type'     => 'complex',
    // 默认使用的缓存
    'default'  => [
        'type'   => 'file', // 驱动方式
        'path'   => '', // 缓存保存目录
        'prefix' => '', // 缓存前缀
        'expire' => 0, // 缓存有效期 0表示永久缓存
    ],
    // 文件缓存
    'file'     => [
        'type'   => 'file',
        'expire' => 0,
        'prefix' => '',
    ],
    // redis缓存
    'redis'    => [
        'type'     => 'redis',
        'host'     => '127.0.0.1',
        'port'     => 6379,
        'password' => '',
        'expire'   => 0,
        'prefix'   => '',
    ],
    //memcache缓存，或memcached更高级
    'memcache' => [
        'type'   => 'memcache',
        'host'   => '127.0.0.1',
        'port'   => 11211,
        'expire' => 0,
        'prefix' => '',
    ],
];
