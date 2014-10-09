<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Arts Portal</title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo BASE_URL; ?>/cdn/bootstrap/css/bootstrap.css?v=3" rel="stylesheet">
        <link href="<?php echo BASE_URL; ?>/cdn/bootstrap-datepicker/css/datepicker.css" rel="stylesheet">
        <link href="<?php echo BASE_URL; ?>/cdn/css/style.css?v=3" rel="stylesheet">

        <script src="<?php echo BASE_URL; ?>/cdn/js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>/cdn/js/jquery-ui.min11.js"></script>
        <script src="<?php echo BASE_URL; ?>/js/jquery.validate.js?t=1"></script>
        <script src="<?php echo BASE_URL; ?>/js/jquery.lazyload.js?t=1"></script>
        <script src="<?php echo BASE_URL; ?>/js/html2canvas.js?t=1"></script>
        
       
        <script src="<?php echo BASE_URL; ?>/cdn/bootstrap/js/bootstrap.js"></script>
        
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
                        <li>
                                <a href="http://rammdesigns.com/frontend">Home</a>
                        </li> 
                        <?php if (isset(Yii::app()->user->useremail) && Yii::app()->user->useremail) { ?> 
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
                            
                      
                        
                        
                   
                        
                       

                        <?php if (!isset(Yii::app()->user->useremail)) { ?> 

                            <?php if (Yii::app()->controller->id == 'admin' && (Yii::app()->controller->action->id == 'signin')) { ?>
                                <li class="active">
                                <?php } else { ?>
                                <li>
                                <?php } ?>
                                <a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_signin']); ?>">Login</a>
                            </li>

                        <?php } ?>


                        <?php if (isset(Yii::app()->user->useremail) && Yii::app()->user->useremail) { ?> 


                            <?php if (Yii::app()->controller->id == 'admin' && (Yii::app()->controller->action->id == 'logout')) { ?>
                                <li class="active">
                                <?php } else { ?>
                                <li>
                                <?php } ?>
                                <a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_logout']); ?>">Logout</a>
                            </li>


                        <?php } ?>

                    </ul>
                </nav>
            </div>
        </header>



<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
