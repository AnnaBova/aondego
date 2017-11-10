<?php

namespace backend\controllers;

use Yii;
use common\models\Newsletter;
use common\models\NewsletterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NewsletterController implements the CRUD actions for Newsletter model.
 */
class NewsletterController extends \backend\components\AdminController
{
    

    /**
     * Lists all Newsletter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsletterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Newsletter model.
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
     * Creates a new Newsletter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Newsletter();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Newsletter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       if ($model->load(Yii::$app->request->post())) {
                
                $translate = \backend\components\Translatte::saveMessage($model,['title', 'description'], $language);
                
                Yii::$app->session->setFlash('success', 'Updated Successfully.');
                
                if(Yii::$app->request->isAjax){
                    echo json_encode(['success' => true]);
                    Yii::$app->end();
                
                }else{
                    return $this->redirect(['update', 'id' => $model->id]);
                }
                
            }
       

        if (isset($_POST['Newsletter'])) {
            $model->attributes = $_POST['Newsletter'];
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
     * Deletes an existing Newsletter model.
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
     * Finds the Newsletter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Newsletter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Newsletter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
