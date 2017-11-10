<?php

use backend\components\AdminHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php echo $form->field($model,'is_commission')->checkBOx(); ?>

<?php 
echo $form->field($model,'commission_type')->dropDownList([1=>'General settings commission',2=>'Package commission',3=>'Fixed',4=>'Percentage'],
        ['prompty' => 'Select type'] );
?>

<?php echo $form->field($model,'percent_commission'); ?>

<?php echo $form->field($model,'fixed_commission'); ?>
