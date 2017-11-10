<?php
namespace frontend\components;

use Yii;
use common\models\MessagebirdDetails;
use common\models\Client;
use common\models\Merchant;

use merchant\components\Restapi;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class MessagebirdManager{
	public function sendsmsAppointment($order){
		$language = $order->merchant->language->code;
		$option = \frontend\models\Option::getValByName('sms_appointment', $language);
		
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
		$variable['booking_total'] = $order->price;
		$variable['booked_seats'] = $order->no_of_seats;

		$body = self::getBody($option, $variable);
		
       		
		$mid=$order->merchant_id;
		$cid=$order->client_id;
		$messagebird = MessagebirdDetails::find()->where(['merchant_id'=>$mid])->one();
		$client = Client::find()->where(['client_id'=>$cid])->one();
		$merchant = Merchant::find()->where(['merchant_id'=>$mid])->one();
		
		if($merchant->enable_sms==1 && ($client->notification==1||$client->notification)){
			$MessageBird = new \MessageBird\Client($messagebird->access_key);
			$Message = new \MessageBird\Objects\Message();
			$Message->originator = 'MessageBird';
			$Message->recipients = array($client->contact_phone);
			$Message->body = $body;
			
			try{
				$balance = $MessageBird->balance->read();


				if($balance->amount > 0){
					try {
						$MessageResult = $MessageBird->messages->create($Message);
						return true;


					} catch (\MessageBird\Exceptions\AuthenticateException $e) {
						// That means that your accessKey is unknown
						return false;

					} catch (\MessageBird\Exceptions\BalanceException $e) {
						// That means that you are out of credits, so do something about it.
						return false;

					} catch (\Exception $e) {
						return false;
					}

				}
			}catch (\MessageBird\Exceptions\BalanceException $e) {
				// That means that you are out of credits, so do something about it.
				return false;

			}
			//print_r('message sent');
		}
		
		return;
	}
	
	public function sendsmsReminderAppointment($order){
		$language = $order->merchant->language->code;
		$option = \frontend\models\Option::getValByName('sms_appointment_reminder', $language);
		
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
		$variable['booking_total'] = $order->price;
		$variable['booked_seats'] = $order->no_of_seats;

		$body = self::getBody($option, $variable);
		
       		
		$mid = $order->merchant_id;
		$cid = $order->client_id;
		
		$messagebird = MessagebirdDetails::find()->where(['merchant_id'=>$mid])->one();
		$client = Client::find()->where(['client_id'=>$cid])->one();
		$merchant = Merchant::find()->where(['merchant_id'=>$mid])->one();
		
		if($merchant->enable_sms==1 && ($client->notification==1||$client->notification)){
			$MessageBird = new \MessageBird\Client($messagebird->access_key);
			$Message = new \MessageBird\Objects\Message();
			$Message->originator = 'MessageBird';
			$Message->recipients = array($client->contact_phone);
			$Message->body = $body;
			$MessageBird->messages->create($Message);
			//print_r('message sent');
		}
		
		return;
	}
	
	
	
	public static function getBody($option, $variable){
        
		foreach($variable as $key => $value)
		{
			//print_r($value);
			$option = str_replace('{'.$key.'}', $value, $option);
		}
        
		return $option;
        
	}
	
	public static function sendsmsbirthday($user, $coupon, $userBirthdayCoupon){
        $language = $coupon->merchant->language->code;
        
        $option = \frontend\models\Option::getValByName('sms_birthday_coupon', $language);
        
        $variable = [];
        $variable['first_name'] = $user['first_name'];
        $variable['last_name'] = $user['last_name'];
        $variable['merchant_name'] = $coupon->merchant->service_name;
        $variable['coupon'] = $userBirthdayCoupon->code;
        $variable['coupon_expire'] = $coupon->expiration;
        
        if($coupon->voucher_type == 1){
            $coupon_value = $coupon->amount.'%';
        }else{
            $coupon_value = '€'.$coupon->amount;
        }
        
        $variable['coupon_amount'] = $coupon_value;
        
        $body = self::getBody($option, $variable);
         
//        echo '<pre>';
//        print_r($body);
        
		$mid=$coupon->merchant->merchant_id;
		$cid=$user->client_id;
		$messagebird = MessagebirdDetails::find()->where(['merchant_id'=>$mid])->one();
		$client = Client::find()->where(['client_id'=>$cid])->one();
		
        
			$MessageBird = new \MessageBird\Client($messagebird->access_key);
			$Message = new \MessageBird\Objects\Message();
			$Message->originator = 'MessageBird';
			$Message->recipients = array($client->contact_phone);
			$Message->body = $body;
			//$MessageBird->messages->create($Message);
			
			try{
				$balance = $MessageBird->balance->read();


				if($balance->amount > 0){
					try {
						$MessageResult = $MessageBird->messages->create($Message);
						return true;


					} catch (\MessageBird\Exceptions\AuthenticateException $e) {
						// That means that your accessKey is unknown
						return false;

					} catch (\MessageBird\Exceptions\BalanceException $e) {
						// That means that you are out of credits, so do something about it.
						return false;

					} catch (\Exception $e) {
						return false;
					}

				}
			}catch (\MessageBird\Exceptions\BalanceException $e) {
				// That means that you are out of credits, so do something about it.
				return false;

			}
			
		
        
        
    }
}