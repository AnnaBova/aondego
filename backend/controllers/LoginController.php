<?php
namespace backend\controllers;

use CHttpException;
use common\models\LoginForm;
use Yii;
use yii\web\Controller;
use yii\widgets\ActiveForm;

class LoginController extends Controller
{
	public function actionIndex()
	{

		$this->layout='login_tpl';
            
            if (!defined('CRYPT_BLOWFISH')||!CRYPT_BLOWFISH)
                throw new CHttpException(500,"This application requires that PHP was compiled with Blowfish support for crypt().");

            $model = new LoginForm;

            // if it is ajax validation request
            if(isset($_POST['ajax']) && $_POST['ajax'] === 'login-form' && $model->load(Yii::$app->request->post()))
            {

                echo json_encode(ActiveForm::validate($model));
                Yii::$app->end();
            }

            // collect user input data
            if(isset($_POST['LoginForm']))
            {
	            $model->load(['LoginForm' => $_POST['LoginForm']]);
                // validate user input and redirect to the previous page if valid
                if($model->validate() && $model->login())
                    $this->redirect(Yii::$app->user->returnUrl);
            }


		// display the login form
            return $this->render('login',array('model'=>$model));
	}

    public function actionLogout()
    {
        Yii::$app->user->logout();
        $this->redirect(['index']);
    }
}