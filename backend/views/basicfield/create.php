<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BasicField */

$this->title = 'Create Basic Field';
$this->params['breadcrumbs'][] = ['label' => 'Basic Fields', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="basic-field-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
