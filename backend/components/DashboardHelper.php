<?php
namespace backend\components;

use Yii;
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 19-May-16
 * Time: 15:22
 */

class DashboardHelper {
    
    static $month = [
        '1' => 'January',
        '2' => 'Feburary',
        '3' => 'March',
        '4' => 'April',
        '5' => 'May',
        '6' => 'June',
        '7' => 'July',
        '8' => 'August',
        '9' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
        
    ];
    
    
    public static function getAllOrdersVoucher()
    {
        
        $sql = 'SELECT count(*) as total FROM `order` where   is_service_gift=1';
        $query = Yii::$app->db->createCommand($sql)->queryOne();
        return $query['total'];
    }


    public static function getNewMerchantToday()
    {
        $sql = 'SELECT count(*) as total FROM mt_merchant where date_created>="'.date('Y-m-d 00:00:00').'"';
        $query = Yii::$app->db->createCommand($sql)->queryOne();

        return $query['total'];
    }

    public static function getAllMerchants()
    {
        $sql = 'SELECT COUNT(*) as total FROM `mt_merchant` ';
        $query = Yii::$app->db->createCommand($sql)->queryOne();

        return $query['total'];
        
    }

    /**
     * @return string
     */
    public static function getOrdersLast24H()
    {
        
        $sql = 'SELECT COUNT(*) as total FROM `order` where create_time >= "' . date('Y-m-d H:i:s',strtotime('-1 day')) . '"';
        $query = Yii::$app->db->createCommand($sql)->queryOne();

        return $query['total'];
    }
    
    public static function getOrdersLast24HVoucher()
    {
        
        $sql = 'SELECT count(*) as total FROM `order` where (create_time>="' . date('Y-m-d 00:00:00') . '"  and create_time<="'.date('Y-m-d 23:59:59').'") and status !=2 and is_service_gift=1';
        $query = Yii::$app->db->createCommand($sql)->queryOne();

        return $query['total'];
    }

    /**
     * @return string
     */
    public static function getCountServices()
    {
        $sql = 'SELECT COUNT(*) as total FROM category_has_merchant';
        $query = Yii::$app->db->createCommand($sql)->queryOne();

        return $query['total'];
        
    }

    /**
     * @return string
     */
    public static function getCountCategories()
    {

        $sql = 'SELECT COUNT(*) as total FROM mt_service_subcategory';
        $query = Yii::$app->db->createCommand($sql)->queryOne();

        return $query['total'];
        
    }


    public static function getAllOrders()
    {
        $sql = 'SELECT COUNT(*) as total FROM `order` ';
        $query = Yii::$app->db->createCommand($sql)->queryOne();

        return $query['total'];

        
    }

    public static function getCountStaff()
    {
        return Staff::model()->count();
    }

    public static function getOrdersThisMonth()
    {
        $crit = new CDbCriteria();
        $crit->addCondition('create_time>="'.date('Y-m-01 00:00:00').'" AND create_time<="'.date('Y-m-d 23:59:59').'"');

        return Order::model()->count($crit);
    }

    public static function getCatsOfMerchant()
    {
        return CategoryHasMerchant::model()->findAll();
    }

    public static function avgRating(){
        $sql = 'SELECT ceil(AVG(rating)) as total FROM `mt_review` ';
        $query = Yii::$app->db->createCommand($sql)->queryOne();
        return $query['total'];

    }

    /**
     * @return string
     */
    public static function getCountReview(){
        $sql = 'SELECT COUNT(*) as total FROM `mt_review` ';
        $query = Yii::$app->db->createCommand($sql)->queryOne();

        return $query['total'];
        
    }
    
    public static  function getCountReviewLast(){
        
        $lastMonth = date('Y-m-01', strtotime('-1 months', strtotime(date('Y-m-d'))));
        
        $lastDay  = date("Y-m-t", strtotime($lastMonth));
        
        
        $sql = "SELECT COUNT(*) as total, DATE(date_created) as date_created FROM `mt_review` where date_created between '$lastMonth' and '$lastDay'";
        $query = Yii::$app->db->createCommand($sql)->queryOne();
        
        return $query['total'];

    }

    public static function getPopularCats(){
//        $crit = new CDbCriteria();
//        $crit->select = 'COUNT(*) as count_by_date, category_id';
//
//        $crit->group = 'category_id';
//        $crit->order = 'count_by_date DESC';
//        $crit->addCondition('create_time>="' . date('Y-01-01 00:00:00') . '"');
//        $crit -> limit = 4;
        
        
        $models = \frontend\models\Order::find()
                ->select('COUNT(*) as count_by_date, category_id')
                ->where('create_time>="' . date('Y-01-01 00:00:00') . '"')
                ->groupBy('category_id')
                ->orderBy('count_by_date DESC')
                ->limit(4)
                ->asArray()
                ->all();


        return $models;
    }


    public static function getDateForGraph(){
        $crit = new CDbCriteria();
        $crit->select = 'COUNT(id) as count_by_date, DATE(order_time) as date_of_order';
        $crit->group = 'date_of_order';
        $crit->order = 'order_time';
        $crit->addCondition('create_time>="' . date('Y-01-01 00:00:00') . '"');
        $models = Order::model()->findAll($crit);
        $res = [];
        foreach($models as $key => $val){
            $res[] = ['y' => date('Y').' Q'.($key+1),'item1'=>$val->count_by_date];
        }
        return CJSON::encode($res);
    }

