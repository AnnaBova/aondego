<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 18-Feb-16
 * Time: 22:35
 */
?>
<div class="item-holder form-inline">
    <?php

    if($item->isNewRecord){
        $id = Yii::app()->securityManager->generateRandomString(7);

    }else{

        $id = $item->id;
        echo CHtml::activeHiddenField($item,"[$id]id");
    }

    foreach($this->model->{$this->behaviour}->fields as $val){
        switch ($val['type']){
             case 'time':
                $this->widget(
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
                        'wrapperHtmlOptions' => array('class' => 'col-md-3'),
                        'htmlOptions' => array('class' => 'form-control'),
                    )
                );
                break;
            case 'textInput':
                echo CHtml::activeTextField($item,"[$id]{$val['attr']}",[ 'class' => 'form-control','style'=>'width:250px']);
                break;
            case 'date':
              $this->widget(
                 'booster.widgets.TbDatePicker',
                 array(
                     'model'=>$item,
                     'attribute'=> "[$id]{$val['attr']}",
                     'options'=>[
                     'format' => 'yyyy-mm-dd',],
                     'htmlOptions' => array('class' => 'form-control ','id'=>"id2_$id-{$val['attr']}",'style'=>'width:250px', 'placeholder'=>'select date'),
                 )
             );
                break;
            case 'dropDown':
                echo CHtml::activeDropDownList($item,"[$id]{$val['attr']}",$val['data'],[ 'class' => 'form-control ','style'=>'width:250px', 'prompt'=>'leave empty if free day']);

    }
    }
    ?>

    <?= CHtml::button('X', ['class' => 'btn btn-danger btn-xs item-dell'] ) ?>

</div>
<br>