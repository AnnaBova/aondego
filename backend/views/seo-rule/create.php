<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SeoRule */

$this->title = Yii::t('basicfield', 'Create Seo Rule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Seo Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seo-rule-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
