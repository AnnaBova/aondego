<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MerchantSchedule */

$this->title = Yii::t('app', 'Create Merchant Schedule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Merchant Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="merchant-schedule-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
