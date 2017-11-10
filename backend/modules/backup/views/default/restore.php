<?php
use yii\helpers\Html;
$this->breadcrumbs=array(
	'Backup'=>array('backup'),
	'Restore',
);?>
<h1><?php echo  $this->action->id; ?></h1>

<p>
	<?php if(isset($error)) echo $error; else echo 'Done';?>
</p>
<p> <?php echo Html::link('View Site',Yii::app()->HomeUrl)?></p>
