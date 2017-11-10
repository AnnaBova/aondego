<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 12-Jan-16
 * Time: 17:51
 */

class MerchantWidget extends CWidget{

    public  static  function displayMerchant($data='')
    {
        $ccCon="/".Yii::app()->controller->id;

        $total_records=0;
        $path_to_upload=Yii::getPathOfAlias('webroot')."/upload";
       // d($data);
        if (is_array($data) && count($data)>=1):
            //if(!isset($data['0']['total_records'])) d($data);
            $total_records= isset($data['0']['total_records'])?(integer) $data['0']['total_records']:1;

            foreach ($data as $val):
                //$address=$val['street']." ".$val['city']." ".$val['state']." ".$val['post_code'] ." ".$val['country_code'];
                //$address=$val['street']." ".$val['city']." ".$val['state']." ".$val['country_code'];
                $address=$val['street']." ".$val['city']." ".$val['state'];

                $is_merchant_open = Yii::app()->functions->isMerchantOpen($val['merchant_id']);
                $merchant_preorder= Yii::app()->functions->getOption("merchant_preorder",$val['merchant_id']);

                $ratings=Yii::app()->functions->getRatings($val['merchant_id']);
                $rating_meanings='';
                if ( $ratings['ratings'] >=1){
                    $rating_meaning=Yii::app()->functions->getRatingsMeaning($ratings['ratings']);
                    $rating_meanings=ucwords($rating_meaning['meaning']);
                }

                $tag_open='';
                if ( $is_merchant_open==TRUE){
                    $tag_open='<div class="uk-badge uk-badge-success">'.t("Open").'</div>';
                } else {
                    if ($merchant_preorder){
                        $tag_open='<div class="uk-badge uk-badge-success">'.t("Pre-Order").'</div>';
                    } else $tag_open='<div class="uk-badge uk-badge-danger">'.t("Closed").'</div>';
                }

                $rating="<div class=\"rate-wrap\">
			<h6 class=\"rounded2\" data-uk-tooltip=\"{pos:'bottom-left'}\" title=\"$rating_meanings\" >".
                    number_format($ratings['ratings'],1)."</h6>
			<span>".$ratings['votes']." ".Yii::t("default","Votes")."</span>
			</div>";

                $merchant_id=$val['merchant_id'];
                $lat=Yii::app()->functions->getOption("merchant_latitude",$merchant_id);
                $long=Yii::app()->functions->getOption("merchant_longtitude",$merchant_id);
                /*$w = new CWidget();
                $w->render('displayMerchant');*/
                ?>
                <div class="links" data-id="<?php echo $address;?>" >
                    <div class="uk-grid" id="restaurant-mini-list">
                        <div class="uk-width-3-10">
                            <a href="<?php echo baseUrl()."$ccCon/menu/merchant/".$val['url']?>">
                                <?php if (!empty($val['merchant_logo'])):?>
                                    <img class="uk-thumbnail uk-thumbnail-mini" src="<?php echo Yii::app()->request->baseUrl."/upload/".$val['merchant_logo'];?>">
                                <?php else :?>
                                    <img class="uk-thumbnail uk-thumbnail-mini" src="<?php echo Yii::app()->request->baseUrl."/assets/images/thumbnail-medium.png";?>">
                                <?php endif;?>
                            </a>
                        </div>
                        <div class="uk-width-7-10">
                            <h5><a href="<?php echo baseUrl()."$ccCon/menu/merchant/".$val['url']?>">
                                    <?php echo $val['service_name']?></a>
                            </h5>
                            <p class="uk-text-muted"><?php echo $address?></p>
                            <a class="view-map" href="javascript:;" data-id="<?php echo $address;?>" data-lat="<?php echo $lat;?>" data-long="<?php echo $long;?>" data-merchantname="<?php echo ucwords($val['service_name'])?>" >
                                <i class="fa fa-map-marker"></i>
                                <?php echo Yii::t("default","View Map")?></a>
                            <?php echo $tag_open;?>
                            <?php echo $rating;?>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;

            $path=Yii::getPathOfAlias('webroot')."/protected/vendor";
            require_once $path."/Pagination/Pagination.class.php";
            $page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;
            $pagination = new Pagination();
            $pagination->setCurrent($page);
            $pagination->setRPP(10);
            $pagination->setTotal($total_records);
            echo $pagination->parse();

        else :
            ?><p class="uk-text-muted"><?php echo Yii::t("default","No data available")?></p><?php
        endif;
    }
} 