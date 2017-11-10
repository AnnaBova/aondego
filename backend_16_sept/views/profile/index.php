<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-Jan-16
 * Time: 20:32
 */

$this->breadcrumbs=array(
    Yii::t('default','profile'),
);
?>
    <h1><?=Yii::t('default','Update')?> <?= Yii::t('default','Profile')?> <?php echo Yii::app()->user->model->username; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>