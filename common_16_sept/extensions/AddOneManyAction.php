<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 22-Feb-16
 * Time: 13:53
 */

class AddOneManyAction extends CAction
{

    public function run()
    {
        $this->controller->renderPartial('site.common.extensions.views.addOne',[],false,true);
        Yii::app()->end();
    }
} 