<?php
class SimpleShare extends CWidget
{
    /**
     * Site Name
     * @var string
     * defaults to Yii::app()->name
     */
    public $siteName = 'http://luckywild.com';
 
    /**
     * Site Administrator's Facebook ID
     * @var string
     */
    public $fbSiteAdmin = '134088429225';
 
    /**
     * URL of the page
     * @var string
     * defaults to the current page URL
     */
    public $pageUrl = '';
 
    /**
     * Title of the page
     * @var string
     */
    public $pageTitle = '';
 
    /**
     * Type of the Page : eg. website, article, ... etc.
     * @var string
     * defaults to 'article'
     */
    public $pageType = '';
 
    /**
     * Description of the page
     * @var string
     */
    public $pageDescription = '';
 
    /**
     * Image(s) of the page
     * @var mixed
     * can be a single string or array of strings
     * defaults $this->defaultPageImage
     */
    public $pageImages = '';
 
    /**
     * Default image of the page
     * @var string
     */
    public $defaultPageImage = '/images/fb/site-logo.jpg';
 
    /**
     * Show Comments
     * @var boolean
     * defaults to true
     */
    public $showComments = false;
 
    /**
     * Minimum IE version required
     * @var string
     */
    public $minimumIEVersion = '8';
 
    /**
     * Initialization
     * @see CWidget::init()
     */
    public function init()
    {
        parent::init();
 
        // Site Name
        if ($this->siteName == '') {
            $this->siteName = Yii::app()->name;
        }
 
        // base URL
        $baseUrl = Yii::app()->request->hostInfo . Yii::app()->request->baseUrl;
        // URL of the page
        if ($this->pageUrl == '') {
            $this->pageUrl = $baseUrl . '/' . Yii::app()->request->pathInfo;
        }
 
        // Type of the page
        if ($this->pageType == '') {
            $this->pageType = 'article';
        }
 
        // Set opengraph meta tags
        /** @var CClientScript $cs */
        $cs = Yii::app()->getClientScript();
        $cs->registerMetaTag($this->siteName, NULL, NULL, array('property'=>'og:site_name'));
        
        $cs->registerMetaTag($this->pageUrl, NULL, NULL, array('property' =>'og:url'));
        $cs->registerMetaTag($this->pageTitle, NULL, NULL, array('property'=>'og:title'));
        $cs->registerMetaTag($this->pageType, NULL, NULL, array('property'=>'og:type'));
        // Description of the page
        if ($this->pageDescription != "") {
            $cs->registerMetaTag($this->pageDescription, NULL, NULL, array('property'=>'og:description'));
        }
        // Image(s) of the page
        if (is_array($this->pageImages)) {
            if (count($this->pageImages) == 0) {
                $this->pageImages = $this->defaultPageImage;
            }
            foreach($this->pageImages as $image) {
                $cs->registerMetaTag($baseUrl . $image, NULL, NULL, array('property'=> 'og:image'));
            }
        } else {
            if ($this->pageImages == "") {
                $this->pageImages = $this->defaultPageImage;
            }
            $cs->registerMetaTag($baseUrl . $this->pageImages, NULL, NULL, array('property'=> 'og:image'));
        }
 
        // javasctipt to enable the gadgets
        $init_js = <<< INIT_JS
var msie = navigator.appVersion.toLowerCase();
msie = (msie.indexOf('msie')>-1) ? parseInt(msie.replace(/.*msie[ ]/,'').match(/^[0-9]+/)) : 0;
if (msie == 0 || msie >= $this->minimumIEVersion) {
    $('#sns-share').show();
    // google plus one
    window.___gcfg = {
        lang: 'ja'
    };
    (function() {
        var po = document.createElement('script');
        po.type = 'text/javascript';
        po.async = true;
        po.src = 'https://apis.google.com/js/plusone.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(po, s);
    })();
    // twitter
    !function(d,s,id){
        var js,fjs=d.getElementsByTagName(s)[0],
        p=/^http:/.test(d.location)?'http':'https';
        if(!d.getElementById(id)){
            js=d.createElement(s);
            js.id=id;
            js.async=true;
            js.src=p+'://platform.twitter.com/widgets.js';
            fjs.parentNode.insertBefore(js,fjs);
        }
    }(document, 'script', 'twitter-wjs');
    // facebook
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.async=true;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
}
INIT_JS;
        $cs->registerScript('init-sns-share', $init_js, CClientScript::POS_READY);
    }
 
    /**
     * Display the widget
     * @see CWidget::run()
     */
    public function run()
    {
        echo '<div id="sns-share" style="margin-bottom:20px;">' . "\n";
        echo '<h3></h3>' . "\n";
        echo '<div class="sns-share-buttons">' . "\n";
 
        // google plusone
        echo '<div class="google-plus" style="float:left">' . "\n";
        echo '<g:plusone size="medium" href="' . $this->pageUrl . '"></g:plusone>' . "\n";
        echo '</div>' . "\n";
 
        // twitter
        $tw_text = $this->siteName . ' - ' . $this->pageTitle;
        if ( $this->pageDescription != '')
        {
            $tw_text .= ' : ' . $this->pageDescription;
        }
        echo '<div class="tweet-button" style="float:left">' . "\n";
        echo '<a href="https://twitter.com/share" '
                . 'class="twitter-share-button" '
                . 'data-url="' . $this->pageUrl . '" '
                . 'data-text="' . $tw_text . '" '
                . 'data-count="horizontal">Tweet</a>' . "\n";
        echo '</div>' . "\n";
 
        // facebook
        echo '<div id="fb-root"></div><div class="fb-like" '
                . 'data-href="' . $this->pageUrl . '" '
                . 'data-share="false" '
                . 'data-layout="button_count"'
                . 'data-show-faces="false"></div>' . "\n";
        
        echo '<div class="fb-share-button" '
                . 'data-href="' . $this->pageUrl . '" '
                . 'data-type="button_count"'
                . '></div>' . "\n";
        
        
        if ($this->showComments)
        {
            echo '</div>' . "\n";
            echo '<div class="facebook-comments">' . "\n";
            echo '<div class="fb-comments" '
                    . 'data-href="' . $this->pageUrl . '" '
                    . 'data-num-posts="4" '
                    . 'data-width="600"></div>' . "\n";
        }
        echo '</div>' . "\n";
        echo '</div>' . "\n";
    }
}