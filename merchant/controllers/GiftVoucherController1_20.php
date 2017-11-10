<?php

namespace merchant\controllers;

use Yii;
use common\models\GiftVoucher;
use common\models\GiftVoucherSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GiftVoucherController implements the CRUD actions for GiftVoucher model.
 */
class GiftVoucherController extends \merchant\components\MerchantController
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
     * Lists all GiftVoucher models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GiftVoucherSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GiftVoucher model.
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
     * Creates a new GiftVoucher model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	public function actionCreate()
	{
		$model = new GiftVoucher();

		if ($model->load(Yii::$app->request->post()) ) {

			if($model->type == 0){
				$model->scenario = 'fixed';
				$model->service = 0;
				
			}else if ($model->type == 1){
				$model->scenario = 'service';
			}else if ($model->type == 2){
				$model->service = 0;
				$model->scenario = 'services';
			}
			if($model->save()){
				return $this->redirect(['index']);
			}
		}
		return $this->render('create', [
				'model' => $model,
			    ]);
		
	}

    /**
     * Updates an existing GiftVoucher model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		
		if(Yii::$app->request->isAjax){
			echo json_encode(['success' => true]);
			Yii::$app->end();
			
		}else{
			return $this->redirect(['index']);
		}
        } 
	
	if(Yii::$app->request->isAjax){
		return $this->renderAjax('update', [
			'model' => $model,
		]);
	}
	else {
		return $this->render('update', [
			'model' => $model,
		]);
        }
    }

    /**
     * Deletes an existing GiftVoucher model.
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
     * Finds the GiftVoucher model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GiftVoucher the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GiftVoucher::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
