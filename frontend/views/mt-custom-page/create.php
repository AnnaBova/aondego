<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\MtCustomPage */

$this->title = 'Create Mt Custom Page';
$this->params['breadcrumbs'][] = ['label' => 'Mt Custom Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mt-custom-page-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
