<!-- SubHeader =============================================== -->
<?php

use dosamigos\datepicker\DatePicker;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
?>
<section class="parallax-window" id="short" data-parallax="scroll" data-image-src="<?php echo Yii::$app->urlManager->baseUrl;?>/img/sub_header_short.jpg" data-natural-width="1600" data-natural-height="850">
    <div id="subheader">
        <div id="sub_content">
            <h1><?php echo Yii::t('basicfield', 'Profile')?></h1>
            <p><?php echo Yii::t('basicfield', 'Manage your profile,address book, credit card and more')?></p>
        </div><!-- End sub_content -->
    </div><!-- End subheader -->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->

<div id="position">
    <div class="container">
        <ul>
            <li><a href="<?php echo Yii::$app->homeUrl;?>"><?php echo Yii::t('basicfield', 'Home')?></a></li>
            <li><?php echo Yii::t('basicfield', 'Dashboard')?></li>
           
        </ul>
    </div>
</div><!-- Position -->

<!-- Content ================================================== -->
<div class="container">

    <div class="row">
        <div class="col-md-9 ">

            <div class="tabs-wrapper">



                <ul id="tabs" class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#profile">
                            <i class="ion-android-contact"></i> <span>
                                <?php echo Yii::t('basicfield', 'Profile')?>
                            </span>
                        </a>
                    </li> 

                    <li >
                        <a data-toggle="tab" href="#address">
                            <i class="ion-ios-location-outline"></i> <span>
                                <?php echo Yii::t('basicfield', 'Address Book')?>
                                </span>
                        </a>
                    </li>

                    <li>
                        <a data-toggle="tab" href="#order">
                            <i class="ion-ios-book-outline"></i> 
                            <span><?php echo Yii::t('basicfield', 'Order History')?></span>
                            </a>
                    </li>

                    <li>
                        <a data-toggle="tab" href="#loyality">
                            <i class="ion-card"></i> <span><?php echo Yii::t('basicfield', 'Loyalty Points')?></span>
                        </a>
                    </li>


                </ul>
                
                <?php
                foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
                }
                ?>

                <div class="tab-content">

                        <div class="box-grey rounded tab-pane fade in active" style="margin-top:0;" id="profile">
<?php $form = ActiveForm::begin([
                                    'options' => [
                                        'class' => 'profile-forms forms'
                                    ],
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
                                ]); ?>
    <div class="row bottom10">
                                    <div class="col-md-6">
                                        <p class="text-small"><?php echo Yii::t('basicfield', 'First Name')?></p>
                                        <?= $form->field($model, 'first_name', ['template'=>'{input}{error}', 
                                                'options' => [
                                                'tag'=>false
                                            ]])->textInput(['autofocus' => true,'class'=>'grey-fields full-widthe'])
                                        ->label(false) ?>

                                        
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-small"><?php echo Yii::t('basicfield', 'Last Name')?></p>
                                        <?= $form->field($model, 'last_name', ['template'=>'{input}{error}', 
                                                'options' => [
                                                'tag'=>false
                                            ]])->textInput(['autofocus' => true,'class'=>'grey-fields full-widthe'])
                                        ->label(false) ?>
                                    </div>
                                </div> <!--row-->  
                                
                                
                                
                                <div class="row bottom10">
                                    <div class="col-md-6">
                                        <p class="text-small"><?php echo Yii::t('basicfield', 'Email address')?></p>
                                        <?= $form->field($model, 'email_address', ['template'=>'{input}{error}', 
                                                'options' => [
                                                'tag'=>false
                                            ]])->textInput(['autofocus' => true,'class'=>'grey-fields full-widthe'])
                                        ->label(false) ?>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-small"><?php echo Yii::t('basicfield', 'Mobil Telefon')?></p>
                                        <?= $form->field($model, 'contact_phone', ['template'=>'{input}{error}', 
                                                'options' => [
                                                'tag'=>false
                                            ]])->textInput(['autofocus' => true,'class'=>'grey-fields full-widthe'])
                                        ->label(false) ?>
                                    </div>
                                </div> <!--row-->
                                
                                <div class="row bottom10">

                                    <div class="col-md-6">
                                        <p class="text-small"><?php echo Yii::t('basicfield', 'Birthday')?></p>
                                        
                                        <?= DatePicker::widget([
                                            'model' => $model,
                                            'attribute' => 'dob',
                                            'template' => '{input}{addon}',
                                            'clientOptions' => [
                                                'autoclose' => true,
                                                'format' => 'yyyy-mm-dd',
                                                'minDate' => '1900-01-01',

                                            ],
                                            'options' => [
                                                'class' => 'grey-fields full-widthe',
                                                'tag'=>false
                                            ]
                                        ]);?>
                                        
                                    </div>


                                </div> <!--row-->
                                <div class="row bottom10"> 
                                <div class="col-md-6">
                                        <p class="text-small"><?php echo Yii::t('basicfield', 'Password')?></p>
                                        <?= $form->field($model, 'newpassword', ['template'=>'{input}{error}', 
                                                'options' => [
                                                'tag'=>false
                                            ]])->passwordInput(['autofocus' => true,'class'=>'grey-fields full-widthe'])
                                        ->label(false) ?>  
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <p class="text-small"><?php echo Yii::t('basicfield', 'Confirm Password')?></p>
                                        <?= $form->field($model, 'confirm_password', ['template'=>'{input}{error}', 
                                                'options' => [
                                                'tag'=>false
                                            ]])->passwordInput(['autofocus' => true,'class'=>'grey-fields full-widthe'])
                                        ->label(false) ?>  
                                    </div>
                                    
                                    
                                </div>
                                


    <div class="row">  
                                    <div class="col-md-6">
                                        
                                        <input type="submit" value="<?php echo Yii::t('basicfield', 'Save')?>" class="green-button medium">  
                                    </div>	
                                </div>
