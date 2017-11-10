<?php

namespace common\components;
use Yii;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Helper{
	
	public static function getOrderAddonsList($order){
		$addons = "";
		if(!empty($order->addons)){
			$addons .= '<ul>';
			foreach ($order->addons as $data){
			
				$addons .= '<li>';
				$addons .= $data->nameWithPriceAndTime;
				$addons .= '</li>';
				
			}
			$addons .= '</ul>';
			
		}
		return $addons;
	}
	
	
	public static function getCurrencyCode($merchant = null){
		
		$currency = '€';
		
		if(!empty($merchant->currency->currency_symbol)){
			$currency = $merchant->currency->currency_symbol;
		}
		
		return $currency;
		
	}
	
	public static function showHidePrice($merchant = null){
		return $merchant->show_price_widget;
	}

		
	public static function dateFormat($model = NULL){
		
		$isMerchant = Yii::$app->params['is_merchant'];
		
		$defaultDateFormat = 'dd-mm-yyyy';
		
		if($isMerchant){
			if(!empty(Yii::$app->user->identity)) $model = Yii::$app->user->identity;
			
			$defaultDateFormat = $model->date_picker_format;
			
		}
		
		return $defaultDateFormat;
	}
	
	public static function getDateFormatYii($format){
		
		if($format == 'yyyy-mm-dd') $format = 'yyyy-MM-dd';
		if($format == 'dd-mm-yyyy') $format = 'dd-MM-yyyy';
		if($format == 'd/m/yy') $format = 'D/M/yyyy';
		
		return $format;
		
	}
	
	public static function getDateFormatGrid($format){
		
		if($format == 'yyyy-mm-dd') $format = 'YYYY-MM-DD';
		if($format == 'dd-mm-yyyy') $format = 'DD-MM-YYYY';
		if($format == 'mm-dd-yyyy') $format = 'MM-DD-YYYY';
		
		return $format;
		
	}
	
	public static function timeFormat($model = NULL){
		
		$isMerchant = Yii::$app->params['is_merchant'];
		
		$defaultDateFormat = false;
		
		if($isMerchant){
			if(!empty(Yii::$app->user->identity)) $model = Yii::$app->user->identity;
			
			if(!empty($model->time_picker_format)){
				
				if($model->time_picker_format == 24) $defaultDateFormat = false;
				if($model->time_picker_format == 12) $defaultDateFormat = true;
				
				
				
			}
			
			
			
		}
		
		return $defaultDateFormat;
	}
	
	
	public static function showDateFormat($model = NULL){
		
		$isMerchant = Yii::$app->params['is_merchant'];
		
		$defaultDateFormat = 'd-m-Y';
		
		if(isset($isMerchant) && $isMerchant == true){
			if(!empty(Yii::$app->user->identity)) $model = Yii::$app->user->identity;
			
			if(!empty($model->date_format))
			$defaultDateFormat = $model->date_format;
			
		}
		
		return $defaultDateFormat;
	}
	
	public static function showTimeFormat($model = NULL){
		
		$isMerchant = Yii::$app->params['is_merchant'];
		
		$defaultTimeFormat = 'G:i:s';
		
		if($isMerchant){
			if(!empty(Yii::$app->user->identity)) $model = Yii::$app->user->identity;
			
			if(!empty($model->time_format))
			$defaultTimeFormat = $model->time_format;
			
		}
		
		return $defaultTimeFormat;
	}
}

