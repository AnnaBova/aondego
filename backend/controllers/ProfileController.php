<?php
namespace backend\controllers;

use backend\components\AdminController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;


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
    public function behaviors() {
        parent::behaviors();
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                    'actions' => ['create','update','index','delete'],
                    'allow' => true,
                    'matchCallback' => function() {
                        return self::allowAccess();
                    }
                    ],
                ]
            ]
        ];
    }

    public static  function allowAccess(){
        if (!Yii::$app->user->isGuest ){
            return true;
        }
        return false;
    }
    public function init(){
        $this->menu = false;
    }

    public function actionIndex()
    {
        $model = \backend\models\AdminUser::findOne(['admin_id' => Yii::$app->user->id]);
        $model->scenario = 'update';
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['AdminUser'])&&isset($_POST['id'])&&$_POST['id'] == Yii::$app->user->id) {
            $model->attributes = $_POST['AdminUser'];
            
            if(!empty($_POST['AdminUser']['new_password'])){
                $model->password = $_POST['AdminUser']['new_password'];
                $model->setPassword($model->password);
                $model->generateAuthKey();
            }
            if ($model->save())
                $this->redirect(array('index'));
        }


        return $this->render('index',['model'=>$model]);
    }

} 