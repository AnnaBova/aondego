<?php
namespace frontend\controllers;


use Yii;
use yii\web\Controller;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class CheckoutController extends Controller{
    
    
    public function actionIndex(){
        $session = Yii::$app->session;
        $client = new \frontend\models\Client();
        $client->scenario = 'checkout';
        
        if(!empty($session['client'])){
            $client->attributes = $session['client'];
        }
        
        if($client->load(Yii::$app->request->post())){
            
            if($client->validate()){
                
                
                $session['client'] = $client->attributes;
                
                echo \yii\helpers\Json::encode(['success' => true, 'data' => Yii::$app->urlManager->createUrl('checkout/payment')]);
                Yii::$app->end();
                
                
            }else{
                echo \yii\helpers\Json::encode(['success' => false, 'data' => $client->getErrors()]);
                Yii::$app->end();
            }
            
        }
        
        return $this->render('index', [
            'client' => $client
        ]);
    }
    
    
    public function actionPayment(){
        
        if(isset($_POST['payment_method']) && !empty($_POST['payment_method'])){
            $session = Yii::$app->session;
            
            $session['payment_method'] = $_POST['payment_method'];
            
            echo \yii\helpers\Json::encode(['success' => true, 'data' => Yii::$app->urlManager->createUrl('checkout/finish')]);
            Yii::$app->end();
            
        }
        return $this->render('payment');
    }
    
    public function actionFinish(){
        
        $session = Yii::$app->session;
        if(!empty($session['client'])){
            $orders = $session['cart'];
            $subtotal = $session['subtotal'];
            $total = $session['total'];
            $couponPer = $session['couponPer'];
            $discount = $session['discount'];
            
            
            $client = \frontend\models\Client::find()->where(['email_address' => trim($session['client']['email_address'])])->one();
            
            if(count($client) == 0){
                $client = new \frontend\models\Client;
                $client->attributes = $session['client'];
                $client->setPassword($client->email_address);
                $client->generateAuthKey();
                $client->save(false);
            }
            
            
            foreach($session['cart'] as $key=>$value){
                
                foreach($value as $k=>$v){
                    $model = new \frontend\models\Order;
                    $model->attributes = $v;
                    $model->payment_type = $session['payment_method'];
                    $model->client_id = $client->client_id;

                    if($v['is_group'] == 0){
                    //print_r($v['is_group']);
                        $model->order_time = $v['order_date'] . ' ' . $v['free_time_list'];
                    }else if($v['is_group'] == 1){
                        $model->order_time = $v['order_date'] . ' ' . $v['time_req'];
                    }
                    $model->category_id = $key;
                    $model->client_name = $client->first_name;
                    $model->client_email = $client->email_address;
                    $model->client_phone = $client->contact_phone;
                    
                    
                    
                    if($model->save(false)){
                        if(isset($v['addons_list'])){
                            foreach($v['addons_list'] as $val){
                                $m = \frontend\models\Addons::findOne(['id'=>$val]);
                                $model->price += $m->price;
                                $addonHasOrder = new \frontend\models\AddonHasOrder;
                                $addonHasOrder->addon_id = $val;
                                $addonHasOrder->order_id = $model->id;
                                $addonHasOrder->save(false);
                            }
                        }
                        
                        $commission = $model::getCommision($model->merchant_id, $model->price);

                        $model->total_commission = $commission['total_commision'];
                        $model->merchant_earnings = $commission['merchant_earnings'];
                        $model->percent_commision = $commission['percent_commision'];

                        if(isset($session['couponid'])){
                            $model->voucher_id = $session['couponid'];
                        }
                        $model->save(false);
                    }
                        
                        
                    
                   
                }

                
            }
            
            $session['cart'] = NULL;
            $session['subtotal'] = NULL;
            $session['total'] = NULL;
            $session['couponPer'] = NULL;
            $session['discount'] = NULL;
            
            
            
        }
        
        
        return $this->render('finish', ['orders' => $orders,
            'subtotal' => $subtotal,
            'total' => $total,
            'couponPer' => $couponPer,
            'discount' => $discount
            
                ]);
    }
}

