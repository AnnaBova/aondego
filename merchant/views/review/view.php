<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Review */
var_dump($comments);
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reviews'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
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
            'id',
            'merchant_id',
            'client_id',
            'review:ntext',
            'rating',
            'status',
            'date_created',
            'ip_address',
            'order_id',
            'name',
            'email:email',
            'food_review',
            'price_review',
            'punctuality_review',
            'courtesy_review',
        ],
    ]) ?>

</div>
<?php

    if ( $comments && is_array($comments) ){
?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="page-header">
                <h1><small class="pull-right"><?php echo count($comments) ?></small> Comments </h1>
            </div>
            <div class="comments-list">
<?php
         foreach($comments as $comment){
?>
             <div class="media">
                 <p class="pull-right"><small><?php echo $comment['created_at'] ?></small></p>
                 <a class="media-left" href="#">
                     <img src="<?php echo'/upload/merchant/'.$comment['photo'] ?>" style="width: 50px;">
                 </a>
                 <div class="media-body">

                     <h4 class="media-heading user_name"><?php echo $comment['name'] ?></h4>
                         <?php echo $comment['body'] ?>

<!--                     <p><small><a href="">Like</a> - <a href="">Share</a></small></p>-->
                 </div>
             </div>
<?php
         }
    }
?>