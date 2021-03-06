<?php
namespace frontend\controllers;

use frontend\components\EmailManager;
use frontend\models\AddonHasOrder;
use frontend\models\Addons;
use frontend\models\Client;
use frontend\models\LoginForm;
use frontend\models\Order;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class CheckoutController extends Controller{
    
	public $enableCsrfValidation = false;
    
    
        public function behaviors()
	{
		return [
		    'access' => [
			'class' => AccessControl::className(),
			
			'rules' => [
			    [
				'actions' => [
				    'voucher',
				    'index',
				    'verification',
				    'widget-verification',
				    'widget-index',
				    'paypal-ipn',
				    'voucher-paypal-ipn',
				    'voucher-verification'
				    ],
				'allow' => true,
				'roles' => ['?'],
			    ],
			    [
				'actions' => [
				    'voucher-payment',
				    'voucher-finish',
				    'check-loyalty',
				    'payment', 
				    'widget-payment',
				    'widget-finish',
				    'finish'
				    ],
				'allow' => true,
				'roles' => ['@'],
			    ],
			],
		    ],
		    
		];
	}
    
    public function beforeAction($event)
    {
        $this->enableCsrfValidation = false;
        $cookies = Yii::$app->request->cookies;
        
        $languageCookie = $cookies['language'];
        
        if(isset($languageCookie->value) && !empty($languageCookie->value)){
            Yii::$app->language = $languageCookie->value;
        }
        
        
        
        return parent::beforeAction($event);
    }
    
    public function actionCheckLoyalty(){
        if(Yii::$app->request->isAjax){
            if(isset($_POST)){
                $minimum = $_POST['minimum'];
                $clientLoyalty = $_POST['clientloyalty'];
                $points = $_POST['points'];
                
                $session = Yii::$app->session;
                
                $loyaltyPointsOne = \common\models\Option::getValByName('website_loyalty_points');
                
                if($points <= $clientLoyalty && $points >= $minimum){
                    
                    $session['loyalty'] = $points;
                    $amount = $points * $loyaltyPointsOne;
                    
                    $subtotal = $session['subtotal'] - $amount;
                    $total = ($session['total'] - $session['discount'])  - $amount;
                    
                    $subtotal = number_format($subtotal, 2, '.', '');
                    $total = number_format($total, 2, '.', '');
                    
                    echo json_encode(['success' => true, 'subtotal' => $subtotal, 'total'=> $total]);
                    Yii::$app->end();
                    
                }else{
                    echo json_encode(['success' => false, 
                        'msg' => Yii::t('basicfield', 'Loyalty points should be greater than {count1} and less than {count2}', ['count1' => $minimum, 'count2' => $clientLoyalty])]);
                    Yii::$app->end();
                    
                }
            }
            //print_r($_POST);
        }
        
    }
    
    public function actionVerification(){
        
        $login = new LoginForm;
        $client = new Client;
        $client->scenario = 'activation';
        
        if($login->load(Yii::$app->request->post())){
            if($login->login()){
                $this->redirect(['checkout/payment']);
            }
            
        }
        
        if($client->load(Yii::$app->request->post())){
            if($client->validate()){
                $checkClient = Client::findOne(['activation_key' => trim($client->activation_key)]);
                
                if(count($checkClient) == 1){
                    $checkClient->status = 1;
                    $checkClient->save(false);
                    
                    $login = new LoginForm;
                    $login->email = $checkClient->email_address;
                    $login->password = $checkClient->password;
                    //$error = ActiveForm::validate($login);
                    
                    
                    if($login->login()){
                    
                        $this->redirect(['payment']);
                    }
                }else{
                    $client->addError('activation_key', 'Wrong activation key.');
                }
                
                
            }
            
        }
        
        return $this->render('verification',[
            'login' => $login, 
            'client' => $client
        ]);
        
    }
    
	public function actionVoucherVerification(){
        
        $login = new LoginForm;
        $client = new Client;
        $client->scenario = 'activation';
        
        if($login->load(Yii::$app->request->post())){
            if($login->login()){
                $this->redirect(['checkout/voucher-payment']);
            }
            
        }
        
        if($client->load(Yii::$app->request->post())){
            if($client->validate()){
                $checkClient = Client::findOne(['activation_key' => trim($client->activation_key)]);
                
                if(count($checkClient) == 1){
                    $checkClient->status = 1;
                    $checkClient->save(false);
                    
                    $login = new LoginForm;
                    $login->email = $checkClient->email_address;
                    $login->password = $checkClient->password;
                    //$error = ActiveForm::validate($login);
                    
                    
                    if($login->login()){
                    
                        $this->redirect(['voucher-payment']);
                    }
                }else{
                    $client->addError('activation_key', 'Wrong activation key.');
                }
                
                
            }
            
        }
        
        return $this->render('voucher-verification',[
            'login' => $login, 
            'client' => $client
        ]);
        
    }
    
    
    public function actionWidgetVerification(){
        
        $login = new LoginForm;
        $client = new Client;
        $client->scenario = 'activation';
        
        $this->layout = 'widget-layout';
        
        if($login->load(Yii::$app->request->post())){
            if($login->login()){
                $this->redirect(['checkout/widget-payment']);
            }
            
        }
        
        if($client->load(Yii::$app->request->post())){
            if($client->validate()){
                $checkClient = Client::findOne(['activation_key' => trim($client->activation_key)]);
                
                if(count($checkClient) == 1){
                    $checkClient->status = 1;
                    $checkClient->save(false);
                    
                    $login = new LoginForm;
                    $login->email = $checkClient->email_address;
                    $login->password = $checkClient->password;
                    //$error = ActiveForm::validate($login);
                    
                    
                    if($login->login()){
                    
                        $this->redirect(['widget-payment']);
                    }
                }else{
                    $client->addError('activation_key', 'Wrong activation key.');
                }
                
                
            }
            
        }
        
        return $this->render('widget-verification',[
            'login' => $login, 
            'client' => $client
        ]);
        
    }
    
    public function actionIndex(){
        $session = Yii::$app->session;
        $login = new LoginForm;
        $client = new Client();
        $client->scenario = 'checkout';
        
        if(empty($session['cart']) || count(array_filter($session['cart'])) == 0){
            
            return $this->goHome();
            
        }
        
        if(!empty($session['client'])){
            $client->attributes = $session['client'];
        }
        
        if($client->load(Yii::$app->request->post())){
            
            if($client->validate()){
                
                
                $session['client'] = $client->attributes;
                
                $client = Client::find()->where(['email_address' => trim($session['client']['email_address'])])->one();
                
                if(count($client) == 0 ){
                        $password = Yii::$app->getSecurity()->generateRandomString(6);
                        $client = new Client;
                        $client->attributes = $session['client'];

                        $client->password = $password;
                        $client->setPassword($password);
                        $client->generateAuthKey();
                        $client->status = 0;
                        $client->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
                        $client->dob = date('Y-m-d', strtotime($session['client']['dob']));
                        
//                        print_r(Yii::$app->request->userIP);
//                        exit;
                        
//                        $email = EmailManager::customerAccountActivate($client);
//                        
//                        exit;
        
                        if($client->save(false)){
                            $addressBook  = new \frontend\models\MtAddressBook;
                            $addressBook->attributes = $session['client'];
                            $addressBook->client_id = $client->id;
                            $addressBook->ip_address = Yii::$app->request->userIP;
                            $addressBook->save(false);
                            
                            $email = EmailManager::customerAccountActivate($client);
                            $url = Yii::$app->urlManager->createUrl('checkout/verification');
                            
                        }
                    
                    
                    
                }else if(empty($client->password)){
                    
                    $client->password = $session['client']['email_address'];
                    $client->setPassword($session['client']['email_address']);
                    $client->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
                    $client->status = 0;
                    $client->save(false);
                    $email = EmailManager::customerAccountActivate($client);
                    $url = Yii::$app->urlManager->createUrl('checkout/verification');
                    
                }else if($client->status == 0){
                    $client->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
                    $client->save(false);
                    $email = EmailManager::customerAccountActivate($client);
                    $url = Yii::$app->urlManager->createUrl('checkout/verification');
                }else{
                    $login = new LoginForm;
                    $login->email = $client->email_address;
                    $login->password = $client->password;
                    //$error = ActiveForm::validate($login);
                    
                    
                    $login->login();
                    $url = Yii::$app->urlManager->createUrl('checkout/payment');
                }
                
                
                
                
                
                echo Json::encode(['success' => true, 'data' => $url]);
                Yii::$app->end();
                
                
            }else{
                echo Json::encode(['success' => false, 'data' => $client->getErrors()]);
                Yii::$app->end();
            }
            
        }
        
        if($login->load(Yii::$app->request->post())){
            if($login->login()){
                $this->redirect(['checkout/payment']);
            }
            
        }
        
        return $this->render('index', [
            'client' => $client,
            'login' => $login
        ]);
    }
    
    
	public function actionVoucher(){
	    $session = Yii::$app->session;
	    $login = new LoginForm;
	    $client = new Client();
	    $client->scenario = 'checkout';


	    if(empty($session['Vouchercart']) || count(array_filter($session['Vouchercart'])) == 0){

		return $this->goHome();

	    }

	    if(!empty($session['client'])){
		$client->attributes = $session['client'];
	    }

	    if($client->load(Yii::$app->request->post())){

		if($client->validate()){


		    $session['client'] = $client->attributes;

		    $client = Client::find()->where(['email_address' => trim($session['client']['email_address'])])->one();

		    if(count($client) == 0 ){
			    $password = Yii::$app->getSecurity()->generateRandomString(6);
			    $client = new Client;
			    $client->attributes = $session['client'];

			    $client->password = $password;
			    $client->setPassword($password);
			    $client->generateAuthKey();
			    $client->status = 0;
			    $client->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
			    $client->dob = date('Y-m-d', strtotime($session['client']['dob']));

    //                        print_r(Yii::$app->request->userIP);
    //                        exit;

    //                        $email = EmailManager::customerAccountActivate($client);
    //                        
    //                        exit;

			    if($client->save(false)){
				$addressBook  = new \frontend\models\MtAddressBook;
				$addressBook->attributes = $session['client'];
				$addressBook->client_id = $client->id;
				$addressBook->ip_address = Yii::$app->request->userIP;
				$addressBook->save(false);

				$email = EmailManager::customerAccountActivate($client);
				$url = Yii::$app->urlManager->createUrl('checkout/voucher-verification');

			    }



		    }else if(empty($client->password)){

			$client->password = $session['client']['email_address'];
			$client->setPassword($session['client']['email_address']);
			$client->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
			$client->status = 0;
			$client->save(false);
			$email = EmailManager::customerAccountActivate($client);
			$url = Yii::$app->urlManager->createUrl('checkout/voucher-verification');

		    }else if($client->status == 0){
			$client->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
			$client->save(false);
			$email = EmailManager::customerAccountActivate($client);
			$url = Yii::$app->urlManager->createUrl('checkout/voucher-verification');
		    }else{
			$login = new LoginForm;
			$login->email = $client->email_address;
			$login->password = $client->password;
			//$error = ActiveForm::validate($login);


			$login->login();
			$url = Yii::$app->urlManager->createUrl('checkout/voucher-payment');
		    }





		    echo Json::encode(['success' => true, 'data' => $url]);
		    Yii::$app->end();


		}else{
		    echo Json::encode(['success' => false, 'data' => $client->getErrors()]);
		    Yii::$app->end();
		}

	    }

	    if($login->load(Yii::$app->request->post())){
		if($login->login()){
		    $this->redirect(['checkout/voucher-payment']);
		}

	    }

	    return $this->render('voucher', [
		'client' => $client,
		'login' => $login
	    ]);
	}
	
	
	public function actionVoucherPayment(){

		$addressBilling = new \frontend\models\BillingAddress();
		
		
		$addressShipping = new \frontend\models\ShippingAddress();
		
		
		$addToCart = new \frontend\models\AddToCart;
		$addToCart->scenario = 'giftvoucher';
		
			
		if(Yii::$app->request->isAjax){

			$addToCart->load(Yii::$app->request->post());
			
			
			if($addToCart->validate()){
				
				$session = Yii::$app->session;
				

				
				if(!empty($session['Vouchercart'])){

					if($addToCart->deliveryOption == 2){

						$addressShipping->load(Yii::$app->request->post());

						if($addressShipping->validate()){

							$street     = $addressShipping->street;
							$city       = $addressShipping->city;
							$zipcode    = $addressShipping->zipcode;
							$first_name = $addressShipping->first_name;
							$last_name  = $addressShipping->last_name;

							$sameAddressClient = '';
							if ( $street && $city && $zipcode && $first_name && $last_name) {
								$sameAddressClient = \frontend\models\MtAddressBook::findOne([
									'client_id' => Yii::$app->user->id,
									'street'    => $street,
									'city'      => $city,
									'zipcode'   => $zipcode,
									'first_name'=> $first_name,
									'last_name' => $last_name,
								]);
							}

							if (!$sameAddressClient) {
								$address = new \frontend\models\MtAddressBook;
								$address->attributes = $addressShipping->attributes;
								$address->client_id = Yii::$app->user->id;
								$address->ip_address = Yii::$app->request->userIP;
								$address->as_default = 2;
								$address->save();
								$addressId = $address->id;
							} else {
								$addressId = $sameAddressClient->id;
							}


						}else{
							echo Json::encode(['success' => false, 'message' => $addressShipping->errors]);
							Yii::$app->end();

						}

					}else if($addToCart->deliveryOption == 1){
						$addressClient = \frontend\models\MtAddressBook::findOne(['client_id' => Yii::$app->user->id, 'as_default' => 1]);
						
						if(count($addressClient) == 0){
							
							$addressBilling->load(Yii::$app->request->post());
							
							if($addressBilling->validate()){
								$address = new \frontend\models\MtAddressBook;
								$address->attributes = $addressBilling->attributes;
								$address->client_id = Yii::$app->user->id;
								$address->as_default = 1;	
								$address->save();
								$addressId = $address->id;

							}else{
								echo Json::encode(['success' => false, 'message' => $addressBilling->errors]);
								Yii::$app->end();

							}
							
						}else{
							
							if(isset($_POST['BillingAddress'])){
								$addressBilling->load(Yii::$app->request->post());

								if($addressBilling->validate()){

									$addressClient->attributes = $addressBilling->attributes;
									$addressClient->client_id = Yii::$app->user->id;
									$addressClient->as_default = 1;	
									$addressClient->save();
									$addressId = $addressClient->id;

								}else{
									echo Json::encode(['success' => false, 'message' => $addressBilling->errors]);
									Yii::$app->end();

								}
							}
							
							$addressId = $addressClient->id;
							
							
						}
						
						
					
						
					}
					
					$client = Yii::$app->user->identity;
					
					$query = \frontend\components\Paypal::VoucherPost($session);
					
					$orderId = 0;
					
					$i=1;foreach ($session['Vouchercart'] as $key=>$value){
						
						$model = new Order;
						$model->client_name = $client->first_name.' '.$client->last_name;
						
						$model->payment_type = $addToCart->paymentMethod;
						$model->client_id = $client->client_id;
						$model->source_type = 1;
						$model->merchant_id = $session['merchant_id'];
						$model->voucher_note = $address->notevoucher;
						
						$currency = \common\models\Currency::findOne(['currency_symbol' => $value['currency']]);
						if($value['is_group'] == 0){
							//print_r($v['is_group']);
							$model->order_time = date('Y-m-d', strtotime($value['order_date'])) . ' ' . $value['free_time_list'];
						}else if($value['is_group'] == 1){
							$model->order_time = date('Y-m-d', strtotime($value['order_date'])) . ' ' . $value['time_req'];
						}
						$model->category_id = $key;

						$model->currency = $currency->currency_code;
						
						

						
						$model->gift_voucher_id = $key;
						$model->client_name = $client->first_name;
						$model->client_email = $client->email_address;
						$model->client_phone = $client->contact_phone;

						$model->no_of_seats = $value['qty'];
						$model->is_service_gift = 1;
						$model->delivery_option = $addToCart->deliveryOption;
						$model->delivery_fee = $addToCart->deliveryFee;
						if(!empty($addressId))  $model->address_id = $addressId;
						$price = $value['price']; 

						$model->price = $price;

						if($model->payment_type == 2){
						    $model->payment_status = 'pending';
						    $model->status = 4;

						}
						
						$commission = $model::getCommision($model->merchant_id, $model->price);

						$model->total_commission = $commission['total_commision'];
						$model->merchant_earnings = $commission['merchant_earnings'];
						$model->percent_commision = $commission['percent_commision'];
						
						
						if($model->payment_type == 2){
							
							$query['custom'] =  $orderId;


							//$custom = base64_encode($custom);
							//$query['custom_'.$i] = json_encode(['id' => $key, 'addonlist' => $v['addons_list']]);
							$query['item_name_'.$i] = $value['title'];
							$query['quantity_'.$i] = $value['qty'];
							$query['amount_'.$i] = $model->price;
						}
						
						$model->order_id = $orderId;
						
						
						
						if($model->save(false)){
							if($model->payment_type != 2){
								EmailManager::buyVoucher($model);
								EmailManager::buyVoucherMerchant($model);
							}
						}
						
						if($i==1){
							$orderId = $model->id;
						}

					$i++;
					}
					
					$merchant = \common\models\Merchant::findOne(['merchant_id' => $model->merchant_id]);
					
					$session['orderid'] = $orderId;
					
//					print_r($query);
//					exit;
					
					if($addToCart->paymentMethod == 2){

						$post = http_build_query($query);
						
						$paypal = new \frontend\components\Paypal;
						
						$paypal->is_sandbox = $merchant->is_paypall_sandbox;
						
						
						echo Json::encode(['success' => true,
						    'data' => $paypal->paypal_url_parse.'?'.$post, 
						    'payment' => $addToCart->paymentMethod,
						    ]);
						Yii::$app->end();
					}else{
						$merchantLoylitypoints = \frontend\models\LoyaltyPoints::findOne(['merchant_id' => $model->merchant_id]);

						if($merchant->giftVoucherSetting->receive_loyalty_points == 1 && $merchantLoylitypoints->is_active == 1){

						    $loyalitypoint = \frontend\models\Option::getValByName('website_loyalty_points');
							$loyalitypoint = $loyalitypoint?$loyalitypoint:1;
						    if(!empty($loyalitypoint)){
							$clintLoyalityPoint = \frontend\models\ClientLoyalityPoints::findOne(['client_id' => Yii::$app->user->id, 'merchant_id' => $model->merchant_id]);


							if(count($clintLoyalityPoint) == 0){
							    $clintLoyalityPoint = new \frontend\models\ClientLoyalityPoints();
							    $clintLoyalityPoint->client_id = Yii::$app->user->id;
							    $clintLoyalityPoint->merchant_id = $model->merchant_id;
							    $clintLoyalityPoint->created_at = new \yii\db\Expression('NOW()');
							}

//							$total = $session['voucher-total'];
							$loyalityPoints = $merchant->getLoyaltyPoints()->all();

							    if ( $loyalityPoints) {

								    if ($loyalityPoints['count_on_order']) {

									    $clintLoyalityPoint->points += $loyalityPoints['count_on_order'] * $loyalitypoint;
									    $clintLoyalityPoint->save(false);
									    $minimumLoyaltyPoints = \common\models\Option::getValByName('minimum_loyalty_points');

									    if ($clintLoyalityPoint->points >= $minimumLoyaltyPoints) {
										    EmailManager::customerLoyaltyPoints($model, $clintLoyalityPoint);

									    }
								    }
							    }

						    }

						}
						
						
						
						echo Json::encode(['success' => true,
						    'data' => Yii::$app->urlManager->createUrl('checkout/voucher-finish')
						    ]);
						Yii::$app->end();
					}
					
				
					
					
				}
				
				
				
				
			}else{
				if(Yii::$app->request->isAjax){
					echo Json::encode(['success' => false, 'message' => $addToCart->errors]);
					Yii::$app->end();
					
				}
			}
			
			

		}
			
		
		
		return $this->render('voucher-payment', [
		    'addressBilling' => $addressBilling,
		    'addressShipping' => $addressShipping,
		    'addToCart' => $addToCart
		]);
	}
	
	
	public function actionVoucherFinish(){
		
		$session = Yii::$app->session;
		
		$cart = $session['Vouchercart'];
		
		$session['Vouchercart'] = NULL;
	
		$order = Order::findOne(['id' => $session['orderid']]);
		
		return $this->render('voucher_finish', [
		    'cart' => $cart,
		    'subtotal' => \frontend\components\UrlHelper::numberFormat($session['voucher-subtotal']),
		    'order' => $order
		]);
		
		
	}
    
    public function actionWidgetIndex(){
        
        
        
        $this->layout = 'widget-layout';
        
        $session = Yii::$app->session;
        $login = new LoginForm;
        $client = new Client();
        $client->scenario = 'checkout';
        
        if(empty($session['cart']) || count(array_filter($session['cart'])) == 0){
            
            return $this->goHome();
            
        }
        
        if(!empty($session['client'])){
            $client->attributes = $session['client'];
        }
        
        if($client->load(Yii::$app->request->post())){
            
            if($client->validate()){
                
                
                $session['client'] = $client->attributes;
                
                $client = Client::find()->where(['email_address' => trim($session['client']['email_address'])])->one();
                
                if(count($client) == 0 ){
                        $password = Yii::$app->getSecurity()->generateRandomString(6);
                        $client = new Client;
                        $client->attributes = $session['client'];

                        $client->password = $password;
                        $client->setPassword($password);
                        $client->generateAuthKey();
                        $client->status = 0;
                        $client->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
                        
//                        print_r(Yii::$app->request->userIP);
//                        exit;
                        
//                        $email = EmailManager::customerAccountActivate($client);
//                        
//                        exit;
        
                        if($client->save(false)){
                            $addressBook  = new \frontend\models\MtAddressBook;
                            $addressBook->attributes = $session['client'];
                            $addressBook->client_id = $client->id;
                            $addressBook->ip_address = Yii::$app->request->userIP;
                            $addressBook->save(false);
                            
                            $email = EmailManager::customerAccountActivate($client, $session['merchant_id']);
                            $url = Yii::$app->urlManager->createUrl('checkout/widget-verification');
                            
                        }
                    
                    
                    
                }else if(empty($client->password)){
                    
                    $client->password = $session['client']['email_address'];
                    $client->setPassword($session['client']['email_address']);
                    $client->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
                    $client->status = 0;
                    $client->save(false);
                    $email = EmailManager::customerAccountActivate($client);
                    $url = Yii::$app->urlManager->createUrl('checkout/widget-verification');
                    
                }else if($client->status == 0){
                    $client->activation_key  = Yii::$app->getSecurity()->generateRandomString(9);
                    $client->save(false);
                    $email = EmailManager::customerAccountActivate($client);
                    $url = Yii::$app->urlManager->createUrl('checkout/widget-verification');
                }else{
                    $login = new LoginForm;
                    $login->email = $client->email_address;
                    $login->password = $client->password;
                    //$error = ActiveForm::validate($login);
                    
                    
                    $login->login();
                    $url = Yii::$app->urlManager->createUrl('checkout/widget-payment');
                }
                
                
                
                
                
                echo Json::encode(['success' => true, 'data' => $url]);
                Yii::$app->end();
                
                
            }else{
                echo Json::encode(['success' => false, 'data' => $client->getErrors()]);
                Yii::$app->end();
            }
            
        }
        
        if($login->load(Yii::$app->request->post())){
            if($login->login()){
                $this->redirect(['checkout/widget-payment']);
            }
            
        }
        
        return $this->render('widget-index', [
            'client' => $client,
            'login' => $login
        ]);
    }
    
    public function actionPaypalIpn(){
        Yii::$app->controller->enableCsrfValidation = false;
        $paypal = new \frontend\components\Paypal;
        $paypal->ipn();
    }
    
    public function actionVoucherPaypalIpn(){
        Yii::$app->controller->enableCsrfValidation = false;
        $paypal = new \frontend\components\Paypal;
        $paypal->voucheripn();
    }
    
    
    public function actionPayment(){
        
        
         
        
        if(isset($_POST['payment_method']) && !empty($_POST['payment_method'])){
            
            
            
            $session = Yii::$app->session;
            
            $session['payment_method'] = $_POST['payment_method'];
            
            $loyalty = $session['loyalty'];
            
            if(empty($session['cart']) || count(array_filter($session['cart'])) == 0){
            
                return $this->goHome();

            }
            
            
            
            if(!empty($session['cart'])){
                $orders = $session['cart'];
                $subtotal = $session['subtotal'];
                $total = $session['total'];
                $couponPer = $session['couponPer'];
                $discount = $session['discount'];
                
                $totalSize = 0;
                
                foreach($session['cart'] as $key=>$value){
                    $size = sizeof($value);
                    $totalSize += $size;
                }
                
                $singleLoyalty = $loyalty / $totalSize;
                
                $loyaltyPointsOne = \common\models\Option::getValByName('website_loyalty_points');
                

                    $client = Yii::$app->user->identity;
                    $clientId = Yii::$app->user->id;
                    $response = [] ;
                    
                    
            
            
                if($session['payment_method'] == 1){
                    
                    $query = \frontend\components\Paypal::Post($session);
                    
//                    print_r($query);
//                    exit;
                    
//                    $post = \frontend\components\Paypal::Post($session);
//                    echo Json::encode(['success' => true,
//                        'data' => 'https://www.sandbox.paypal.com/cgi-bin/webscr?'.$post, 
//                        'response' => $response]);
//                    Yii::$app->end();
            

                }
                    
                    
                    

                $i=1;foreach($session['cart'] as $key=>$value){

                    foreach($value as $k=>$v){
                        $model = new Order;
                        $model->attributes = $v;
                        $model->payment_type = $session['payment_method'];
                        $model->user_birthday_coupon_id = $session['userbirthdaycoupon'];
                        $model->client_id = $client->client_id;
                        $model->source_type = 1;
			
			$currency = \common\models\Currency::findOne(['currency_symbol' => $v['currency']]);
			
			$model->currency = $currency->currency_code;

                        if($v['is_group'] == 0){
                        //print_r($v['is_group']);
                            $model->order_time = date('Y-m-d', strtotime($v['order_date'])) . ' ' . $v['free_time_list'];
                        }else if($v['is_group'] == 1){
                            $model->order_time = date('Y-m-d', strtotime($v['order_date'])) . ' ' . $v['time_req'];
                        }
                        $model->category_id = $key;
                        $model->client_name = $client->first_name;
                        $model->client_email = $client->email_address;
                        $model->client_phone = $client->contact_phone;
			
			$model->loyalty_points = $singleLoyalty;
                        $model->loyalty_points_amount = $loyaltyPointsOne * $singleLoyalty;
                        $price = $model::getPrice($model); 
                        
                        $model->price = $price;
                        
                        if($model->payment_type == 1){
                            $model->payment_status = 'pending';
                            $model->status = 4;
                            
                        }
                        
                        
			
                        

                        if($model->save(false)){
                            
                            
                            
                            if(isset($v['addons_list'])){
                                foreach($v['addons_list'] as $val){
                                    $m = Addons::findOne(['id'=>$val]);
                                    $model->price += $m->price;
                                    $addonHasOrder = new AddonHasOrder;
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
								$model->voucher_amount = $session['discount'];
                            }
                            $model->save(false);
                            
                            
                            $categoryName = 'Service: '.$model->category->title.'<br>';
							$addons = \common\components\Helper::getOrderAddonsList($model);
							if(!empty($addons)){
								$categoryName .= 'Addons : '.$addons;
							}
                            
                            $response[] = [
                                'id' => $model->id,
                                'staff_id' => $model->staff_id,
                                'merchant_id' => $model->merchant_id,
                                'title' => $model->client_name,
                                'start' => date('Y-m-d\TH:i:s', strtotime($model->order_time)),
                                'end' => date('Y-m-d\TH:i:s', strtotime("+{$model->category->time_in_minutes} minutes", strtotime($model->order_time))),
                                'url' => 'order/update-inst?id=' . $model->id,
                                'backgroundColor' => $model->category->color,
                                'is_group' =>$model->is_group,
								'description' => $categoryName
                            ];
                                
                                if($session['payment_method'] == 2){
                                
                                    EmailManager::newAppointment($model);
                                    EmailManager::newAppointmentMerchant($model);
                                }
                            
                            
                            if($session['payment_method'] == 1){
                                $addons = implode('/', $v['addons_list']);
                                $custom .= '&'.'_'.$i.'_'.$key.'_'.$model->merchant_id.'_'.Yii::$app->user->id.'_'.$addons.'_'.$v['order_date'].'_'.$v['free_time_list'].'_'.$v['time_req'].'_'.$v['is_group'].'_'.$session['couponid'].'_'.$session['userbirthdaycoupon'].'_'.$session['loyalty'].'_'.$v['staff_id'].'_'.$model->id;


                                //$custom = base64_encode($custom);
                                //$query['custom_'.$i] = json_encode(['id' => $key, 'addonlist' => $v['addons_list']]);
                                $query['item_name_'.$i] = $v['title'];
                                $query['quantity_'.$i] = 1;
                                $query['amount_'.$i] = $model->price;
                            }
                        
                        }




                    $i++;}


                }
                
                
                if($session['payment_method'] == 2){
                
                    $merchantLoylitypoints = \frontend\models\LoyaltyPoints::findOne(['merchant_id' => $model->merchant_id]);

                    if($merchantLoylitypoints->is_active == 1){

                        $loyalitypoint = \frontend\models\Option::getValByName('website_loyalty_points');

                        if(!empty($loyalitypoint)){
                            $clintLoyalityPoint = \frontend\models\ClientLoyalityPoints::findOne(['client_id' => Yii::$app->user->id, 'merchant_id' => $model->merchant_id]);


                            if(count($clintLoyalityPoint) == 0){
                                $clintLoyalityPoint = new \frontend\models\ClientLoyalityPoints();
                                $clintLoyalityPoint->client_id = Yii::$app->user->id;
                                $clintLoyalityPoint->merchant_id = $model->merchant_id;
                                $clintLoyalityPoint->created_at = new \yii\db\Expression('NOW()');
                            }

                            $clintLoyalityPoint->points -= $session['loyalty'];

                            $clintLoyalityPoint->points += $loyalitypoint * $total;
                            $clintLoyalityPoint->save(false);

                            $minimumLoyaltyPoints = \common\models\Option::getValByName('minimum_loyalty_points');

                            if($clintLoyalityPoint->points >= $minimumLoyaltyPoints){
                                EmailManager::customerLoyaltyPoints($model, $clintLoyalityPoint);

                            }
                        }

                    }
                }
                
                if($session['payment_method'] == 1){
                    
                    $query['custom'] = base64_encode($custom);
                
                    $post = http_build_query($query);
                    echo Json::encode(['success' => true,
                        'data' => 'https://www.sandbox.paypal.com/cgi-bin/webscr?'.$post, 
                        'payment' => $session['payment_method'],
                        'response' => $response]);
                    Yii::$app->end();
                }
                



            }
            
            echo Json::encode(['success' => true,
                'data' => Yii::$app->urlManager->createUrl('checkout/finish'), 
                'payment' => $session['payment_method'],
                'response' => $response]);
            Yii::$app->end();
            
        }
        return $this->render('payment');
    }
    
    
    public function actionWidgetPayment(){
        
        
        
        $this->layout = 'widget-layout';
        
        if(isset($_POST['payment_method']) && !empty($_POST['payment_method'])){
            $session = Yii::$app->session;
            
            $session['payment_method'] = $_POST['payment_method'];
            
            $session = Yii::$app->session;
            
            if($session['payment_method'] == 1){
                    
                $query = \frontend\components\Paypal::Post($session);
            }
            
            if(empty($session['cart']) || count(array_filter($session['cart'])) == 0){
            
                return $this->goHome();

            }
            
            
            if(!empty($session['cart'])){
                $orders = $session['cart'];
                $subtotal = $session['subtotal'];
                $total = $session['total'];
                $couponPer = $session['couponPer'];
                $discount = $session['discount'];

                    $client = Yii::$app->user->identity;
                    $clientId = Yii::$app->user->id;
                    $response = [] ;

                $i=1;foreach($session['cart'] as $key=>$value){

                    foreach($value as $k=>$v){
                        $model = new Order;
                        $model->attributes = $v;
                        $model->payment_type = $session['payment_method'];
                        $model->client_id = $client->client_id;
                        $model->source_type = 1;
			
			$currency = \common\models\Currency::findOne(['currency_symbol' => $v['currency']]);
			
			$model->currency = $currency->currency_code;

                        if($v['is_group'] == 0){
                        //print_r($v['is_group']);
                            $model->order_time = date('Y-m-d', strtotime($v['order_date'])) . ' ' . $v['free_time_list'];
                        }else if($v['is_group'] == 1){
                            $model->order_time = date('Y-m-d', strtotime($v['order_date'])) . ' ' . $v['time_req'];
                        }
                        $model->category_id = $key;
                        $model->client_name = $client->first_name;
                        $model->client_email = $client->email_address;
                        $model->client_phone = $client->contact_phone;

                        $price = $model::getPrice($model); 
                        
                        $model->price = $price;
                                

                        if($model->save(false)){
                            if(isset($v['addons_list'])){
                                foreach($v['addons_list'] as $val){
                                    $m = Addons::findOne(['id'=>$val]);
                                    $model->price += $m->price;
                                    $addonHasOrder = new AddonHasOrder;
                                    $addonHasOrder->addon_id = $val;
                                    $addonHasOrder->order_id = $model->id;
                                    $addonHasOrder->save(false);
                                }
                            }

                            $commission = $model::getCommision($model->merchant_id, $model->price);

                            $model->total_commission = 0;
                            $model->merchant_earnings = $commission['merchant_earnings'];
                            $model->percent_commision = 0;

                            if(isset($session['couponid'])){
                                $model->voucher_id = $session['couponid'];
                            }
                            $model->save(false);
                            
                            
                            $categoryName = 'Service: '.$model->category->title.'<br>';
							$addons = \common\components\Helper::getOrderAddonsList($model);
							if(!empty($addons)){
								$categoryName .= 'Addons : '.$addons;
							}
                            
                            $response[] = [
                                'id' => $model->id,
                                'staff_id' => $model->staff_id,
                                'merchant_id' => $model->merchant_id,
                                'title' => $model->client_name,
                                'start' => date('Y-m-d\TH:i:s', strtotime($model->order_time)),
                                'end' => date('Y-m-d\TH:i:s', strtotime("+{$model->category->time_in_minutes} minutes", strtotime($model->order_time))),
                                'url' => 'order/update-inst?id=' . $model->id,
                                'backgroundColor' => $model->category->color,
								'description' => $categoryName
                            ];
                                
                            EmailManager::newAppointment($model);
                            EmailManager::newAppointmentMerchant($model);
                            
                            if($session['payment_method'] == 1){
                                $addons = implode('/', $v['addons_list']);
                                $custom .= '&'.'_'.$i.'_'.$key.'_'.$model->merchant_id.'_'.Yii::$app->user->id.'_'.$addons.'_'.$v['order_date'].'_'.$v['free_time_list'].'_'.$v['time_req'].'_'.$v['is_group'].'_'.$session['couponid'].'_'.$session['userbirthdaycoupon'].'_'.$session['loyalty'].'_'.$v['staff_id'].'_'.$model->id;


                                //$custom = base64_encode($custom);
                                //$query['custom_'.$i] = json_encode(['id' => $key, 'addonlist' => $v['addons_list']]);
                                $query['item_name_'.$i] = $v['title'];
                                $query['quantity_'.$i] = 1;
                                $query['amount_'.$i] = $model->price;
                            }
                        
                        }




                    $i++;}


                }
                
                
                $merchantLoylitypoints = \frontend\models\LoyaltyPoints::findOne(['merchant_id' => $model->merchant_id]);
        
                if($merchantLoylitypoints->is_active == 1){

                    $loyalitypoint = \frontend\models\Option::getValByName('website_loyalty_points');

                    if(!empty($loyalitypoint)){
                        $clintLoyalityPoint = \frontend\models\ClientLoyalityPoints::findOne(['client_id' => Yii::$app->user->id, 'merchant_id' => $model->merchant_id]);


                        if(count($clintLoyalityPoint) == 0){
                            $clintLoyalityPoint = new \frontend\models\ClientLoyalityPoints();
                            $clintLoyalityPoint->client_id = Yii::$app->user->id;
                            $clintLoyalityPoint->merchant_id = $model->merchant_id;
                            $clintLoyalityPoint->created_at = new \yii\db\Expression('NOW()');
                        }
                        
                        

                        $clintLoyalityPoint->points += $loyalitypoint * $total;
                        $clintLoyalityPoint->save(false);
                    }

                }
                
                if($session['payment_method'] == 1){
                    
                    $query['custom'] = base64_encode($custom);
                
                    $post = http_build_query($query);
                    echo Json::encode(['success' => true,
                        'data' => 'https://www.sandbox.paypal.com/cgi-bin/webscr?'.$post, 
                        'payment' => $session['payment_method'],
                        'response' => $response]);
                    
                    $session['cart'] = NULL;
                    $session['subtotal'] = NULL;
                    $session['total'] = NULL;
                    $session['couponPer'] = NULL;
                    $session['discount'] = NULL;
                    $session['client'] = NULL;
                    $session['loyalty'] = NULL;
                    $session['userbirthdaycoupon'] = NULL;
                    
                    Yii::$app->end();
                }
                



            }
            
            echo Json::encode(['success' => true,
                'data' => Yii::$app->urlManager->createUrl('checkout/widget-finish'), 
                'payment' => $session['payment_method'],
                'response' => $response]);
            Yii::$app->end();
            
        }
        return $this->render('widget-payment');
    }
    
    
    public function actionWidgetFinish(){
        
        
        
        $this->layout = 'widget-layout';
        
        $session = Yii::$app->session;
        
        if(empty($session['cart']) || count(array_filter($session['cart'])) == 0){
            
            return $this->goHome();
            
        }
        if(!empty($session['cart'])){
            $loyaltyPointsOne = \common\models\Option::getValByName('website_loyalty_points');
            $orders = $session['cart'];
            $loyalty = $session['loyalty'] * $loyaltyPointsOne;
            $subtotal = $session['subtotal'] - $loyalty;
            $total = ($session['total'] - $session['discount']) - $loyalty;
            $couponPer = $session['couponPer'];
            $discount = $session['discount'];
            
                
            
            $session['cart'] = NULL;
            $session['subtotal'] = NULL;
            $session['total'] = NULL;
            $session['couponPer'] = NULL;
            $session['discount'] = NULL;
            $session['client'] = NULL;
            $session['loyalty'] = NULL;
            $session['userbirthdaycoupon'] = NULL;
            
            
            
        }
        
        
        
        
        return $this->render('widget-finish', ['orders' => $orders,
            'subtotal' => $subtotal,
            'total' => $total,
            'couponPer' => $couponPer,
            'discount' => $discount
            
                ]);
    }
    
    public function actionFinish(){
        
        
        $session = Yii::$app->session;
        
        if(empty($session['cart']) || count(array_filter($session['cart'])) == 0){
            
            return $this->goHome();
            
        }
        if(!empty($session['cart'])){
            $loyaltyPointsOne = \common\models\Option::getValByName('website_loyalty_points');
            $orders = $session['cart'];
            $loyalty = $session['loyalty'] * $loyaltyPointsOne;
            $subtotal = $session['subtotal'] - $loyalty;
            $total = ($session['total'] - $session['discount']) - $loyalty;
            $couponPer = $session['couponPer'];
            $discount = $session['discount'];
            
                
            
            $session['cart'] = NULL;
            $session['subtotal'] = NULL;
            $session['total'] = NULL;
            $session['couponPer'] = NULL;
            $session['discount'] = NULL;
            $session['client'] = NULL;
            $session['loyalty'] = NULL;
            $session['userbirthdaycoupon'] = NULL;
            
            
        }
        
        
        
        
        return $this->render('finish', ['orders' => $orders,
            'subtotal' => $subtotal,
            'total' => $total,
            'couponPer' => $couponPer,
            'discount' => $discount,
            
            
                ]);
    }
}

