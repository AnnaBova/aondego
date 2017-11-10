<?php
namespace common\extensions;
use Yii;
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-Mar-16
 * Time: 22:50
 */

class GroupScheduleHelper {

     public static $merchantAdditionalSchedule;
    public static $groupAdditionalSchedule;
    public static $groups;

    public static function init($date, $group_id){
        
        

       
        $condition = 'merchant_id='.Yii::$app->user->id.' and work_date >='.date('Y-m-d',$date).' and work_date <= '.date('Y-m-d',strtotime("next Sunday",$date));
        
        if(is_null(self::$merchantAdditionalSchedule))
            self::$merchantAdditionalSchedule = \yii\helpers\ArrayHelper::map(
            \common\models\MerchantSchedule::find()->where($condition)->all(),'work_date','model');
        
//        echo '<pre>';
//        print_r($group_id);
//        echo '</pre>';
        
        
        $condition = 'group_id='.$group_id.' and work_date >= "'.date('Y-m-d',$date).'" and work_date <= "'.date('Y-m-d',strtotime("next Sunday",$date)).'"';
        //echo '<br>';
        self::$groupAdditionalSchedule[$group_id] = \yii\helpers\ArrayHelper::map(\common\models\GroupSchedule::find()->where($condition)->all(),'work_date', 'model');

        
       //print_r(self::$groupAdditionalSchedule);
        
        if(is_null(self::$groups))
            self::$groups = \yii\helpers\ArrayHelper::map(\common\models\CategoryHasMerchant::find()->where(['merchant_id'=>Yii::$app->user->id, 'is_group'=>1,'is_active'=>1])->all(),'id','model');
    
       
        
    }
    public static function checkGroupServices($group , $d, $t, $m){
        
        foreach ($group as $model) {
            
                $k = 0;
                $dStart = new \DateTime($d);

                \common\extensions\GroupScheduleHelper::init(strtotime("+$k day", $dStart->getTimestamp()), $model->id);
                $dayGroupSchedule = \common\extensions\GroupScheduleHelper::getDateSchedule(strtotime("+$k day", $dStart->getTimestamp()), $model->id);

                if ($dayGroupSchedule['models']) {
                    foreach ($dayGroupSchedule['models'] as $val) {
                        
                        $date2 = $val['time_start'];
                        //print_r($val['time_start']);
                        
                        $date3 = date('H:i', strtotime("+$m minutes", strtotime($val['time_start'])));
                        
                        if($t == $date2 || ($t < $date3 && $t > $date2)){

                            return false;

                        }else if($t < $date2){

                            $diff1 = strtotime($date2) - strtotime($t);
                            $totalDiff = $diff1/60;
                            
                            //exit;
                            if($totalDiff < $m){
                                
                                return false;
                            }


                        }
                    }

                }
            }
            
            return true;
        
    }
    

    public static function getDateSchedule($date, $group_id)
    {
        
        $dateSQL = date('Y-m-d', $date);//exit;
        
        
        if(isset(self::$merchantAdditionalSchedule[$dateSQL])) {
            
            if(self::$merchantAdditionalSchedule[$dateSQL]->schedule_days_template_id)
            $currentMerchantSchedule =  [
                'reason' => self::$merchantAdditionalSchedule[$dateSQL]->reason,
                'type'=> 1,
                'model'=>self::$merchantAdditionalSchedule[$dateSQL]->scheduleDaysTemplate
            ];
            else return
                [
                    'reason' => self::$merchantAdditionalSchedule[$dateSQL]->reason,
                    'type'=> 1,
                    'models'=>''
                ];
        }
        else{
            if(Yii::$app->user->identity->lastSchedule && Yii::$app->user->identity->lastSchedule->{strtolower(date('D',$date))}){
                $currentMerchantSchedule =  [
                    'reason' => '',
                    'type'=> 2,
                    'model'=>  \common\models\ScheduleDaysTemplate::findOne(Yii::$app->user->identity->lastSchedule->{strtolower(date('D',$date))})
                ];

            }

            else
                return   [
                    'reason' => '',
                    'type'=> 2,
                    'models'=>''
                ];

        }
	
//	echo $group_id;
//	echo '<br>';
//	
//	echo $dateSQL;
//	
//	print_r(self::$groupAdditionalSchedule[$group_id][$dateSQL]);

        
        if(isset(self::$groupAdditionalSchedule[$group_id][$dateSQL])) {
		
		
            
            if(self::$groupAdditionalSchedule[$group_id][$dateSQL]->schedule_days_template_id){
                $schedule = \common\models\GroupSchedule::findOne(['id' => 27]);
                
//                print_r($schedule);
//                print_r(self::$groupAdditionalSchedule[$group_id][$dateSQL]);
                $currentGroupSchedule = [
                    'reason' => self::$groupAdditionalSchedule[$group_id][$dateSQL]->reason,
                    'type'=> 3,
                    'model'=>self::$groupAdditionalSchedule[$group_id][$dateSQL]->groupScheduleDaysTemplate
                ];
            }
            else
                return
                    [
                        'reason' => self::$groupAdditionalSchedule[$group_id][$dateSQL]->reason,
                        'type'=> 3,
                        'models'=>''
                    ];

        }
        else{ $varval = strtolower(date('D',$date));
            if(self::$groups[$group_id]->lastSchedule&&self::$groups[$group_id]->lastSchedule->$varval){

                $currentGroupSchedule = [
                    'reason' => '',
                    'type' => 4,
                    'model' => \common\models\GroupScheduleDaysTemplate::findOne(self::$groups[$group_id]->lastSchedule->$varval)
                ];
            }else{
                return
                    [
                    'reason' => '',
                    'type' => 4,
                    'models' => ''
                    ];
            }
        }
        
        

        $result = [];
        $nonSorted = $currentGroupSchedule['model']->groupTimeRanges;
        
        
        foreach($currentMerchantSchedule['model']->timeRanges as $val){
            
            foreach($nonSorted as $key => $res){
                
                //print_r($res);
                if($res->time_start>=$val->time_from&& date("H:i", strtotime('+30 minutes', strtotime($res->time_start)))<=$val->time_to ){
                    $result[] = $res;
                    unset($nonSorted[$key]);
                }
            }
        }

        return [
            'reason' =>$currentMerchantSchedule['reason'].' '.$currentMerchantSchedule['reason'],
            'type' =>'',
            'models' => $result
        ];

    }

} 