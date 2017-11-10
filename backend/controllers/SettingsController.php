<?php
namespace backend\controllers;

use backend\components\AdminController;

/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-Jan-16
 * Time: 20:29
 */

class SettingsController extends AdminController {

    public function init(){
        $this->menu = false;
    }

    public function actionIndex()
    {
        $model = new \common\models\Option;
        if (isset($_POST['Option'])) {
            $model->attributes = $_POST['Option'];
            $model->language_code = 'en';

           $model->save();

                $this->redirect(array('index'));
        }

        $models = \common\models\Option::find()->select('option_name, option_value')->all();
        if($models)
            $model->values =  \yii\Helpers\ArrayHelper::map($models,'option_name','option_value');

        return $this->render('settings',['model'=>$model]);
    }

} 