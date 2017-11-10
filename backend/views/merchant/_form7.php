<div>
<?php 

$value = $model->id.'_'.time();

$encrypted = urlencode(base64_encode($value));
//echo '<br>';

//echo urldecode(base64_decode($encrypted));
//$encrypted = Yii::$app->security->encryptByKey($model->id);

//print_r($encrypted);


?>
    
<div class="form-group">
<label class="control-label" for="merchant-ip_address">Widget</label>
<input  text="input" readonly="" class="form-control"
        value='<iframe src="<?php echo Yii::$app->getRequest()->getHostInfo().'/merchant/widgetview?id='.$encrypted;?>" width="100%" height="2000" frameborder="0"></iframe>'>

</div>
</div>