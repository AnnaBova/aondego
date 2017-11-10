<?php
namespace common\extensions;
use Yii;

/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-Mar-16
 * Time: 22:50
 */
class SingleScheduleHelper
{

    public static $merchantAdditionalSchedule;
    public static $groupAdditionalSchedule;
    public static $groups;

    public static $freeMerchantDays = null;
    public static $freeStaffDays;

    /**
     * @param $staff_id
     * @return string
     */
    public static function getEmptyDays($staff_id)
    {
        $days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
        if (is_null(self::$freeMerchantDays)) {
            self::$freeMerchantDays = [];

            foreach ($days as $key => $day) {
                if (empty(Yii::$app->user->identity->lastSchedule) || empty(Yii::$app->user->identity->lastSchedule->$day)) {
                    self::$freeMerchantDays[] = $key;
                }
            }
        }

        if (!isset(self::$freeStaffDays[$staff_id])) {
            $staff = \common\models\Staff::findOne($staff_id);
	    
	    
	    
            self::$freeStaffDays[$staff_id] = [];
            foreach ($days as $key => $day) {
                if (empty($staff->lastSchedule) || empty($staff->lastSchedule->$day)) {
			
			
			self::$freeStaffDays[$staff_id][] = $key;
			
			
                }
		
		if(!empty($staff->futureStaffSchedules)){
			foreach ($staff->futureStaffSchedules as $futureSchedule){
				
				$dateFormat = date('Y-m-d', strtotime($futureSchedule->work_date));
				


				$date = new \DateTime($dateFormat);
				$dayFuture =  date_format($date, 'D');
				
				$dayFuture = strtolower($dayFuture);
				
				
				if($dayFuture == $day){
					$daykeys = array_search($dayFuture, $days);
					if($daykeys){
					
						$arraysearch = array_search($daykeys, self::$freeStaffDays[$staff_id]);
						
						if($arraysearch)
						unset(self::$freeStaffDays[$staff_id][$arraysearch]);
					}
						
					
				}



			}
				
		}
            }
        }

        $res = array_values(array_unique(array_merge(self::$freeMerchantDays, self::$freeStaffDays[$staff_id])));
	
//	echo '<pre>';
//	print_r($res);
//	echo '</pre>';

        if (count($res) == 7) {
            return false;
        } else
            return json_encode($res);

    }

    /**
     * @param $d
     * @param $t
     * @param $m
     * @return bool
     */
    public static function isMerchantWork($d,$m)
    {
        $d = date('Y-m-d', strtotime($d));
	
		$condition = 'merchant_id = '.Yii::$app->user->id. ' and "'.$d.'" BETWEEN work_date AND work_date';

			$s = \common\models\MerchantSchedule::find()
			->where($condition)
			->one();



		if ($s) {



				if ($s->scheduleDaysTemplate) {

					//foreach ($s->scheduleDaysTemplate->timeRanges as $val) {
						//if ($val->time_from <= $t && $val->time_to > date('H:i', strtotime("+$m minutes", strtotime($t)))) {
							return true;
						//}
					//}
				}
			} else {

				if (Yii::$app->user->identity->lastSchedule && Yii::$app->user->identity->lastSchedule->{strtolower(date('D', strtotime($d)))}) {

					$tr = \common\models\ScheduleDaysTemplate::find()->where(['id'=>Yii::$app->user->identity->lastSchedule->{strtolower(date('D', strtotime($d)))}])->one();
					
					if($tr->timeRanges){
						return true;
					}

					//foreach ($tr->timeRanges as $val) {


						//if ($val->time_from <= $t && $val->time_to > date('H:i', strtotime("+$m minutes", strtotime($t)))) {

							
						//}
					//}
				}
			}
			return false;
    }

    public static function isStaffWork($d, $t, $m, $staff, $u, $c)
    {
		
        $d = date('Y-m-d', strtotime($d));
	
	
        //print_r($staff->attributes);
		
		$staffVacation = \common\models\StaffVacation::findOne(['staff_id' => $staff['id']]);
		
        if ($staffVacation) {
		
            
            $condition = 'start_date<="' . $d . '" AND end_date>="' . $d . '" and staff_id=' . $staff['id'];
            
            if (\common\models\StaffVacation::find()->where($condition)->one()) return false;

        }
        $s = \common\models\StaffSchedule::find()->where(['work_date' => $d, 'staff_id' => $staff['id']])->one();
	
	
        if ($s) {
		
		
		
		
            
            if ($s->scheduleDaysTemplate) {
                //foreach ($s->scheduleDaysTemplate->timeRanges as $val) {
                    //if ($val->time_from <= $t && $val->time_to > date('H:i', strtotime("+$m minutes", strtotime($t)))) {

                        return self::issetOrder($d, $t, $m, $staff['id'], $u, $c);
                    //}
                //}
            }
        } else {
		
		
			$lastSchedule = \common\models\StaffScheduleHistory::find()->where(['staff_id' => $staff['id']])->orderBy('id desc')->one();
            
            if ($lastSchedule && $lastSchedule->{strtolower(date('D', strtotime($d)))}) {
                $tr = \common\models\ScheduleDaysTemplate::findOne($lastSchedule->{strtolower(date('D', strtotime($d)))});
                
                
                
                
                //foreach ($tr->timeRanges as $val) {
                    //if ($val->time_from <= $t && $val->time_to > date('H:i', strtotime("+$m minutes", strtotime($t)))) {
                        if($tr->timeRanges)
                        return self::issetOrder($d, $t, $m, $staff['id'], $u, $c);
                    //}
                //}
            }
        }

        return false;
    }

