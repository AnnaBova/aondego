<?php
namespace backend\controllers;

use backend\components\AdminController;
use common\models\ServiceCategory;
use Yii;

class ServiceCategoryController extends AdminController
{
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new ServiceCategory;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['ServiceCategory'])) {
            $model->attributes = $_POST['ServiceCategory'];
            if ($model->save()){
                
                $translate = \backend\components\Translatte::save($model,['title', 'description']);
                $this->redirect(array('update', 'id'=> $model->id));
            }
        }

        return $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        
        $translate = \backend\components\Translatte::save($model,['title', 'description']);
        

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);
        
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

        if (isset($_POST['ServiceCategory'])) {
            $model->attributes = $_POST['ServiceCategory'];
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
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::$app->request->isPost) {
// we only allow deletion via POST request
            $this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }


    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        
        $searchModel = new \common\models\ServiceCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->pagination->pageSize = 10;
        
        //$pageSize = isset(Yii::$app->request->queryParams['pageSize']) ? Yii::$app->request->queryParams['pageSize'] : 10;
        
        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            //'pageSize' => $pageSize
        ]);
        
        
        
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = ServiceCategory::findOne($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'service-category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
