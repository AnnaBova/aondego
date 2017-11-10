<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\MtMerchantCc */

$this->title = 'Update Mt Merchant Cc: ' . $model->mt_id;
$this->params['breadcrumbs'][] = ['label' => 'Mt Merchant Ccs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mt_id, 'url' => ['view', 'id' => $model->mt_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mt-merchant-cc-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
