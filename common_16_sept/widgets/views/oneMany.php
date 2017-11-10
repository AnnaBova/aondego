<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 18-Feb-16
 * Time: 22:33
 */
?>
<?php
if(!empty($this->model->{$this->field}))
foreach($this->model->{$this->field} as $val){

   echo CHtml::errorSummary($val);
}

$this->widget(
    'booster.widgets.TbButton',
    array(
        'context' => 'primary',
        'id' => 'addButtonFotThis'.$this->saction,
        'label' => 'Add',
        'buttonType' => 'ajaxSubmit',
        'url' => Yii::app()->createUrl(
            Yii::app()->controller->id.'/add'.$this->saction
        ),
        'ajaxOptions' => array(
            'type' => 'POST',
            'success' => 'function(data) {
                                $("#items'.$this->saction.'").append(data);
                }',
        )
    )
);
?>
<table >
    <thead>
    <tr>
        <?php
        foreach($this->model->{$this->behaviour}->fields as $val){
            echo "<th width='320px'>{$val['label']}</th>";
        }
        ?>
    </tr>
    </thead>
</table>
<div id="items<?=$this->saction?>">
    <?php
    if(!empty($this->model->{$this->field}))
        foreach($this->model->{$this->field} as $item){
            echo $this->render('_addOne',['item'=>$item]);
        }

   if($this->model->isNewRecord) echo $this->render('_addOne',['item'=>new $this->model->{$this->behaviour}->relationModel]);
    ?>
</div>
<br>
<br>

<?php
Yii::app()->clientScript->registerScript('delx'.$this->saction,"
    $('#items{$this->saction}').on('click','.item-dell',function(){
        $(this).parent().remove();

    });");
Yii::app()->clientScript->registerScript('delhghjggu', "$('form').submit( function () {

        $('.item-holder').each(function(){
            var isValid = true;
            $(this).find('input.form-control').each(function() {

                var element = $(this);
                if (element.val() != '') {
                    isValid = false;
                }
            });

           if (isValid) $(this).remove();
        });

    });");
