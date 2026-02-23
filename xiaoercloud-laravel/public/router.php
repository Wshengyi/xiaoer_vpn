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

// 1.1) 防止缺失静态资源被错误路由到前台首页
if (strpos($uri, '/assets/') === 0 && !is_file(__DIR__ . $uri)) {
    http_response_code(404);
    echo 'Asset not found: ' . $uri;
    return true;
}

// 2) 后台短路由：/bbc => /MAchXneSHE.php
if ($uri === '/bbc' || strpos($uri, '/bbc/') === 0) {
    $_SERVER['SCRIPT_NAME'] = '/MAchXneSHE.php';
    $_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/MAchXneSHE.php';
    $_SERVER['PATH_INFO'] = $uri === '/bbc' ? '' : substr($uri, 4);
    require __DIR__ . '/MAchXneSHE.php';
    return true;
}

// 2.1) 兼容后台常见直连路径，避免“模块不存在:dashboard”
if (preg_match('#^/(dashboard|ajax)(/.*)?$#', $uri, $m)) {
    $_SERVER['SCRIPT_NAME'] = '/MAchXneSHE.php';
    $_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/MAchXneSHE.php';
    $_SERVER['PATH_INFO'] = '/' . $m[1] . ($m[2] ?? '');
    require __DIR__ . '/MAchXneSHE.php';
    return true;
}

// 3) 兼容 /adminEntry.php/xxx 这种“入口文件 + PATH_INFO”写法
if (preg_match('#^/([^/]+\.php)(/.*)?$#', $uri, $m) && is_file(__DIR__ . '/' . $m[1])) {
    $_SERVER['SCRIPT_NAME'] = '/' . $m[1];
    $_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/' . $m[1];
    $_SERVER['PATH_INFO'] = $m[2] ?? '';
    require __DIR__ . '/' . $m[1];
    return true;
}

// 4) 默认走前台入口
$_SERVER["SCRIPT_FILENAME"] = __DIR__ . '/index.php';
require __DIR__ . "/index.php";
