<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Client */

$this->title = $model->client_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->client_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->client_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'client_id',
            'social_strategy',
            'first_name',
            'last_name',
            'email_address:email',
            'password',
            'street',
            'city',
            'state',
            'zipcode',
            'country_code',
            'location_name:ntext',
            'contact_phone',
            'lost_password_token',
            'date_created',
            'date_modified',
            'last_login',
            'ip_address',
            'status',
            'token',
            'mobile_verification_code',
            'mobile_verification_date',
            'custom_field1',
            'custom_field2',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'activation_key',
            'dob',
        ],
    ]) ?>

</div>
