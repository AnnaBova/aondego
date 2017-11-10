<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'db' => 'db',
                    'sourceLanguage' => 'en', // Developer language
                    'sourceMessageTable' => 'source_message',
                    'messageTable' => 'message',
                    //'cachingDuration' => 86400,
                    //'enableCaching' => true,
                ],
            ],
        ],
    ],
];
