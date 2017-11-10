<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 22-Feb-16
 * Time: 16:15
 * @property CController $this
 */

if($this->context->action->id == 'addOneMany2'){
    
    echo common\widgets\OneManyWidget::widget([
        'model'=>$this->context->getNewModel(),'action'=>'AddOne', 'behaviour'=>'vacationBehavior'
    ]);

    //$this->widget('OneManyWidget', ['model'=>$this->getNewModel(),'action'=>'AddOne', 'behaviour'=>'vacationBehavior']);
}else
    echo common\widgets\OneManyWidget::widget(['model'=> $this->context->getNewModel(),'action'=>'AddOne']);
//$this->widget('OneManyWidget',['model'=> $this->getNewModel(),'action'=>'AddOne']);