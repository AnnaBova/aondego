<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 19-May-16
 * Time: 15:22
 */

class DashboardHelper {
    public static function getNewMerchantToday()
    {
        $crit = new CDbCriteria();

        $crit->addCondition('date_created>="'.date('Y-m-d 00:00:00').'"');

        return Merchant::model()->count($crit);
    }

    public static function getAllMerchants()
    {
        return Merchant::model()->count();
    }

    /**
     * @return string
     */
    public static function getOrdersLast24H()
    {
        $crit = new CDbCriteria();

        $crit->addCondition('create_time>="' . date('Y-m-d H:i:s',strtotime('-1 day')) . '"');

        return Order::model()->count($crit);
    }

    /**
     * @return string
     */
    public static function getCountServices()
    {
        return CategoryHasMerchant::model()->count();
    }

    /**
     * @return string
     */
    public static function getCountCategories()
    {


        return ServiceSubcategory::model()->count();
    }


    public static function getAllOrders()
    {

        return Order::model()->count();
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

    }

    /**
     * @return string
     */
    public static function getCountReview(){
        return Review::model()->count();
    }

    public static function getPopularCats(){
        $crit = new CDbCriteria();
        $crit->select = 'COUNT(*) as count_by_date, category_id';

        $crit->group = 'category_id';
        $crit->order = 'count_by_date DESC';
        $crit->addCondition('create_time>="' . date('Y-01-01 00:00:00') . '"');
        $crit -> limit = 4;
        $models = Order::model()->findAll($crit);


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
        $crit = new CDbCriteria();
        $crit->select = 'MONTH(create_time) as date_of_order, COUNT(id) as count_by_date, create_time';
        $crit->group = 'MONTH(create_time)';
        $crit->condition = 'create_time>="'.date('Y-01-01').'"';
        $crit->order = 'create_time';

        $orders = Order::model()->findAll($crit);

        return CJSON::encode(self::getArrayFromOrdersByMonth($orders));

    }

    public static  function CountSingleByMonth()
    {
        $crit = new CDbCriteria();
        $crit->select = 'MONTH(create_time) as date_of_order, COUNT(id) as count_by_date, create_time';
        $crit->group = 'MONTH(create_time)';
        $crit->condition = 'create_time>="'.date('Y-01-01').'"';
        $crit->order = 'create_time';
        $orders = SingleOrder::model()->findAll($crit);

        return CJSON::encode(self::getArrayFromOrdersByMonth($orders));
    }

    public static  function CountGroupByMonth()
    {
        $crit = new CDbCriteria();
        $crit->select = 'MONTH(create_time) as date_of_order, COUNT(id) as count_by_date, create_time';
        $crit->group = 'MONTH(create_time)';
        $crit->condition = 'create_time>="'.date('Y-01-01').'"';
        $crit->order = 'create_time';

        $orders = GroupOrder::model()->findAll($crit);

        return CJSON::encode(self::getArrayFromOrdersByMonth($orders));
    }

    public static function getArrayFromOrdersByMonth($orders){
        $arr = [];
        $monthes = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $k = 0;
        for($i=0;$i<=12;$i++){
            if($monthes[$i]>date('m')) break;
            if(isset($orders[$k])){
                if(date('m',strtotime($orders[$k]->create_time)) == $monthes[$i] ){
                    $arr[] =$orders[$k]->count_by_date;
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