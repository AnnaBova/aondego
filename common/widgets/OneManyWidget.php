<?php
namespace common\widgets;
use yii\base\Widget;
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 18-Feb-16
 * Time: 22:27
 */

class OneManyWidget extends Widget {

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

            return $this->{$this->action}();

        }
    }

    public function OneMany(){
        
        return $this->render('oneMany');
    }

    public  function AddOne()
    {
        
       
        return $this->render('_addOne',['item'=> new $this->model->behaviors[$this->behaviour]->relationModel()]);
    }
}
