<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-Jan-16
 * Time: 20:32
 */


$this->title = Yii::t('app', 'Profile');
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?=Yii::t('default','Update')?> <?= Yii::t('default','Profile')?> <?php echo Yii::$app->user->identity->username; ?></h1>

<?php echo $this->render('_form',array('model'=>$model)); ?>