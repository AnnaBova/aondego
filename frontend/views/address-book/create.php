<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\MtAddressBook */

$this->title = 'Create Mt Address Book';
$this->params['breadcrumbs'][] = ['label' => 'Mt Address Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mt-address-book-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
