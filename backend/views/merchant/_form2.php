<?php

use backend\components\AdminHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
?>

<?php 
echo $form->field($model,'package_id')
        ->dropDownList(ArrayHelper::map(\common\models\Packages::find()->all(), 'package_id', 'title'), 
                [
                    'prompt' => 'select package'
                ]);
 ?>


<?php echo $form->field($model,'is_featured')->checkBox(); ?>

<?php echo $form->field($model,'is_sponsored')->checkBox(); ?>


<?php 
echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'sponsored_expiration',
        'template' => '{input}{addon}',
            'clientOptions' => [
                'startDate'=> "today",
                'autoclose' => true,
                'defaultDate' =>  'today',
                'minDate' => 'today',
                'format' => 'yyyy-mm-dd'
            ]
    ]);
?>
<?php echo $form->field($model,'sort_featured'); ?>