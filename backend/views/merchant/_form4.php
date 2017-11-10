<?php

use backend\components\AdminHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php echo $form->field($model,'is_purchase')->checkBox(); ?>
<?php echo $form->field($model,'is_ready')->checkBox(); ?>

<?php echo $form->field($model,'date_created')->textInput(['readonly' => true]); ?>

<?php echo $form->field($model,'membership_purchase_date')->textInput(['readonly' => true]); ?>

<?php echo $form->field($model,'date_modified')->textInput(['readonly' => true]); ?>

<?php echo $form->field($model,'date_activated')->textInput(['readonly' => true]); ?>

<?php echo $form->field($model,'membership_expired')->textInput(['readonly' => true]); ?>

<?php echo $form->field($model,'ip_address')->textInput(['readonly' => true]); ?>