<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-Jan-16
 * Time: 20:29
 */

class ProfileController extends AdminController {
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update','index','delete'),
                'expression'=>['ProfileController','allowAccess'],
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public static  function allowAccess(){

        if (!Yii::app()->user->isGuest&&(Yii::app()->user->model instanceof AdminUser)){
            return true;
        }
        return false;
    }
    public function init(){
        $this->menu = false;
    }

    public function actionIndex()
    {
        $model = AdminUser::model()->findByPk(Yii::app()->user->id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['AdminUser'])&&isset($_POST['id'])&&$_POST['id'] == Yii::app()->user->id) {
            $model->attributes = $_POST['AdminUser'];
            if ($model->save())
                $this->redirect(array('index'));
        }


        $this->render('index',['model'=>$model]);
    }

} 