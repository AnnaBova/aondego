<?php
//error_reporting(E_ALL);
//date_default_timezone_set('Europe/Kiev');
$webRoot=dirname(__FILE__);
$yiic=$webRoot .'/vendor/yiisoft/yii/framework/yiic.php';
/*function d($var,$d=true) {CVarDumper::dump($var,30,true); if($d)die;}*/
$config=dirname(__FILE__).'/config/console.php';
// remove the following lines when in production mode
/*defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);*/
//d($config);
require_once($yiic);
