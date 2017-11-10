<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BasicField */

$this->title = 'Update Basic Field: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Basic Fields', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="basic-field-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
