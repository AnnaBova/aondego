<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Packages */

$this->title = Yii::t('basicfield', 'Create Packages');
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Packages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


