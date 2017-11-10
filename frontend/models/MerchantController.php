<?php

namespace frontend\controllers;

use frontend\models\MtMerchant;
use frontend\models\MtMerchantCc;
use frontend\models\MtPackages;
use frontend\models\SearchMtMerchant;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * MerchantController implements the CRUD actions for MtMerchant model.
 */
class MerchantController extends Controller
{
    public $package;
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
    
    public function actionDeleteOrder(){
        
        if(Yii::$app->request->isAjax){
            $catid = $_POST['catid'];
            $key = $_POST['key'];
            
            if(isset($catid) && isset($key)){
                $session = Yii::$app->session;
                
                $array = $session['cart'];
                
                if(isset($array[$catid][$key])){
                    
                    unset($array[$catid][$key]);
                    
                    $session['cart'] = $array;
                    
                    $data = $this->renderAjax('orders', ['orders'=>$session['cart']]);
                    echo \yii\helpers\Json::encode(['success' => true,
                        'data'=> $data,
                        'subtotal' => $session['subtotal'],
                        'total' => $session['total']
                        ]);
                    Yii::$app->end();
                    
                }
            
            }
            
            Yii::$app->end();
            
        }
        
        
    }
    
    public function actionDate(){
        return $this->renderAjax('date');
    }
    
    public function actionService(){
        if(Yii::$app->request->isAjax){
            
            $update = 0;
            $key = "";
            $serviceId = isset($_POST['serviceid']) ? $_POST['serviceid'] : "";
            
            
            if(isset($_POST['AddToCart']['serviceid'])){
                $serviceId = $_POST['AddToCart']['serviceid'];
            }
            
            $service = \frontend\models\CategoryHasMerchant::findOne(['id'=>$serviceId]);
            if($service->is_group == 1){
                $addToCard  =  new \frontend\models\AddToCart();
                $addToCard->scenario = 'grouporder';
            }else{
                $addToCard  =  new \frontend\models\AddToCart();
                $addToCard->scenario = 'singleorder';
            }
            
            $session = Yii::$app->session;
            $updateArray = [];
            if(isset($_POST['key'])){
                $key = $_POST['key'];
                $update = $_POST['update'];
                
                if(isset($session['cart'][$serviceId][$key])){
                    
                    $addToCard->attributes = $session['cart'][$serviceId][$key];
                    $addToCard->serviceid = $serviceId;
                    
                    $updateArray = $session['cart'][$serviceId][$key];
                }
            }
            
            
            if(isset($_POST['AddToCart'])){
                //$session['cart'] = Null;
                
                
                if($addToCard->load(Yii::$app->request->post())){
                    
                    $post = $_POST['AddToCart'];
                    
                    
                    if($addToCard->validate()){
                        if(isset($session['cart'])){
                            $addToCartArray = $session['cart'];
                        }else{
                            $addToCartArray = [];
                        }
                        
                        if($update == 0){
                            
                            if (isset($session['cart']) && array_key_exists($serviceId, $session['cart'])) {
                                $size = sizeof($session['cart'][$serviceId]);

                                $k = array_keys($session['cart'][$serviceId]);

                                $key = $k[$size-1] + 1;


                            }else{
                                $key  = 0;
                            }
                        }
                        
                        
                        
                        
                        
                        $addToCartArray[$serviceId][$key]['qty'] = 1;
                        $addToCartArray[$serviceId][$key]['title'] = $service->title;
                        $addToCartArray[$serviceId][$key]['price'] = $service->price;
                        $addToCartArray[$serviceId][$key]['order_date'] = $addToCard->order_date;
                        $addToCartArray[$serviceId][$key]['time_req'] = $addToCard->time_req;
                        $addToCartArray[$serviceId][$key]['staff_id'] = $addToCard->staff_id;
                        $addToCartArray[$serviceId][$key]['free_time_list'] = $addToCard->free_time_list;
                        $addToCartArray[$serviceId][$key]['time_in_minutes'] = $service->time_in_minutes;
                        $addToCartArray[$serviceId][$key]['additional_time'] = $service->additional_time;
                        $addToCartArray[$serviceId][$key]['merchant_id'] = $service->merchant_id;
                        $addToCartArray[$serviceId][$key]['is_group'] = $service->is_group;

                        if(isset($post['addons_list']))
                            $addToCartArray[$serviceId][$key]['addons_list'] = $post['addons_list'];
                        
                        
                        
                        $session['cart'] = $addToCartArray;
                        
                        $data = $this->renderAjax('orders', ['orders'=>$session['cart']]);
                        
                        echo \yii\helpers\Json::encode(['success' => true,
                            'data'=> $data, 
                            'subtotal' => $session['subtotal'],
                            'total' => $session['total']
                                ]);
                        Yii::$app->end();
                        
                    }else{
                        
                        echo \yii\helpers\Json::encode(['success' => false, 'data' => $addToCard->getErrors()]);
                        Yii::$app->end();
                        
                    }
                    
                }
               
                
            }
            
            if($service->is_group == 0){
                return $this->renderAjax('service', [
                    'model' => $service,
                    'addToCard' => $addToCard,
                    'update' => $update,
                    'updateArray' => $updateArray,
                    'key' => $key
                ]);
            }else if($service->is_group == 1){
                return $this->renderAjax('service_group', [
                    'model' => $service,
                    'addToCard' => $addToCard,
                    'update' => $update,
                    'updateArray' => $updateArray,
                    'key' => $key
                ]);
                
            }
        }
    }
    
