
    <h3>
        <?php echo Yii::t('basicfield', 'Your booking');?>
         <i class="icon_calendar pull-right"></i></h3>
    	
    <h4><?php echo Yii::t('basicfield', 'Services & Treatments');?></h4>
    <hr>
    <table class="table table_summary">
        <tbody>
            <?php $session = Yii::$app->session;
            echo $this->render('/merchant/orders', ['orders' => $session['cart']]);
            
            $loyaltyPointsOne = \common\models\Option::getValByName('website_loyalty_points');
            
            $loyaltyPrice = $loyaltyPointsOne * $session['loyalty'];
            ?>


        </tbody>
    </table>

    <table class="table table_summary">
        <tbody>
            <tr>
                <td>
                    <?php echo Yii::t('basicfield','Subtotal');?> 
                    <span class="pull-right">€ 
                        <span id="sub-total">
                            <?php 
                            $subtotal = $session['subtotal'] - $loyaltyPrice;
                            echo number_format($subtotal, 2, '.', '')?>
                        </span>
                    </span>
                </td>
            </tr>
            
            <?php if(!empty($session['discount'])){?>
            <tr>
                <td>
                    <?php echo Yii::t('basicfield','Coupon');?> <?php echo $session['couponPer']?> <span class="pull-right">€ <?php echo number_format($session['discount'], 2, '.', '')?></span>
                </td>
            </tr>
            
            <?php }?>
            <tr>
                <td class="total">
                    
                    <?php echo Yii::t('basicfield','TOTAL')?> 
                    <span class="pull-right">€ 
                        <span id="total"><?php 
                        $total  = ($session['total'] - $session['discount']) - $loyaltyPrice;
                    echo number_format(($total), 2, '.', '')?>
                        </span>
                        </span>
                </td>
            </tr>
        </tbody>
    </table>
    <hr>

    


<?php 
$this->registerJs("
    
    var loyalty = $('input[name=\'option_1\']:checked').val();
        console.log(loyalty);
    if(loyalty == 0){
        $('#loyalty-points').hide();
    }else{
        $('#loyalty-points').show();
    }
    
    $('.loyalty').on('ifChecked', function(event){
    
        value = $(this).val();
        
        if(value == 0){
            $('#loyalty-points').hide();
        }else{
            $('#loyalty-points').show();
        }
    
    })
    
    $('#apply-loyalty').on('click', function(e){
            e.preventDefault();
            var value = $('#points').val();
            console.log(value);
            if(value === ''){
                $('#loyal-msg').html('Please enter loyalty points.')
            }
            else{
                $('#loyal-msg').empty();
                
                $.ajax({
                    type : 'post',
                    url : '".Yii::$app->urlManager->createUrl('checkout/check-loyalty')."',
                    data : $('#frm-loyalty').serialize(),
                    dataType : 'json',
                    success : function(response){
                        if(response.success == true){
                            $('#sub-total').html(response.subtotal);
                            $('#total').html(response.total);
                        
                        }else{
                            $('#loyal-msg').html(response.msg)
                        }

                    }
                })
            }
    })
    
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
                            val.type = 1;
                            if(val.is_group == 1){
                                val.type = 5;
                            }
                            console.log(val);
                            socket.emit('order', val);
                            
                        });
                        //return ;
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
