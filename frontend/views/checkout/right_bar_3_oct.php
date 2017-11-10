
    <h3>
        <?php echo Yii::t('basicfield', 'Your booking');?>
         <i class="icon_calendar pull-right"></i></h3>
    	
    <h4><?php echo Yii::t('basicfield', 'Services & Treatments');?></h4>
    <hr>
    <table class="table table_summary">
        <tbody>
            <?php $session = Yii::$app->session;
            echo $this->render('/merchant/orders', ['orders' => $session['cart']]);
            ?>


        </tbody>
    </table>

    <table class="table table_summary">
        <tbody>
            <tr>
                <td>
                    Subtotal <span class="pull-right">€ <?php echo number_format($session['subtotal'], 2, '.', '')?></span>
                </td>
            </tr>
            
            <?php if(!empty($session['discount'])){?>
            <tr>
                <td>
                    Coupon <?php echo $session['couponPer']?> <span class="pull-right">€ <?php echo number_format($session['discount'], 2, '.', '')?></span>
                </td>
            </tr>
            
            <?php }?>
            <tr>
                <td class="total">
                    TOTAL <span class="pull-right">€ <?php echo number_format($session['total'], 2, '.', '')?></span>
                </td>
            </tr>
        </tbody>
    </table>
    <hr>

    


<?php 
$this->registerJs("
    $('#checkout').on('click', function(){
        console.log($('#checkout-form'));
        $('body .help-block').remove();
        $.ajax({
            type : 'post',
            url : '".Yii::$app->urlManager->createUrl('checkout/index')."',
            data : $('#checkout-form').serialize(),
            dataType : 'json',
            success : function(response){
                if(response.success == true){
                    window.location.href = response.data;

                }else{
                    $.each(response.data, function(key, val) {
                        console.log(key);
                        $('#client-'+key).after('<div class=\"help-block\">'+val+'</div>');
                        $('#client-'+key).closest('.form-group').addClass('has-error');
                    });
                }
            }
        
            })
    })

    $('#proceed-checkout').on('click', function(){
        console.log($('#checkout-form'));
        var agree = document.getElementById(\"agree\").checked;
        
        if(agree == false){
            $('#error-msg').show();
        }
        else if(agree == true){
            $('#error-msg').hide();
            $('body .help-block').remove();
            $.ajax({
                type : 'post',
                url : '".Yii::$app->urlManager->createUrl('checkout/payment')."',
                data : $('#payment-form').serialize(),
                dataType : 'json',
                success : function(response){
                    
                    if(response.success == true){
                        
                        $.each(response.response, function(key, val) {
                            socket.emit('order', val);
                            
                        });
                        window.location.href = response.data;
                        //return ;

                    }else{
                        $.each(response.data, function(key, val) {
                            console.log(key);
                            $('#client-'+key).after('<div class=\"help-block\">'+val+'</div>');
                            $('#client-'+key).closest('.form-group').addClass('has-error');
                        });
                    }
                }

                })
        }
    })

");

?>
