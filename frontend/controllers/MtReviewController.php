<?php

namespace frontend\controllers;

use Yii;
use frontend\models\MtReview;
use frontend\models\mtReviewSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MtReviewController implements the CRUD actions for MtReview model.
 */
class MtReviewController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MtReview models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new mtReviewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MtReview model.
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
     * Creates a new MtReview model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(){
        if(Yii::$app->request->isAjax){
            $model = new MtReview();
		    if ($model->load(Yii::$app->request->post() )) {
		        $model->client_id =Yii::$app->user->id;
		        $model->date_created = date('Y-m-d');
		        $food= $model->food_review;
		        $price= $model->price_review;
		        $punctuality=$model->punctuality_review;
		        $courtesy=$model->courtesy_review;
		        $average=($food+$price+$punctuality+$courtesy)/4;
		        $model->rating =$average;
		        $model->ip_address = '192.168.0.0';
		        $model->order_id = 'asdsa';

		        if($model->validate()){
			        $model->save();
			        $merchantUrl = preg_replace('/\s+/', '',$model->merchant->service_name);
			        $merchantUrl = strtolower($merchantUrl).'-'.$model->merchant_id;
			        return $this->redirect(['merchant/view', 'id' => $merchantUrl]);
		        } else {
			        echo \yii\helpers\Json::encode(['success' => false, 'data' => $model->getErrors()]);
			        Yii::$app->end();
			        return $this->render('create', [
			            'model' => $model,
			        ]);
		        }
		    }
        }
    }
    

    /**
     * Updates an existing MtReview model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MtReview model.
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
     * Finds the MtReview model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MtReview the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MtReview::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
}