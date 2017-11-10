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
            }
        }

        $res = array_values(array_unique(array_merge(self::$freeMerchantDays, self::$freeStaffDays[$staff_id])));

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
    public static function isMerchantWork($d, $t, $m)
    {
        
        $s = \common\models\MerchantSchedule::find()->where(['work_date' => $d, 'merchant_id' => Yii::$app->user->id])->one();
        if ($s) {
           
            if ($s->scheduleDaysTemplate) {
                foreach ($s->scheduleDaysTemplate->timeRanges as $val) {
                    if ($val->time_from <= $t && $val->time_to > date('H:i', strtotime("+$m minutes", strtotime($t)))) {
                        return true;
                    }
                }
            }
        } else {
            
            if (Yii::$app->user->identity->lastSchedule && Yii::$app->user->identity->lastSchedule->{strtolower(date('D', strtotime($d)))}) {
                
                $tr = \common\models\ScheduleDaysTemplate::find()->where(['id'=>Yii::$app->user->identity->lastSchedule->{strtolower(date('D', strtotime($d)))}])->one();
                
                
                foreach ($tr->timeRanges as $val) {
                    
                    
                    if ($val->time_from <= $t && $val->time_to > date('H:i', strtotime("+$m minutes", strtotime($t)))) {
                        
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static function isStaffWork($d, $t, $m, $staff, $u, $c)
    {
        //echo $c;
        //print_r($staff->attributes);
        if ($staff->staffVacations) {

//            $crit = new CDbCriteria();
//            $crit->condition = 'start_date<="' . $d . '" AND end_date>="' . $d . '"';
//            $crit->addCondition('staff_id=' . $staff->id);
            
            $condition = 'start_date<="' . $d . '" AND end_date>="' . $d . '" and staff_id=' . $staff->id;
            
            if (\common\models\StaffVacation::find()->where($condition)->one()) return false;

        }
        $s = \common\models\StaffSchedule::find()->where(['work_date' => $d, 'staff_id' => $staff->id])->one();

        if ($s) {
            
            if ($s->scheduleDaysTemplate) {
                foreach ($s->scheduleDaysTemplate->timeRanges as $val) {
                    if ($val->time_from <= $t && $val->time_to > date('H:i', strtotime("+$m minutes", strtotime($t)))) {

                        return self::issetOrder($d, $t, $m, $staff->id, $u, $c);
                    }
                }
            }
        } else {
            
            
            if ($staff->lastSchedule && $staff->lastSchedule->{strtolower(date('D', strtotime($d)))}) {
                $tr = \common\models\ScheduleDaysTemplate::findOne($staff->lastSchedule->{strtolower(date('D', strtotime($d)))});
                
                
                
                
                foreach ($tr->timeRanges as $val) {
                    if ($val->time_from <= $t && $val->time_to > date('H:i', strtotime("+$m minutes", strtotime($t)))) {
                        
                        return self::issetOrder($d, $t, $m, $staff->id, $u, $c);
                    }
                }
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
        
//        if($c){
//           $condition .= ' and category_id = ' . $c;
//        }
        
        //print_r($crit);
        if ($u) {
            $condition .= ' and id!=' . $u;
            
        }
        $orders = \common\models\SingleOrder::find()->where($condition)->all();

        $cOrders = \common\models\CachedSingleOrder::getOrdersByStaffAndDay($staff_id,$d);
//        echo $d . ' ' . $t;
//        echo '<pre>';
//        print_r($cOrders);

        
        foreach ($orders + $cOrders as $order) {
            
            $date2 = date('H:i', strtotime($order->order_time));
            $order->orderTimeLength;
            
            $date3 = date('H:i', strtotime("+$order->orderTimeLength minutes", strtotime($order->order_time)));
//            
//            
//            echo $t;
//            echo '<br>';
//            echo $date2;
//            echo '<br>';
            
            
            //exit;
            
            
            
            if($t == $date2 || ($t < $date3 && $t > $date2)){
                //echo 'condition if';
                return false;
            
            }else if($t < $date2){
                
//                print_r($order->attributes);
//                echo 'condition else';
                
                $diff1 = strtotime($date2) - strtotime($t);
                $totalDiff = $diff1/60;
                
                
                if($totalDiff < $m){
                    return false;
                }
                
                
            }
            
            
            
            
//            $ot = date('Y-m-d H:i', strtotime($order->order_time));
//            
//            
//            $date1 = date('Y-m-d H:i', strtotime("+" . $order->orderTimeLength . " minutes", strtotime($ot)));
//        
//            $date2 = date('H:i', strtotime("+$m minutes", strtotime($t)));
//            
//            $date3 = date('Y-m-d H:i', strtotime("+" . $order->orderTimeLength . " minutes", strtotime($ot)));
//
//            
//            if (($ot == $d . ' ' . $t) || (($ot <= $d . ' ' . $t) && ($d . ' ' . $t < $date1)) ||
//            //if (($ot == $d . ' ' . $t) || (($d . ' ' . $t < $date1)) ||
//                (($ot < $d . ' ' . $date2) && ($d . ' ' . $date2 <= $date1))
//            ) {
//                //echo 'i m here';
//                return false;
//            }
        }
        //exit;
        return true;

    }

    public static function getStaffOrders($staff_id, $range_start, $range_end)
    {
        $result = [];

        $staff = \common\models\Staff::findOne($staff_id);
        
       

        foreach ($staff->futureOrders as $order) {
            if ($order->order_time >= $range_start.' 00:00:00' && $order->order_time <= $range_end.' 00:00:00')
                $result[] = [
                    'id' => $order->id,
                    'title' => $order->client_name,
                    'start' => date('Y-m-d\TH:i:s', strtotime($order->order_time)),
                    'end' => date('Y-m-d\TH:i:s', strtotime("+{$order->orderTimeLength} minutes", strtotime($order->order_time))),
                    'url' => Yii::$app->urlManager->createUrl(['order/update-inst', 'id'=>$order->id]) ,
                    'backgroundColor' => $order->category->color,

                ];
        }

        foreach ($staff->futureStaffVacations as $vacation) {
            $result[] = [
                'start' => $vacation->start_date,
                'end' => date('Y-m-d', strtotime('+1 day', strtotime($vacation->end_date))),
                'rendering' => 'background',
                'overlap' => false,
                'color' => '#ff9f89'
            ];
        }

        foreach ($staff->futureFreeStaffSchedules as $val) {

            $result[] = [
                'start' => $val->work_date,
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
                    
                    
                    
                    $k = 0;
                    do {

                        GroupScheduleHelper::init(strtotime("+$k day", $dStart->getTimestamp()), $model->id);
                        $dayGroupSchedule = GroupScheduleHelper::getDateSchedule(strtotime("+$k day", $dStart->getTimestamp()), $model->id);
                         
                        if ($dayGroupSchedule['models']) {
                            foreach ($dayGroupSchedule['models'] as $val) {
                                
                                $result[] = [
                                    'id' => 'g-' . strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()) . ' ' . $val->time_start . ':00')). $model->id,
                                    'title' => $model->title . ' (' . $val->time_start . ') left:' . ($model->group_people - \common\models\GroupOrder::countByDate(date('Y-m-d H:i:s', strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()) . ' ' . $val->time_start . ':00'))), $model->id)),
                                    'start' => date('Y-m-d\TH:i:s', strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()) . ' ' . $val->time_start . ':00'))),
                                    'end' => date('Y-m-d\TH:i:s', strtotime("+{$model->time_in_minutes} minutes", strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()) . ' ' . $val->time_start . ':00')))),
                                    'url' => Yii::$app->urlManager->createUrl(['group-order/get-group-orders', 'id'=>$model->id , 'date_id' =>strtotime("+$k day", strtotime(date('Y-m-d', $dStart->getTimestamp()) . ' ' . $val->time_start . ':00'))]),
                                    'backgroundColor' => $model->color,

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
               // 'url' => '/order/updateInst/' . $order->id,
                'backgroundColor' => '#000000',

            ];
        }


        return json_encode($result);
    }

} 