<div id="footer">
    <div id="footerLinks">
        <ul id="ulFootLinks">
            <li class="first">
                <a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_aboutus']); ?>" title="About Us">About Us</a>
            </li> 
            <li>
                <a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_contactus']); ?>" title="Contact Us">Contact Us</a>
            </li> 
            <li>
                <a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_responsibly']); ?>" title="Play Responsibly">Play Responsibly</a>
            </li> 
            <li>
                <a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_tos']); ?>" title="Terms &amp; Conditions">Terms &amp; Conditions</a>
            </li> 
            <li><a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_privacy']); ?>" title="Privacy Policy">Privacy Policy</a>
            </li>
        </ul>
    </div>

    <div style="height: 66px;margin: 15px auto 0;width: 750px;">

    </div>


    <div id="copyright">
        <p>
            Arts
            art design art design art design art design art design art design , Powered by 
            art designart designart designart designart designart designart designart design by 
            art design, the Lotteries and Art Authority of Colombia
        </p>
        <p>© Copyright 2014 Arts Portal- All Rights Reserved</p>
        <p>Powered by <a href="javascript://" title="Pluscoder">Pluscoder</a></p>
    </div>

</div>

<script>
    var BASE_URL = '<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_index']); ?>';
    var JBASE_URL = '<?php echo Yii::app()->request->baseUrl; ?>';
    $(function() {

        $("img.lazy").lazyload();

    });
</script>


<script>
    myTimer();
    var myVar = setInterval(function() {
        myTimer()
    }, 40000*2);
    function myTimer()
    {
        var jqxhr = $.ajax(JBASE_URL+"/site/dofunction")
        .done(function() {
            
        })
        .fail(function() {
            
        })
        .always(function() {
            
        });
    }
</script>

