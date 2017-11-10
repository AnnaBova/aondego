<?php 
namespace common\extensions\gallerymanager\assets;

use yii\web\AssetBundle;
use Yii;

class GalleryWidgetAsset extends AssetBundle
{
    public $js = [
        'jquery.iframe-transport.js',
        'jquery.galleryManager.js',
        'jquery.iframe-transport.min.js',
        'jquery.galleryManager.min.js',
        
    ];

    public $css = [
         // CDN lib
        'galleryManager.css',
        //'css/votewidget.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
    ];

    public function init()
    {
        // Tell AssetBundle where the assets files are
        $this->sourcePath = '@common/extensions/gallerymanager/assets/';
        
        parent::init();
    }
}