<?php
namespace backend\controllers;

use backend\components\AdminController;

/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-Jan-16
 * Time: 20:29
 */

class RptMerchantRegController extends AdminController {

    public function init(){
        $this->menu = false;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

} 