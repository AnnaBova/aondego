<?php

namespace console\controllers;
use yii\console\Controller;
use Yii;

Class BirthdayController extends Controller
{
    
    public function init() {
        parent::init();
        $client = \frontend\models\Client::find()->one();
        Yii::$app->user->setIdentity(\frontend\models\Client::findOne(['client_id'=>$client->client_id]));
    }
    
    public function actionMembershipExpiration(){
        $today = date('Y-m-d');
        $sql = 'SELECT *, DATEDIFF(membership_expired, "'.$today.'") AS DiffDate FROM `mt_merchant` having DiffDate = 7';
        
        $merchants = Yii::$app->db->createCommand($sql)->queryAll();
        
//        echo '<pre>';
//        print_r($merchants);
//        echo '</pre>';
//        exit;
        
        foreach ($merchants as $merchant){
            
            
            
            if(!empty($merchant['membership_expired'])){
                
                //print_r($merchant['contact_email']);
            
               
                    \frontend\components\EmailManager::membershipExpired($merchant);
                    
                
                
            }
            
        }
    }
    
    public function actionLoyaltyExpire(){
        //echo 'i ma here';
        $orders = \frontend\models\Order::find()->where(['status' => 0])->groupBy('client_id')->all();
        
        foreach ($orders as $order){
            
            
            if(!empty($order->client_id)){
                $today = date('Y-m-d');
                $sql = 'SELECT DATEDIFF("'.$today.'", create_time) AS DiffDate, create_time, client_id, merchant_id FROM `order` where client_id='.$order->client_id.' having DiffDate = 365 order by id desc ';
                $query = Yii::$app->db->createCommand($sql)->queryOne();
                
//                echo '<pre>';
//                print_r($query);
                
                if($query){
                    
                    $clientLoyaltyPoints = \frontend\models\ClientLoyalityPoints::findOne([
                        'client_id' => $query['client_id'],
                        'merchant_id' => $query['merchant_id']]);
                    
                    //$clientLoyaltyPoints->points = 0;
                    if($clientLoyaltyPoints->save()){
                        
                        \frontend\components\EmailManager::loyaltyExpire($query, $clientLoyaltyPoints);
                    }
                    
                }
                
                
            }
            
            
            
        }
    }
    
    public function actionAppointment(){
        
        
        $orders = \common\models\Order::find()
                ->where(['status' => 0])
                //->where('(order_time >= "'.date('Y-m-d 00:00:00').'" and order_time <="'.date('Y-m-d 23:59:59').'") and status=0')
                ->all();
                
        foreach ($orders as $data){
            $offset = 5 * 60 * 60;
            $today = date('Y-m-d H:i:s', time() + $offset);
            
            //echo $data->order_time;
            $t1 = strtotime ( $today );
            $t2 = strtotime ( $data->order_time );
            $diff = $t2 - $t1;
            $hours = $diff / ( 60 * 60 );
            
            
            
            if(floor($hours) == 24){
                
                \frontend\components\EmailManager::appointmentRemider($data);
                
            }
        } 
        
        
    }
    
    
    public function actionIndex(){
        
        //$sql = "SELECT *, MONTH(dob) as mondob, DAY(dob) as daydob FROM mt_client having mondob=".date('m')." and daydob=".date('d');
		$sql = "SELECT * FROM mt_client where dob='".date('d')."/".date('m')."' and status=1";
        $query = Yii::$app->db->createCommand($sql)->queryAll();
       
        
        
        foreach ($query as $user){
            
            
            
            $coupons = \common\models\Voucher::find()
                    ->where(['status' => 1, 'type' => 2])
                    ->andWhere(['>', 'expiration', date('Y-m-d')])
                    ->all();
            
            foreach ($coupons as $coupon){
                $userBirthdayCoupon = \common\models\UserBirthdayCoupon::findOne(['merchant_id'=>$coupon->merchant_id, 'year' => date('Y'), 'user_id' => $user['client_id'] ]);
                
                
                if(count($userBirthdayCoupon) == 0) $userBirthdayCoupon = new \common\models\UserBirthdayCoupon;
                
                $userBirthdayCoupon->merchant_id = $coupon->merchant_id;
                $userBirthdayCoupon->user_id = $user['client_id'];
                $userBirthdayCoupon->voucher_id = $coupon->voucher_id;
                $userBirthdayCoupon->code = 'Birthday'.date('Y');
                $userBirthdayCoupon->year = date('Y');
                if($userBirthdayCoupon->save(false)){
                    \frontend\components\EmailManager::birthday($user, $coupon, $userBirthdayCoupon);
                }
               
            }
            
            
        }
        
    }
}