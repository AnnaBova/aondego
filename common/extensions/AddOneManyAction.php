<?php
namespace common\extensions;
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 22-Feb-16
 * Time: 13:53
 */

class AddOneManyAction extends \yii\base\Action 
{

    public function run()
    {
        //$this->controller->renderPartial('site.common.extensions.views.addOne',[],false,true);
        
        return $this->controller->renderAjax('@common/extensions/views/addOne');
        Yii::$app->end();
    }
} 