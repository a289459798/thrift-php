<?php
/**
 * 文件说明
 * @Author: zhangzy
 * @time: 六  8/23 11:45:03 2014
 *
 **/
error_reporting(E_ALL ^ E_NOTICE);
define('PHPTHRIFT', dirname(__FILE__));
$thriftPath = '/Users/zhangzy/workspace/lib/thrift-0.9.1/lib/php/lib';
require $thriftPath . '/Thrift/Classloader/ThriftClassLoader.php';

use Thrift\ClassLoader\ThriftClassLoader;
//加载自动注册类
$classLoader = new ThriftClassLoader(false);
//注册命名空间
$classLoader->registerNamespace('Thrift', $thriftPath);
$classLoader->registerNamespace('ThriftRpc', dirname(PHPTHRIFT));
//自动加载
$classLoader->register();
$controller = '\\ThriftRpc\\ThriftController\\' . ucfirst(strtolower($_GET['c'])) . 'Controller';
$action = $_GET['a'];
$class = new $controller();
$class->$action();

