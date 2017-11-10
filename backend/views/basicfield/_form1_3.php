<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BasicField */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">
    
    <?php if(Yii::$app->controller->action->id == 'update'){
     \backend\components\Translatte::getLanguage($model);
    }?>

    <?php $form = ActiveForm::begin(); ?>
<div class="box-body">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    
</div>
    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
