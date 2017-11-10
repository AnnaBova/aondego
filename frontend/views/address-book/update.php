<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\MtAddressBook */

$this->title = 'Update Address Book: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mt Address Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mt-address-book-update">
    <?php if(isset($model->id)){?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php }?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
