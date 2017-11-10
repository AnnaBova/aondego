<?php

namespace backend\controllers;

use Yii;
use common\models\ServiceSubcategory;
use common\models\ServiceSubcategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ServiceSubcategoryController implements the CRUD actions for ServiceSubcategory model.
 */
class ServiceSubcategoryController extends \backend\components\AdminController
{
    
    /**
     * Lists all ServiceSubcategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServiceSubcategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->pagination->pageSize = 10;
    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ServiceSubcategory model.
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
     * Creates a new ServiceSubcategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ServiceSubcategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $translate = \backend\components\Translatte::save($model,['title', 'description']);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ServiceSubcategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $translate = \backend\components\Translatte::save($model,['title', 'description']);
        

        if(isset($_GET['language']) && trim($_GET['language']) != 'en'){
            $language = $_GET['language'];
            Yii::$app->language = $language;
            \backend\components\Translatte::loadModel($model,['title', 'description'], $language);
            
             if ($model->load(Yii::$app->request->post())) {
                
                $translate = \backend\components\Translatte::saveMessage($model,['title', 'description'], $language);
                
                Yii::$app->session->setFlash('success', 'Updated Successfully.');
                
                if(Yii::$app->request->isAjax){
                    echo json_encode(['success' => true]);
                    Yii::$app->end();
                
                }else{
                    return $this->redirect(['update', 'id' => $model->id,'language'=>$language]);
                }
                
            }
        }
//        print_r($_POST);
        
        if (isset($_POST['ServiceSubcategory'])) {
            $model->attributes = $_POST['ServiceSubcategory'];
            if ($model->save()){
                if(Yii::$app->request->isAjax){
                    echo json_encode(['success' => true]);
                    Yii::$app->end();
                
                }else{
                    $this->redirect(array('index'));
                }
            }
        }
        
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', array(
            'model' => $model,
            ));
            
        }else{

            return $this->render('update', array(
                'model' => $model,
            ));
        }
    }

    /**
     * Deletes an existing ServiceSubcategory model.
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
     * Finds the ServiceSubcategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ServiceSubcategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ServiceSubcategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
