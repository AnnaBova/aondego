<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CustomPage */

$this->title = Yii::t('basicfield', 'Create Custom Page');
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Custom Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


