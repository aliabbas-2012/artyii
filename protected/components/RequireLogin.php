<?php

class RequireLogin extends CBehavior {

    public function attach($owner) {

        $owner->attachEventHandler('onBeginRequest', array($this, 'handleBeginRequest'));
    }

    /**
     * Check authentication and redirect user to activity page if not logged in.
     * @param type $event 
     */
    public function handleBeginRequest($event) {
       
        $route = Yii::app()->getUrlManager()->parseUrl(Yii::app()->getRequest());
        //echo $route;exit();
        $routepieces = explode("/", $route);
       // echo $routepieces[0];exit();
        if (in_array($routepieces[0], array('site', 'upload',''))) { /// Push login free controller name here
            $site_mode = Helpers::siteMode();
            if ($site_mode) {
                if (!in_array($route, array('site/message'))) {
                    $url = Yii::app()->createUrl(Yii::app()->params['AppUrls']['fr_message']);
                    Yii::app()->request->redirect($url);
                }
            }
        } else {
            if (isset(Yii::app()->user->useremail) && Yii::app()->user->useremail) {
                if (Yii::app()->user->admin != 3 && $routepieces[0] == 'admin') {
                    $url = Yii::app()->createUrl(Yii::app()->params['AppUrls']['si_index']);
                    Yii::app()->request->redirect($url);
                }
                if (isset(Yii::app()->user->password) && !Yii::app()->user->password) {
                    if (in_array($route, array('site/changepassword', 'admin/changepassword', 'admin/logout', 'site/logout', 'site/passwordcheck'))) {
                        
                    } else {
                        $url = Yii::app()->createUrl(Yii::app()->params['AppUrls']['si_index']);
                        Yii::app()->request->redirect($url);
                    }
                } else if (in_array($route, array('site/verifyuser', 'admin/signin', 'site/signup', 'site/emailcheck'))) {
                    $url = Yii::app()->createUrl(Yii::app()->params['AppUrls']['si_index']);
                    Yii::app()->request->redirect($url);
                }
            } else {
                if ($routepieces[0] == 'admin') {
                    if (in_array($route, array('admin/signin'))) {
                        
                    }else{
                        $url = Yii::app()->createUrl(Yii::app()->params['AppUrls']['si_index']);
                        Yii::app()->request->redirect($url);
                    }
                }
            }
        }
    }

    public function handlelogout() {
        $url = Yii::app()->createUrl('user/logout');
        Yii::app()->request->redirect($url);
    }

    /**
     *
     * @param type $event 
     */
    public function handleBrowserCheck($event) {

        //echo $browserName = Yii::app()->browser->getName();
    }

    /**
     *
     * @param type $event 
     */
    public function handleImports($event) {
        
    }

    /**
     *
     * @param type $event 
     */
    public function handleLoadTimeZone($event) {
        
    }

    /**
     *
     * @param type $event 
     */
    public function handleCheckAndUpdateCurrencyRates($event) {
        
    }

    /**
     *
     * @param type $event 
     */
    public function handleResolveCustomData($event) {
        
    }

    /**
     *
     * @param type $event 
     */
    public function handleLoadLanguage($event) {
        
    }

    /**
     *
     * @param type $event 
     */
    public function handleClearCache($event) {
        
    }

}

?>