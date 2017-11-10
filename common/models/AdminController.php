<?php

namespace backend\components;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AdminController extends Controller {

    /**
     * @var string the default layout for the controller view. Defaults to 'column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = 'admin_tpl';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    /**
     * @return array action filters
     */
    

    public function behaviors() {

        parent::behaviors();
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                    'actions' => ['create', 'update', 'index', 'delete', 'admin', 'merchant', 'customer', 'language', 'getdata'],
                    'allow' => true,
                    'matchCallback' => function() {
                        return self::allowAccess();
                    }
                    ],
                ]
            ]
        ];
    }
    
    public function beforeAction($event)
    {
        $cookies = Yii::$app->request->cookies;
        
        $languageCookie = $cookies['language'];
        
        if(isset($languageCookie->value) && !empty($languageCookie->value)){
            Yii::$app->language = $languageCookie->value;
        }
        
        
        
        return parent::beforeAction($event);
    }

    public static function allowAccess() {

        $access = [];
        if(Yii::$app->user->id){
            $access = json_decode(Yii::$app->user->identity->user_access);
        }
        
        if (!Yii::$app->user->isGuest && in_array(Yii::$app->controller->id, (array) $access)) {
            
            return true;
        }
        return false;
    }

    public function init() {
        $this->menu = true;
    }
    
//    public function beforeAction($action,$controller){
//        ECHO '<pre>';
//        print_r($action);
//        ECHO 'i AHERE';
//        exit;
//    }

}
