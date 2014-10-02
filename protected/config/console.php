<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.


return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Console Application',
    // preloading 'log' component
    'preload' => array('log'),
    // application components
    'components' => array(
        'db' => array(
            //local
            'connectionString' => 'mysql:host=localhost;dbname=artshire_yii',
            'emulatePrepare' => true,
            'username' => 'artshire_yii',
            'password' => 'yii@123',
            'charset' => 'utf8',
            'tablePrefix' => '',
        ),
    ),
);