    public function actionSearch(){
        
        
        $keyword = trim($_GET['Merchant']['search']);
        
        
        //$query = MtMerchant::find();
                //->where(['like', 'street', $search])
                //->orWhere(['like', 'city', $search])
                //->orWhere(['like', 'post_code', $search]);
        
//        $searchModel = new SearchMtMerchant();
//        $searchModel->search = $search;
//        
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        
//        $priceSql = '';
//                
//        return $this->render('search', [
//            'dataProvider' => $dataProvider,
//            'search' => $search
//        ]);
        
        
        $where = ' WHERE (m.street like "%'.$keyword.'%" or m.city like "%'.$keyword.
                '%" or m.service_name like "%'.$keyword.
                '%" or m.address like "%'.$keyword.
                '%" or m.post_code like "%'.$keyword.'%")';
        
        $serviceSql = ' RIGHT JOIN category_has_merchant AS chm ON chm.merchant_id=m.merchant_id ';
        $selectCat = 'chm.category_id, ssc.id as subcatid, ssc.title , sc.id as catid, sc.title, ';
        
        $leftJoinCategory = 'LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                LEFT JOIN  mt_service_category AS sc ON sc.id=ssc.category_id';

        $where .=' or sc.title like "%'.$keyword.'%" or ssc.title like "%'.$keyword.'%"';
        
        $sql  = 'SELECT '.$selectCat.' m.* FROM mt_merchant AS m '.$serviceSql.$leftJoinCategory.$where.' group by m.merchant_id';
        
        $countSql =  'SELECT '.$selectCat.'count(*) FROM mt_merchant as m'.$serviceSql.$leftJoinCategory.$where;
            
        $count = Yii::$app->db->createCommand($countSql)->queryScalar();
        
        $price = 'SELECT '.$selectCat.' max(chm.price) as maxprice,chm.merchant_id, m.merchant_id  FROM mt_merchant AS m 
                '.$serviceSql.$leftJoinCategory.$where;
        
        
        
        $maxprice = Yii::$app->db->createCommand($price)->queryOne();
        
        
        if(empty($maxprice['maxprice']))
            $maxprice = 0;
        else
            $maxprice = $maxprice['maxprice'];
        
        

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => $count,
            

        ]);


        $models = $dataProvider->getModels();
        $distance = 0;
        if(count($models) == 0){
            $distance = 5;
            $session = Yii::$app->session;
            $where = ' WHERE m.gmap_latitude
                    BETWEEN p.latpoint  - (p.radius / p.distance_unit)
                        AND p.latpoint  + (p.radius / p.distance_unit)
                   AND m.gmap_altitude
                    BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
                        AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))';
            
            
             
            $getLatLang = $session['latlang'];
            if(!empty($getLatLang ) && !empty($distance) && $distance != 0){
            
                $sql = 'SELECT '.$selectCat.'m.* , p.distance_unit
                                     * DEGREES(ACOS(COS(RADIANS(p.latpoint))
                                     * COS(RADIANS(m.gmap_latitude))
                                     * COS(RADIANS(p.longpoint) - RADIANS(m.gmap_altitude))
                                     + SIN(RADIANS(p.latpoint))
                                     * SIN(RADIANS(m.gmap_latitude)))) AS distance_in_km
                        FROM mt_merchant as m
                        JOIN (   
                              SELECT  '.$getLatLang["lat"].'  AS latpoint,  '.$getLatLang["long"].' AS longpoint,
                                      '.$distance.' AS radius,      69.0 AS distance_unit
                          ) AS p ON 1=1 '.$serviceSql.$leftJoinCategory. $where. ' group by m.merchant_id';
            }
            
            $countSql = 'SELECT count(*), '.$selectCat.'m.* , p.distance_unit
                                     * DEGREES(ACOS(COS(RADIANS(p.latpoint))
                                     * COS(RADIANS(m.gmap_latitude))
                                     * COS(RADIANS(p.longpoint) - RADIANS(m.gmap_altitude))
                                     + SIN(RADIANS(p.latpoint))
                                     * SIN(RADIANS(m.gmap_latitude)))) AS distance_in_km
                        FROM mt_merchant as m
                        JOIN (   
                              SELECT  '.$getLatLang["lat"].'  AS latpoint,  '.$getLatLang["long"].' AS longpoint,
                                      '.$distance.' AS radius,      111.045 AS distance_unit
                          ) AS p ON 1=1 '.$serviceSql.$leftJoinCategory. $where. ' group by m.merchant_id';
            $count = Yii::$app->db->createCommand($countSql)->queryScalar();
            
            
            
            
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                'totalCount' => $count,


            ]);
            $models = $dataProvider->getModels();
            
            
            $price = 'SELECT '.$selectCat.' max(chm.price) as maxprice, m.* , p.distance_unit
                                     * DEGREES(ACOS(COS(RADIANS(p.latpoint))
                                     * COS(RADIANS(m.gmap_latitude))
                                     * COS(RADIANS(p.longpoint) - RADIANS(m.gmap_altitude))
                                     + SIN(RADIANS(p.latpoint))
                                     * SIN(RADIANS(m.gmap_latitude)))) AS distance_in_km
                        FROM mt_merchant as m
                        JOIN (   
                              SELECT  '.$getLatLang["lat"].'  AS latpoint,  '.$getLatLang["long"].' AS longpoint,
                                      '.$distance.' AS radius,      111.045 AS distance_unit
                          ) AS p ON 1=1 '.$serviceSql.$leftJoinCategory. $where; 
                    
        
        
        
            $maxprice = Yii::$app->db->createCommand($price)->queryOne();
            
            if(empty($maxprice['maxprice']))
                $maxprice = 0;
            else
                $maxprice = $maxprice['maxprice'];
            
        }
        
        
        

        return $this->render('search', [
            'models' => $models,
            'dataProvider' => $dataProvider,
            'maxprice' => $maxprice,
            'search' => $keyword,
            'distance' => $distance
        ]);
        
    }
    
    public function actionRefineSearch(){
//        echo '<pre>';
//        print_r($_POST);
//        exit;
            
            $keyword = isset($_POST['SearchMtMerchant']['keyword']) ? $_POST['SearchMtMerchant']['keyword'] : "";
            $category  = isset($_POST['SearchMtMerchant']['category']) ? $_POST['SearchMtMerchant']['category'] : "";
            $subCategory  = isset($_POST['SearchMtMerchant']['subcategory']) ? $_POST['SearchMtMerchant']['subcategory'] : "";
            $price = isset($_POST['SearchMtMerchant']['price']) ? $_POST['SearchMtMerchant']['price'] : "";
            $rating = isset($_POST['SearchMtMerchant']['rating']) ? $_POST['SearchMtMerchant']['rating'] : "";
            $ranking = isset($_POST['SearchMtMerchant']['ranking']) ? $_POST['SearchMtMerchant']['ranking'] : "";
            $distance = isset($_POST['SearchMtMerchant']['distance']) ? $_POST['SearchMtMerchant']['distance'] : "";
            $date = isset($_POST['SearchMtMerchant']['date']) ? $_POST['SearchMtMerchant']['date'] : "";
            
            $session = Yii::$app->session;
            if(empty($session['latlang'])){
                $latLang = \frontend\models\MtMerchant::getLatLang($keyword);
                $session['latlang']  = $latLang;
            }
            
            $where = "";
            $selectCat = "";
            $order = "";
            if(empty($distance) ){
                $where .= ' WHERE (m.street like "%'.$keyword.'%" or m.city like "%'.$keyword.
                        '%" or m.address like "%'.$keyword.
                        '%" or m.post_code like "%'.$keyword.'%")';
            }else if ($distance != 0){
                $where .= ' WHERE m.gmap_latitude
                               BETWEEN p.latpoint  - (p.radius / p.distance_unit)
                                   AND p.latpoint  + (p.radius / p.distance_unit)
                              AND m.gmap_altitude
                               BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
                                   AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))';
            }
                
            
                
            $serviceSql = "";    
            $ratingSql = "";    
            $leftJoinCategory = "";
            if(!empty($category)){
                $serviceSql = ' LEFT JOIN category_has_merchant AS chm ON chm.merchant_id=m.merchant_id ';
                $selectCat = 'chm.category_id, ssc.id as subcatid , sc.id as catid,';
                $implodeCat = implode(',', $category);
                $leftJoinCategory = ' 
                        RIGHT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                        RIGHT JOIN  mt_service_category AS sc ON sc.id=ssc.category_id
                        ';
                
                $where .=' AND sc.id IN ('.$implodeCat.')';
            }
            
            if(!empty($subCategory)){
                $serviceSql = ' LEFT JOIN category_has_merchant AS chm ON chm.merchant_id=m.merchant_id ';
                
                $selectCat = 'chm.category_id, ssc.id as subcatid , sc.id as catid,';
                
                $implodeSubCat = implode(',', $subCategory);
                $leftJoinCategory = ' 
                        RIGHT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                        RIGHT JOIN  mt_service_category AS sc ON sc.id=ssc.category_id
                        ';
                
                $where .=' AND chm.category_id IN ('.$implodeSubCat.')';    
            }
            
            if(!empty($price)){
                $serviceSql = ' LEFT JOIN category_has_merchant AS chm ON chm.merchant_id=m.merchant_id ';
                
                $explodePrice = explode(';', $price);
                
                
                $selectCat .= 'chm.price, ';
                if( $explodePrice[1] !=0 )
                $where .=' AND chm.price between '.$explodePrice[0]. ' and '.$explodePrice[1];
                
            }
            
            if(!empty($rating)){
                //$serviceSql = "";
                $selectCat .= 'mr.merchant_id, ceil(AVG(mr.ratings)) AS ratings, ';
                $implodeRating = implode(',', $rating);
                $ratingSql = ' LEFT JOIN mt_rating as mr ON mr.merchant_id=m.merchant_id';
                $where .=' AND ratings IN ('.$implodeRating.')';
                
                
            } 
            
            if(!empty($ranking)){
                
                $selectCat .= 'mr.merchant_id, ceil(AVG(mr.ratings)) AS ratings, ';
                $ratingSql = ' LEFT JOIN mt_rating as mr ON mr.merchant_id=m.merchant_id';
                
                $order = ' ORDER BY ratings '.$ranking;
                
            }
            $datesql = "";
            if(!empty($date)){
                $selectCat .= 'so.merchant_id, DATE(order_time) AS order_time, ';
                $datesql = ' LEFT JOIN `order` as so ON so.merchant_id=m.merchant_id';
                $where .= ' AND so.staff_id is NULL and so.order_time like "%'.$date.'%"';
            }
            
            
            
            $sql = 'SELECT  '.$selectCat.'m.* FROM mt_merchant as m'.$serviceSql.$leftJoinCategory.$ratingSql.$datesql. $where. ' group by m.merchant_id'.$order;
            
            
            $getLatLang = $session['latlang'];
            if(!empty($getLatLang ) && !empty($distance) && $distance != 0){
            
                $sql = 'SELECT '.$selectCat.'m.* , p.distance_unit
                                     * DEGREES(ACOS(COS(RADIANS(p.latpoint))
                                     * COS(RADIANS(m.gmap_latitude))
                                     * COS(RADIANS(p.longpoint) - RADIANS(m.gmap_altitude))
                                     + SIN(RADIANS(p.latpoint))
                                     * SIN(RADIANS(m.gmap_latitude)))) AS distance_in_km
                        FROM mt_merchant as m
                        JOIN (   
                              SELECT  '.$getLatLang["lat"].'  AS latpoint,  '.$getLatLang["long"].' AS longpoint,
                                      '.$distance.' AS radius,      111.045 AS distance_unit
                          ) AS p ON 1=1 '.$serviceSql.$leftJoinCategory.$ratingSql.$datesql. $where. ' group by m.merchant_id'.$order;
            }
            
            //echo $sql;
            
            //$countSql =  'SELECT count(*) FROM mt_merchant as m '.$serviceSql.$leftJoinCategory.$ratingSql. $where;
            
            //$count = Yii::$app->db->createCommand($countSql)->queryScalar();
            
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                //'totalCount' => $count,
                
            ]);
            
            
            $models = $dataProvider->getModels();
            
            
            
            
            
            //print_r($models);
        if(Yii::$app->request->isAjax){   
            if($_POST['SearchMtMerchant']['listtype'] == 'grid'){
                return $this->renderAjax('searchview_grid', [
                    'models' => $models,
                    'dataProvider' => $dataProvider
                ]);
                
            }else{
                return $this->renderAjax('searchview', [
                    'models' => $models,
                    'dataProvider' => $dataProvider
                ]);
            }
            
        }else{
            
            $price = 'SELECT '.$selectCat.' max(chm.price) as maxprice,chm.merchant_id, m.merchant_id  FROM mt_merchant AS m 
                '.$serviceSql.$leftJoinCategory.$where;
        
            $maxprice = Yii::$app->db->createCommand($price)->queryScalar();
            
            
            if(!$maxprice){
                $maxprice = 0;
            }
            
            return $this->render('search', [
                'models' => $models,
                'dataProvider' => $dataProvider,
                'maxprice' => $maxprice,
                'search' => $keyword,
                'distance' => 0
            ]);
        }
        
    }
    
    public function actionGetSubcategory(){
        if(Yii::$app->request->isAjax){
            $sql = "";
            if(isset($_POST['sel']) && $_POST['sel'] == 'all'){
                $sql = 'SELECT * FROM mt_service_subcategory';
            }else if(!empty($_POST['SearchMtMerchant']['category']) ){
                $selectedCat = [];
                $selectedCat = $_POST['SearchMtMerchant']['category'];
                
                $implode = implode(',', $selectedCat);
                $sql = 'SELECT * FROM mt_service_subcategory WHERE category_id IN('.$implode.')';
                
            }
            if($sql){
                $querySubCat = Yii::$app->db->createCommand($sql)->queryAll();
                return $this->renderAjax('subcategory',['subcategories'=>$querySubCat]);
            }
            
        }
    }
    

    /**
     * Lists all MtMerchant models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MtMerchant::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionSignUp(){
        return $this->render('sign-up');
        
    }

    /**
     * Displays a single MtMerchant model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $appointment = new \frontend\models\Appointment();
        
        
        
        if($appointment->load(Yii::$app->request->post())){
            
            
            $session = Yii::$app->session;
            
            
            if(isset($session['cart']) && count(array_filter($session['cart'])) == 0){
                $appointment->addError('order', 'Please add at least one service to cart');
            }else if($appointment->validate()){
                
                $this->redirect(['checkout/index']);
                
            }
            
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
            'appointment' => $appointment,
            
        ]);
    }

    /**
     * Creates a new MtMerchant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($packageid)
    {
        $this->package = $packageid;
        $package = MtPackages::findOne(['package_id'=>$packageid]);
        
        
        $model = new MtMerchant();
        
        $session = Yii::$app->session;
        
        if($session['merchant']){
            $model->attributes = $session['merchant'];
        }
        
        $model->package_id = $packageid;

        if ($model->load(Yii::$app->request->post())) {
            if(!empty($model->cuisine)){
                $model->cuisine = implode('|', $model->cuisine);
            }
            
            if($model->validate()){
                
                $session['merchant'] = $model->attributes; 
                
                $this->redirect(['payment']);
               
                
            }
            
        } 
        
        return $this->render('create', [
            'model' => $model,
            'package' => $package,
            'selectedpackage' => $packageid
        ]);
        
    }
    
    public function actionPayment(){
        
        $creditCard = new MtMerchantCc;
        $session = Yii::$app->session;
        //$session['creditcard'] = null;
        
        $creditcard = [];
        
        if(isset($session['creditcard']) && !empty($session['creditcard'])){
            $creditcard  = $session['creditcard'];
         }
        
        if(Yii::$app->request->isAjax){
           
            if($creditCard->load(Yii::$app->request->post())){
                
                
                if($creditCard->validate()){
                    
                    
                    $creditcard[] = $creditCard->attributes;
                    //$creditCard->save(false);
                    
                    $session['creditcard'] = $creditcard;
                    
                    
                    $view = $this->renderAjax('credit-card', ['model'=>$creditCard], false, true);
                    
                    $result = ['success'=>true, 'view'=>$view];
                    Yii::$app->response->format = trim(Response::FORMAT_JSON);
                    return $result;
                    
                    
                }else{
                    $error = ActiveForm::validate($creditCard);
                    Yii::$app->response->format = trim(Response::FORMAT_JSON);
                    return $error; 
                }
                
            }
            
        }
        return $this->render('payment', ['creditCard' => $creditCard,
            'session' => $session
                ]);
        
    }
    
    public function actionFinalPayment(){
        if(Yii::$app->request->isAjax){
            
            if(isset($_POST['paymentType'])){
                $paymentType = $_POST['paymentType'];
                $creditCardId = (isset($_POST['creditCard'])) ? $_POST['creditCard'] : "";
                
                $session = Yii::$app->session;
                
                
                if(!empty($session['merchant'])){
                    $merchant = new MtMerchant;
                    $merchant->attributes = $session['merchant'];
                    $merchant->setPassword($merchant->password);
                    $merchant->payment_steps = $paymentType;
                    $merchant->ip_address = $_SERVER['REMOTE_ADDR'];
                    $merchant->generateAuthKey();
                    $merchant->free_delivery = 0;
                    $merchant->status = 1;
                    $merchant->date_created = new Expression('NOW()');
                    if($merchant->save(false)){
                        
                        if($paymentType == 1){
                    
                            $creditCard = new MtMerchantCc();
                            $creditCard->attributes = $session['creditcard'][$creditCardId];
                            $creditCard->merchant_id = $merchant->id;
                            $creditCard->date_created = new Expression('NOW()');
                            $creditCard->ip_address = $_SERVER['REMOTE_ADDR'];
                            $creditCard->save(false);
                            
                        }
                        
                        $session['merchant'] = NULL;
                        $session['creditcard'] = NULL;
                        
                        $result = ['success'=>true, 'url'=>Yii::$app->urlManager->createUrl('merchant/verification')];
                        Yii::$app->response->format = trim(Response::FORMAT_JSON);
                        return $result;
                        
                    }
                    
                    
                    
                }else{
                    $result = ['success'=>false, 'msg'=>'There is some problem in registering. Please try again later.'];
                    Yii::$app->response->format = trim(Response::FORMAT_JSON);
                    return $result;
                }
                
                
            }
            
            
        }
    }
    
    public function actionVerification(){
        return $this->render('verification');
    }

    /**
     * Updates an existing MtMerchant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->merchant_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MtMerchant model.
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
     * Finds the MtMerchant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MtMerchant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MtMerchant::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
