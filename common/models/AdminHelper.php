<?php
namespace backend\components;
use Yii;
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 21-Jan-16
 * Time: 20:22
 */
class AdminHelper
{
    private static $_options = null;

    public static function adminMenu()
    {
        
        
        
        return array(
            'activeCssClass' => 'active',
            'options' => ['class' => 'sidebar-menu'],
            //'itemOptions'=>array('class'=>'treeview '),
            'encodeLabels' => false,
            'items' => array(
                array('visible' => self::AA('dashboard'),
                    'tag' => "dashboard",
                    'label' => '<i class="fa fa-home"></i>'. Yii::t("basicfield", "Dashboard"),
                    'url' => array('/dashboard'),
                    'active' => Yii::$app->controller->id == 'dashboard'),
                array(
                    'label' => '<i class="fa fa-gear"></i>'.Yii::t("basicfield", "Sale Section").'<i class="fa fa-angle-left pull-right"></i>',
                    'options' => array('class' => ' ' . (in_array(Yii::$app->controller->id, ['service-category', 'service-subcategory', 'merchant', 'packages', 'commisionsettings']) ? 'active' : '')),
                    'url' => '#',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('visible' => self::AA('service-category'),
                            'tag' => "serviceCategory", 'label' => '<i class="fa fa-sticky-note-o"></i>' . Yii::t("basicfield", "Category List"),
                            'url' => array('/service-category'), 'active' => Yii::$app->controller->id == 'service-category'),
                        array('visible' => self::AA('service-subcategory'),
                            'tag' => "service-subcategory", 'label' => '<i class="fa fa-clone"></i>' . Yii::t("basicfield", "Subcategory List"),
                            'url' => array('/service-subcategory'), 'active' => Yii::$app->controller->id == 'service-subcategory'),

                        array('visible' => self::AA('merchant'),
                            'tag' => "merchant", 'label' => '<i class="fa fa-puzzle-piece"></i>' . Yii::t("basicfield", "Merchant List"),
                            'url' => array('/merchant'), 'active' => Yii::$app->controller->id == 'merchant'),


                        array('visible' => self::AA('packages'),
                            'tag' => "packages", 'label' => '<i class="fa fa-black-tie"></i>' . Yii::t("basicfield", "Packages"),
                            'url' => array('/packages'), 'active' => Yii::$app->controller->id == 'packages'),

                        array('visible' => self::AA('commisionsettings'),
                            'tag' => "commisionsettings",
                            'label' => '<i class="fa fa-wrench"></i>' . Yii::t("basicfield", "Commission Settings"),
                            'url' => array('/commisionsettings'), 'active' => Yii::$app->controller->id == 'commisionsettings'),
                    )),
                array(
                    'label' => '<i class="fa fa-cubes"></i>'.Yii::t("basicfield", "Admin Settings").'<i class="fa fa-angle-left pull-right"></i>',
                    'options' => array('class' => 'treeview ' . (in_array(Yii::$app->controller->id, ['settings', 'voucher', 'emailsettings', 'custom-page', 'contact-settings', 'social-settings', 'basicfield', 'seo']) ? 'active' : '')),
                    'url' => '#',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('visible' => self::AA('settings'),
                            'tag' => "settings", 'label' => '<i class="fa fa-cogs"></i>' . Yii::t("basicfield", "General Settings"),
                            'url' => array('/settings'), 'active' => Yii::$app->controller->id == 'settings'),

                        array('visible' => self::AA('voucher'),
                            'tag' => "voucher",
                            'label' => '<i class="fa fa-bolt"></i>' . Yii::t("basicfield", "Voucher"),
                            'url' => array('/voucher'), 'active' => Yii::$app->controller->id == 'voucher'),

                        /* array('visible'=>self::AA('merchantcommission'),
                             'tag'=>"merchantcommission",
                             'label'=>'<i class="fa fa-list-alt"></i>'.Yii::t("basicfield","Merchant Commission"),
                             'url'=>array('/merchantcommission','active' => Yii::$app->controller->id == 'merchantcommission')),*/


                        array('visible' => self::AA('emailsettings'), 'tag' => "emailsettings",
                            'label' => '<i class="fa fa-at"></i>' . Yii::t("basicfield", "Mail & SMTP Settings"),
                            'url' => array('/emailsettings'), 'active' => Yii::$app->controller->id == 'emailsettings'),

//                        array('visible' => self::AA('emailtpl'),
//                            'tag' => "emailtpl", 'label' => '<i class="fa fa-envelope-o"></i>' . Yii::t("basicfield", "Email Template"),
//                            'url' => array('/emailtpl'), 'active' => Yii::$app->controller->id == 'emailtpl'),


                        array('visible' => self::AA('custom-page'),
                            'tag' => "custom-page", 'label' => '<i class="fa fa-building-o"></i>' . Yii::t("basicfield", "Custom Page"),
                            'url' => array('/custom-page'), 'active' => Yii::$app->controller->id == 'custom-pages'),


                        array('visible' => self::AA('contact-settings'), 'tag' => "contact-settings",
                            'label' => '<i class="fa fa-phone"></i>' . Yii::t("basicfield", "Contact Settings"),
                            'url' => array('/contact-settings'), 'active' => Yii::$app->controller->id == 'contact-settings'),

                        array('visible' => self::AA('social-settings'), 'tag' => "social-settings",
                            'label' => '<i class="fa fa-share-alt"></i>' . Yii::t("basicfield", "Social Settings"),
                            'url' => array('/social-settings'), 'active' => Yii::$app->controller->id == 'social-settings'),
                        
                        array('visible' => self::AA('basicfield'), 'tag' => "manageLanguage",
                            'label' => '<i class="fa fa-graduation-cap"></i>' . Yii::t("basicfield", "Add Language"),
                            'url' => array('/language'), 'active' => Yii::$app->controller->id == 'language'),
                        

                        array('visible' => self::AA('basicfield'), 'tag' => "manageLanguage",
                            'label' => '<i class="fa fa-graduation-cap"></i>' . Yii::t("basicfield", "Manage Language"),
                            'url' => array('/basicfield'), 'active' => Yii::$app->controller->id == 'basicfield'),
                        
                        array('visible' => self::AA('seo'),
                            'tag' => "seo", 'label' => '<i class="fa fa-flask"></i>' . Yii::t("basicfield", "SEO"),
                            'url' => array('/seo'), 'active' => Yii::$app->controller->id == 'seo'),
                    )),
                
                array(
                    'label' => '<i class="fa fa-envelope"></i>'.Yii::t("basicfield", "Email Template").'<i class="fa fa-angle-left pull-right"></i>',
                    'options' => array('class' => 'treeview ' . (in_array(Yii::$app->controller->action->id, ['admin', 'merchant', 'customer']) ? 'active' : '')),
                    'url' => '#',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('visible' => self::AA('emailtpl'),
                            'tag' => "admin", 'label' => '<i class="fa fa-envelope"></i>' . Yii::t("basicfield", "Email Template For Admin"),
                            'url' => array('/emailtpl/admin'), 'active' => (Yii::$app->controller->id == 'emailtpl' && Yii::$app->controller->action->id == 'admin')),

                        array('visible' => self::AA('emailtpl'),
                            'tag' => "merchant",
                            'label' => '<i class="fa fa-envelope"></i>' . Yii::t("basicfield", "Email Template For Merchant"),
                            'url' => array('/emailtpl/merchant'), 'active' => (Yii::$app->controller->id == 'emailtpl' && Yii::$app->controller->action->id == 'merchant')),

                        array('visible' => self::AA('emailtpl'), 'tag' => "emailCustomer",
                            'label' => '<i class="fa fa-envelope"></i>' . Yii::t("basicfield", "Email Template For Customer"),
                            'url' => array('/emailtpl/customer'), 'active' => (Yii::$app->controller->id == 'emailtpl' && Yii::$app->controller->action->id == 'customer')),


                        
                    )),
                array(
                    'label' => '<i class="fa fa-pie-chart"></i>'.Yii::t("basicfield", "Marketing Section").'<i class="fa fa-angle-left pull-right"></i>',
                    'options' => array('class' => 'treeview ' . (in_array(Yii::$app->controller->id, ['client', 'newsletter', 'review',]) ? 'active' : '')),
                    'url' => '#',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                array('visible' => self::AA('client'), 'tag' => "client",
                    'label' => '<i class="fa fa-sun-o"></i>' . Yii::t("basicfield", "Customer List"),
                    'url' => array('/client'), 'active' => Yii::$app->controller->id == 'client'),

                array('visible' => self::AA('newsletter'), 'tag' => "newsletter",
                    'label' => '<i class="fa fa-rss"></i>' . Yii::t("basicfield", "Subscriber List"),
                    'url' => array('/newsletter'), 'active' => Yii::$app->controller->id == 'newsletter'),

                array('visible' => self::AA('review'), 'tag' => "review",
                    'label' => '<i class="fa fa-comment"></i>' . Yii::t("basicfield", "Reviews"),
                    'url' => array('/review'), 'active' => Yii::$app->controller->id == 'review'),
                    )),


                array('visible' => self::AA('paymentgateway'), 'tag' => 'paymentgateway',
                    'label' => '<i class="fa fa-usd"></i>' . Yii::t("basicfield", 'Payment Gateway') . '<i class="fa fa-angle-left pull-right"></i>',
                    'option' => array('class' => 'treeview ' . (in_array(Yii::$app->controller->id, ['paypalSettings', 'paymentProvider']) ? 'active' : '')),
                    'url' => '#',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(

                        array('visible' => self::AA('paypalSettings'),
                            'tag' => 'paypalSettings', 'label' => '<i class="fa fa-paypal"></i>' . Yii::t("basicfield", "Paypal"),
                            'url' => array('/paypalSettings'), 'active' => Yii::$app->controller->id == 'paypalSettings'),

                        array('visible' => self::AA('paymentProvider'), 'tag' => 'paymentProvider',
                            'label' => '<i class="fa fa-paypal"></i>' . Yii::t("basicfield", "Pay On Delivery settings"),
                            'url' => array('/paymentProvider'), 'active' => Yii::$app->controller->id == 'paymentProvider'),
                    )
                ),
                
                array('visible' => self::AA('seo-rule'),
                    'tag' => "seo-rule",
                    'label' => '<i class="fa fa-home"></i>'. Yii::t("basicfield", "Seo Rule"),
                    'url' => array('/seo-rule'),
                    'active' => Yii::$app->controller->id == 'seo-rule'),


                array('visible' => self::AA('reports'),
                    'tag' => 'reports', 'label' => '<i class="fa fa-list-alt"></i>' . Yii::t("basicfield", 'Reports') . '<i class="fa fa-angle-left pull-right"></i>',
                    'options' => array('class' => 'treeview ' . (in_array(Yii::$app->controller->id, ['rptMerchantReg', 'rptMerchantPayment', 'rptMerchanteSales', 'rptmerchantsalesummary']) ? 'active' : '')),
                    'url' => '#',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(

                        array('visible' => self::AA('rpt-merchant-reg'), 'tag' => 'rptMerchantReg',
                            'label' => '<i class="fa fa-calendar"></i>' . Yii::t("basicfield", "Merchant Registration"),
                            'url' => array('/rpt-merchant-reg'), 'active' => Yii::$app->controller->id == 'rptMerchantReg'),

                        array('visible' => self::AA('rpt-merchant-payment'), 'tag' => 'rptMerchantPayment',
                            'label' => '<i class="fa fa-calendar-plus-o"></i>' . Yii::t("basicfield", "Merchant Payment"),
                            'url' => array('/rpt-merchant-payment'), 'active' => Yii::$app->controller->id == 'rptMerchantPayment'),

                        array('visible' => self::AA('rpt-merchante-sales'), 'tag' => 'rptMerchanteSales',
                            'label' => '<i class="fa fa-calendar-check-o"></i>' . Yii::t("basicfield", "Merchant Sales Report"),
                            'url' => array('/rpt-merchante-sales'), 'active' => Yii::$app->controller->id == 'rptMerchanteSales'),

                        array('visible' => self::AA('rptmerchantsalesummary'), 'tag' => 'rptmerchantsalesummary',
                            'label' => '<i class="fa fa-calendar-o"></i>' . Yii::t("basicfield", "Merchant Sales Summary Report"),
                            'url' => array('/rptmerchantsalesummary'), 'active' => Yii::$app->controller->id == 'rptmerchantsalesummary'),

                        /* array('visible'=>self::AA('rptbookingsummary'),'tag'=>'rptbookingsummary',
                             'label'=>'<i class="fa fa-paypal"></i>'.Yii::t("basicfield","Booking Summary Report"),
                             'url'=>array('/rptbookingsummary')),*/
                    )),

                array('visible' => self::AA('admin-user'),
                    'tag' => "userList", 'label' => '<i class="fa fa-users"></i>' . Yii::t("basicfield", "User List"),
                    'url' => array('/admin-user')),

                array('tag' => "logout", 'label' => '<i class="fa fa-sign-out"></i>' . Yii::t("basicfield", "Logout"),
                    'url' => array('/login/logout')),
            ),
            'submenuTemplate' => "\n<ul class='treeview-menu' role='menu'>\n{items}\n</ul>\n",
        );
    }

    /** NEW CODE ADDED FOR VERSION 2.1.1*/

    public static function AA($tag = '')
    {
        $access = json_decode(Yii::$app->user->identity->user_access);
        if (!Yii::$app->user->isGuest && in_array($tag, (array)$access)) {
            return true;
        }

        return false;
    }

    public static function getOptionAdmin($option_name = '')
    {

        if (is_null(self::$_options)) {
            $models = \common\models\Option::find()->all();
            if ($models) {
                self::$_options = \yii\helpers\ArrayHelper::map($models, 'option_name', 'option_value');
            }
        }
        return isset(self::$_options[$option_name]) ? self::$_options[$option_name] : '';

    }

    public static function allActions()
    {
        $data = [0 => 'autologin',
            1 => 'dashboard',

            2 => 'merchant',
            //   3 => 'sponsoredMerchantList',
            4 => 'packages',
            5 => 'service-category',
            6 => 'service-subcategory',
            7 => 'order-status',
            8 => 'settings',
            //9 => 'zipcode',
            10 => 'commisionsettings',
            11 => 'voucher',
            12 => 'merchantcommission',
            //  13 => 'withdrawal',
            //14 => 'incomingwithdrawal',
            //15 => 'withdrawalsettings',
            16 => 'emailsettings',
            17 => 'emailtpl',
            18 => 'custom-page',
            19 => 'ratings',
            20 => 'contact-settings',
            21 => 'social-settings',
            22 => 'language',
            23 => 'basicfield',
            24 => 'seo',
            //  25 => 'addons',
            // 26 => 'addonexport',
            // 27 => 'analytics',
            28 => 'client',
            29 => 'newsletter',
            30 => 'review',
            //   31 => 'bankdeposit',
            // 32 => 'paymentgatewaysettings',
            // 33 => 'paymentgateway',
            34 => 'paypal-settings',
            // 35 => 'cardpaymentsettings',
            // 36 => 'stripeSettings',
            // 37 => 'mercadopagoSettings',
            // 38 => 'sisowsettings',
            // 39 => 'payumonenysettings',
            // 40 => 'obdsettings',
            // 41 => 'payserasettings',
            42 => 'payment-provider',
            //  43 => 'barclay',
            //  44 => 'epaybg',
            //  45 => 'authorize',
            // 46 => 'sms',
            // 47 => 'smsSettings',
            // 48 => 'smsPackage',
            // 49 => 'smstransaction',
            // 50 => 'smslogs',
            // 51 => 'fax',
            // 52 => 'faxtransaction',
            //  53 => 'faxpackage',
            //  54 => 'faxlogs',
            // 55 => 'faxsettings',
            56 => 'reports',
            57 => 'rpt-merchant-reg',
            58 => 'rpt-merchant-payment',
            59 => 'rpt-merchante-sales',
            60 => 'rptmerchantsalesummary',
            //61 => 'rptbookingsummary',
            62 => 'admin-user',
            63 => 'seo-rule'
            ];
        return array_combine($data, $data);
    }

    public static function clientStatus()
    {
        return array(
            'pending' => Yii::t("basicfield", 'pending for approval'),
            'active' => Yii::t("basicfield", 'active'),
            'suspended' => Yii::t("basicfield", 'suspended'),
            'blocked' => Yii::t("basicfield", 'blocked'),
            'expired' => Yii::t("basicfield", 'expired')
        );
    }

    private static function allSystemActions()
    {
        return [];
    }
} 