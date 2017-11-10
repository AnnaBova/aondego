<?php

namespace backend\controllers;

use Yii;
use common\models\CustomPage;
use common\models\CustomPageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomPageController implements the CRUD actions for CustomPage model.
 */
class CustomPageController extends \backend\components\AdminController
{
    

    /**
     * Lists all CustomPage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $language = \common\models\Language::findOne(['is_default' => 1]);
        $searchModel = new CustomPageSearch();
        $searchModel->language_id = $language->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CustomPage model.
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
     * Creates a new CustomPage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CustomPage();
        
        $language = \common\models\Language::findOne(['is_default' => 1]);
        
        $model->language_id = $language->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            //$translate = \backend\components\Translatte::save($model,['page_name', 'content', 'seo_title', 'meta_description', 'meta_keywords']);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CustomPage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $languageCode = \common\models\Language::findOne(['is_default' => 1]);
        $model = $this->findModel($id);
        
        //$translate = \backend\components\Translatte::save($model,['page_name', 'content', 'seo_title', 'meta_description', 'meta_keywords']);
        
        
        //print_r($translate);
        //exit;
        
        if(isset($_GET['language']) && trim($_GET['language']) != $languageCode->code){
            $language = $_GET['language'];
            Yii::$app->language = $language;
            //\backend\components\Translatte::loadModel($model,['page_name', 'content', 'seo_title', 'meta_description', 'meta_keywords'], $language);
            
            
            $languageSelected = \common\models\Language::findOne(['code' => $language]);
            
            $newModel = CustomPage::findOne(['language_id' =>$languageSelected->id, 'slug_name' => $model->slug_name ]);
            
            if(count($newModel) == 0){
                $newModel = new CustomPage;
                $newModel->attributes = $model->attributes;
                $newModel->slug_name = $model->slug_name;
                $newModel->language_id = $languageSelected->id;
                $newModel->page_name = "";
                $newModel->content = "";
                $newModel->seo_title = "";
                $newModel->meta_description = "";
                $newModel->meta_keywords = "";
                $newModel->save(false);
                $model = $newModel;
                
            }else{
                $model = $newModel;
            }
            
//            if ($model->load(Yii::$app->request->post())) {
//                
//                $translate = \backend\components\Translatte::saveMessage($model,['page_name', 'content', 'seo_title', 'meta_description', 'meta_keywords'], $language);
//                
//                Yii::$app->session->setFlash('success', 'Updated Successfully.');
//                return $this->redirect(['update', 'id' => $model->id,'language'=>$language]);
//                
//            }
        }

//        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
//            return $this->redirect(['index']);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
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
        

        if (isset($_POST['CustomPage'])) {
            $model->attributes = $_POST['CustomPage'];
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
     * Deletes an existing CustomPage model.
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
     * Finds the CustomPage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CustomPage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CustomPage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
