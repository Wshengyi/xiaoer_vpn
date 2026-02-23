<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// 1) 静态文件直接返回
if ($uri !== '/' && is_file(__DIR__ . $uri)) {
    return false;
}

// 2) 兼容 /adminEntry.php/xxx 这种“入口文件 + PATH_INFO”写法
if (preg_match('#^/([^/]+\.php)(/.*)?$#', $uri, $m) && is_file(__DIR__ . '/' . $m[1])) {
    $_SERVER['SCRIPT_NAME'] = '/' . $m[1];
    $_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/' . $m[1];
    $_SERVER['PATH_INFO'] = $m[2] ?? '';
    require __DIR__ . '/' . $m[1];
    return true;
}

// 3) 默认走前台入口
$_SERVER["SCRIPT_FILENAME"] = __DIR__ . '/index.php';
require __DIR__ . "/index.php";
