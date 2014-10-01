<?php

require_once('constants.php');
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'OMS',
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.extensions.recaptcha.EReCaptcha',
    ),
    'behaviors' => array(
        'onBeginRequest' => array(
            'class' => 'application.components.RequireLogin'
        )
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123456',
        // 'ipFilters'=>array(...a list of IPs...),
        // 'newFileMode'=>0666,
        // 'newDirMode'=>0777,
        )
    ),
    'defaultController' => 'admin',
    'params' => include(dirname(__FILE__) . '/params.php'),
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'loginUrl' => array('home/'),
        //'allowAutoLogin'=>true,
        ),
        'db' => array(
            //local
            //'connectionString' => 'mysql:host=localhost;dbname=gamezone',
            //server
            'connectionString' => 'mysql:host=localhost;dbname=pluscode_gmaezone',
            'emulatePrepare' => true,
            //local
            //'username' => 'root',
            //server
            'username' => 'pluscode_game',
            //local
            //'password' => '',
            //server
            'password' => 'pluscode_gmae',
            'charset' => 'utf8',
            'tablePrefix' => '',
        ),
        'errorHandler' => array(
        // use 'site/error' action to display errors
        //      'errorAction' => 'home/error',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'caseSensitive' => false,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            ),
        ),
    ),
);