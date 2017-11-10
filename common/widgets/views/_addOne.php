<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 18-Feb-16
 * Time: 22:35
 */

use \yii\helpers\Html;
use dosamigos\datepicker\DatePicker;
use kartik\time\TimePicker;
?>
<div class="item-holder form-inline">
    <?php

    if($item->isNewRecord){
        $id = Yii::$app->getSecurity()->generateRandomString(7);

    }else{

        $id = $item->id;
        echo Html::hiddenInput("[$id]id", $item->id);
    }
    
//    echo '<pre>';
//    print_r($this->context->model->behaviors);
//    print_r($this->context->model->behaviors[$this->context->behaviour]->fields);
    
    
    foreach($this->context->model->behaviors[$this->context->behaviour]->fields as $val){
	
        switch ($val['type']){
             case 'time':
                 
                echo TimePicker::widget([
                    'model' => $item,
                    'attribute' => "[$id]{$val['attr']}", 
                    'id'=>"id_$id-{$val['attr']}",
                    'value' => '11:24 AM',
                    'pluginOptions' => [
                        'showSeconds' => false,
                        'showMeridian' => false,
                        'minuteStep' => 15,

                    ]
                ]);
                /*$this->widget(
                    'booster.widgets.TbTimePicker',
                    array(
                        'model'=>$item,
                        'attribute'=> "[$id]{$val['attr']}",
                        'id'=>"id_$id-{$val['attr']}",
                        'noAppend' => true, // mandatory
                        'options' => array(
                            'disableFocus' => true, // mandatory
                            'showMeridian' => false, // irrelevant
                            'minuteStep'=>5,
                            'defaultTime'=>'12:00'
                        ),
                        //'wrapperHtmlOptions' => array('class' => 'col-md-3'),
                        'htmlOptions' => array('class' => 'form-control','style'=>'width:250px'),
                    )
                );*/
                break;
            case 'textInput':
                echo Html::activeTextInput($item,"[$id]{$val['attr']}",[ 'class' => 'form-control','style'=>'width:250px']);
                break;
            case 'date':
                
                echo DatePicker::widget([
                    'model' => $item,
                    'attribute' => "[$id]{$val['attr']}",
                    'template' => '{input}{addon}',
                        'clientOptions' => [
                            'startDate'=> "today",
                            'autoclose' => true,
                            'defaultDate' =>  'today',
                            'minDate' => 'today',
                            'format' => 'dd-mm-yyyy'
                        ]
                ]);
                
                /*$this->widget(
                   'booster.widgets.TbDatePicker',
                   array(
                       'model'=>$item,
                       'attribute'=> "[$id]{$val['attr']}",
                       'options'=>[
                       'format' => 'yyyy-mm-dd',],
                       'htmlOptions' => array('class' => 'form-control ','id'=>"id2_$id-{$val['attr']}",'style'=>'width:250px', 'placeholder'=>'select date'),
                   )
               );*/
                break;
            case 'dropDown':
		    
		    if(empty($val['data']) && $this->context->behaviour == 'oneManyBehavior'){
			    $val['data'] = \yii\helpers\ArrayHelper::map(common\models\ScheduleDaysTemplate::find()
				->where(['merchant_id'=>Yii::$app->user->id])->all(),'id','title');
			    
		    }
                echo Html::activeDropDownList($item, "[$id]{$val['attr']}",$val['data'],[ 'class' => 'form-control ','style'=>'width:250px', 'prompt'=>Yii::t('basicfield', 'leave empty if free day')]);

    }
    }
    ?>

    <?= Html::button('X', ['class' => 'btn btn-danger btn-xs item-dell'] ) ?>

</div>
<br>