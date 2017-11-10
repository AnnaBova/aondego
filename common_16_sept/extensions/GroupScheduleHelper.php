<?php
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

        $criteria = new CDbCriteria();
        $criteria->condition = 'merchant_id = :id';
        $criteria->addCondition('work_date >= :date_start');
        $criteria->addCondition('work_date <= :date_end');
        $criteria->params = [':id'=>Yii::app()->user->id, ':date_start'=>date('Y-m-d',$date), ':date_end'=> date('Y-m-d',strtotime("next Sunday",$date))];
        if(is_null(self::$merchantAdditionalSchedule))
            self::$merchantAdditionalSchedule = CHtml::listData(MerchantSchedule::model()->findAll($criteria),'work_date','model');

        $criteria = new CDbCriteria();
        $criteria->condition = 'group_id = :id';
        $criteria->addCondition('work_date >= :date_start');
        $criteria->addCondition('work_date <= :date_end');
        $criteria->params = [':id'=>$group_id, ':date_start'=>date('Y-m-d',$date), ':date_end'=> date('Y-m-d',strtotime("next Sunday",$date))];


        self::$groupAdditionalSchedule[$group_id] = CHtml::listData(GroupSchedule::model()->findAll($criteria),'work_date', 'model');

        if(is_null(self::$groups))
            self::$groups = CHtml::listData(CategoryHasMerchant::model()->findAllByAttributes(['merchant_id'=>Yii::app()->user->id, 'is_group'=>1,'is_active'=>1]),'id','model');
    }

    public static function getDateSchedule($date, $group_id)
    {
        $dateSQL = date('Y-m-d', $date);
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
            if(Yii::app()->user->model->lastSchedule && Yii::app()->user->model->lastSchedule->{strtolower(date('D',$date))}){
                $currentMerchantSchedule =  [
                    'reason' => '',
                    'type'=> 2,
                    'model'=>ScheduleDaysTemplate::model()->findByPk(Yii::app()->user->model->lastSchedule->{strtolower(date('D',$date))})
                ];

            }

            else
                return   [
                    'reason' => '',
                    'type'=> 2,
                    'models'=>''
                ];

        }


        if(isset(self::$groupAdditionalSchedule[$group_id][$dateSQL])) {
            if(self::$groupAdditionalSchedule[$group_id][$dateSQL]->schedule_days_template_id)
                $currentGroupSchedule = [
                    'reason' => self::$groupAdditionalSchedule[$group_id][$dateSQL]->reason,
                    'type'=> 3,
                    'model'=>self::$groupAdditionalSchedule[$group_id][$dateSQL]->groupScheduleDaysTemplate
                ];
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
                    'model' => GroupScheduleDaysTemplate::model()->findByPk(self::$groups[$group_id]->lastSchedule->$varval)
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