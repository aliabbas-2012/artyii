<?php

$yii = dirname(__FILE__) . '/yii/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';

require_once($yii);

Yii::createWebApplication($config);
define('BASE_URL', Yii::app()->request->baseUrl);
/*Yii::import('ext.yiiexcel.YiiExcel', true);
Yii::registerAutoloader(array('YiiExcel', 'autoload'), true);

// Optional:
//  As we always try to run the autoloader before anything else, we can use it to do a few
//      simple checks and initialisations
PHPExcel_Shared_ZipStreamWrapper::register();

if (ini_get('mbstring.func_overload') & 2) {
    throw new Exception('Multibyte function overloading in PHP must be disabled for string functions (2).');
}
PHPExcel_Shared_String::buildCharacterSets();*/
Yii::app()->run();
