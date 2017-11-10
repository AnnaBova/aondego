<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Packages */

$this->title = Yii::t('basicfield', 'Update {modelClass}: ', [
    'modelClass' => 'Packages',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Packages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->package_id]];
$this->params['breadcrumbs'][] = Yii::t('basicfield', 'Update');
?>
<div class="packages-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
