<?php

namespace backend\controllers;

use common\models\BasicField;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * BasicfieldController implements the CRUD actions for BasicField model.
 */
class BasicfieldController extends \backend\components\AdminController
{
    /**
     * @inheritdoc
     */
    

    /**
     * Lists all BasicField models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        
        $searchModel = new \common\models\BasicFieldSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->pagination->pageSize = 10;
        

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single BasicField model.
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
     * Creates a new BasicField model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BasicField();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->created_at = new Expression('NOW()');
            
            $model->save();
            
            $translate = \backend\components\Translatte::save($model,['name']);
            return $this->redirect(['update', 'id'=> $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BasicField model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $translate = \backend\components\Translatte::save($model,['name']);
	
	
        
        
        if(isset($_GET['language']) && trim($_GET['language']) != 'en'){
            $language = $_GET['language'];
            Yii::$app->language = $language;
            \backend\components\Translatte::loadModel($model,['name'], $language);
	    
		
            
             if ($model->load(Yii::$app->request->post())) {
		     
		    
		     
		     
                
                $translate = \backend\components\Translatte::saveMessage($model,['name', 'description'], $language);
		
		 
                
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
     * Deletes an existing BasicField model.
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
     * Finds the BasicField model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BasicField the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BasicField::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
