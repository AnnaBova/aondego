<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ServiceSubcategory */

$this->title = Yii::t('basicfield', 'Create Service Subcategory');
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Service Subcategories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-subcategory-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
