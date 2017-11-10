<?php

namespace common\extensions\gallerymanager;
use yii\base\Widget;
use yii\helpers\Html;
use Yii;
/**
 * Widget to manage gallery.
 * Requires Twitter Bootstrap styles to work.
 *
 * @author Bogdan Savluk <savluk.bogdan@gmail.com>
 */
class GalleryManager extends Widget
{
    /** @var Gallery Model of gallery to manage */
    public $gallery;
    /** @var string Route to gallery controller */
    public $controllerRoute = false;
    public $assets;

    public function init()
    {
        $this->assets = Yii::$app->getAssetManager()->publish(dirname(__FILE__) . '/assets');
    }


    public $htmlOptions = array();


    /** Render widget */
    public function run()
    {
        /** @var $cs CClientScript */
//        $cs = Yii::$app;
//        $cs->registerCssFile($this->assets . '/galleryManager.css');
//
//        $cs->registerCoreScript('jquery');
//        $cs->registerCoreScript('jquery.ui');
//
//        if (YII_DEBUG) {
//            $cs->registerScriptFile($this->assets . '/jquery.iframe-transport.js');
//            $cs->registerScriptFile($this->assets . '/jquery.galleryManager.js');
//        } else {
//            $cs->registerScriptFile($this->assets . '/jquery.iframe-transport.min.js');
//            $cs->registerScriptFile($this->assets . '/jquery.galleryManager.min.js');
//        }
        
        assets\GalleryWidgetAsset::register($this->getView());

        if ($this->controllerRoute === null)
            throw new CException('$controllerRoute must be set.', 500);

        $photos = array();
        
        
        foreach ($this->gallery->galleryPhotos as $photo) {
            
            $photos[] = array(
                'id' => $photo->id,
                'rank' => $photo->rank,
                'name' => (string)$photo->name,
                'description' => (string)$photo->description,
                'preview' => (is_object($photo)) ? $photo->getPreview() : "",
            );
        }
        

        $opts = array(
            'hasName' => $this->gallery->name ? true : false,
            'hasDesc' => $this->gallery->description ? true : false,
            'uploadUrl' => Yii::$app->urlManager->createUrl([$this->controllerRoute . '/ajax-upload','gallery_id' => $this->gallery->id]),
            'deleteUrl' => Yii::$app->urlManager->createUrl($this->controllerRoute . '/delete'),
            'updateUrl' => Yii::$app->urlManager->createUrl($this->controllerRoute . '/change-data'),
            'arrangeUrl' => Yii::$app->urlManager->createUrl($this->controllerRoute . '/order'),
            'nameLabel' => Yii::t('galleryManager.main', 'Name'),
            'descriptionLabel' => Yii::t('galleryManager.main', 'Description'),
            'photos' => $photos,
        );
        
        

        if (Yii::$app->request->enableCsrfValidation) {
            $opts['csrfTokenName'] = Yii::$app->request->csrfParam;
            $opts['csrfToken'] = Yii::$app->request->csrfToken;
        }
        
        
        
        
        $opts = json_encode($opts);
        //$cs->registerScript('galleryManager#' . $this->id, "$('#{$this->id}').galleryManager({$opts});");

        $this->htmlOptions['id'] = $this->id;
        $this->htmlOptions['class'] = 'GalleryEditor';
        
        

        return $this->render('galleryManager', ['opts' => $opts]);
    }

}
