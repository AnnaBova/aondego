<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Client', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'client_id',
            'social_strategy',
            'first_name',
            'last_name',
            'email_address:email',
            // 'password',
            // 'street',
            // 'city',
            // 'state',
            // 'zipcode',
            // 'country_code',
            // 'location_name:ntext',
            // 'contact_phone',
            // 'lost_password_token',
            // 'date_created',
            // 'date_modified',
            // 'last_login',
            // 'ip_address',
            // 'status',
            // 'token',
            // 'mobile_verification_code',
            // 'mobile_verification_date',
            // 'custom_field1',
            // 'custom_field2',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
