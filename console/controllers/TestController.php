<?php
 
namespace console\controllers;
 
use yii\console\Controller;
 
/**
 * Test controller
 */
class TestController extends Controller {
 
    public function actionIndex() {
        $birthdayCoupon = new \common\models\UserBirthdayCoupon();
        $birthdayCoupon->code = 'test';
        $birthdayCoupon->save(false);
        echo "cron service runnning";
    }
 
    public function actionMail($to) {
        echo "Sending mail to " . $to;
    }
 
}