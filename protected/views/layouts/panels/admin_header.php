<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Arts Portal</title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo BASE_URL; ?>/cdn/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo BASE_URL; ?>/cdn/bootstrap-datepicker/css/datepicker.css" rel="stylesheet">
        <link href="<?php echo BASE_URL; ?>/cdn/css/style.css" rel="stylesheet">

        <script src="<?php echo BASE_URL; ?>/cdn/js/modernizr.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL; ?>/cdn/js/jquery-1.8.2.min.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL; ?>/cdn/jquery-validation/jquery.validate.min.js"></script>
        <script src="<?php echo BASE_URL; ?>/cdn/bootstrap/js/bootstrap.js"></script>
        <script src="<?php echo BASE_URL; ?>/cdn/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="<?php echo BASE_URL; ?>/cdn/js/app.common.js"></script>
        <script src="<?php echo BASE_URL; ?>/js/jquery.lazyload.js?t=1"></script>
        <script src="<?php echo BASE_URL; ?>/cdn/js/jquery.tmpl.min.js?t=1"></script>

        <!-- Favicons -->

        <style>
            .disnone{
                display: none;
            }
        </style>
        <script>
            var baseUrl = '<?php echo BASE_URL; ?>';
            var JBASE_URL = '<?php echo BASE_URL; ?>';
            var signin_url = JBASE_URL + '/admin/signin'
        </script>

    </head>
    <body>




        <header class="navbar navbar-blue navbar-fixed-top bs-app-nav" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".app-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <nav class="collapse navbar-collapse app-navbar-collapse" role="navigation">

                    <ul class="nav navbar-nav navbar-right">
                        <?php if (isset(Yii::app()->user->useremail) && Yii::app()->user->useremail) { ?> 

                            <li>
                                <a  href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['ad_upload_bg']); ?>/">Upload Default Background</a>
                            </li>

                            <?php if (Yii::app()->controller->id == 'admin' && (Yii::app()->controller->action->id == 'Users'||Yii::app()->controller->action->id == 'onlineusers')) { ?>
                                <li class="dropdown active">
                                <?php } else { ?>
                                <li class="dropdown">
                                <?php } ?>
                                <a href="javascript://" class="dropdown-toggle" data-toggle="dropdown">User<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['adusers']); ?>">User List</a></li>
                                </ul>
                            </li>

                        <?php } ?>

                        
                        <li>
                            <a target="_blank" href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['site_root']); ?>/">Live Preview</a>
                        </li>
                        
                        
                        
                        
                        <?php if (isset(Yii::app()->user->useremail) && Yii::app()->user->useremail) { ?> 

                            

                            <?php if (Yii::app()->controller->id == 'admin' && (Yii::app()->controller->action->id == 'projects')) { ?>
                                <li class="dropdown active">
                                <?php } else { ?>
                                <li class="dropdown">
                                <?php } ?>
                                <a href="javascript://" class="dropdown-toggle" data-toggle="dropdown">Projects<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['adprojects']); ?>">Projects List</a></li>
                                </ul>
                            </li>

                        <?php } ?>
                        
                       

                        <?php if (!isset(Yii::app()->user->useremail)) { ?> 

                            <?php if (Yii::app()->controller->id == 'admin' && (Yii::app()->controller->action->id == 'signin')) { ?>
                                <li class="active">
                                <?php } else { ?>
                                <li>
                                <?php } ?>
                                <a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['adsignin']); ?>">Login</a>
                            </li>

                        <?php } ?>


                        <?php if (isset(Yii::app()->user->useremail) && Yii::app()->user->useremail) { ?> 


                            <?php if (Yii::app()->controller->id == 'admin' && (Yii::app()->controller->action->id == 'logout')) { ?>
                                <li class="active">
                                <?php } else { ?>
                                <li>
                                <?php } ?>
                                <a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['adlogout']); ?>">Logout</a>
                            </li>


                        <?php } ?>

                    </ul>
                </nav>
            </div>
        </header>



<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>