<?php
namespace backend\controllers;

use backend\components\AdminController;
use Yii;
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-Jan-16
 * Time: 20:29
 */

class DashboardController extends AdminController {
    //public $defaultControllerAction = 'index';
    public function init(){
        $this->menu = false;
    }

    public function actionIndex()
    {
        //echo 'I am here'; exit;
        return $this->render('index');
    }
    
    
    public function actionLanguage(){
        
        $language = $_POST['code'];
        if(isset($language)){            
            
            Yii::$app->language = $language;

            $languageCookie = new \yii\web\Cookie([
                'name' => 'language',
                'value' => $language,
                'expire' => time() + 60 * 60 * 24 * 30, // 30 days
            ]);
            Yii::$app->response->cookies->add($languageCookie);
            echo true;
            Yii::$app->end();
            
        }
        
    }

} 