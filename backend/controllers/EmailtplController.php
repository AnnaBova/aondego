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

class EmailtplController extends AdminController {
    
    
    public function actions()
    {
        return [
            'tinyMceCompressor' => [
                'class' => TinyMceCompressorAction::className(),

            ],
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

    public function actionIndex()
    {
        
        $model = new \common\models\Option;
        if (isset($_POST['Option'])) {
            $model->attributes = $_POST['Option'];

           $model->save();

                $this->redirect(array('index'));
        }

        $models = \common\models\Option::find()->select('option_name, option_value')->all();;
        if($models)
            $model->values =  \yii\Helpers\ArrayHelper::map($models,'option_name','option_value');

        $this->render('email-tpl',['model'=>$model]);
    }
    
    public function actionAdmin(){
        $language = 'en';
        if(isset($_GET['language'])){
            $language = $_GET['language'];
        }
        
        $model = new \common\models\Option;
        if (isset($_POST['Option'])) {
            $model->attributes = $_POST['Option'];
            $model->language_code = $language;

           $model->save();

                $this->redirect(array('admin'));
        }

        $models = \common\models\Option::find()->select('option_name, option_value')->all();;
        if($models)
            $model->values =  \yii\Helpers\ArrayHelper::map($models,'option_name','option_value');

        return $this->render('email-tpl-admin',['model'=>$model]);
        
    }
    
    public function actionMerchant(){
        
        $language = 'en';
        if(isset($_GET['language'])){
            $language = $_GET['language'];
        }
        $model = new \common\models\Option;
        if (isset($_POST['Option'])) {
            
            $model->attributes = $_POST['Option'];
            $model->language_code = $language;
            

            $model->save();

                $this->redirect(array('merchant', 'language'=>$language));
        }

        $models = \common\models\Option::find()->select('option_name, option_value, language_code')
                ->where(['language_code' => $language])->all();;
        if($models)
            $model->values =  \yii\Helpers\ArrayHelper::map($models,'option_name','option_value');

        return $this->render('email-tpl-merchant',['model'=>$model]);
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
        
        

        return $this->render('email-tpl-customer',['model'=>$model]);
    }
    
    

} 