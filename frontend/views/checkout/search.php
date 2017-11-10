<?php

use yii\widgets\ListView;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//
?>


<!-- SubHeader =============================================== -->
<section class="parallax-window" id="short" data-parallax="scroll" data-image-src="img/sub_header_short.jpg" data-natural-width="1600" data-natural-height="850">
    <div id="subheader">
        <div id="sub_content">
            <h1><?php echo $search?></h1>
            <div><i class="icon_pin"></i> <?php echo $search?></div>
        </div><!-- End sub_content -->
    </div><!-- End subheader -->
</section><!-- End section -->
<!-- End SubHeader ============================================ -->

<div id="position">
    <div class="container">
        <ul>
            <li><a href="<?php echo Yii::$app->homeUrl;?>">
                    <?php echo Yii::t('basicfield', 'Home')?></a></li>
            <li><?php echo Yii::t('basicfield', 'Search')?></li>
            <li>
                <?php echo $search?>
                
            </li>
        </ul>
    </div>
</div><!-- Position -->

<div class="collapse" id="collapseMap">
    <div id="map" class="map"></div>
</div><!-- End Map -->

<!-- Content ================================================== -->
<div class="container margin_60_35">
    <div class="row">

        <div class="col-md-3">

<?php echo $this->render('search-sidebar', ['search' => $search,
        'maxprice' => $maxprice,
        'distance' => $distance,
        'selcategory' => $category
        ]); ?>
        </div><!--End col-md -->

        <div class="col-md-9">

            <div id="tools">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="styled-select">
                            <select name="sort_rating" id="sort_rating">
                                <option value="" selected><?php Yii::t('basicfield', 'Sort by ranking')?></option>
                                <option value="asc"><?php Yii::t('basicfield', 'Lowest ranking')?></option>
                                <option value="desc"><?php Yii::t('basicfield', 'Highest ranking')?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-6 hidden-xs">
                        <a href="javascript:void(0)" class="bt_filters" id="grid-view" data-listtype="grid">
                            <i class="icon-th"></i>
                        </a>
                    </div>
                </div>
            </div><!--End tools -->
            <div id="search-view">
<?php
echo $this->render('searchview', [
    'models' => $models
]);

//echo ListView::widget([
//    'dataProvider' => $dataProvider,
//    'itemView' => '_searchview',
//]);
?>
            </div>

<!--            <a href="#0" class="load_more_bt wow fadeIn" data-wow-delay="0.2s">Load more...</a>  -->
        </div><!-- End col-md-9-->

    </div><!-- End row -->
</div><!-- End container -->
<!-- End Content =============================================== -->

<?php 
$session = Yii::$app->session;
$this->registerJs('
        
        ');
?>
