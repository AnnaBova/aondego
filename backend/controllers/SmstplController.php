<?php
namespace backend\controllers;

use backend\components\AdminController;
use zxbodya\yii2\elfinder\ConnectorAction;
use zxbodya\yii2\tinymce\TinyMceCompressorAction;
use Yii;


/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-Jan-16
 * Time: 20:29
 */

class SmstplController extends AdminController {
    
    
    public function actions()
    {
        return [
            
            'connector' => array(         
                    'class' => ConnectorAction::className(),         
                    'settings' => array(         
                        'root' => Yii::getAlias('@webroot') . '/uploads/',                    
                        'URL' => Yii::getAlias('@web') . '/uploads/',         
                        'rootAlias' => 'Home',         
                        'mimeDetect' => 'none'         
                    )                    
                ),      
        ];
    }

    public function init(){
        $this->menu = false;
    }

      
    public function actionCustomer(){
        $language = 'en';
        
        if(isset($_GET['language'])){
            $language = $_GET['language'];
        }
        
        $model = new \common\models\Option;
        if (isset($_POST['Option'])) {
            $model->attributes = $_POST['Option'];
            $model->language_code = $language;
            $model->save();

                $this->redirect(array('customer', 'language'=>$language));
        }

        $models = \common\models\Option::find()->select('option_name, option_value, language_code')
                ->where(['language_code' => $language])->all();
        if($models)
            $model->values =  \yii\Helpers\ArrayHelper::map($models,'option_name','option_value');
        
        

        return $this->render('index',['model'=>$model]);
    }
    
    

} 