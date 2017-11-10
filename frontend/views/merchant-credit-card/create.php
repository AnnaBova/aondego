<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\MtMerchantCc */

$this->title = 'Create Mt Merchant Cc';
$this->params['breadcrumbs'][] = ['label' => 'Mt Merchant Ccs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mt-merchant-cc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
