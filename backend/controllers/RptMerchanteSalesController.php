<?php
namespace backend\controllers;

use backend\components\AdminController;
use Yii;

/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-Jan-16
 * Time: 20:29
 */

class RptMerchanteSalesController extends AdminController {

    public function init(){
        $this->menu = false;
    }

    public function actionIndex()
    {
        $searchModel = new \common\models\MerchantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionDetails($merchantId){
        
        $model = \common\models\Merchant::findOne(['merchant_id' => $merchantId]);
        
        $searchModel = new \common\models\OrderSearch();
        $searchModel->merchant_id = $merchantId;
        $searchModel->status = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('details', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
            
        ]);
    }

} 