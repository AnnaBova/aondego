<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-Jan-16
 * Time: 20:29
 */

class EmailtplController extends AdminController {

    public function init(){
        $this->menu = false;
    }

    public function actionIndex()
    {
        $model = new Option;
        if (isset($_POST['Option'])) {
            $model->attributes = $_POST['Option'];

           $model->save();

                $this->redirect(array('index'));
        }

        $models = Option::model()->findAll(['select'=>'option_name, option_value']);
        if($models)
            $model->values =  CHtml::listData($models,'option_name','option_value');

        $this->render('email-tpl',['model'=>$model]);
    }
    
    public function actionAdmin(){
        
        $model = new Option;
        if (isset($_POST['Option'])) {
            $model->attributes = $_POST['Option'];

           $model->save();

                $this->redirect(array('index'));
        }

        $models = Option::model()->findAll(['select'=>'option_name, option_value']);
        if($models)
            $model->values =  CHtml::listData($models,'option_name','option_value');

        $this->render('email-tpl-admin',['model'=>$model]);
        
    }
    
    public function actionMerchant(){
        $model = new Option;
        if (isset($_POST['Option'])) {
            $model->attributes = $_POST['Option'];

           $model->save();

                $this->redirect(array('index'));
        }

        $models = Option::model()->findAll(['select'=>'option_name, option_value']);
        if($models)
            $model->values =  CHtml::listData($models,'option_name','option_value');

        $this->render('email-tpl-merchant',['model'=>$model]);
    }
    
    
    public function actionCustomer(){
        $model = new Option;
        if (isset($_POST['Option'])) {
            $model->attributes = $_POST['Option'];

           $model->save();

                $this->redirect(array('index'));
        }

        $models = Option::model()->findAll(['select'=>'option_name, option_value']);
        if($models)
            $model->values =  CHtml::listData($models,'option_name','option_value');

        $this->render('email-tpl-customer',['model'=>$model]);
    }
    
    

} 