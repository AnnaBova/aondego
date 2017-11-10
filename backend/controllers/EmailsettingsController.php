<?php

namespace backend\controllers;

use backend\components\AdminController;
use common\models\Option;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-Jan-16
 * Time: 20:29
 */

class EmailsettingsController extends AdminController {

    public function init(){
        $this->menu = false;
    }

    public function actionIndex()
    {
        $model = new Option;
        if (isset($_POST['Option'])) {
            $model->attributes = $_POST['Option'];
            $model->language_code = 'en';
            $model->save();
            
             

                $this->redirect(array('index'));
        }

        $models = Option::find()->select('option_name, option_value')->where(['language_code' => 'en'])->all();
        if($models)
            $model->values =  ArrayHelper::map($models,'option_name','option_value');

        return $this->render('email-settings',['model'=>$model]);
    }

} 