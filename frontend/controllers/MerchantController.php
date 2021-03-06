<?php

namespace frontend\controllers;

use frontend\components\EmailManager;
use frontend\models\MtMerchant;
use frontend\models\MtMerchantCc;
use frontend\models\MtPackages;
use frontend\models\Staff;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\db\Expression;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\Cookie;
use yii\helpers\Json;

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
    
    
	public function beforeAction($event)
	{
	    $cookies = Yii::$app->request->cookies;

	    $languageCookie = $cookies['language'];

	    if(isset($languageCookie->value) && !empty($languageCookie->value)){
		Yii::$app->language = $languageCookie->value;
	    }



	    return parent::beforeAction($event);
	}
	
	
	public function actionGiftVoucher($id){
		
		$explode = explode('-', $id);
		$id = $explode[1];
		
		$session = Yii::$app->session;
		$session['merchant_id'] = $id;
		
		$merchant = MtMerchant::findOne(['merchant_id' => $id]);
		
		$giftVoucher = \common\models\GiftVoucher::find()->where(['merchant_id' => $id, 'status' => 1])->orderBy('type asc')->all();
		
		
		if(Yii::$app->request->isPost){
			$session = Yii::$app->session;
			if(isset($session['Vouchercart']) && count(array_filter($session['Vouchercart'])) != 0){
				
				if(Yii::$app->user->id){
					$this->redirect(['checkout/voucher-payment']);
					
				}else{
					
					$this->redirect(['checkout/voucher']);
				}
				
				
			}
			
		}
		
		return $this->render('gift-voucher', [
		    'model' => $merchant,
		    'giftVoucher' => $giftVoucher
		]);
		
	}


	
    public function actionWidget(){
        $this->layout = false;
        return $this->render('widget');
    }
    
    public function actionWidgetview($id){
        $this->layout = 'widget-layout';
	
		$session = Yii::$app->session;
	
		$session['merchant_id_widget'] = $id;
        
        $id = explode('_',urldecode(base64_decode($id)));
        
        $id = $id[0];
		
		if($session['merchant_id'] != $id){
			$session['cart'] = NULL;
		}
        
        $appointment = new \frontend\models\Appointment();
        
        
		$session['merchant_id'] = $id;
        
        $model = $this->findModel($id);
	
	
	
	
	if($model::hasServices($model) == 0 && $model::hasVoucher($model)){
		
		return $this->redirect(['/widget/gift-voucher', 'id' => $id]);
		
	}
        
        $language = $model->language->code;
        if(isset($language)){            
            
            Yii::$app->language = $language;

            $languageCookie = new Cookie([
                'name' => 'language',
                'value' => $language,
                'expire' => time() + 60 * 60 * 24 * 30, // 30 days
            ]);
            Yii::$app->response->cookies->add($languageCookie);
            
        }
        
        if($appointment->load(Yii::$app->request->post())){
            
            
            if(!isset($session['cart']) || count(array_filter($session['cart'])) == 0){
                $appointment->addError('order', 'Please add at least one service to cart');
            }else if($appointment->validate()){
                
                if(Yii::$app->user->id){
                    $this->redirect(['checkout/widget-payment']); 
                }else{
                    $this->redirect(['checkout/widget-index']);
                }
                
            }
            
        }
        
        return $this->render('widgetview',[
            'model' => $model,
            'appointment' => $appointment,
        ]);
        
        
    }
    
    public function actionDeleteOrder(){
        
        if(Yii::$app->request->isAjax){
            $catid = $_POST['catid'];
            $key = $_POST['key'];
            
            if(isset($catid) && isset($key)){
                $session = Yii::$app->session;
                
                $array = $session['cart'];
                
                if(isset($array[$catid][$key])){
                    
                    //print_r($catid);
                    
                    unset($array[$catid][$key]);
                    
                    $session['cart'] = $array;
                    $discount = 0;
                    $couponPer = 0;
                    if(isset($session['couponid'])){
                        
//                        $voucher = \frontend\models\MtVoucher::findOne(['voucher_id' => $session['couponid']]);
//                        if($voucher->service_id == $catid){
                            $session['couponid'] = NULL;
                            $discount = $session['discount'] = 0;
                            $couponPer = $session['couponPer'] = 0;
                        //}
                    }
                    
                    $data = $this->renderAjax('orders', ['orders'=>$session['cart']]);
                    echo \yii\helpers\Json::encode(['success' => true,
                        'data'=> $data,
                        'subtotal' => number_format($session['subtotal'], 2, '.', ''),
                        'total' => number_format($session['total'], 2, '.', ''),
                        'discount' => number_format($discount, 2, '.', ''),
                        'couponPer' => $couponPer
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
	    $merchant = MtMerchant::findOne(['merchant_id' => $session['merchant_id']]);
            $updateArray = [];
            
            $discount = 0;
            $couponPer = 0;
            
            if(isset($_POST['key'])){
                $key = $_POST['key'];
                $update = $_POST['update'];
                
                if(isset($session['cart'][$serviceId][$key])){
                    
                    $addToCard->attributes = $session['cart'][$serviceId][$key];
                    $addToCard->serviceid = $serviceId;
                    
                    $updateArray = $session['cart'][$serviceId][$key];
                    
                    
                    if(isset($session['couponid'])){
                        
//                        $voucher = \frontend\models\MtVoucher::findOne(['voucher_id' => $session['couponid']]);
//                        if($voucher->service_id == $catid){
                            $session['couponid'] = NULL;
                            $discount = $session['discount'] = 0;
                            $couponPer = $session['couponPer'] = 0;
                        //}
                    }
                }
            }
            
            
            if(isset($_POST['AddToCart'])){
                //$session['cart'] = Null;
				
                
                if($addToCard->load(Yii::$app->request->post())){
					
                    
                    $post = $_POST['AddToCart'];
					
					if(empty($addToCard->order_date)){
						$today = date ('Y-m-d');
						$addToCard->order_date = date ('Y-m-d', strtotime('+1 days', strtotime($today)));
                    
					}
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
						
						$addToCartArray[$serviceId][$key]['pid'] = $service->category->id;
                        
                        $addToCartArray[$serviceId][$key]['no_of_seats'] = 1;
                        
                        if($service->is_group == 1){
                           $addToCartArray[$serviceId][$key]['price'] = $service->price * $addToCard->no_of_seats; 
                           $addToCartArray[$serviceId][$key]['no_of_seats'] = $addToCard->no_of_seats;
                           $addToCartArray[$serviceId][$key]['qty'] = $addToCard->no_of_seats;
                        }
			
			$currency = \common\components\Helper::getCurrencyCode($merchant);
                        
                        $addToCartArray[$serviceId] [$key]['order_date'] = $addToCard->order_date;
                        $addToCartArray[$serviceId][$key]['time_req'] = $addToCard->time_req;
                        $addToCartArray[$serviceId][$key]['staff_id'] = $addToCard->staff_id;
                        $addToCartArray[$serviceId][$key]['free_time_list'] = $addToCard->free_time_list;
                        $addToCartArray[$serviceId][$key]['time_in_minutes'] = $service->time_in_minutes;
                        $addToCartArray[$serviceId][$key]['additional_time'] = $service->additional_time;
                        $addToCartArray[$serviceId][$key]['merchant_id'] = $service->merchant_id;
                        $addToCartArray[$serviceId][$key]['is_group'] = $service->is_group;
			$addToCartArray[$serviceId][$key]['currency'] = $currency;

                        if(isset($post['addons_list']))
                            $addToCartArray[$serviceId][$key]['addons_list'] = $post['addons_list'];
                        
                        
                        
                        $session['cart'] = $addToCartArray;
                        
                        $data = $this->renderAjax('orders', ['orders'=>$session['cart']]);
                        
                        echo \yii\helpers\Json::encode(['success' => true,
                            'data'=> $data, 
							'serviceid' => $service->id,
                            'subtotal' => number_format($session['subtotal'], 2, '.', ''),
                            'total' => number_format($session['total'], 2, '.', '')
                                ]);
                        Yii::$app->end();
                        
                    }else{
                        
                        echo \yii\helpers\Json::encode(['success' => false, 'data' => $addToCard->getErrors()]);
                        Yii::$app->end();
                        
                    }
                    
                }
               
                
            }

//and st.category_id=$serviceId

	        $sql = "SELECT s.id, s.name, 
						   s.description, 
						   st.category_id as category_id, 
						   GROUP_CONCAT(DISTINCT(a_s.addon_id)) as addon_ids
                    FROM staff as s 
					JOIN staff_has_category as st on s.id=st.staff_id
					JOIN addon_has_staff as a_s on s.id=a_s.staff_id  
				    WHERE s.is_active=1 and s.merchant_id=".$session['merchant_id']."
				    group by s.id";

	        $staffsArray = Yii::$app->db->createCommand($sql)->queryAll();
	        $sql = "SELECT a.id as addon_id, a.name as addon_name, a.price as addon_price, a.time_in_minutes as addon_time 
						FROM category_has_merchant as c_m 
						JOIN merch_cat_has_addon as m on  c_m.id=m.m_c_id
						JOIN addon as a on m.addon_id=a.id
					    WHERE c_m.merchant_id=".$session['merchant_id']."
					    and c_m.id=".$serviceId."
					    GROUP by a.id 
					    ";
	        $addonArray =  Yii::$app->db->createCommand($sql)->queryAll();
	        $addonArray = array_combine(array_column($addonArray,'addon_id'), $addonArray);
	        $staffs = [];
	        foreach ($staffsArray as $staffArray) {
		        $addons = explode(',',$staffArray['addon_ids']);
		        foreach ($addons as $addon){
			        if(key_exists($addon,$addonArray)){
				        $addonArray[$addon]['img'] = "/upload/addon/flowers-on-human-feet.svg";
				        $staffArray['addons'][] = $addonArray[$addon];
			        }
		        }
		        $staffArray['img'] = "/upload/staff/".$staffArray['id'].".jpg?lastmod=".time();
		        $staffs[] = $staffArray;
	        }
//	        \yii\helpers\VarDumper::dump($staffs, 10, true);
//	        die();
            if($service->is_group == 0){
                return $this->renderAjax('service', [
                    'model' => $service,
	                'staffs' => json_encode($staffs),
                    'addToCard' => $addToCard,
                    'update' => $update,
                    'updateArray' => $updateArray,
                    'key' => $key,
                    'discount' => $discount,
                    'couponPer' => $couponPer,
		    'merchant' => $merchant
                ]);
            }else if($service->is_group == 1){
                return $this->renderAjax('service_group', [
                    'model' => $service,
	                'staffs' => json_encode($staffs),
                    'addToCard' => $addToCard,
                    'update' => $update,
                    'updateArray' => $updateArray,
                    'key' => $key,
                    'discount' => $discount,
                    'couponPer' => $couponPer,
					'merchant' => $merchant
                ]);

            }
        }
    }
   

    public function actionSearch(){

        $seo = \common\models\Seo::findOne(['type' => 2]);

        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('seo', $seo->meta_description)
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => Yii::t('seo', $seo->meta_keyword)
        ]);
	
	$type = (isset($_GET['Merchant']['type'])) ? $_GET['Merchant']['type'] : "";
        
        
        $keyword = trim($_GET['Merchant']['search']);
	
	$keyword = urldecode($keyword);
	
	$latLang = \frontend\models\MtMerchant::getLatLang($keyword);
            
            
            
	$session = Yii::$app->session;
	$session['latlang']  = $latLang;
	$session['keyword']  = $keyword;
        
        
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
                '%" or m.post_code like "%'.$keyword.'%") and m.status=1 AND m.is_activate=1 ';
        
        $serviceSql = ' LEFT JOIN category_has_merchant AS chm ON chm.merchant_id=m.merchant_id ';
        $selectCat = 'chm.category_id, ssc.id as subcatid, ssc.title , sc.id as catid, sc.title, ';
        
        $leftJoinCategory = 'LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                LEFT JOIN  mt_service_category AS sc ON sc.id=ssc.category_id';

        
	
	
	if(isset($type) && $type == 'voucher'){
		
		$serviceSql .= ' RIGHT JOIN gift_voucher AS gv ON gv.merchant_id=m.merchant_id ';  
		$leftJoinCategory = "";
		$selectCat = "";
	}else{
		$where .=' or sc.title like "%'.$keyword.'%" or ssc.title like "%'.$keyword.'%"';
	}
	
        
        $sql  = 'SELECT '.$selectCat.' m.* FROM mt_merchant AS m '.$serviceSql.$leftJoinCategory.$where.' group by m.merchant_id';
        
        $countSql =  'SELECT '.$selectCat.'count(*) FROM mt_merchant as m'.$serviceSql.$leftJoinCategory.$where;
            
        $count = Yii::$app->db->createCommand($countSql)->queryScalar();
        
//        $price = 'SELECT '.$selectCat.' max(chm.price) as maxprice,chm.merchant_id, m.merchant_id  FROM mt_merchant AS m 
//                '.$serviceSql.$leftJoinCategory.$where;
//        
//        
//        
//        $maxprice = Yii::$app->db->createCommand($price)->queryOne();
//        
//        
//        if(empty($maxprice['maxprice']))
//            $maxprice = 0;
//        else
//            $maxprice = $maxprice['maxprice'];
        
        

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => $count,
            

        ]);


        $models = $dataProvider->getModels();
        $distance = 0;
        if(count($models) == 0){
            $distance = 5;
            
            $where = ' WHERE m.gmap_latitude
                    BETWEEN p.latpoint  - (p.radius / p.distance_unit)
                        AND p.latpoint  + (p.radius / p.distance_unit)
                   AND m.gmap_altitude
                    BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
                        AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
                        
                    AND m.status=1 AND m.is_activate=1';
            
            
             
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
	    
	    $maxprice = 0;
            
            
//            $price = 'SELECT '.$selectCat.' max(chm.price) as maxprice, m.* , p.distance_unit
//                                     * DEGREES(ACOS(COS(RADIANS(p.latpoint))
//                                     * COS(RADIANS(m.gmap_latitude))
//                                     * COS(RADIANS(p.longpoint) - RADIANS(m.gmap_altitude))
//                                     + SIN(RADIANS(p.latpoint))
//                                     * SIN(RADIANS(m.gmap_latitude)))) AS distance_in_km
//                        FROM mt_merchant as m
//                        JOIN (   
//                              SELECT  '.$getLatLang["lat"].'  AS latpoint,  '.$getLatLang["long"].' AS longpoint,
//                                      '.$distance.' AS radius,      111.045 AS distance_unit
//                          ) AS p ON 1=1 '.$serviceSql.$leftJoinCategory. $where; 
//                    
//        
//        
//        
//            $maxprice = Yii::$app->db->createCommand($price)->queryOne();
//            
//            if(empty($maxprice['maxprice']))
//                $maxprice = 0;
//            else
//                $maxprice = $maxprice['maxprice'];
            
        }
        
        
        

        return $this->render('search', [
            'models' => $models,
            'dataProvider' => $dataProvider,
            //'maxprice' => $maxprice,
            'search' => $keyword,
            'distance' => $distance,
            'seo' => $seo,
	    'type' => $type
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
            
	    $type = isset($_POST['SearchMtMerchant']['type']) ? $_POST['SearchMtMerchant']['type'] : "";
	    
	    
            $keyword = urldecode($keyword);
	
		$latLang = \frontend\models\MtMerchant::getLatLang($keyword);
		
		$session = Yii::$app->session;
		$session['latlang']  = $latLang;
		$session['keyword']  = $keyword;
            
            
            
            if(empty($session['latlang'])){
                $latLang = \frontend\models\MtMerchant::getLatLang($keyword);
                $session['latlang']  = $latLang;
            }
            
            $getLatLang = $session['latlang'];
            
            $where = "";
            $selectCat = "";
            $order = "";
            $having = "";
            if(empty($distance) ){
                $where .= ' WHERE (m.street like "%'.$keyword.'%" or m.city like "%'.$keyword.
                        '%" or m.address like "%'.$keyword.
                        '%" or m.post_code like "%'.$keyword.'%") AND m.status=1 AND m.is_activate=1';
            }else if ($distance != 0){
                $where .= ' WHERE m.gmap_latitude
                               BETWEEN p.latpoint  - (p.radius / p.distance_unit)
                                   AND p.latpoint  + (p.radius / p.distance_unit)
                              AND m.gmap_altitude
                               BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
                                   AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
                                   AND m.status=1 AND m.is_activate=1';
            }
                
            
                
            $serviceSql = "";    
            $ratingSql = "";    
            $leftJoinCategory = "";
            $serviceSql = ' LEFT JOIN category_has_merchant AS chm ON chm.merchant_id=m.merchant_id ';
	    
	    
            if(!empty($category) && !empty($category[0])){
                
                $selectCat = 'chm.category_id, ssc.id as subcatid , sc.id as catid,';
                $implodeCat = implode(',', $category);
		
                $leftJoinCategory = ' 
                        LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                        LEFT JOIN  mt_service_category AS sc ON sc.id=ssc.category_id
                        ';
                
                $where .=' AND sc.id IN ('.$implodeCat.')';
            }
            
            if(!empty($subCategory)){
                $serviceSql = ' LEFT JOIN category_has_merchant AS chm ON chm.merchant_id=m.merchant_id ';
                
                $selectCat = 'chm.category_id, ssc.id as subcatid , sc.id as catid,';
                
                $implodeSubCat = implode(',', $subCategory);
                $leftJoinCategory = ' 
                        LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                        LEFT JOIN  mt_service_category AS sc ON sc.id=ssc.category_id
                        ';
                
                $where .=' AND chm.category_id IN ('.$implodeSubCat.')';    
            }
            
               
                
            if(!empty($rating)){
                //$serviceSql = "";
                $selectCat .= 'mr.merchant_id, ceil(AVG(mr.rating)) AS ratings, ';
                $implodeRating = implode(',', $rating);
                $ratingSql = ' LEFT JOIN mt_review as mr ON mr.merchant_id=m.merchant_id';
                $having .=' HAVING ratings IN ('.$implodeRating.')';
            } 
            
            if(!empty($ranking)){
                
                $selectCat .= 'mr.merchant_id, ceil(AVG(mr.rating)) AS ratings, ';
                $ratingSql = ' LEFT JOIN mt_review as mr ON mr.merchant_id=m.merchant_id';
                
                $order = '  ORDER BY ratings '.$ranking;
                
            }
            $datesql = "";
            if(!empty($date)){
//                $selectCat .= 'so.merchant_id, DATE(order_time) AS order_time, ';
//                $datesql = ' LEFT JOIN `order` as so ON so.merchant_id=m.merchant_id';
//                $where .= ' AND so.staff_id is NULL and so.order_time like "%'.$date.'%"';
                
                $timestamp = strtotime($date);

                $day = date('D', $timestamp);
                
                $day = strtolower($day);
                $selectCat .= "msh.merchant_id, msh.$day, msh.id, ";
                //$datesql = ' RIGHT JOIN `merchant_schedule_history` as msh ON msh.merchant_id=m.merchant_id';
                $datesql = " LEFT JOIN ( SELECT id, merchant_id,$day  FROM merchant_schedule_history order by id desc) as  msh ON msh.merchant_id=m.merchant_id";
                
                $where .= " AND msh.$day IS NOT NULL";
                //$order .= ' msh.id desc';
                //exit;
            }   
            
            
//            if(!empty($getLatLang ) && !empty($distance) && $distance != 0){
//                $priceSql = 'SELECT '.$selectCat.' max(chm.price) as maxprice, m.* , p.distance_unit
//                                     * DEGREES(ACOS(COS(RADIANS(p.latpoint))
//                                     * COS(RADIANS(m.gmap_latitude))
//                                     * COS(RADIANS(p.longpoint) - RADIANS(m.gmap_altitude))
//                                     + SIN(RADIANS(p.latpoint))
//                                     * SIN(RADIANS(m.gmap_latitude)))) AS distance_in_km
//                        FROM mt_merchant as m
//                        JOIN (   
//                              SELECT  '.$getLatLang["lat"].'  AS latpoint,  '.$getLatLang["long"].' AS longpoint,
//                                            '.$distance.' AS radius,      111.045 AS distance_unit
//                                ) AS p ON 1=1 '.$serviceSql.$leftJoinCategory.$ratingSql.$datesql. $where; 
//
//
//
//
//                $maxprice = Yii::$app->db->createCommand($priceSql)->queryOne();
//
//                if(empty($maxprice['maxprice']))
//                    $maxprice = 0;
//                else
//                    $maxprice = $maxprice['maxprice'];
//                
//                //$price = "0;".$maxprice;
//                
//                
//            }else{
//            
//                $priceSql = 'SELECT '.$selectCat.' max(chm.price) as maxprice,chm.merchant_id, m.merchant_id  FROM mt_merchant AS m 
//                '.$serviceSql.$leftJoinCategory.$ratingSql.$datesql. $where;
//                
//                $maxprice = Yii::$app->db->createCommand($priceSql)->queryOne();
//
//                if(empty($maxprice['maxprice']))
//                    $maxprice = 0;
//                else
//                    $maxprice = $maxprice['maxprice'];
//                
//                //$price = "0;".$maxprice;
//                
//                //echo $maxprice;
//            }
            
            if(!empty($price)){
                $serviceSql = ' LEFT JOIN category_has_merchant AS chm ON chm.merchant_id=m.merchant_id ';
                
                $explodePrice = explode(';', $price);
		
		if($explodePrice[0] !=0 && $explodePrice[1] != 0){
                
                
			$selectCat .= 'chm.price, ';
			if( $explodePrice[1] !=0 )
			$where .=' AND chm.price between '.$explodePrice[0]. ' and '.$explodePrice[1];
		}
                
                //$maxprice = $explodePrice[1];
                
            }
	    
		$voucherSql = "";
		$selectVoucher = "";
	    
		if(isset($type) && $type == 'voucher'){
			$selectVoucher = ' gv.*, ';
			$voucherSql = ' RIGHT JOIN gift_voucher AS gv ON gv.merchant_id=m.merchant_id '; 
			 
			
//			if(!empty($category)){
//				//$selectCat .= ' chm.id, ';
//				
//				$voucherSql .= ' RIGHT JOIN gift_voucher_services AS gvs ON  chm.id = gvs.category_has_merchant_id';
//				//$where .= ' AND (chm.id=gv.service  or gv.services like "%chm.id%")'; 
//			}
		}
            
            
            
            
            
            $sql = 'SELECT  '.$selectVoucher.$selectCat.'m.* FROM mt_merchant as m'.$serviceSql.$voucherSql.$leftJoinCategory.$ratingSql.$datesql. $where. ' group by m.merchant_id'.$having.$order;
           
	    //ECHO $sql;
	    
	    
            if(!empty($getLatLang ) && !empty($distance) && $distance != 0){
            
                $sql = 'SELECT '.$selectVoucher.$selectCat.'m.* , p.distance_unit
                                     * DEGREES(ACOS(COS(RADIANS(p.latpoint))
                                     * COS(RADIANS(m.gmap_latitude))
                                     * COS(RADIANS(p.longpoint) - RADIANS(m.gmap_altitude))
                                     + SIN(RADIANS(p.latpoint))
                                     * SIN(RADIANS(m.gmap_latitude)))) AS distance_in_km
                        FROM mt_merchant as m
                        JOIN (   
                              SELECT  '.$getLatLang["lat"].'  AS latpoint,  '.$getLatLang["long"].' AS longpoint,
                                      '.$distance.' AS radius,      111.045 AS distance_unit
                          ) AS p ON 1=1 '.$serviceSql.$voucherSql.$leftJoinCategory.$ratingSql.$datesql. $where. ' group by m.merchant_id'.$having.$order;
            
                
                
                
            }
            
            //echo $sql;EXIT;
            
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
                $html =  $this->renderAjax('searchview_grid', [
                    'models' => $models,
                    'dataProvider' => $dataProvider,
		    'type' => $type
                ]);
                
                echo json_encode(['price' => $maxprice, 'html' => $html]);
                Yii::$app->end();
                
            }else{
                $html =  $this->renderAjax('searchview', [
                    'models' => $models,
                    'dataProvider' => $dataProvider,
		    'type' => $type
                ]);
                
                echo json_encode(['price' => $maxprice, 'html' => $html]);
                Yii::$app->end();
            }
            
        }else{
		
		$maxprice = 0;
            
//            $price = 'SELECT '.$selectCat.' max(chm.price) as maxprice,chm.merchant_id, m.merchant_id  FROM mt_merchant AS m 
//                '.$serviceSql.$leftJoinCategory.$where;
//        
//            $maxprice = Yii::$app->db->createCommand($price)->queryScalar();
//            
//            
//            if(!$maxprice){
//                $maxprice = 0;
//            }
            
            
            
            return $this->render('search', [
                'models' => $models,
                'dataProvider' => $dataProvider,
                'maxprice' => $maxprice,
                'search' => $keyword,
                'distance' => 0,
                'category' => $category,
		'type' => $type
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
//    public function actionIndex()
//    {
//        $dataProvider = new ActiveDataProvider([
//            'query' => MtMerchant::find(),
//        ]);
//
//        return $this->render('index', [
//            'dataProvider' => $dataProvider,
//        ]);
//    }
    
    public function actionSignUp(){
        $seo = \common\models\Seo::findOne(['type' => 4]);
        
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('seo', $seo->meta_description)
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => Yii::t('seo', $seo->meta_keyword)
        ]);
        return $this->render('sign-up', [
            'seo' => $seo
        ]);
        
    }

    /**
     * Displays a single MtMerchant model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $merchantId = $id;
        $explode = explode('-', $id);
        $id = $explode[count($explode) - 1];

		$model = MtMerchant::findOne(['slug' => $merchantId]);

		if(is_numeric($id) && count($model) == 0){
			$model = $this->findModel($id);
		}else{
			
			$id = $model->id;
		}
		
        $session = Yii::$app->session;
		
		if($session['merchant_id'] != $id){
			$session['cart'] = NULL;
		}
        
        $appointment = new \frontend\models\Appointment();
        $review = new \frontend\models\MtReview();
        $session['merchant_id'] = $id;

	if(!$model::hasServices($model->id) && $model::hasVoucher($model->id)){
		
		return $this->redirect(['gift-voucher', 'id' => $merchantId]);
		
	}
        
        if($appointment->load(Yii::$app->request->post())){
            
            
            
            
            
            if(!isset($session['cart']) || count(array_filter($session['cart'])) == 0){
                $appointment->addError('order', 'Please add at least one service to cart');
            }else if($appointment->validate()){
                if(Yii::$app->user->id){
                    $this->redirect(['checkout/payment']); 
                }else{
                    $this->redirect(['checkout/index']);
                }
                
            }
            
        }
        
        \Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => Yii::t('custompage',  MtMerchant::getSeo($model, $model->seo_description))
        ]);
        
        \Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => Yii::t('custompage', MtMerchant::getSeo($model, $model->seo_keywords))
        ]);


        return $this->render('view', [
            'model' => $model,
            'appointment' => $appointment,
            'review' =>$review,
            
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
    
    public function actionPaypalIpn(){
        Yii::$app->controller->enableCsrfValidation = false;
        $paypal = new \frontend\components\Paypal();
        $paypal->merchantIpn();
    }
    
    public function actionFinalPayment(){
        if(Yii::$app->request->isAjax){
            
            if(isset($_POST['paymentType'])){
                $paymentType = $_POST['paymentType'];
                
                
                $creditCardId = (isset($_POST['creditCard'])) ? $_POST['creditCard'] : "";
                
                $session = Yii::$app->session;
                
                //print_r($session['merchant']);
                if(!empty($session['merchant'])){
                    
                    $merchant = MtMerchant::findOne(['contact_email' => $session['merchant']['contact_email'],
                        ]);
                    
                    if(count($merchant) == 0){
                        $merchant = new MtMerchant;
                    }
                    
                    $merchant->attributes = $session['merchant'];
                    
                    
                    
                    $merchant->setPassword($merchant->password);
                    $merchant->payment_steps = $paymentType;
                    $merchant->ip_address = $_SERVER['REMOTE_ADDR'];
                    $merchant->generateAuthKey();
                    $merchant->free_delivery = 0;
                    $merchant->status = ($paymentType == 2) ? 0: 1;
                    $merchant->date_created = new Expression('NOW()');
                    $merchant->membership_expired = date('Y-m-d', strtotime("+1 years", strtotime(date('Y-m-d'))));
                    
                    
                    $seoRule = \common\models\SeoRule::findOne(['type' =>1]);
                    $merchant->is_manual_seorule = 1;
                    $merchant->seo_rule_id = $seoRule->id;
                    $merchant->seo_description = $seoRule->meta_description;
                    $merchant->seo_title = $seoRule->meta_title;
                    $merchant->seo_keywords = $seoRule->meta_keyword;
                    
                    
                    if($merchant->save(false)){
                        
                        if($paymentType == 2){
                            
                            $merchantPackageOrder = \common\models\MerchantPackageOrder::findOne(['merchant_id' => $merchant->id, 'package_id' => $merchant->package_id]);
                
                            if(count($merchantPackageOrder) == 0)
                            $merchantPackageOrder = new \common\models\MerchantPackageOrder;
                            

                            $merchantPackageOrder->merchant_id = $merchant->merchant_id;
                            $merchantPackageOrder->package_id = $merchant->package_id;
                            $merchantPackageOrder->payment_status = 'pending';
                            
                            $merchantPackageOrder->payment_type = 2;
                            $merchantPackageOrder->save(false);
                            
                            $post = \frontend\components\Paypal::merchantPost($merchant);

                            
                            echo Json::encode(['success' => true,
                                'url' => 'https://www.sandbox.paypal.com/cgi-bin/webscr?'.$post, 
                                ]);
                            Yii::$app->end();


                        }
                        
                        \frontend\components\EmailManager::merchantRegistration($merchant);
                        
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
        if (($model = MtMerchant::findOne(['merchant_id' => $id, 'status'=>1])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public static function actionCreateReview(){

       $model = new MtReview();
        
        $session = Yii::$app->session;
        
        if($session['merchant']){
            $model->attributes = $session['review'];
            $model->merchant_id = $session['id'];
            $model->client_id =Yii::$app->user->id;
            $model->date_created =strtotime('Now');

	        $merchant = \common\models\Merchant::findOne(['merchant_id' => $model->$session['id']]);
	        $clientLoyalityPoint = \frontend\models\ClientLoyalityPoints::findOne(['client_id' => Yii::$app->user->id, 'merchant_id' => $session['id']]);

	        $loyalityPoints = $merchant->getLoyaltyPoints()->all();

	        if ( $loyalityPoints ) {

		        if ( $loyalityPoints['count_on_comment'] ) {
			        $loyalitypoint = \frontend\models\Option::getValByName('website_loyalty_points');
			        $loyalitypoint = $loyalitypoint?$loyalitypoint:1;
			        $clientLoyalityPoint->points += $loyalityPoints['count_on_comment'] * $loyalityPoints;
			        $clientLoyalityPoint->save(false);
			        $minimumLoyaltyPoints = \common\models\Option::getValByName('minimum_loyalty_points');

			        if ( $clientLoyalityPoint->points >= $minimumLoyaltyPoints ) {
				        EmailManager::customerLoyaltyPoints($model, $clientLoyalityPoint);

			        }
		        }
	        }
        }



	    return $this->render('create', [
            'model' => $model,
            
        ]);
        
    
    } 
}
