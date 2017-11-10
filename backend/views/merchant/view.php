<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Merchant */

$this->title = $model->merchant_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Merchants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="merchant-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->merchant_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->merchant_id], [
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
            'merchant_id',
            'service_name',
            'service_phone',
            'contact_name',
            'contact_phone',
            'contact_email:email',
            'country_code',
            'street:ntext',
            'city',
            'state',
            'post_code',
            'cuisine:ntext',
            'service',
            'free_delivery',
            'delivery_estimation',
            'username',
            'password',
            'activation_key',
            'activation_token',
            'status',
            'date_created',
            'date_modified',
            'date_activated',
            'last_login',
            'ip_address',
            'package_id',
            'package_price',
            'membership_expired',
            'payment_steps',
            'is_featured',
            'is_ready',
            'is_sponsored',
            'sponsored_expiration',
            'lost_password_code',
            'user_lang',
            'membership_purchase_date',
            'sort_featured',
            'is_commission',
            'percent_commission',
            'fixed_commission',
            'session_token',
            'commission_type',
            'seo_title',
            'seo_description',
            'seo_keywords',
            'url:url',
            'manager_username',
            'manager_password',
            'manager_extended',
            'fb',
            'tw',
            'gl',
            'yt',
            'it',
            'paypall_id',
            'paypall_pass',
            'gmap_altitude',
            'gmap_latitude',
            'gallery_id',
            'address',
            'vk',
            'pr',
            'is_purchase',
            'description:ntext',
            'password_hash',
            'password_reset_token',
            'auth_key',
        ],
    ]) ?>

</div>
