<?php

class AppController extends Controller {

    public $pageDesc = '';
    public $pageHttpEquiv = 'text/html; charset=UTF-8';
    public $pageRobotsIndex = true;
    public $pageOgTitle = '';
    public $pageOgDesc = '';
    public $pageOgImage = '';
    public $createLog = false;
    public $logType = '';
    public $logUserId = 0;
    public $logItemId = 0;
    public $logIp = '';
    public $logparentId = 0;
    public $logBrowserInfo = '';
    public $logOsInfo = '';
    public $jsArray = array();
    public $cssArray = array();
    
    /*Searche variables*/
    public $searchboxValue = '';
    public $totalLoaded = 0;
    public $showLimit = 0;
    public $allImages = true;
    public $imagePath = '';
    public $imgwidth = 0;
    public $imgheight = 0;
    public $userPublicData = '';
    public $publicData = '';
    public $publicDataDetails = '';
    public $userName = '';
    public $placePublicData = '';
    public $placeSlug = '';
    public $placeName = '';
    public $access = 'private';
    public $connectedPeople = array();
    public $userLeftMenue = true;
    public $userViewConnections = true;
    public $alllists = true;
    public $allstatus = true;
    public $allconnections = true;
    public $homeitems = true;
    public $global_site_meta_key = '';
    public $global_site_meta_des = '';
    public function display_seo() {

        echo "\t" . '' . PHP_EOL;

        echo "\t" . '<meta http-equiv="Content-Type" content="', CHtml::encode($this->pageHttpEquiv), '">' . PHP_EOL;

        echo "\t" . '<meta name="description" content="', CHtml::encode($this->pageDesc), '">' . PHP_EOL;
        if ($this->pageRobotsIndex == false) {
            echo '<meta name="robots" content="noindex">' . PHP_EOL;
        }

        if (!empty($this->pageOgTitle)) {
            echo "\t" . '<meta property="og:title" content="', CHtml::encode($this->pageOgTitle), '">' . PHP_EOL;
        }
        if (!empty($this->pageOgDesc)) {
            echo "\t" . '<meta property="og:description" content="', CHtml::encode($this->pageOgDesc), '">' . PHP_EOL;
        }
        if (!empty($this->pageOgImage)) {
            echo "\t" . '<meta property="og:image" content="', $this->pageOgImage, '">' . PHP_EOL;
        }
    }

    public function addCSS() {

        if (!empty($this->cssArray) && count($this->cssArray) > 0) {

            for ($i = 0; $i < count($this->cssArray); $i++) {
                
                echo "\t" . '<link rel="stylesheet" media="screen" href="' . Yii::app()->request->baseUrl . '/css/' . $this->cssArray[$i] . '">' . PHP_EOL;
            }
        }
    }

    public function addJS() {

        if (!empty($this->jsArray) && count($this->jsArray) > 0) {

            for ($i = 0; $i < count($this->jsArray); $i++) {

                echo "\t" . '<script src="' . Yii::app()->request->baseUrl . '/js/' . $this->jsArray[$i] . '"></script>' . PHP_EOL;
            }
        }
    }

    

}
