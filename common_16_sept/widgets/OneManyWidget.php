<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 18-Feb-16
 * Time: 22:27
 */

class OneManyWidget extends CWidget {

    public $model = null;
    public $action = null;
    public $saction = 'OneMany';
    public $behaviour = 'oneManyBehavior';
    public $field = 'oneMany';

    public function run()
    {
        if(is_null($this->model)||is_null($this->action)){
            throw  new CHttpException(500,'Wrong widget init');
        }else{

            $this->{$this->action}();

        }
    }

    public function OneMany(){
        $this->render('oneMany');
    }

    public  function AddOne()
    {
        $this->render('_addOne',['item'=> new $this->model->{$this->behaviour}->relationModel()]);
    }
}
