<?php
return
	array(
        'components'=>array(
			'session' => [
				'name' => 'advanced-frontend',
				//'savePath' => __DIR__ . '/../runtime', // a temporary folder on frontend
			],

            'db'=>array(
                'class'            => 'CDbConnection' ,
                'connectionString' => 'mysql:host=localhost;dbname=appointment_portal',
                'emulatePrepare'   => true,
                'username'         => 'root',
                'password'         => 'portal1',
                'charset'          => 'utf8',
                'tablePrefix'      => 'mt_',
            ),
        ),
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
		'name'=>'socpatnerstvo console application',
		
		'import'=>array(
			'application.modelsphp.*',
			'application.components.*',
			//'application.extensions.*',
		),
		
		// application componportal1ents
		/*'components'=>array(
			'email' => array(
				'class' 		=> 'application.extensions.email.Email',
				'delivery' 		=> 'php',
			),
		),*/
		'params' => array(
			'siteName' => 'Site',
			'emails' => array('robot' => 'noreply@site.com',),
		),

);