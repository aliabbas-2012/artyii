<?php $this->beginContent('/layouts/panels/site_header'); ?>
<?php $this->endContent();ob_start(); ?>
<body>         

    <div id="main-container">


        <div id="fixed-header"><!--//-->
            <div id="head">
                <div id="headerSection">
                    <div id="menu-container">
                        <div id="menu">
                            <div id="mobile-button"><a href="javascript://">
                                    <img title="" src="<?php echo BASE_URL; ?>/images/mobile-button.png"></a>
                            </div>
                            <div id="promotion-button"><a href="javascript://">
                                    <img alt="undefined" title="" src="<?php echo BASE_URL; ?>/images/promotion-button.png"></a>
                            </div>
                        </div>
                        <div id="logo">
                            <a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_index']); ?>"><img style="height: 200px;" alt="undefined" title="" src="<?php echo BASE_URL; ?>/images/logo4.png"></a>
                        </div>
                        <div id="headLinks">
                            <div id="user-section-container">
                                 <?php if (isset(Yii::app()->user->useremail) && Yii::app()->user->useremail) { ?> 
                                
                                <?php }else { ?>
                                    <div id="user-section">
                                        <form name="login-form" id="login-form" method="post" action="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_index']); ?>">
                                            <input name="txtEmail" id="txtEmail" maxlength="20" class="input-field" placeholder="Email" required="" type="text"> 
                                            <input name="txtPassword" maxlength="20" size="20" value="PASS" id="txtPassword" class="input-field" type="password"> 
                                            <input name="login-submit" id="login-submit" value="" class="button" type="submit">
                                        </form>
                                    </div>
                                <?php } ?>
                                <div id="user-section-links" <?php if (isset(Yii::app()->user->useremail) && Yii::app()->user->useremail) { ?> style="float:right;" <?php } ?>>
                                     <?php if (isset(Yii::app()->user->useremail) && Yii::app()->user->useremail) { ?> 
                                        
                                        <a  href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_logout']); ?>">Logout</a> 

                                       
                                    <?php } else { ?>
                                        <a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_forgotpass']); ?>">Forgot Login</a>
                                        <div id="head-signup">
                                            <a class="lightbox" href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_signup']); ?>">
                                                <img title="" src="<?php echo BASE_URL; ?>/images/signup.png"> 
                                            </a>
                                        </div> 
                                        
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div id="contentSection">
            <?php if (isset(Yii::app()->user->useremail) && Yii::app()->user->useremail) { ?> 
                
            <?php } else { ?>
            <div id="head-banner">
                <div id="head-banner-left">
                    <img alt="undefined" title="" src="<?php echo BASE_URL; ?>/images/header_img1.jpg">
                </div>
                <div id="head-banner-right">
                    <div id="head-banner-right-top">
                        <img alt="undefined" title="" src="<?php echo BASE_URL; ?>/images/quicksignup2.png" style="margin: 0 auto 0 6px;" width="300px">
                        <div class="shortFormContainer">

                            <div class="textblock" style="margin-top: -20px;">
                                <?php
                                    $form = $this->beginWidget('CActiveForm', array(
                                        'id' => 'contactus',
                                        'enableAjaxValidation' => true,
                                        'enableClientValidation' => true,
                                        'htmlOptions' => array(
                                            'enctype' => 'multipart/form-data',
                                            'name' => 'contactus',
                                        ),
                                        'clientOptions' => array(
                                            'validateOnSubmit' => true,
                                            'validateOnChange' => true,
                                            'validateOnType' => false,
                                        ),
                                    ));
                              ?>

                                <div class='container'>
                                    <label for='tu_username' >User Name*: </label><br/>
                                    <input type='text' name='tu_username' id='tu_username' value='<?php if (isset($_POST["tu_username"]) && $success == false) echo $_POST["tu_username"]; else if (isset($_COOKIE["tu_username"])) echo $_COOKIE["tu_username"]; ?>' />
                                </div>
                                <div class='container'>
                                    <label for='tu_password' >Password*: </label><br/>
                                    <input type='password' name='tu_password' id='tu_password' value='<?php if (isset($_POST["tu_password"]) && $success == false) echo $_POST["tu_password"]; else if (isset($_COOKIE["password"])) echo $_COOKIE["password"]; ?>' />
                                </div>

                                <div class='container'>
                                    <label for='tu_email' >Email Address*:</label><br/>
                                    <input type='text' name='tu_email' id='tu_email' value='<?php if (isset($_POST["tu_email"]) && $success == false) echo $_POST["tu_email"]; else if (isset($_COOKIE["email"])) echo $_COOKIE["email"]; ?>'  />
                                </div>
                                <div class='container'>
                                    <label for='tu_mobile' >Mobile: </label><br/>
                                    <input type='text' name='tu_mobile' id='tu_mobile' value='<?php if (isset($_POST["tu_mobile"]) && $success == false) echo $_POST["tu_mobile"]; else if (isset($_COOKIE["mobile"])) echo $_COOKIE["mobile"]; ?>' />
                                </div>
                                <div class='container'>
                                    <input style="width:120px;" type='submit' id="Submit" name='Submit' value='Create Account' />
                                </div>

                            
                            <?php $this->endWidget(); ?>
      
        
                        </div>


                        </div>
                        <img title="" class="euro-t" src="<?php echo BASE_URL; ?>/images/euro.gif" alt="Euro">
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>	 

        <?php  
              $criteria = new CDbCriteria();
              $criteria->order = 'tc_id DESC';
              $allcategories =  Category::model()->findAll($criteria);
        ?>
        <?php  if(isset($allcategories) && !empty($allcategories) && count($allcategories)>0){?>
        <div id="horizontal-line">
            <ul>
                <?php for($i=0;$i<count($allcategories);$i++){?>
                <li>
                    <a class="active" href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_index']); ?>/?cat=<?php echo $allcategories[$i]->tc_slug;?>" title="<?php echo $allcategories[$i]->tc_name;?> Games">
                        <img src="<?php echo BASE_URL; ?>/images/other.png"><span><?php echo $allcategories[$i]->tc_name;?></span>
                    </a>
                </li> 
                <?php }?>
            </ul>
        </div>
        <?php } ?>



        <div id="lower-body">
            <div id="gameSection">
                 <?php  
                        $criteria = new CDbCriteria();
                        $criteria->order = 'tp_id DESC';
                        $allproviders =  Provider::model()->findAll($criteria);
                  ?>
                  
                
                <div id="game-page-navigation">
                    
                    <ul
                        <?php  if(isset($allproviders) && !empty($allproviders) && count($allproviders)>0){
                            for($i=0;$i<count($allproviders);$i++){?>
                            <li class="selected_game_nav"><a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_index']); ?>/?provider=<?php echo $allproviders[$i]->tp_slug;?>" title="<?php echo $allproviders[$i]->tp_name;?>"><span><?php echo $allproviders[$i]->tp_name;?></span></a></li>
                        <?php }} ?>
                    </ul>
                </div>
                
                <div id="gamePanelWrapper">

                    <div id="game-container">

                        <?php echo $content; ?>

                    </div>
                </div>
            </div>
        </div>
        
        <?php $this->beginContent('/layouts/panels/site_footer'); ?>
        <?php $this->endContent(); ?>

    </div>
</body>
</html>
<?php ob_end_flush();//echo "<pre>";print_r($_COOKIE);
?>
