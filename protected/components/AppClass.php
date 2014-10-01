<?php

class AppClass {

    public static $userName;
    public static $pageDesc;
    public static $pageHttpEquiv;
    public static $pageRobotsIndex = true;
    public static $pageOgTitle = '';
    public static $pageOgDesc = '';
    public static $pageOgImage = '';
    public static $createLog = false;
    public static $logType = '';
    public static $logUserId = 0;
    public static $logItemId = 0;
    public static $logIp = '';
    public static $logparentId = 0;
    public static $logBrowserInfo = '';
    public static $logOsInfo = '';
    public static $jsArray = array();
    public static $cssArray = array();
    
    

    public  function __construct() {
        
    }

    public static  function init() {
        
        self::$userName = 'Jamal';
    }

}