    public static  function CountByMonth()
    {
//        $crit = new CDbCriteria();
//        $crit->select = 'MONTH(create_time) as date_of_order, COUNT(id) as count_by_date, create_time';
//        $crit->group = 'MONTH(create_time)';
//        $crit->condition = 'create_time>="'.date('Y-01-01').'"';
//        $crit->order = 'create_time';

        $orders = $models = \frontend\models\Order::find()
                ->select('MONTH(create_time) as date_of_order, COUNT(id) as count_by_date, create_time')
                ->where('create_time>="'.date('Y-01-01').'"')
                ->groupBy('MONTH(create_time)')
                ->orderBy('create_time')
                ->asArray()
                ->all();
//        echo '<pre>';
//        print_r($orders);
//        exit;
        
         
        $today = date('Y-m-d');
        //$today = '2016-03-04';
        $previousDate = date('Y-m-01', strtotime('-6 months', strtotime($today)));
        
        $sql = "SELECT MONTH(create_time) as date_of_order, DATE(create_time) as create_time, COUNT(id) as count_by_date from `order`
                    where  create_time >= '$previousDate' AND create_time <= '$today' group by date_of_order ";
        
        $query = Yii::$app->db->createCommand($sql)->queryAll();
        
        $month = [];
        $dataa = [];
        
        foreach ($query as $data){
            $month[] = self::$month[$data['date_of_order']];
            $dataa[] = $data['count_by_date'];
            
        }
        
        
        
        return ['month' => \yii\helpers\Json::encode($month), 'data' => \yii\helpers\Json::encode($dataa)];
                

        //return \yii\helpers\Json::encode(self::getArrayFromOrdersByMonth($orders));

    }

    public static  function CountSingleByMonth()
    {
//        $crit = new CDbCriteria();
//        $crit->select = 'MONTH(create_time) as date_of_order, COUNT(id) as count_by_date, create_time';
//        $crit->group = 'MONTH(create_time)';
//        $crit->condition = 'create_time>="'.date('Y-01-01').'"';
//        $crit->order = 'create_time';
        
        
//        $orders = $models = \common\models\SingleOrder::find()
//                ->select('MONTH(create_time) as date_of_order, COUNT(id) as count_by_date, create_time')
//                ->where('create_time>="'.date('Y-01-01').'"')
//                ->groupBy('MONTH(create_time)')
//                ->orderBy('create_time')
//                ->asArray()
//                ->all();
        
        //$orders = SingleOrder::model()->findAll($crit);
        
        $today = date('Y-m-d');
        //$today = '2016-03-04';
        $previousDate = date('Y-m-01', strtotime('-6 months', strtotime($today)));
        
        $sql = "SELECT MONTH(create_time) as date_of_order, DATE(create_time) as create_time, COUNT(id) as count_by_date from `order`
                    where  (create_time >= '$previousDate' AND create_time <= '$today') and is_group=0 group by date_of_order ";
        
        $query = Yii::$app->db->createCommand($sql)->queryAll();
        
        $month = [];
        $dataa = [];
        
        foreach ($query as $data){
            $month[] = self::$month[$data['date_of_order']];
            $dataa[] = $data['count_by_date'];
            
        }
        
        return ['month' => \yii\helpers\Json::encode($month), 'data' => \yii\helpers\Json::encode($dataa)];
        
        

        //return \yii\helpers\Json::encode(self::getArrayFromOrdersByMonth($orders));
    }

    public static  function CountGroupByMonth()
    {
//        $crit = new CDbCriteria();
//        $crit->select = 'MONTH(create_time) as date_of_order, COUNT(id) as count_by_date, create_time';
//        $crit->group = 'MONTH(create_time)';
//        $crit->condition = 'create_time>="'.date('Y-01-01').'"';
//        $crit->order = 'create_time';
        
//        $orders = $models = \frontend\models\Order::find()
//                ->select('MONTH(create_time) as date_of_order, COUNT(id) as count_by_date, create_time')
//                ->where('create_time>="'.date('Y-01-01').'"')
//                ->groupBy('MONTH(create_time)')
//                ->orderBy('create_time')
//                ->asArray()
//                ->all();
        
        $today = date('Y-m-d');
        //$today = '2016-03-04';
        $previousDate = date('Y-m-01', strtotime('-6 months', strtotime($today)));
        
        $sql = "SELECT MONTH(create_time) as date_of_order, DATE(create_time) as create_time, COUNT(id) as count_by_date from `order`
                    where  (create_time >= '$previousDate' AND create_time <= '$today') and is_group=1 group by date_of_order ";
        
        $query = Yii::$app->db->createCommand($sql)->queryAll();
        
        $month = [];
        $dataa = [];
        
        foreach ($query as $data){
            $month[] = self::$month[$data['date_of_order']];
            $dataa[] = $data['count_by_date'];
            
        }
        
        return ['month' => \yii\helpers\Json::encode($month), 'data' => \yii\helpers\Json::encode($dataa)];
        

        //return \yii\helpers\Json::encode(self::getArrayFromOrdersByMonth($orders));
    }

    public static function getArrayFromOrdersByMonth($orders){
        $arr = [];
        $monthes = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $k = 0;
        for($i=0;$i<=12;$i++){
            if($monthes[$i]>date('m')) break;
            if(isset($orders[$k])){
                if(date('m',strtotime($orders[$k]['create_time'])) == $monthes[$i] ){
                    $arr[] =$orders[$k]['count_by_date'];
                    $k++;
                }
                else{
                    $arr[] =0;
                }
            }else{
                $arr[] =0;
            }
        }
        return $arr;
    }

} 