<?php ActiveForm::end(); ?>
                            
                                
                        </div> <!--box-->      
                   

                        <div class="box-grey rounded section-address-book tab-pane fade" style="margin-top:0;" id="address">



                            <div class="bottom10 top10">
                                <a class="green-button inline rounded" href="<?php echo Yii::$app->urlManager->createUrl('address-book/create')?>" id="address-update">
                                    <?php echo Yii::t('basicfield', 'Add New')?></a>
                            </div>
                            
                            
                            <div id="new-address" style="display: none">
                                
                                <?php /*echo $this->render('/address-book/_form', [
                                    'model' => new \frontend\models\MtAddressBook
                                ])*/?>
                                
                                
                            </div>
                            <div id="update-address" ></div>
                            
                            <div id="address-list">
                                <?php \yii\widgets\Pjax::begin(); ?>
                            <?= GridView::widget([
                                'dataProvider' => $dataProviderAddress,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    //'id',
                                    'street',
                                    'location_name',
                                    // 'zipcode',
                                    // 'location_name',
                                    // 'country_code',
                                    
                                    [
                                        'label' => Yii::t('basicfield','Is Default'),
                                        'value' => function ($model) {    
                                                if($model->as_default == 1){
                                                    return 'Yes';
                                                }else{
                                                    return 'No';
                                                }
                                        },
                                    ],
                                    // 'date_created',
                                    // 'date_modified',
                                    // 'ip_address',
                                    ['class' => 'yii\grid\ActionColumn', 
                                        'template' => '{update}',
                                        'buttons' => [
                                            'update' => function ($url, $model) {
                                                return \yii\helpers\Html::a('<span class="glyphicon glyphicon-edit"></span>', Yii::$app->urlManager->createUrl(['address-book/create', 'id' => $model->id]), [
                                                            'title' => Yii::t('yii', 'Update'),
                                                            'id' => 'address-update',
                                                            'data-pjax'=>'w0',
                                                ]);
                                            }
                                        ]
                                        ],
                                ],
                            ]); ?>
                                <?php \yii\widgets\Pjax::end(); ?>
                            </div>
                            
                            
                                

                            
                            


                        </div> <!--box-grey-->       
                    

                        <div class="box-grey rounded section-order-history tab-pane fade " style="margin-top:0;" id="order">

                            <div class="bottom10">
                                <div class="section-label">
                                    <a class="section-label-a">
                                        <span class="bold">
                                            <?php echo Yii::t('basicfield', 'Your Recent Order')?></span>
                                        <b></b>
                                    </a>     
                                </div>    
                            </div>
                            <?php \yii\widgets\Pjax::begin(); ?>
                            <?= GridView::widget([
//                               
//                                'tableOptions' => [
//                                    'class' => 'table table-responsive',
//                                ],
                                'dataProvider' => $dataProviderOrder,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                    //'id',
                                    //'status',
                                    //'client_id',
                                    
                                    
                                    [
                                        'label' => Yii::t('basicfield','Service'),
                                        'value' => function ($model) {                      
                                                return $model->category->title;
                                        },
                                    ],
                                                
                                    [
                                        'label' => Yii::t('basicfield','Merchant'),
                                         'format' => 'html',
                                        'value' => function ($model) {  
                                            
                                            $merchantUrl = preg_replace('/\s+/', '',$model->merchant->service_name);
                                            $merchantUrl = strtolower($merchantUrl).'-'.$model->merchant->merchant_id;
                                            return \yii\helpers\Html::a($model->merchant->service_name, ['merchant/view', 'id'=>$merchantUrl]);
                                        },
                                    ],
                                                
                                    [
                                        'label' => Yii::t('basicfield','Staff'),
                                        'value' => function ($model) {                      
                                                return $model->staff->name;
                                        },
                                    ],
                                    [
                                        'label' => Yii::t('basicfield','Is Group'),
                                        'value' => function ($model) {  
                                            if($model->is_group == 1){
                                               return 'Yes'; 
                                            }else{
                                                return 'No'; 
                                            }
                                            
                                                
                                        },
                                    ],
                                    
                                    'price',
                                    'payment_type',
                                    
                                    'order_time',
                                    // 'more_info',

                                    ['class' => 'yii\grid\ActionColumn', 
                                        'template' => '{cancel}', 
                                        'buttons' => [
                                            'cancel' => function ($url, $model) {
                                                if(date('Y-m-d',  strtotime($model->order_time)) > date('Y-m-d')){
                                                    return \yii\helpers\Html::a(Yii::t('basicfield', 'Cancel'), Yii::$app->urlManager->createUrl(['order/cancel', 'id' => $model->id]), [
                                                                'title' => Yii::t('basicfield', 'Cancel'),
                                                                'data-pjax'=>'w0',
                                                    ]);
                                                }
                                            }
                                        ]
                                            ],
                                ],
                            ]); ?>
                            
                            <?php \yii\widgets\Pjax::end(); ?>
                            


                        </div> <!--box-grey-->                
                    

                        <div class="box-grey rounded section-credit-card tab-pane fade" style="margin-top:0;" id="loyality">

                            <div class="bottom10">
                                <div class="section-label">
                                    <a class="section-label-a">
                                        <span class="bold">
                                            <?php echo Yii::t('basicfield', 'Your Loyalty Points')?></span>
                                        <b></b>
                                    </a>     
                                </div>    
                            </div>
                            <?= GridView::widget([
                                'dataProvider' => $dataProviderLoyality,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                    
                                    [
                                        'label' => Yii::t('basicfield','Merchant'),
                                        'value' => function ($model) {                      
                                                return $model->merchant->service_name;
                                        },
                                    ],
                                    
                                    'points',
                                    // 'client_phone',
                                    // 'client_email:email',
                                    // 'order_time',
                                    // 'category_id',
                                    // 'staff_id',
                                    // 'merchant_id',
                                    // 'create_time',
                                    // 'is_group',
                                    // 'source_type',
                                    // 'order_id',
                                    // 'price',
                                    // 'more_info',

                                    //['class' => 'yii\grid\ActionColumn'],
                                ],
                            ]); ?>


                        </div> <!--box-grey-->  
                </div>
                    
            </div> <!--tabs-wrapper--> 


        </div> <!--col-->

        <div class="col-md-3 avatar-section">
            <div class="box-grey rounded" style="margin-top:0;">

                <div class="avatar-wrap">
                    <img src="<?php echo \frontend\components\ImageBehavior::getImage($model->id, 'client/thumb')?>" class="img-circle">
                </div> <!--center-->

                <div class="center top10">
                    
                    <?php $form = ActiveForm::begin([
                                'id' => 'image-upload',
                                'options' => [
                                    'class' => 'profile-forms forms'
                                ],

                                ]); ?>
                    
                    <?= $form->field($model, 'image')->fileInput(['style' => 'display: none;'])->label(false);?>
                    
                    
                   <?php ActiveForm::end(); ?>
                    <a href="javascript:void(0);" id="uploadavatar" > <?php echo Yii::t('basicfield', 'Browse')?></a> 
                    
                    
                </div>
                <div  style="display:none;" class="uploadavatar_chart_status" >
                    <div id="percent_bar" class="uploadavatar_percent_bar"></div>
                    <div id="progress_bar" class="uploadavatar_progress_bar">
                        <div id="status_bar" class="uploadavatar_status_bar"></div>
                    </div>
                </div>		  

                <div class="line-top line-bottom center">
                    <?php echo Yii::t('basicfield', 'Update your profile picture')?>          </div>

                <div class="connected-wrap">
                    <div class="mytable web">
                        <div class="mycol  col-1 center">
                            <i class="ion-social-dribbble i-big"></i>
                        </div> <!--col-->
                        <div class="mycol  col-2">
                            <span class="small"> <?php echo Yii::t('basicfield', 'Connected as')?>    </span><br/>
                            <span class="bold"><?php echo $model->first_name.' '.$model->last_name?></span>
                        </div> <!--col-->
                    </div>
                </div> <!--connected-wrap-->



            </div>
        </div> <!--col-->

    </div> <!--row-->
