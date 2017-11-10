<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 18-Feb-16
 * Time: 22:33
 */

use demogorgorn\ajax\AjaxSubmitButton;
?>
<?php

//
//echo '<pre>';
//print_r($this->context->model->behaviors[$this->context->behaviour]);
//exit;



if(!empty($this->context->model->{$this->context->field}))
foreach($this->context->model->{$this->context->field} as $val){
    

   echo \yii\helpers\Html::errorSummary($val);
}


AjaxSubmitButton::begin([
    'label' => Yii::t('basicfield','Add'),
    'ajaxOptions' => [
        'type' => 'POST',
        'url' => Yii::$app->urlManager->createUrl(
            Yii::$app->controller->id.'/add'.$this->context->saction
        ),
        /*'cache' => false,*/
        'success' => new \yii\web\JsExpression('function(html){
            $("#items'.$this->context->saction.'").append(html);
        }'),
    ],
    'options' => [
        'class' => 'btn btn-primary',
        'type' => 'button',
        'id' => 'addButtonFotThis'.$this->context->saction
    ]
]);

AjaxSubmitButton::end();

/*$this->widget(
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
                                $("#items'.$this->context->saction.'").append(data);
                }',
        )
    )
);*/
?>
<table >
    <thead>
    <tr>
        <?php
        
        
        if(isset($this->context->behaviour)){
            
            
            
            //exit;
            foreach($this->context->model->behaviors[$this->context->behaviour]->fields as $val){
                
                
                echo "<th width='320px'>".Yii::t('basicfield',$val['label'] )."</th>";
            }
        }
        ?>
    </tr>
    </thead>
</table>
<div id="items<?=$this->context->saction?>">
    <?php
    
    
    
    if(!empty($this->context->model->{$this->context->field})){
        
        
        foreach($this->context->model->{$this->context->field} as $item){
		
		
		
		
		echo $this->render('_addOne',['item'=>$item]);
        }
    }
    
    

   //if($this->context->model->isNewRecord) echo $this->render('_addOne',['item'=>new $this->context->model->behaviors[$this->context->behaviour]->relationModel]);
    ?>
</div>
<br>
<br>

<?php
$this->registerJs("
    $('#items{$this->context->saction}').on('click','.item-dell',function(){
        $(this).parent().remove();

    });");
$this->registerJs('delhghjggu', "$('form').submit( function () {

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
