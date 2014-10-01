<?php $this->beginContent('/layouts/panels/site_header'); ?>
<?php $this->endContent();
ob_start(); ?>
<body>         

    <div id="main-container">


        <div id="fixed-header"><!--//-->
            <div id="head">
                <div id="footerLinks" style="padding:20px;">
                    <ul id="ulFootLinks">
                        <li class="first">
                            <?php if (isset(Yii::app()->user->useremail) && Yii::app()->user->useremail) { ?> 

                                <a  href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_logout']); ?>">Logout</a> 


                            <?php } else { ?>


                                <a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_signin']); ?>" title="Log In">Log In</a>
                               
                                
                                
                            <?php } ?>
                        </li>
                        <?php if (isset(Yii::app()->user->useremail)) { ?> 
                            <li>
                                <a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_dashboard']); ?>" title="Dashboard">Dashboard</a>
                            </li> 
                            <li>
                                <a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_create_project']); ?>" title="Create Project">Create Project</a>
                            </li> 
                        <?php } ?>
                        <?php if (!isset(Yii::app()->user->useremail)) { ?> 
                            <li>
                                <a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_forgotpass']); ?>">Forgot Log In</a>
                            </li> 
                            <li>
                                <a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_signup']); ?>" title="Sign Up">Sign Up</a>
                            </li> 
                         <?php } ?>
                        
                    </ul>
                </div>
            </div>
        </div>



        <div id="contentSection">

        </div>	 




        <div id="lower-body">
            <?php echo $content; ?>
        </div>

        <?php $this->beginContent('/layouts/panels/site_footer'); ?>
<?php $this->endContent(); ?>

    </div>
</body>
</html>