    public static function issetOrder($d, $t, $m, $staff_id, $u = 0, $c=0)
    {
        
        
//        $crit = new CDbCriteria();
//        $crit->condition = 'staff_id = ' . $staff_id;
//        $crit->addCondition('order_time>="' . date('Y-m-d', strtotime($d)) . ' 00:00:00"');
//        $crit->addCondition('order_time<"' . date('Y-m-d', strtotime($d)) . ' 23:59:00"');
        
        $condition = 'order_time>="' . date('Y-m-d', strtotime($d)) . ' 00:00:00"';
        $condition .= ' and order_time<"' . date('Y-m-d', strtotime($d)) . ' 23:59:00"';
        $condition .= ' and staff_id = ' . $staff_id;
        $condition .= ' and status !=2';
        
        //echo $condition;
        
//        if($c){
//           $condition .= ' and category_id = ' . $c;
//        }
        
        //print_r($crit);
        if ($u) {
            $condition .= ' and id!=' . $u;
        }
        
        $orders = \common\models\SingleOrder::find()->where($condition)->all();

        $cOrders = \common\models\CachedSingleOrder::getOrdersByStaffAndDay($staff_id,$d);
        
        

        
        foreach ($orders + $cOrders as $order) {
            
            //print_r($order->attributes);
            
            $date2 = date('H:i', strtotime($order->order_time));
//            echo $order->orderTimeLength;
//            echo '<br>';
            
            $date3 = date('H:i', strtotime("+$order->orderTimeLength minutes", strtotime($order->order_time)));
//            
//            
//            echo $t;
//            echo '<br>';
//            echo $date2;
//            echo '<br>';
            
            
            //exit;
            
            
            //echo 'date2 --- '.$date3;
            
            if($t == $date2 || ($t < $date3 && $t > $date2)){
                
                return false;
            
            }else if($t < $date2){
                
                $diff1 = strtotime($date2) - strtotime($t);
                $totalDiff = $diff1/60;
//                echo 'i mahere';
//                echo $t;
                //exit;
                if($totalDiff < $m){
                    return false;
                }
                
                
            }
            

        }
        
        return true;

    }

