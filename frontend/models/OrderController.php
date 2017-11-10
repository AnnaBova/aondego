<?php

namespace frontend\controllers;

use frontend\components\GroupScheduleHelper;
use frontend\components\SingleScheduleHelper;
use frontend\models\AddToCart;
use frontend\models\CategoryHasMerchant;
use frontend\models\MtVoucher;
use frontend\models\Order;
use frontend\models\Staff;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    
    public $enableCsrfValidation = false;
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
    
    public function actionCoupon(){
        
        if(Yii::$app->request->isAjax){
            
            $couponCode = trim($_POST['coupon']);
            $merchantId = $_POST['merchanid'];
            $session  = Yii::$app->session;
            $total = $session['total'];
            $is_checked = $_POST['checkornot'];
            $discount = 0;
            $couponPer = "";
            
            
            if($is_checked == 'true'){
            
            $voucher = MtVoucher::find()
                    ->where(['voucher_name'=> $couponCode, 'merchant_id'=> $merchantId])
                    ->one();
            
                if(count($voucher) > 0){

                    $amount = 0;
                    if(empty($voucher->service_id)){
                        $amount = $session['total'];

                    }else{
                        if(isset($session['cart'][$voucher->service_id])){
                            $amount = array_sum(array_column($session['cart'][$voucher->service_id],'price'));

                        }

                    }
                    
                    if($amount != 0){

                        if($voucher->voucher_type == 0){
                            $discount = $voucher->amount;
                        }else{
                            $couponPer = $voucher->amount;
                            $discount =  ($voucher->amount / 100) * $amount;
                        }

                    }

                    $total = $total - $discount;

                    $session['total'] = $total;
                    $session['couponid'] = $voucher->voucher_id;
                    $session['discount'] = $discount;
                    $session['couponPer'] = $couponPer.'%';

                    echo Json::encode(['couponPer' => $couponPer.'%', 'discount' => $discount, 'total' => $total]);

                    Yii::$app->end();
                    


                }else{
                    $session['total'] = $session['subtotal'];
                    $session['couponid'] = NULL;
                    $session['discount'] = NULL;
                    $session['couponPer'] = NULL;
                    $total = $session['total'];
                    echo Json::encode(['couponPer' => $couponPer, 'discount' => $discount, 'total' => $total]);
                    Yii::$app->end();
                    
                }
            }else{
                $session['total'] = $session['subtotal'];
                $session['couponid'] = NULL;
                $session['discount'] = NULL;
                $session['couponPer'] = NULL;
                $total = $session['total'];
                echo Json::encode(['couponPer' => $couponPer, 'discount' => $discount, 'total' => $total]);
                Yii::$app->end();
            }
            
            
            //$coupon = 
            
        }
    }


    public function actionGetFreeStaff(){
        
        if (isset($_POST['time_val']) && $_POST['time_val'] && isset($_POST['date_val']) && $_POST['date_val']) {

            $d = trim($_POST['date_val']);
            $t = trim($_POST['time_val']);
            $m = trim($_POST['min_val']);
            $c = trim($_POST['cat']);
            $merchant_id = trim($_POST['merchant_id']);
            
            if (SingleScheduleHelper::isMerchantWork($d, $t, $m, $merchant_id)) {
                $u = 0;
                
                $staffs = Staff::find()
                    ->joinWith('staffHasCategories')
                    ->where(['is_active' => 1,
                        'merchant_id' => $merchant_id,
                        'staff_has_category.category_id'=>$c])
                    ->all();
                    
                $data = [];

                foreach ($staffs as $staff) {
                    echo 'category'.$c;
                    print_r($staff->attributes);

                    if (SingleScheduleHelper::isStaffWork($d, $t, $m, $staff, $u, $c))
                        $data[] = $staff;
                }

                $data = ArrayHelper::map($data, 'id', 'name');
                if ($data) {
                    echo Html::tag('option',
                         Html::encode('select'), ['value'=>""]);
                    foreach ($data as $value => $name) {
                        echo Html::tag('option',
                             Html::encode($name),  ['value'=>$value]);
                    }
                } else {
                    echo Html::tag('option',
                         Html::encode('No staff for this time'),  ['value'=>""]);
                }
        }else {
            echo Html::tag('option', Html::encode('this day is free'), ['value'=>'']);
        }
        
    }
    }
    
    public function actionGetGroupTime(){
        
        
        if(Yii::$app->request->isAjax){
            
            
            $addToCart = new AddToCart();
            
            if($addToCart->load(Yii::$app->request->post())){
                $dStart = strtotime($addToCart->order_date);
                
                
                $service = CategoryHasMerchant::findOne(['id'=>$addToCart->serviceid]);
                
                $k = 0;
                GroupScheduleHelper::init(strtotime("+$k day", $dStart), $addToCart->serviceid, $service);
                $dayGroupSchedule = GroupScheduleHelper::getDateSchedule(strtotime("+$k day", $dStart), $addToCart->serviceid, $service);
                
                echo  $this->renderAjax('group_time', ['model' =>$dayGroupSchedule ]);
                Yii::$app->end();
                
                
            }
        
            
        }              
    }
    
    
    public function actionGetStaffFreeTime()
    {
        if (isset($_POST['staff_id']) && $_POST['staff_id']) {
            $d = $_POST['date_val'];
            $m = $_POST['min_val'];
            $u = (isset($_POST['update'])) ? $_POST['update'] : 0;
            $staff = Staff::findOne($_POST['staff_id']);
            $dd = Html::tag('option', Html::encode('select'), 
                ['value' => '']);
            foreach ($staff->getFreeTime($d, $m, $u) as $name) {
                $dd.= Html::tag('option',
                Html::encode($name), ['value' => $name]);
            }

            $addOns = $this->renderAjax('_addons_single', ['addons' => $staff->addons]);
            $res = [
                'dd' => $dd,
                'add_ons' => $addOns

            ];

            echo json_encode($res);

        }
        Yii::$app->end();
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
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
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Order model.
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
     * Deletes an existing Order model.
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
