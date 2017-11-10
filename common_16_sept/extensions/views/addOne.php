<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 22-Feb-16
 * Time: 16:15
 * @property CController $this
 */

if($this->action->id == 'addOneMany2'){

    $this->widget('OneManyWidget', ['model'=>$this->getNewModel(),'action'=>'AddOne', 'behaviour'=>'vacationBehavior']);
}else
$this->widget('OneManyWidget',['model'=> $this->getNewModel(),'action'=>'AddOne']);