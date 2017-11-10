<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\MtAddressBook */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mt Address Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mt-address-book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'client_id',
            'street',
            'city',
            'state',
            'zipcode',
            'location_name',
            'country_code',
            'as_default',
            'date_created',
            'date_modified',
            'ip_address',
        ],
    ]) ?>

</div>
