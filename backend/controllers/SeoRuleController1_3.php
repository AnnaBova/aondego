<?php

namespace backend\controllers;

use Yii;
use common\models\SeoRule;
use common\models\SeoRuleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SeoRuleController implements the CRUD actions for SeoRule model.
 */
class SeoRuleController extends \backend\components\AdminController
{
    
    public function actionGetdata(){
        
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $id = $_POST['id'];
            $model = $this->findModel($id);
            
            echo json_encode(['success' => true, 'msg' => $model->attributes]);
            Yii::$app->end();
            
        }else{
            echo json_encode(['success' => false]);
        }
        
        
        
    }
    
    /**
     * Lists all SeoRule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SeoRuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SeoRule model.
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
     * Creates a new SeoRule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SeoRule();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $translate = \backend\components\Translatte::save($model,['meta_title', 'meta_description', 'meta_keyword']);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SeoRule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $translate = \backend\components\Translatte::save($model,['meta_title', 'meta_description', 'meta_keyword']);

        
        if(isset($_GET['language']) && trim($_GET['language']) != 'en'){
            $language = $_GET['language'];
            Yii::$app->language = $language;
            \backend\components\Translatte::loadModel($model,['meta_title', 'meta_description', 'meta_keyword'], $language);
            
            if ($model->load(Yii::$app->request->post())) {
                
                $translate = \backend\components\Translatte::saveMessage($model,['meta_title', 'meta_description', 'meta_keyword'], $language);
                
                Yii::$app->session->setFlash('success', 'Updated Successfully.');
                return $this->redirect(['update', 'id' => $model->id,'language'=>$language]);
                
            }
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SeoRule model.
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
     * Finds the SeoRule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SeoRule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SeoRule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