</div> <!--container-->   <!--container--><!-- End container -->
<!-- End Content =============================================== -->


<?php 
$this->registerJs("
    
        $('body').on('click','#address-update', function(e){
            e.preventDefault();
            var href = $(this).attr('href');
            console.log(href)
            $.ajax({
                type : 'post',
                url  : href,
                success : function(response){
                    console.log(response);
                    $('#update-address').html(response);
                    $('#address-list').hide();
                }
            })
            
        })
        
        $('#uploadavatar').on('click', function(){
        
            $('#client-image').trigger('click');
        })
        
        $('#client-image').on('change', function(){
            $('#image').submit(function(){})
            var formdata = new FormData($('#image-upload')[0]);
            
            $.ajax({
                type: 'post',
                url: '".Yii::$app->urlManager->createUrl('client/upload-image')."', 
                data: formdata,
                dataType: 'json',
                success: function (response) {
                    if(response.success == true){
                        console.log($('.img-circle'));
                        $('.img-circle').attr('src', response.image);
                    }
                    
                },
                cache: false,
                contentType: false,
                processData: false

            })
            
            
                
        })
        
        
    $('#add-new-address').on('click', function(){
        $('#new-address').show();
        $('#address-list').hide();
        $(this).hide();
        
        });
        
    $('body').on('click','#address-back', function(){
        $('#update-address').empty();
        $('#address-list').show();
        $('#add-new-address').show();
    
    })
    
    $('body').on('click', '#save-address', function(e){
        e.preventDefault();
        
        $('body .help-block').remove();
        $.ajax({
            type : 'post',
            url : '".Yii::$app->urlManager->createUrl('address-book/create')."',
            data : $('#address-form').serialize(),
            dataType : 'json',
            success : function(response){
            
                if(response.success == true){
                    $('#update-address').empty();
                    $('#address-list').html(response.data);
                    $('#new-address').hide();
                    $('#address-list').show();
                    $('#add-new-address').show();
                
                }else{
                
                    $.each(response.data, function(key, val) {
                        console.log(key);
                        $('#mtaddressbook-'+key).after('<div class=\"help-block\">'+val+'</div>');
                        $('#mtaddressbook-'+key).closest('.form-group').addClass('has-error');
                    });
                
                }
            
                
            
            }
        })
    })
        
    
");

?>
