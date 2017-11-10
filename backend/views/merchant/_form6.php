<?php

use backend\components\AdminHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php echo $form->field($model,'username'); ?>

<?php echo $form->field($model,'new_password')->passwordInput(); ?>

<?php echo $form->field($model,'new_password_repeat')->passwordInput();; ?>
<br /><br />
<?php echo $form->field($model,'manager_username'); ?>

<?php echo $form->field($model,'manager_new_password')->passwordInput();; ?>

<?php echo $form->field($model,'manager_new_password_repeat')->passwordInput();; ?>