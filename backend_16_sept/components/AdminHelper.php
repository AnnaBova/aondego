<?php

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
            'htmlOptions' => ['class' => 'sidebar-menu'],
            'encodeLabel' => false,
            'items' => array(
                array('visible' => self::AA('dashboard'),
                    'tag' => "dashboard", 'label' => '<i class="fa fa-home"></i>' . Yii::t("default", "Dashboard"),
                    'url' => array('/dashboard'), 'active' => Yii::app()->controller->getId() == 'dashboard'),
                array(
                    'label' => '<i class="fa fa-gear"></i>'.Yii::t("default", "Sale Section").'<i class="fa fa-angle-left pull-right"></i>',
                    'itemOptions' => array('class' => 'treeview ' . (in_array(Yii::app()->controller->id, ['serviceCategory', 'serviceSubcategory', 'merchant', 'packages', 'commisionsettings']) ? 'active' : '')),
                    'url' => '#',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('visible' => self::AA('serviceCategory'),
                            'tag' => "serviceCategory", 'label' => '<i class="fa fa-sticky-note-o"></i>' . Yii::t("default", "Category List"),
                            'url' => array('/serviceCategory'), 'active' => Yii::app()->controller->getId() == 'serviceCategory'),
                        array('visible' => self::AA('serviceSubcategory'),
                            'tag' => "serviceSubcategory", 'label' => '<i class="fa fa-clone"></i>' . Yii::t("default", "Subcategory List"),
                            'url' => array('/serviceSubcategory'), 'active' => Yii::app()->controller->getId() == 'serviceSubcategory'),

                        array('visible' => self::AA('merchant'),
                            'tag' => "merchant", 'label' => '<i class="fa fa-puzzle-piece"></i>' . Yii::t("default", "Merchant List"),
                            'url' => array('/merchant'), 'active' => Yii::app()->controller->getId() == 'merchant'),


                        array('visible' => self::AA('packages'),
                            'tag' => "packages", 'label' => '<i class="fa fa-black-tie"></i>' . Yii::t("default", "Packages"),
                            'url' => array('/packages'), 'active' => Yii::app()->controller->getId() == 'packages'),

                        array('visible' => self::AA('commisionsettings'),
                            'tag' => "commisionsettings",
                            'label' => '<i class="fa fa-wrench"></i>' . Yii::t("default", "Commission Settings"),
                            'url' => array('/commisionsettings'), 'active' => Yii::app()->controller->getId() == 'commisionsettings'),
                    )),
                array(
                    'label' => '<i class="fa fa-cubes"></i>'.Yii::t("default", "Admin Settings").'<i class="fa fa-angle-left pull-right"></i>',
                    'itemOptions' => array('class' => 'treeview ' . (in_array(Yii::app()->controller->id, ['settings', 'voucher', 'emailsettings', 'customPage', 'contactSettings', 'socialSettings', 'yiiT', 'seo']) ? 'active' : '')),
                    'url' => '#',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('visible' => self::AA('settings'),
                            'tag' => "settings", 'label' => '<i class="fa fa-cogs"></i>' . Yii::t("default", "General Settings"),
                            'url' => array('/settings'), 'active' => Yii::app()->controller->getId() == 'settings'),

                        array('visible' => self::AA('voucher'),
                            'tag' => "voucher",
                            'label' => '<i class="fa fa-bolt"></i>' . Yii::t("default", "Voucher"),
                            'url' => array('/voucher'), 'active' => Yii::app()->controller->getId() == 'voucher'),

                        /* array('visible'=>self::AA('merchantcommission'),
                             'tag'=>"merchantcommission",
                             'label'=>'<i class="fa fa-list-alt"></i>'.Yii::t("default","Merchant Commission"),
                             'url'=>array('/merchantcommission','active' => Yii::app()->controller->getId() == 'merchantcommission')),*/


                        array('visible' => self::AA('emailsettings'), 'tag' => "emailsettings",
                            'label' => '<i class="fa fa-at"></i>' . Yii::t("default", "Mail & SMTP Settings"),
                            'url' => array('/emailsettings'), 'active' => Yii::app()->controller->getId() == 'emailsettings'),

//                        array('visible' => self::AA('emailtpl'),
//                            'tag' => "emailtpl", 'label' => '<i class="fa fa-envelope-o"></i>' . Yii::t("default", "Email Template"),
//                            'url' => array('/emailtpl'), 'active' => Yii::app()->controller->getId() == 'emailtpl'),


                        array('visible' => self::AA('customPage'),
                            'tag' => "customPage", 'label' => '<i class="fa fa-building-o"></i>' . Yii::t("default", "Custom Page"),
                            'url' => array('/customPage'), 'active' => Yii::app()->controller->getId() == 'customPage'),


                        array('visible' => self::AA('contactSettings'), 'tag' => "contactSettings",
                            'label' => '<i class="fa fa-phone"></i>' . Yii::t("default", "Contact Settings"),
                            'url' => array('/contactSettings'), 'active' => Yii::app()->controller->getId() == 'contactSettings'),

                        array('visible' => self::AA('socialSettings'), 'tag' => "socialSettings",
                            'label' => '<i class="fa fa-share-alt"></i>' . Yii::t("default", "Social Settings"),
                            'url' => array('/socialSettings'), 'active' => Yii::app()->controller->getId() == 'socialSettings'),


                        array('visible' => self::AA('yiiT'), 'tag' => "manageLanguage",
                            'label' => '<i class="fa fa-graduation-cap"></i>' . Yii::t("default", "Manage Language"),
                            'url' => array('/yiiT'), 'active' => Yii::app()->controller->getId() == 'yiiT'),

                        array('visible' => self::AA('seo'),
                            'tag' => "seo", 'label' => '<i class="fa fa-flask"></i>' . Yii::t("default", "SEO"),
                            'url' => array('/seo'), 'active' => Yii::app()->controller->getId() == 'seo'),
                    )),
                
                array(
                    'label' => '<i class="fa fa-envelope"></i>'.Yii::t("default", "Email Template").'<i class="fa fa-angle-left pull-right"></i>',
                    'itemOptions' => array('class' => 'treeview ' . (in_array(Yii::app()->controller->action->id, ['admin', 'merchant', 'customer']) ? 'active' : '')),
                    'url' => '#',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('visible' => self::AA('emailtpl'),
                            'tag' => "admin", 'label' => '<i class="fa fa-envelope"></i>' . Yii::t("default", "Email Template For Admin"),
                            'url' => array('/emailtpl/admin'), 'active' => (Yii::app()->controller->getId() == 'emailtpl' && Yii::app()->controller->action->getId() == 'admin')),

                        array('visible' => self::AA('emailtpl'),
                            'tag' => "merchant",
                            'label' => '<i class="fa fa-envelope"></i>' . Yii::t("default", "Email Template For Merchant"),
                            'url' => array('/emailtpl/merchant'), 'active' => (Yii::app()->controller->getId() == 'emailtpl' && Yii::app()->controller->action->getId() == 'merchant')),

                        array('visible' => self::AA('emailtpl'), 'tag' => "emailCustomer",
                            'label' => '<i class="fa fa-envelope"></i>' . Yii::t("default", "Email Template For Customer"),
                            'url' => array('/emailtpl/customer'), 'active' => (Yii::app()->controller->getId() == 'emailtpl' && Yii::app()->controller->action->getId() == 'customer')),


                        
                    )),
                array(
                    'label' => '<i class="fa fa-pie-chart"></i>'.Yii::t("default", "Marketing Section").'<i class="fa fa-angle-left pull-right"></i>',
                    'itemOptions' => array('class' => 'treeview ' . (in_array(Yii::app()->controller->id, ['client', 'newsletter', 'review',]) ? 'active' : '')),
                    'url' => '#',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                array('visible' => self::AA('client'), 'tag' => "client",
                    'label' => '<i class="fa fa-sun-o"></i>' . Yii::t("default", "Customer List"),
                    'url' => array('/client'), 'active' => Yii::app()->controller->getId() == 'client'),

                array('visible' => self::AA('newsletter'), 'tag' => "newsletter",
                    'label' => '<i class="fa fa-rss"></i>' . Yii::t("default", "Subscriber List"),
                    'url' => array('/newsletter'), 'active' => Yii::app()->controller->getId() == 'newsletter'),

                array('visible' => self::AA('review'), 'tag' => "review",
                    'label' => '<i class="fa fa-comment"></i>' . Yii::t("default", "Reviews"),
                    'url' => array('/review'), 'active' => Yii::app()->controller->getId() == 'review'),
                    )),


                array('visible' => self::AA('paymentgateway'), 'tag' => 'paymentgateway',
                    'label' => '<i class="fa fa-usd"></i>' . Yii::t("default", 'Payment Gateway') . '<i class="fa fa-angle-left pull-right"></i>',
                    'itemOptions' => array('class' => 'treeview ' . (in_array(Yii::app()->controller->id, ['paypalSettings', 'paymentProvider']) ? 'active' : '')),
                    'url' => '#',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(

                        array('visible' => self::AA('paypalSettings'),
                            'tag' => 'paypalSettings', 'label' => '<i class="fa fa-paypal"></i>' . Yii::t("default", "Paypal"),
                            'url' => array('/paypalSettings'), 'active' => Yii::app()->controller->getId() == 'paypalSettings'),

                        array('visible' => self::AA('paymentProvider'), 'tag' => 'paymentProvider',
                            'label' => '<i class="fa fa-paypal"></i>' . Yii::t("default", "Pay On Delivery settings"),
                            'url' => array('/paymentProvider'), 'active' => Yii::app()->controller->getId() == 'paymentProvider'),
                    )
                ),


                array('visible' => self::AA('reports'),
                    'tag' => 'reports', 'label' => '<i class="fa fa-list-alt"></i>' . Yii::t("default", 'Reports') . '<i class="fa fa-angle-left pull-right"></i>',
                    'itemOptions' => array('class' => 'treeview ' . (in_array(Yii::app()->controller->id, ['rptMerchantReg', 'rptMerchantPayment', 'rptMerchanteSales', 'rptmerchantsalesummary']) ? 'active' : '')),
                    'url' => '#',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(

                        array('visible' => self::AA('rptMerchantReg'), 'tag' => 'rptMerchantReg',
                            'label' => '<i class="fa fa-calendar"></i>' . Yii::t("default", "Merchant Registration"),
                            'url' => array('/rptMerchantReg'), 'active' => Yii::app()->controller->getId() == 'rptMerchantReg'),

                        array('visible' => self::AA('rptMerchantPayment'), 'tag' => 'rptMerchantPayment',
                            'label' => '<i class="fa fa-calendar-plus-o"></i>' . Yii::t("default", "Merchant Payment"),
                            'url' => array('/rptMerchantPayment'), 'active' => Yii::app()->controller->getId() == 'rptMerchantPayment'),

                        array('visible' => self::AA('rptMerchanteSales'), 'tag' => 'rptMerchanteSales',
                            'label' => '<i class="fa fa-calendar-check-o"></i>' . Yii::t("default", "Merchant Sales Report"),
                            'url' => array('/rptMerchanteSales'), 'active' => Yii::app()->controller->getId() == 'rptMerchanteSales'),

                        array('visible' => self::AA('rptmerchantsalesummary'), 'tag' => 'rptmerchantsalesummary',
                            'label' => '<i class="fa fa-calendar-o"></i>' . Yii::t("default", "Merchant Sales Summary Report"),
                            'url' => array('/rptmerchantsalesummary'), 'active' => Yii::app()->controller->getId() == 'rptmerchantsalesummary'),

                        /* array('visible'=>self::AA('rptbookingsummary'),'tag'=>'rptbookingsummary',
                             'label'=>'<i class="fa fa-paypal"></i>'.Yii::t("default","Booking Summary Report"),
                             'url'=>array('/rptbookingsummary')),*/
                    )),

                array('visible' => self::AA('adminUser'),
                    'tag' => "userList", 'label' => '<i class="fa fa-users"></i>' . Yii::t("default", "User List"),
                    'url' => array('/adminUser')),

                array('tag' => "logout", 'label' => '<i class="fa fa-sign-out"></i>' . Yii::t("default", "Logout"),
                    'url' => array('/login/logout')),
            )
        );
    }

    /** NEW CODE ADDED FOR VERSION 2.1.1*/

    public static function AA($tag = '')
    {
        if (!Yii::app()->user->isGuest && in_array($tag, (array)Yii::app()->user->model->access)) {
            return true;
        }

        return false;
    }

    public static function getOptionAdmin($option_name = '')
    {

        if (is_null(self::$_options)) {
            $models = Option::model()->findAll(['select' => 'option_name, option_value']);
            if ($models) {
                self::$_options = CHtml::listData($models, 'option_name', 'option_value');
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
            5 => 'serviceCategory',
            6 => 'serviceSubcategory',
            7 => 'orderStatus',
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
            18 => 'customPage',
            19 => 'ratings',
            20 => 'contactSettings',
            21 => 'socialSettings',
            23 => 'yiiT',
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
            34 => 'paypalSettings',
            // 35 => 'cardpaymentsettings',
            // 36 => 'stripeSettings',
            // 37 => 'mercadopagoSettings',
            // 38 => 'sisowsettings',
            // 39 => 'payumonenysettings',
            // 40 => 'obdsettings',
            // 41 => 'payserasettings',
            42 => 'paymentProvider',
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
            57 => 'rptMerchantReg',
            58 => 'rptMerchantPayment',
            59 => 'rptMerchanteSales',
            60 => 'rptmerchantsalesummary',
            //61 => 'rptbookingsummary',
            62 => 'adminUser'];
        return array_combine($data, $data);
    }

    public static function clientStatus()
    {
        return array(
            'pending' => Yii::t("default", 'pending for approval'),
            'active' => Yii::t("default", 'active'),
            'suspended' => Yii::t("default", 'suspended'),
            'blocked' => Yii::t("default", 'blocked'),
            'expired' => Yii::t("default", 'expired')
        );
    }

    private static function allSystemActions()
    {
        return [];
    }
} 