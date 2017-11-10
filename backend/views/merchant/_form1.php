<?php

use backend\components\AdminHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
?>

<?php  ?>
<?=Html::img($model->behaviors['imageBehavior']->getImageUrl(),['style'=>'width:150px;']) ?>

<?php echo $form->field($model,'service_name')->textInput(); ?>



<?php echo $form->field($model,'url')->textInput(); ?>


<?php  echo $form->field($model, 'description')->widget(Widget::className(), [
                'settings' => [
                   
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                        'fullscreen'
                    ]
                ]
            ]);?>

	<?php echo $form->field($model,'service_phone'); ?>

	<?php echo $form->field($model,'contact_name'); ?>

	<?php echo $form->field($model,'contact_phone'); ?>

	<?php echo $form->field($model,'contact_email'); ?>

	<?php echo $form->field($model,'country_code'); ?>

	<?php echo $form->field($model,'street')->textArea(array('rows'=>6, 'cols'=>50)); ?>

	<?php echo $form->field($model,'city'); ?>

	<?php echo $form->field($model,'state'); ?>

	<?php echo $form->field($model,'post_code'); ?>


	<?php echo $form->field($model,'status')->checkBox(); ?>

        <?php echo $form->field($model,'is_activate')->checkBox(); ?>

