<?php

namespace backend\controllers;

use Yii;
use common\models\Merchant;
use common\models\MerchantSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MerchantController implements the CRUD actions for Merchant model.
 */
class MerchantController extends \backend\components\AdminController
{
    

    /**
     * Lists all Merchant models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MerchantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Merchant model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Merchant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Merchant();

        if ($model->load(Yii::$app->request->post() )){ 
            $model->ip_address = $_SERVER['REMOTE_ADDR'];
            $model->membership_expired = date('Y-m-d', strtotime("+1 years", strtotime(date('Y-m-d'))));
            $model->save();
            return $this->redirect(['view', 'id' => $model->merchant_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Merchant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'edit';
        
        if ($model->load(Yii::$app->request->post()) ) {
            $model->is_ready_old = $model->is_ready;
            
            if(!empty($_POST['Merchant']['new_password'])){
                $model->password = $_POST['Merchant']['new_password'];
                $model->setPassword($_POST['Merchant']['new_password']);
                $model->generateAuthKey();
            }
            
            if(!empty($_POST['Merchant']['manager_new_password'])){
                $model->manager_password = $_POST['Merchant']['manager_new_password'];
                $model->setManagerPassword($_POST['Merchant']['manager_new_password']);
            }
            
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Merchant model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Merchant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Merchant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Merchant::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
