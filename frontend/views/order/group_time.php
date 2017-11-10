<?php

use yii\helpers\Html;

if($model['models']){
    foreach ($model['models'] as $data){
        $select = isset($selected) ? "checked : 'checked'" : "";
        //echo '<input type="radio"  value="'.$data.'" '.$select.' name="AddToCart[time_req]"> '. $data;
		$style = '';
		if($selected == $data){
			$style = 'style=background:#167a7b;';
		}
		$name = '<a '.$style.' class="btn_4 select-free-time" href="javascript:void(0)" data-name="'.$data.'">'.$data.'</a>';
		echo $name = Html::tag('li',($name));

    }
}else{
    echo 'No time avaiable for this date.';
}

