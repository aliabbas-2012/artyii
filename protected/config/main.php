<?php

require_once('constants.php');

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'OMS',
    'import' => array(
        'application.vendors.phpexcel.PHPExcel',
        'application.models.*',
        'application.components.*',
        'application.components.qupload.*',
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
    'defaultController' => 'site',
    'params' => include(dirname(__FILE__) . '/params.php'),
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'loginUrl' => array('home/'),
        //'allowAutoLogin'=>true,
        ),
        'db' => array(
            //local
            'connectionString' => 'mysql:host=localhost;dbname=artshire_yii',
           
            'emulatePrepare' => true,
        
            'username' => 'artshire_yii',
           
            'password' => 'yii@123',
         
            'charset' => 'utf8',
            'tablePrefix' => '',
        ),
        'errorHandler' => array(
        // use 'site/error' action to display errors
             //'errorAction' => 'admin/error'
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => true,
            'caseSensitive' => false,
            'class' => 'MyUrlManager'
        ),
    ),
);