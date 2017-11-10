<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\MtCustomPage */

$this->title = 'Update Mt Custom Page: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mt Custom Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mt-custom-page-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
