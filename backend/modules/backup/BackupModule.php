<?php
/**
 * Backup
 * 
 * Yii module to backup, restore databse
 * 
 * @version 1.0
 * @author Shiv Charan Panjeta <shiv@toxsl.com> <shivcharan.panjeta@outlook.com>
 */
namespace backend\modules\backup;

class BackupModule extends \yii\base\Module
{
	public $path = null;
	public function init()
	{
                        
//		 \Yii::configure($this, require(__DIR__ . '/config.php'));
        parent::init();
	}

//	public function beforeControllerAction($controller, $action)
//	{
//		if(parent::beforeControllerAction($controller, $action))
//		{
//			// this method is called before any module controller action is performed
//			// you may place customized code here
//			return true;
//		}
//		else
//			return false;
//	}
}
