<?php

error_reporting(E_ALL);
/*define('YII_ENABLE_ERROR_HANDLER', true);
define('YII_ENABLE_EXCEPTION_HANDLER', true);
ini_set("display_errors",true);*/
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',150);




// include Yii bootstrap file
require_once(dirname(__FILE__).' /../../protected/vendor/yiisoft/yii/framework/yii.php');
$config=dirname(__FILE__).'/../config/main.php';
// remove the following lines when in production mode


function d($var,$d=true) {CVarDumper::dump($var,30,true); if($d)die();}
// create a Web application instance and run
Yii::createWebApplication($config)->run();