<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Language */

$this->title = Yii::t('app', 'Create Language');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<a href="<?php echo Yii::$app->urlManager->createUrl('language/create')?>" class="btn btn-default">Create</a>
<a href="<?php echo Yii::$app->urlManager->createUrl('language/index')?>" class="btn btn-default">List</a>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