    public static function getStaffOrders($staff_id, $range_start, $range_end)
    {
	    
	    
        $result = [];

        $staff = \common\models\Staff::findOne($staff_id);
		
        foreach ($staff->futureOrders as $order) {
			
		//$name = utf8_encode($order->category->title);
		
		//$categoryName = substr($name, 0, 25);
		
		if ($order->order_time >= $range_start.' 00:00:00' && $order->order_time <= $range_end.' 00:00:00')
            $description = 'Service: '.$order->category->title.'<br>';
			$addons = \common\components\Helper::getOrderAddonsList($order);
			if(!empty($addons)){
				$description .= 'Addons : '.$addons;
			}
				
			$result[] = [
				'id' => $order->id,
				'title' => $order->client_name,
				'start' => date('Y-m-d\TH:i:s', strtotime($order->order_time)),
				'end' => date('Y-m-d\TH:i:s', strtotime("+{$order->orderTimeLength} minutes", strtotime($order->order_time))),
				'url' => Yii::$app->urlManager->createUrl(['order/update-inst', 'id'=>$order->id]) ,
				'backgroundColor' => $order->category->color,
				'description' => $description,

			];
        }
		
		if($staff->futureStaffSchedules){
			foreach ($staff->futureStaffSchedules as $extraSchedule){
				
				$result[] = [
                    
					'title' => $extraSchedule->reason,
					'start' => date('Y-m-d', strtotime($extraSchedule->work_date)),
					'end' => date('Y-m-d', strtotime("+1 day", strtotime($extraSchedule->work_date))),
					//'rendering' => 'background',
					'overlap' => false,
					'color' => '#e10000',
					'description' => 'Extra Schedule: '.$extraSchedule->reason

                ];
				
			}
			
		}
		
		
		//print_r($staff->futureStaffSchedules);
		
		//exit;
		
		
	
	

        foreach ($staff->futureStaffVacations as $vacation) {
			
            $result[] = [
				'title' => $vacation->remark,
                'start' => date('Y-m-d', strtotime($vacation->start_date)),
                'end' => date('Y-m-d', strtotime('+1 day', strtotime($vacation->end_date))),
                //'rendering' => 'background',
                'overlap' => false,
                'color' => '#e10000',
				'description' => 'Vacation: '.$vacation->remark
            ];
			
			
        }
		
		//print_r($result);

        foreach ($staff->futureFreeStaffSchedules as $val) {

            $result[] = [
                'start' => date('Y-m-d', strtotime($val->work_date)),
                'end' => date('Y-m-d', strtotime('+1 day', strtotime($val->work_date))),
                'rendering' => 'background',
                'overlap' => false,
                'color' => '#ff9f89'
            ];
        }
        if ($staff->staff_has_category) {
            if ($range_start < date('Y-m-d'))
                $range_start = date('Y-m-d');
            if ($range_end < date('Y-m-d'))
                $range_end = date('Y-m-d');
            if ($range_start != $range_end) {
				
				
                $dStart = new \DateTime($range_start);
                $dEnd = new \DateTime($range_end);
                $dDiff = $dStart->diff($dEnd);
                $diff = $dDiff->days;
		
		
		
				
		
               

                foreach ($staff->groupCat as $model) {
					
					
					//print_r($model->attributes);
					
                    
                    
                    
                    $k = 0;
                    do {

                        GroupScheduleHelper::init(strtotime("+$k day", $dStart->getTimestamp()), $model->id);
                        $dayGroupSchedule = GroupScheduleHelper::getDateSchedule(strtotime("+$k day", $dStart->getTimestamp()), $model->id);
                        // echo $k;
			
//			print_r(date('Y-m-d\TH:i:s', strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp())). ' ' . $val->time_start . ':00')));
//			echo '<br>';
//			echo date('Y-m-d\TH:i:s', strtotime("+{$model->time_in_minutes} minutes", strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp())) . ' ' . $val->time_start . ':00')));
//			exit;
			
                        if ($dayGroupSchedule['models']) {
                            foreach ($dayGroupSchedule['models'] as $val) {
								
								//echo strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()). ' ' . $val->time_start . ':00'));
								
								//echo $d = date('Y-m-d', $dStart->getTimestamp()). ' ' . $val->time_start;
								
								//$startDate = strtotime("+$k day", strtotime($d));
								//echo $k;
								//echo date('Y-m-d\TH:i:s', $startDate);
								
								//echo date('Y-m-d\TH:i:s', strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()) . ' ' . $val->time_start . ':00')));
								
								$timeStart = date('H:i:s', strtotime($val->time_start));
								
								$s = $k-1;
								$ordertime = date('Y-m-d\TH:i:s', strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()) . ' ' . $timeStart)));
								
								$left = \common\models\GroupOrder::countByDate($ordertime, $model->id);
                                
								if(empty($left)){
									$left = 0;
								}
								
								$left = $model->group_people - $left;
								
								
								
                                $result[] = [
                                    'id' => 'g-' . strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()) . ' ' . $timeStart)). $model->id,
                                    'title' => $model->title . ' (' . $val->time_start . ') left:' . ($model->group_people - \common\models\GroupOrder::countByDate(date('Y-m-d H:i:s', strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()) . ' ' . $timeStart))), $model->id)),
                                    'start' => date('Y-m-d\TH:i:s', strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()) . ' ' . $timeStart))),
                                    'end' => date('Y-m-d\TH:i:s', strtotime("+{$model->time_in_minutes} minutes", strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()) . ' ' . $timeStart)))),
                                    'url' => Yii::$app->urlManager->createUrl(['group-order/get-group-orders', 'id'=>$model->id , 'date_id' =>strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()). ' ' . $timeStart))]),
                                    'backgroundColor' => $model->color,
									'description' => 'Service: '.$left.' seats left'

                                ];

                            }
                        }
                        $k++;

                    } while ($k < $diff);
                }
            }


        }

        $blocked = \common\models\CachedSingleOrder::getOrdersByStaffAndRange($staff_id, $range_start, $range_end);
        foreach($blocked as $order){
            $result[] = [
                'id' => uniqid(),
                'title' => 'blocked',
                'start' => date('Y-m-d\TH:i:s', strtotime($order->order_time)),
                'end' => date('Y-m-d\TH:i:s', strtotime("+{$order->orderTimeLength} minutes", strtotime($order->order_time))),
				'url' => Yii::$app->urlManager->createUrl(['order/update-inst', 'id'=>$order->id]) ,
                'backgroundColor' => '#000000',

            ];
        }
	
	
//	print_r($result);
//	
//	if(is_array($result)){
//		echo 'i here';
//		
//	}
	
	
	
	//echo \yii\helpers\Json::encode(($result));

        return \yii\helpers\Json::encode($result);
    }

} 