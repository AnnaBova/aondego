<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\MtReview */

$this->title = 'Create Mt Review';
$this->params['breadcrumbs'][] = ['label' => 'Mt Reviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mt-review-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
