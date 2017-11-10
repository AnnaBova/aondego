<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SeoRule */

$this->title = Yii::t('basicfield', 'Update {modelClass}: ', [
    'modelClass' => 'Seo Rule',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Seo Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('basicfield', 'Update');
?>
<div class="seo-rule-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
