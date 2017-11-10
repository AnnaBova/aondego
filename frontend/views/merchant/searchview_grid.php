<?php $merchantUrl = preg_replace('/\s+/', '',$model['service_name']);
$merchantUrl = strtolower($merchantUrl).'-'.$model['merchant_id'];

$url = Yii::$app->urlManager->createUrl(['merchant/view', 'id'=>$merchantUrl]);

if(!empty($type)){
       $url = Yii::$app->urlManager->createUrl(['merchant/gift-voucher', 'id'=>$merchantUrl]); 

}

?>
<?php $i = 1;
foreach ($models as $model) {
    if ($i == 1) {
        ?>       	

        <div class="row">
    <?php } ?>
        <div class="col-md-6 col-sm-6 wow zoomIn" data-wow-delay="0.1s">
            <a class="strip_list grid" href="<?php echo $url;?>">
                <div class="ribbon_1">Popular</div>
                <div class="desc">
                    <div class="thumb_strip responsive">
                        <?php echo \yii\helpers\Html::img(\frontend\components\ImageBehavior::getImage($model['merchant_id'], 'merchant'))?>
                    </div>
                    <div class="rating">
                        <?php /*
                    
				$queryRating = 0;
				if($model['merchant_id']){
				    $ratingSql = 'SELECT ceil(AVG(rating)) as totalrating FROM mt_review where merchant_id='.$model['merchant_id'];
				    $queryRating = Yii::$app->db->createCommand($ratingSql)->queryScalar();


				    $ratingCountSql = 'SELECT count(*) as totalrating FROM mt_review where merchant_id='.$model['merchant_id'];
				    $queryRatingCount = Yii::$app->db->createCommand($ratingCountSql)->queryScalar();


				    if($queryRating !=0 ){
				    for($i = 1; $i <= $queryRating ;$i++){
				?>
				<i class="icon_star voted"></i>
				<?php 
				    }

				    }
				}*/?>
                    </div>
                    <h3><?php echo $model['service_name'];?></h3>
                    <div class="type">
                        <?php 
                    
			$sql = 'SELECT chm.category_id, ssc.*,sc.*  from category_has_merchant as chm 
				LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
				LEFT JOIN  mt_service_category AS sc ON sc.id=ssc.category_id
				WHERE chm.merchant_id='.$model['merchant_id'].' group by sc.id';

			$query = Yii::$app->db->createCommand($sql)->queryAll();


			    foreach ($query as $key=>$cat){
				echo Yii::t('servicecategory',$cat['title']);
				if((sizeof($query) - 1) > $key)
				    echo ' | ';
			    }
			?>
                    </div>
                    <div class="location">
                        <?php echo $model['address'];?><br>
                    </div>
		    
		    <div>
			<span class="opening"><?php echo Yii::t('basicfield', 'Opening Time')?></span>
		       <?php
			    $sql = 'SELECT * FROM merchant_schedule_history where merchant_id=' . $model['merchant_id'] . ' order by id desc';
			    $squerySchedule = Yii::$app->db->createCommand($sql)->queryOne();

			    $schedule = \frontend\models\MtMerchant::getSchedule($squerySchedule);

			    $days = \frontend\models\MtMerchant::$days;

			    foreach ($schedule as $key => $value) {
				?>
				<?php
				    if (!empty($value)) {?>
				<li><?php echo Yii::t('basicfield', $days[$key]); ?>

				    <?php 
					echo '<span>';
					foreach ($value as $sch) {
					    ?>
					    <?php echo $sch['time_from']; ?>-<?php echo $sch['time_to']; ?>
					<?php
					}
					echo '</span>';

				    ?>

				</li>

				    <?php }?>

			<?php }
		    ?>

		    </div>
                    <ul>
                    
                    
                    <?php 
                    
//                    $sqlCategoryhadMerchant = 'SELECT * FROM category_has_merchant where merchant_id='.$model['merchant_id'];
//                    $queryCathasMerchant = Yii::$app->db->createCommand($sqlCategoryhadMerchant)->queryAll();
//                    
                    $sqlCategoryhadMerchant = 'SELECT chm.category_id, ssc.*, sc.id as catid from category_has_merchant as chm 
                                        LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                                        RIGHT JOIN  mt_service_category as sc ON ssc.category_id=sc.id
                                        WHERE chm.merchant_id=' . $model['merchant_id'] . ' group by sc.id';
                                
                    $queryCathasMerchant = Yii::$app->db->createCommand($sqlCategoryhadMerchant)->queryAll();
                    if($queryCathasMerchant){
                        
                        
                        foreach ($queryCathasMerchant as $cat){
                            
                            $sqlCategoryMerchant = 'SELECT chm.category_id, ssc.*, sc.id as catid from category_has_merchant as chm 
                            LEFT JOIN  mt_service_subcategory as ssc ON ssc.id=chm.category_id
                            RIGHT JOIN  mt_service_category as sc ON ssc.category_id=sc.id
                            WHERE chm.merchant_id=' . $model['merchant_id']. ' and sc.id='.$cat['catid'].' group by ssc.id';

                            $queryCatMerchant = Yii::$app->db->createCommand($sqlCategoryMerchant)->queryAll();
                            foreach($queryCatMerchant as $service){
                        ?>
                    <li><?php echo Yii::t('servicesubcategory',$service['title']);?><i class="icon_check_alt2 ok"></i></li>
                    <?php 
                        }
                        }
                        }?>
                    
                </ul>
                    
                    <?php 
                $voucher = 'SELECT * FROM mt_voucher WHERE merchant_id='.$model['merchant_id'];
                $queryVoucher = Yii::$app->db->createCommand($voucher)->queryAll();
                
                
                
                $loyality = 'SELECT * FROM loyalty_points WHERE merchant_id='.$model['merchant_id'];
                $queryLoyality = Yii::$app->db->createCommand($loyality)->queryOne();
                
                
                if(!empty($queryVoucher) || (!empty($queryLoyality) && $queryLoyality[0]['is_active'] == 1)){
                    
                    
                    //print_r($queryVoucher);
                ?>
                <i class="icon-heart"></i> 
                <?php echo Yii::t('basicfield','Loyalty Points');?> 
                <span  class="label label-success">
                    <i class="icon_check_alt2 ok"></i> </span>
<!--                <ul>
                    <?php /*
                    $sqlAddons = 'SELECT name FROM addon where merchant_id='.$model['merchant_id'];
                    $queryAddon = Yii::$app->db->createCommand($sqlAddons)->queryAll();
                    
                    if($queryVoucher){
                        foreach ($queryVoucher as $voucher){?>
                            <li><?php echo $voucher['voucher_name']?><i class="icon-gift"></i></li>
                        <?php }
                        
                    }*/?>
                    
                </ul>-->
                <i class="icon-euro"></i> 
                <?php echo Yii::t('basicfield','Coupon');?>  
                <span  class="label label-success"><i class="icon_check_alt2 ok"></i> </span>
<!--                <span class='opening'>Loyality Points</span>
                <ul>
                    
                    <li>Count On Order  : <?php echo $queryLoyality['count_on_order']?></li>
                    <li>Count On Like  : <?php echo $queryLoyality['count_on_like]']?></li>
                    <li>Count On Comment  : <?php echo $queryLoyality['count_on_comment']?></li>
                    <li>Count On Rate  : <?php echo $queryLoyality['count_on_rate']?></li>
                </ul>-->
                <?php }?>
                </div>
            </a><!-- End strip_list-->
        </div><!-- End col-md-6-->


        <?php if ($i % 2 == 0) { ?>    
        </div><!-- End row-->
        <div class="row">
        <?php } ?>

        <?php
        $i++;
    }
    ?>
            
