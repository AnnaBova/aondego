<?php

namespace console\controllers;
use yii\console\Controller;
use Yii;

Class BackUpController extends Controller
{
	
	public function actionIndex(){
		\common\components\Backup::backup();
	}
	
}