<?php
namespace frontend\components;

use Yii;
use frontend\components\MessagebirdManager;
use common\models\Merchant;
use common\models\Client;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class EmailManager{
	
	public static function getAdminLogo(){
		return 'http://help.aondego.de/img/logo-sign-210-grey.png';
	}
	
	public static function getMerchantLogo($merchant){
		
		return $merchant->behaviors['imageBehavior']->getImageUrl();
		
	}
	
	public static function SiteLink(){
		return 'https://aondego.com/';
	}


	public static function adminEmail(){
            return \frontend\models\Option::getValByName('global_admin_sender_email');
        }
    
        public static function adminSendEmail($subjectName, $bodyName, $variable, $emailProvider){
            
            
            
            $subject = \frontend\models\Option::getValByName($subjectName);
            
            $subject = self::getBody($subject, $variable);
            
            $body = \frontend\models\Option::getValByName($bodyName);
            
            $body = self::getBody($body, $variable);
            
            
            
            if($emailProvider == 0){
                self::sendPhpEmail(self::adminEmail(), $subject, $body);
            }else if($emailProvider == 1){
                $email = self::sendSmtpEmail(self::adminEmail(), $subject, $body);
                
            }

        }
	
	public static function buyVoucher($order){
		
		$language = $order->merchant->language->code;
        
		$option = \frontend\models\Option::getValByName('email_tpl_customer_voucher_order', $language);

		$email_provider = \frontend\models\Option::getValByName('email_provider');
		
		$variable = [];
		$variable['client_name'] = $order->client_name;
		$variable['merchant_name'] = $order->merchant->service_name;
		
		$variable['voucher_package'] = $order->voucher->name;
		$variable['voucher_receiver'] = ($order->delivery_option ==0)?"":$order->client_name;
		$variable['voucher_message'] = $order->voucher_note;
		$variable['delivery_option'] = $order::$deliveryOption[$order->delivery_option];
		$variable['payment'] = \common\models\GiftVoucherSetting::$payment[$order->payment_type];
		$variable['price'] = $order->price;
		$variable['delivery_fee'] = $order->delivery_fee;
		$variable['currency_code'] = \common\components\Helper::getCurrencyCode($order->merchant);
		
		
		$variable['delivery_to_name'] = "";
		$variable['delivery_to_address'] = "";
		
		if($order->delivery_option !=0 ){
			$variable['delivery_to_name'] = $order->address->first_name. ' ' .$order->address->last_name;
			$variable['delivery_to_address'] = $order->address->street. ', ' .$order->address->city.', '.$order->address->zipcode;
			
		}
		
		$variable['admin_logo'] = self::getAdminLogo();
	
		$variable['merchant_logo'] = self::getMerchantLogo($order->merchant);
		
		$body = self::getBody($option, $variable);
        
		$subject = \frontend\models\Option::getValByName('email_tpl_sub_customer_voucher_order', $language);
		
		$adminEmail = self::adminSendEmail('email_tpl_sub_admin_voucher_order', 'email_tpl_admin_voucher_order', $variable, $email_provider);
		if( ClientNotificationFilter::check($order->client->client_id, 6) ) {
			if ($email_provider == 0) {
				self::sendPhpEmail($order->client->email_address, $subject, $body);
			} else if ($email_provider == 1) {
				self::sendSmtpEmail($order->client->email_address, $subject, $body);
			}
		}
	}
	
	//info@creatingbusiness.de
	public static function buyVoucherMerchant($order){
		$language = $order->merchant->language->code;
        
		$option = \frontend\models\Option::getValByName('email_tpl_merchant_voucher_order', $language);

		$email_provider = \frontend\models\Option::getValByName('email_provider');
		
		$variable = [];
		$variable['client_name'] = $order->client_name;
		$variable['client_email'] = $order->client_email;
		$variable['merchant_name'] = $order->merchant->service_name;
		
		$variable['voucher_package'] = $order->voucher->name;
		$variable['voucher_receiver'] = ($order->delivery_option ==0)?"":$order->client_name;
		$variable['voucher_message'] = $order->voucher_note;
		$variable['delivery_option'] = $order::$deliveryOption[$order->delivery_option];
		$variable['payment'] = \common\models\GiftVoucherSetting::$payment[$order->payment_type];
		$variable['price'] = $order->price;
		$variable['delivery_fee'] = $order->delivery_fee;
		$variable['delivery_to_name'] = "";
		$variable['delivery_to_address'] = "";
		if($order->delivery_option !=0 ){
			$variable['delivery_to_name'] = $order->address->first_name. ' ' .$order->address->last_name;
			$variable['delivery_to_address'] = $order->address->street. ', ' .$order->address->city.', '.$order->address->zipcode;
			
		}
		
		$variable['admin_logo'] = self::getAdminLogo();
	
		$variable['merchant_logo'] = self::getMerchantLogo($order->merchant);
		
		$variable['currency_code'] = \common\components\Helper::getCurrencyCode($order->merchant);
		
		$body = self::getBody($option, $variable);
        
		$subject = \frontend\models\Option::getValByName('email_tpl_sub_merchant_voucher_order', $language);
		
		

		if($email_provider == 0){
		    self::sendPhpEmail($order->merchant->contact_email, $subject, $body);
		}else if($email_provider == 1){
		    self::sendSmtpEmail($order->merchant->contact_email, $subject, $body);
		}
	}

	
	public static function loyaltyExpire($model, $clientLoyaltyPoints){
            $client = \common\models\Client::findOne(['client_id'=>$model['client_id']]);
            
            $merchant = \common\models\Merchant::findOne(['merchant_id' => $model['merchant_id']]);
            
            $language = 'de';
        
            $option = \frontend\models\Option::getValByName('email_tpl_customer_loyality_exire', $language);

            $email_provider = \frontend\models\Option::getValByName('email_provider');
            
            $variable = [];
            $variable['first_name'] = $client->first_name;
            $variable['last_name'] = $client->last_name;
            $variable['merchant_name'] = $merchant->service_name;
            $variable['loyalty_point'] = $clientLoyaltyPoints->points;
            $variable['loyalty_expire'] = date('Y-m-d');
            
             
            $body = self::getBody($option, $variable);
        
            $subject = \frontend\models\Option::getValByName('email_tpl_sub_customer_loyality_exire', $language);


		if( ClientNotificationFilter::check($client->client_id, 6) ) {
			if ($email_provider == 0) {
				self::sendPhpEmail($client->email_address, $subject, $body);
			} else if ($email_provider == 1) {
				self::sendSmtpEmail($client->email_address, $subject, $body);
			}
		}
        }


        public static function newsLetter($model){
	        if( ClientNotificationFilter::check($model->client_id, 5) ) {
		        $email_provider = \frontend\models\Option::getValByName('email_provider');

		        $variable = [];
		        $variable['email'] = $model->email_address;

		        $adminEmail = self::adminSendEmail('email_tpl_sub_admin_newsletter', 'email_tpl_admin_newsletter', $variable, $email_provider);
	        }
        }
        
        
        

        public static function customerLoyaltyPoints($order, $loyaltyPoint){
            
            $language = $order->merchant->language->code;
        
            $option = \frontend\models\Option::getValByName('email_tpl_customer_loyality', $language);

            $email_provider = \frontend\models\Option::getValByName('email_provider');
            
            $variable = [];
            $variable['first_name'] = Yii::$app->user->identity->first_name;
            $variable['last_name'] = Yii::$app->user->identity->last_name;
            $variable['merchant_name'] = $order->merchant->service_name;
            $variable['loyalty_point'] = $loyaltyPoint->points;
            $variable['loyalty_expire'] = date('Y-m-d', strtotime('+1 years', strtotime(date('Y-m-d'))));
            
             
            $body = self::getBody($option, $variable);
        
            $subject = \frontend\models\Option::getValByName('email_tpl_sub_customer_loyality', $language);;


	        if( ClientNotificationFilter::check(Yii::$app->user->identity->client_id, 6) ) {
		        if ($email_provider == 0) {
			        self::sendPhpEmail(Yii::$app->user->identity->email_address, $subject, $body);
		        } else if ($email_provider == 1) {
			        self::sendSmtpEmail(Yii::$app->user->identity->email_address, $subject, $body);
		        }
	        }
        }
        
        public static function membershipExpired($model){
            
            $language = 'en';
            if(!empty($model['language_id'])){
                $language = \common\models\Language::findOne(['id' => $model['language_id']])->code;
            }
            
            
            
            //$language = $model->language->code;
        
            $option = \frontend\models\Option::getValByName('email_tpl_merchant_membership_expires', $language);

            $email_provider = \frontend\models\Option::getValByName('email_provider');
            
            
            
            $variable = [];
            $variable['merchant_name'] = $model['service_name'];
            $variable['website_title'] = $model['url'];
            $variable['expiration_date'] = $model['membership_expired'];
            
            $body = self::getBody($option, $variable);
            
        
            $subject = \frontend\models\Option::getValByName('email_tpl_sub_merchant_membership_expires', $language);;

            $adminEmail = self::adminSendEmail('email_tpl_sub_admin_membership_expires', 'email_tpl_admin_membership_expires', $variable, $email_provider);
            
            if($email_provider == 0){
                self::sendPhpEmail($model['contact_email'], $subject, $body);
            }else if($email_provider == 1){
                self::sendSmtpEmail($model['contact_email'], $subject, $body);
            }
            
        }

        public static function merchantRegistration($model){
        
        
        $option = \frontend\models\Option::getValByName('email_tpl_merchant_welcome_message');
        
        $email_provider = \frontend\models\Option::getValByName('email_provider');
        
        $variable = [];
        $variable['client_name'] = $model->service_name;
        $variable['username'] = $model->username;
        $variable['password'] = $model->password;
        $variable['link'] = \yii\helpers\Html::a('Login into your Account',Yii::$app->getRequest()->getHostInfo().'/merchant/web/login/index');
        
	
        $body = self::getBody($option, $variable);
        
        $subject = \frontend\models\Option::getValByName('email_tpl_sub_merchant_welcome_message');;
        
        $adminEmail = self::adminSendEmail('email_tpl_sub_admin_new_merchant', 'email_tpl_admin_new_merchant', $variable, $email_provider);
        
        if($email_provider == 0){
            self::sendPhpEmail($model->contact_email, $subject, $body);
        }else if($email_provider == 1){
            self::sendSmtpEmail($model->contact_email, $subject, $body);
        }
        
        
        
    }


    
    public static function appointmentRemider($order){
        
        $language = $order->merchant->language->code;
        
        $option = \frontend\models\Option::getValByName('email_tpl_customer_reminder_email', $language);
        
        $email_provider = \frontend\models\Option::getValByName('email_provider');
        
        $variable = [];
        $variable['first_name'] = $order->client_name;
        $variable['last_name'] = "";
        $variable['merchant_name'] = $order->merchant->service_name;
        $variable['merchant_address'] = $order->merchant->address;
        $variable['booked_seats'] = $order->no_of_seats;
        $variable['booked_service'] = $order->category->title;
        $variable['booking_total'] = $order->price;
        $variable['staff_member'] = $order->staff->name;
        $variable['startdate'] = date('Y-m-d', strtotime($order->order_time));
        $variable['starttime'] = date('H:i:s', strtotime($order->order_time));
        $variable['endtime'] = date('H:i:s', strtotime("+{$order->category->time_in_minutes} minutes", strtotime($order->order_time)));
       
        $variable['admin_logo'] = self::getAdminLogo();
	
		$variable['merchant_logo'] = self::getMerchantLogo($order->merchant);
		
		$variable['addons_list'] = \common\components\Helper::getOrderAddonsList($order);
        
        $body = self::getBody($option, $variable);
        
        
        $subject = \frontend\models\Option::getValByName('email_tpl_sub_customer_reminder_email', $language);;
        
        $subvariable = [];
        $subvariable['merchant_name'] = $order->merchant->service_name;
        
        $subject = self::getBody($subject, $subvariable);
        
        
        if($email_provider == 0){
            self::sendPhpEmail($order->client_email, $subject, $body);
        }else if($email_provider == 1){
            self::sendSmtpEmail($order->client_email, $subject, $body);
        }
	
	$mid=$order->merchant->merchant_id;
	$cid=$order->client_id;
	$merchant = Merchant::find()->where(['merchant_id'=>$mid])->one();
	$client = Client::find()->where(['client_id'=>$cid])->one();
	if($merchant->enable_sms==1 && ($client->notification==1 || $client->notification==2)){
		MessagebirdManager::sendsmsReminderAppointment($order);
	}
        
    }

        public static function birthday($user, $coupon, $userBirthdayCoupon){
        $language = $coupon->merchant->language->code;
        
        $option = \frontend\models\Option::getValByName('email_tpl_customer_birthday_coupon', $language);
        
        $email_provider = \frontend\models\Option::getValByName('email_provider');
        
        $variable = [];
        $variable['first_name'] = $user['first_name'];
        $variable['last_name'] = $user['last_name'];
        $variable['merchant_name'] = $coupon->merchant->service_name;
        $variable['coupon'] = $userBirthdayCoupon->code;
        $variable['coupon_expire'] = $coupon->expiration;
	
		$variable['admin_logo'] = self::getAdminLogo();

		$variable['merchant_logo'] = self::getMerchantLogo($coupon->merchant);
		$variable['currency_code'] = \common\components\Helper::getCurrencyCode($coupon->merchant);
        
        if($coupon->voucher_type == 1){
            $coupon_value = $coupon->amount.'%';
        }else{
            $coupon_value = $coupon->currency.$coupon->amount;
        }
        
        $variable['coupon_amount'] = $coupon_value;
        
        $body = self::getBody($option, $variable);
         
//        echo '<pre>';
//        print_r($body);
        
        $subject = \frontend\models\Option::getValByName('email_tpl_sub_customer_birthday_coupon', $language);;
        
        $subvariable = [];
        $subvariable['first_name'] = $user['first_name'];
        
        $subject = self::getBody($subject, $subvariable);
	    if( ClientNotificationFilter::check($user['client_id'], 6) ) {
		    if ($email_provider == 0) {
			        self::sendPhpEmail($user['email_address'], $subject, $body);
		    } else if ($email_provider == 1) {
			    self::sendSmtpEmail($user['email_address'], $subject, $body);
		    }
	    }
		$mid=$coupon->merchant->merchant_id;
		$cid=$user['client_id'];
		$merchant = Merchant::find()->where(['merchant_id'=>$mid])->one();
		$client = Client::find()->where(['client_id'=>$cid])->one();
		if($merchant->enable_sms==1 && ($client->notification==1||$client->notification==2)){
			MessagebirdManager::sendsmsbirthday($client, $coupon, $userBirthdayCoupon);
		}
        
    }
    
    
    public static function cancelAppointment($order){
        $language = $order->merchant->language->code;
        
        $option = \frontend\models\Option::getValByName('email_tpl_customer_appointment_cancelled', $language);
        
        $email_provider = \frontend\models\Option::getValByName('email_provider');
        
        $variable = [];
        $variable['first_name'] = $order->client->first_name;
        $variable['last_name'] = $order->client->last_name;
        $variable['merchant_name'] = $order->merchant->service_name;
        $variable['merchant_address'] = $order->merchant->address;
        $variable['booked_seats'] = $order->no_of_seats;
        $variable['booked_service'] = $order->category->title;
        $variable['staff_member'] = $order->staff->name;
        $variable['startdate'] = date('Y-m-d', strtotime($order->order_time));
        $variable['starttime'] = date('H:i:s', strtotime($order->order_time));
        $variable['endtime'] = date('H:i:s', strtotime("+{$order->category->time_in_minutes} minutes", strtotime($order->order_time)));
       
        $variable['admin_logo'] = self::getAdminLogo();
	
		$variable['merchant_logo'] = self::getMerchantLogo($order->merchant);
		
		$variable['currency_code'] = \common\components\Helper::getCurrencyCode($order->merchant);
        
        $body = self::getBody($option, $variable);
        
        $subject = \frontend\models\Option::getValByName('email_tpl_sub_customer_appointment_cancelled', $language);;
        
        $subvariable = [];
        $subvariable['merchant_name'] = $order->merchant->service_name;
        
        $subject = self::getBody($subject, $subvariable);



	    if (ClientNotificationFilter::check($order->client->client_id, 3)) {
	        if($email_provider == 0){
	            self::sendPhpEmail($order->client->email_address, $subject, $body);
	        }else if($email_provider == 1){
	            self::sendSmtpEmail($order->client->email_address, $subject, $body);
	        }
	    }
    }
    
    public static function cancelAppointmentMerchant($order){
        $language = $order->merchant->language->code;
        $option = \frontend\models\Option::getValByName('email_tpl_merchant_appointment_cancelled', $language);
        
        $email_provider = \frontend\models\Option::getValByName('email_provider');
        
        $variable = [];
        $variable['first_name'] = $order->client->first_name;
        $variable['last_name'] = $order->client->last_name;
        $variable['merchant_name'] = $order->merchant->service_name;
        $variable['merchant_address'] = $order->merchant->address;
        $variable['booked_seats'] = $order->no_of_seats;
        $variable['booked_service'] = $order->category->title;
        $variable['staff_member'] = $order->staff->name;
        $variable['startdate'] = date('Y-m-d', strtotime($order->order_time));
        $variable['starttime'] = date('H:i:s', strtotime($order->order_time));
        $variable['endtime'] = date('H:i:s', strtotime("+{$order->category->time_in_minutes} minutes", strtotime($order->order_time)));
		$variable['admin_logo'] = self::getAdminLogo();
	
		$variable['merchant_logo'] = self::getMerchantLogo($order->merchant);
		
        $variable['currency_code'] = \common\components\Helper::getCurrencyCode($order->merchant);
        $variable['addons_list'] = \common\components\Helper::getOrderAddonsList($order);
        $body = self::getBody($option, $variable);
        
        
        
        $subject = \frontend\models\Option::getValByName('email_tpl_sub_merchant_appointment_cancelled', $language);;
        
        $adminEmail = self::adminSendEmail('email_tpl_sub_admin_appointment_cancelled', 'email_tpl_admin_appointment_cancelled', $variable, $email_provider);
        
        if($email_provider == 0){
            self::sendPhpEmail($order->merchant->contact_email, $subject, $body);
        }else if($email_provider == 1){
            self::sendSmtpEmail($order->merchant->contact_email, $subject, $body);
        }
    }


    public static function newAppointmentMerchant($order){
        $language = $order->merchant->language->code;
        
        $option = \frontend\models\Option::getValByName('email_tpl_merchant_new_appointment', $language);
        
        $email_provider = \frontend\models\Option::getValByName('email_provider');
        $variable = [];
        
        $variable['merchant_name'] = $order->merchant->service_name;
        $variable['customer_name'] = $order->client->first_name.' '.$order->client->last_name;
        $variable['booked_seats'] = $order->no_of_seats;
        $variable['booked_service'] = $order->category->title;
        $variable['staff_member'] = $order->staff->name;
        $variable['startdate'] = date('Y-m-d', strtotime($order->order_time));
        $variable['starttime'] = date('H:i:s', strtotime($order->order_time));
        $variable['endtime'] = date('H:i:s', strtotime("+{$order->category->time_in_minutes} minutes", strtotime($order->order_time)));
        
	$variable['coupon_amount'] = "";
	$variable['coupon_used'] = "";
	$variable['loyalty_points_used'] = "";
	$variable['loyalty_points_amount'] = "";
	
	$total  = $order->price;
	if(!empty($order->voucher_amount)){
		$total = $order->price - $order->voucher_amount;
		$variable['coupon_amount'] = $order->voucher_amount;
		$variable['coupon_used'] = $order->coupone->voucher_name;
	}
	if(!empty($order->loyalty_points_amount)){
		$total = $order->price - $order->loyalty_points_amount;
		$variable['loyalty_points_amount'] = $order->loyalty_points_amount;
		$variable['loyalty_points_used'] = $order->loyalty_points;
	}
	
	
	
	$variable['booking_total'] = $order->price;
	$variable['currency_code'] = \common\components\Helper::getCurrencyCode($order->merchant);
	
	$variable['admin_logo'] = self::getAdminLogo();
	
	$variable['merchant_logo'] = self::getMerchantLogo($order->merchant);
        
		$variable['addons_list'] = \common\components\Helper::getOrderAddonsList($order);
        
        $body = self::getBody($option, $variable);
        
        
        
        $subject = \frontend\models\Option::getValByName('email_tpl_sub_merchant_new_appointment', $language);;
        
        $adminEmail = self::adminSendEmail('email_tpl_sub_admin_new_appointment', 'email_tpl_admin_new_appointment', $variable, $email_provider);
        
        if($email_provider == 0){
            self::sendPhpEmail($order->merchant->contact_email, $subject, $body);
        }else if($email_provider == 1){
            self::sendSmtpEmail($order->merchant->contact_email, $subject, $body);
        }
        
    }


    
    public static function newAppointment($order){
        $language = $order->merchant->language->code;
        $option = \frontend\models\Option::getValByName('email_tpl_customer_appointment', $language);
        
        $email_provider = \frontend\models\Option::getValByName('email_provider');
        $variable = [];
        $variable['first_name'] = $order->client->first_name;
        $variable['last_name'] = $order->client->last_name;
        $variable['merchant_name'] = $order->merchant->service_name;
        $variable['merchant_address'] = $order->merchant->address;
        $variable['booked_service'] = $order->category->title;
        $variable['staff_member'] = $order->staff->name;
        $variable['startdate'] = date('Y-m-d', strtotime($order->order_time));
        $variable['starttime'] = date('H:i:s', strtotime($order->order_time));
        $variable['endtime'] = date('H:i:s', strtotime("+{$order->category->time_in_minutes} minutes", strtotime($order->order_time)));
        $variable['currency_code'] = \common\components\Helper::getCurrencyCode($order->merchant);
		
		$total  = $order->price;
		if(!empty($order->voucher_amount)){
			$total = $order->price - $order->voucher_amount;
		}
		if(!empty($order->loyalty_points_amount)){
			$total = $order->price - $order->loyalty_points_amount;
		}

		$variable['booking_total'] = $order->price;
			$variable['booked_seats'] = $order->no_of_seats;

		$variable['admin_logo'] = self::getAdminLogo();

		$variable['merchant_logo'] = self::getMerchantLogo($order->merchant);
		
		$variable['addons_list'] = \common\components\Helper::getOrderAddonsList($order);
        
        $body = self::getBody($option, $variable);
	
        
        $subject = \frontend\models\Option::getValByName('email_tpl_sub_customer_appointment', $language);;
        
        $subvariable = [];
        $subvariable['merchant_name'] = $order->merchant->service_name;
        
        $subject = self::getBody($subject, $subvariable);

	    if (ClientNotificationFilter::check($order->client->client_id, 1)) {
		    if ($email_provider == 0) {
			    self::sendPhpEmail($order->client->email_address, $subject, $body);
		    } else if ($email_provider == 1) {
			    self::sendSmtpEmail($order->client->email_address, $subject, $body);
		    }
	    }
		$mid=$order->merchant->merchant_id;
		$cid=$order->client_id;
		$merchant = Merchant::find()->where(['merchant_id'=>$mid])->one();
		$client = Client::find()->where(['client_id'=>$cid])->one();
		if($merchant->enable_sms==1 && ($client->notification==1 || $client->notification==2)){
			MessagebirdManager::sendsmsAppointment($order);
		}
    }


    public static function passwordResetRequest($user){
        
        $language = 'de';
        
        $option = \frontend\models\Option::getValByName('email_tpl_customer_forgot_password', $language);
        
        $email_provider = \frontend\models\Option::getValByName('email_provider');
        $variable = [];
        $variable['first_name'] = $user->first_name;
        $variable['last_name'] = $user->last_name;
        $variable['link'] = \yii\helpers\Html::a('Click to change password',Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]));
        
        $body = self::getBody($option, $variable);
        
        $subject = 'Password Reset Request.';
        
        $subject = \frontend\models\Option::getValByName('email_tpl_sub_customer_forgot_password', $language);;
        
        if($email_provider == 0){
            $mail = self::sendPhpEmail($user->email_address, $subject, $body);
        }else if($email_provider == 1){
            $mail = self::sendSmtpEmail($user->email_address, $subject, $body);
        }
        
        return $mail;
    }
    
    
    
	public static function customerAccountActivate($customer,$merchantId = NULL){

		$language = 'de';

		$option = \frontend\models\Option::getValByName('email_tpl_customer_user_welcome_activation', $language);

		$email_provider = \frontend\models\Option::getValByName('email_provider');
		$variable = [];
		$variable['first_name'] = $customer->first_name;
		$variable['last_name'] = $customer->last_name;
		$variable['activation_key'] = $customer->activation_key;
		$variable['password'] = $customer->password;
		$variable['site_link'] = self::SiteLink();
		
		$variable['merchant_name'] = "";
		
		if(!empty($merchantId)){
			$merchant = \frontend\models\MtMerchant::findOne(['merchant_id' => $merchantId]);
			$variable['merchant_name'] = $merchant->service_name;
			
		}

		$body = self::getBody($option, $variable);
		
		

		$subject = 'Account Activation.';

		$subject = \frontend\models\Option::getValByName('email_tpl_sub_customer_user_welcome_activation', $language);;


		$adminEmail = self::adminSendEmail('email_tpl_sub_admin_new_customer_register', 'email_tpl_admin_new_customer_register', $variable, $email_provider);

		if( ClientNotificationFilter::check($customer->client_id, 6) ) {
			if($email_provider == 0){
				self::sendPhpEmail($customer->email_address, $subject, $body);
			}else if($email_provider == 1){
				self::sendSmtpEmail($customer->email_address, $subject, $body);
			}
		}
	}
    
    public static function getBody($option, $variable){
        
        foreach($variable as $key => $value)
        {
                //print_r($value);
		$option = str_replace('/{'.$key.'}', $value, $option);
                $option = str_replace('{'.$key.'}', $value, $option);
        }
        
        return $option;
        
    }
    
    public static function sendPhpEmail($emailAddress, $subject, $body ){
        $headers = "From: appointmentapp.com<www-data@appointmentapp>\r\n";
        $headers .= "To: " . strip_tags($emailAddress) . " <" . $emailAddress . ">\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        
        //echo 'i ma here';
        
        $email = @mail($emailAddress, $subject, $body, $headers);
        
        //exit;
        
        return $email;
        
	   
    }
    
    public static function sendSmtpEmail($emailAddress, $subject, $body ){
        
        $smtpHost = \frontend\models\Option::getValByName('smtp_host');
        $smtpPort = \frontend\models\Option::getValByName('smtp_port');
        $smtpUsername = \frontend\models\Option::getValByName('smtp_username');
        $smtpPassword = \frontend\models\Option::getValByName('smtp_password');
        
        $smtp = new \yii\swiftmailer\Mailer;
        $smtp->transport = [
            
            'class' => 'Swift_SmtpTransport',
            'host' => $smtpHost,
            'username' => $smtpUsername,
            'password' => $smtpPassword,
            'port' => $smtpPort,
            'encryption' => 'tls',
            
            
        ];
        
        $smtp->compose()
        ->setFrom('noreply@aondego.com')
        ->setTo($emailAddress)
        ->setSubject($subject)
        ->setHtmlBody($body)
        ->send();
        
        return true;
    }
}

