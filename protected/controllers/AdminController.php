<?php

/**
 * Admin Controller.
 *
 */
class AdminController extends AppController {

    public $layout = 'admin';

    public function actionIndex() {

        $this->redirect(array(Yii::app()->params['AppUrls']['adsignin']));
    }

    public function actionSignin() {
        $model = new LoginForm('login');
        if (isset($_POST['txtEmail'])) {
            $model->tu_email = Helpers::getCleanValue($_POST['txtEmail']);
            $model->tu_password = Helpers::getCleanValue($_POST['txtPassword']);
            if ($model->validate() && $model->login()) {
                $this->redirect(array(Yii::app()->params['AppUrls']['adusers']));
            }
        }
        $this->render(Yii::app()->params['AppViews']['adsignin'], array(
            'model' => $model,
        ));
    }

    public function actionProjects() {

        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->addCondition("mode=1");
        $count = Project::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = VIEW_PER_PAGE;
        $pages->applyLimit($criteria);
        $models = Project::model()->findAll($criteria);
        if(!empty($models) && count($models) > 0){
            for($i=0;$i<count($models);$i++){
                $model_user[$i] =  new User();
                $models[$i]->user = $model_user[$i]->findByPK($models[$i]->owner_id);
            }
        }
        $this->render(Yii::app()->params['AppViews']['adprojects'], array(
            'models' => $models,
            'pages' => $pages,
            'total' => $count
        ));
    }

    public function actionDownloadcollage() {
        if (!empty($_GET['ukey'])) {
            $_ukey = $_GET['ukey'];
            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where mode = 1 and ukey='$_ukey'");
            $result = $command->queryRow();
            if (isset($result['ukey'])) {
                $file = "./finalimages/" . $result['final_image_name'];
                if (file_exists($file)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: image/png');
                    header('Content-Disposition: attachment; filename=' . basename($file));
                    header('Content-Transfer-Encoding: binary');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    ob_clean();
                    flush();
                    readfile($file);
                    exit;
                } else {
                    echo "$file not found";
                }
            }
        }
        exit();
    }

    public function actionUsers() {

        $criteria = new CDbCriteria();
        $criteria->order = 'tu_id DESC';
        $count = User::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = VIEW_PER_PAGE;
        $pages->applyLimit($criteria);
        $models = User::model()->findAll($criteria);
        $this->render(Yii::app()->params['AppViews']['adusers'], array(
            'models' => $models,
            'pages' => $pages,
            'total' => $count
        ));
    }

    public function actionNewuser() {
        $model = array();
        $this->render(Yii::app()->params['AppViews']['sigin_view'], array(
            'model' => $model,
        ));
    }

    public function actionUploadbg() {
        
        $this->render('ad_upload');
               
    }
    
     public function actionLoadimages() {
        if (1) {
            $_file_name = $_POST['newimage'];
            $_owner_id = Yii::app()->user->getId();
            $_upload_message = "";
            $_done=false;
            if (1) {
                if (!empty($_file_name)) {
                    $savepath = Yii::getPathOfAlias('webroot') . '/collage/';
                    $new_filename = Helpers::getFilenameAsUnique($savepath, $_file_name);
                    $savepath = Yii::getPathOfAlias('webroot') . '/collage/' . $_file_name;
                    $newsavepath = Yii::getPathOfAlias('webroot') . '/collage/';
                    Helpers::fileRename($savepath, $new_filename, $newsavepath);
                    $logo_thumbnail = $new_filename;
                    
                  
                    $_done = true;
                    $model_img = new Images();
                    $model_img->img_key = Helpers::getUnqiueKey();
                    $model_img->project_key = 'XXX';
                    $model_img->main_img = $_file_name;
                    $model_img->cropped_img = $new_filename;
                    $model_img->created_at = date(DB_INSERT_TIME_FORMAT, time());
                    $model_img->bg_img = 1;
                    $model_img->save();
                }
                
                $_retArray = '';
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("project_key='XXX'");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = VIEW_PER_PAGE;
                $pages->applyLimit($criteria);
                $_project_model_imges = Images::model()->findAll($criteria);
                $_data = $this->renderPartial(Yii::app()->params['AppViews']['si_partial_img_view'], array(
                'models' => $_project_model_imges,
                'pages' => $pages,
                'total' => $count,
                '_upload_message'=>$_upload_message
                ), true);
                
                echo CJSON::encode(array(
                        'message' => $_upload_message,
                        'dataset' => $_data,
                ));
            }
        }
        exit();
    }
    
    
     public function actionCropimg() {

        if (!empty($_POST['ukey'])) {
            $_ukey = $_POST['ukey'];
            $_imgkey = $_POST['imgkey'];
            $_owner_id = Yii::app()->user->getId();

            if (1) {
                $_project_id = 0;
                if (!empty($_imgkey)) {
                    $command = Yii::app()->db->createCommand("SELECT * From tbl_images where img_key = '$_imgkey'");
                    $result_img = $command->queryRow();
                    if (isset($result_img['img_key'])) {


                        $targ_wmain = $targ_hmain = 370;
                        $targ_hmain = 170;
                        $targ_w = $targ_wmain = $_POST['w'];

                        $targ_h = $targ_hmain = $_POST['h'];

                        $targ_x = $_POST['x'];

                        $targ_y = $_POST['y'];


                        $savepath = Yii::getPathOfAlias('webroot') . '/collage/' . $result_img['main_img'];

                        if (1) {
                            $_ext = Helpers::getFilenameAsUniqueExt($savepath, $result_img['main_img'], $targ_w, $targ_h);
                            $new_crop_file_name = Helpers::getFilenameAsUniqueCrop($savepath, $result_img['main_img'], $targ_w, $targ_h);
                        }

                        if ($targ_w > 200 and $targ_h > 200) {
                            $jpeg_quality = 80;
                        } else {
                            $jpeg_quality = 9;
                        }

                        $src = 'collage/' . $result_img['main_img'];
                        $dsrc = 'collage/' . $new_crop_file_name;
                        if ($_ext == '.png' || $_ext == '.PNG') {
                            $jpeg_quality = 9;
                            $img_r = imagecreatefrompng($src);
                            $dst_r = ImageCreateTrueColor($targ_wmain, $targ_hmain);

                            imagecopyresampled($dst_r, $img_r, 0, 0, $targ_x, $targ_y, $targ_wmain, $targ_hmain, $targ_w, $targ_h);
                            imagepng($dst_r, $dsrc, $jpeg_quality);
                        } else if ($_ext == '.gif' || $_ext == '.GIF') {
                            $jpeg_quality = 9;
                            $img_r = imagecreatefromgif($src);
                            $dst_r = ImageCreateTrueColor($targ_wmain, $targ_hmain);

                            imagecopyresampled($dst_r, $img_r, 0, 0, $targ_x, $targ_y, $targ_wmain, $targ_hmain, $targ_w, $targ_h);
                            imagegif($dst_r, $dsrc, $jpeg_quality);
                        } else {
                            $img_r = imagecreatefromjpeg($src);
                            $dst_r = ImageCreateTrueColor($targ_wmain, $targ_hmain);

                            imagecopyresampled($dst_r, $img_r, 0, 0, $targ_x, $targ_y, $targ_wmain, $targ_hmain, $targ_w, $targ_h);
                            imagejpeg($dst_r, $dsrc, $jpeg_quality);
                        }
                       
                        
                        $command_update = Yii::app()->db->createCommand("UPDATE `tbl_images` SET `cropped_img` = '$new_crop_file_name' WHERE img_key = '$_imgkey'");
                        $command_update->execute();
                        
                    }
                }

                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("project_key='XXX'");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = VIEW_PER_PAGE;
                $pages->applyLimit($criteria);
                $_project_model_imges = Images::model()->findAll($criteria);
                echo $_data = $this->renderPartial(Yii::app()->params['AppViews']['si_partial_img_view'], array(
                'models' => $_project_model_imges,
                'pages' => $pages,
                'total' => $count
                    ), true);
                }
        }
        exit();
    }

    public function actionReportplayerwise() {
        $this->render(Yii::app()->params['AppViews']['adplayerwisereport']);
    }

    public function actionReportgamewise() {
        $command = Yii::app()->db->createCommand("SELECT * FROM `tbl_users` WHERE `tu_status`=1 order by tu_username asc");
        $allusers = $command->queryAll();

        $command = Yii::app()->db->createCommand("SELECT * FROM `tbl_country` order by name asc");
        $allcountries = $command->queryAll();

        $this->render(Yii::app()->params['AppViews']['adgamewisereport'], array(
            'allusers' => $allusers,
            'allcountries' => $allcountries,
        ));
    }

    public function actionProviders() {

        $criteria = new CDbCriteria();
        $criteria->order = 'tp_id DESC';
        $count = Provider::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = VIEW_PER_PAGE;
        $pages->applyLimit($criteria);
        $models = Provider::model()->findAll($criteria);
        $this->render(Yii::app()->params['AppViews']['adproviders'], array(
            'models' => $models,
            'pages' => $pages,
            'total' => $count
        ));
    }

    public function actionNewprovider() {
        if (isset($_POST['tp_name'])) {
            $p_name = $_POST['tp_name'];
            $p_name = trim($p_name);
            if (!empty($p_name)) {
                $model = new Provider;
                $model->tp_name = Helpers::getCleanValue($_POST['tp_name']);
                $model->tp_slug = Helpers::getUniqueProviderSlug($model->tp_name);
                $model->tp_slug = str_replace("&", "and", $model->tp_slug);
                $model->tp_key = Helpers::getUnqiueKey();
                $erromessage = '';
                if ($erromessage == '' && $model->save()) {
                    Yii::app()->user->setFlash('success', "Provider is created successfully!");
                } else {
                    if (!empty($erromessage)) {
                        Yii::app()->user->setFlash('success', $erromessage);
                    } else {
                        Yii::app()->user->setFlash('success', "Something is wrong. Please try again!");
                    }
                }
            }
        }
        $model = array();
        $this->render(Yii::app()->params['AppViews']['adnewprovider'], array(
            'model' => $model,
        ));
    }

    public function actionSettings() {
        if (isset($_POST['tg_cou'])) {
            $p_name = $_POST['tg_cou'];
            if (1) {
                $model = Psettings::model()->findByAttributes(array('tps_id' => 1));
                $model->tps_animation = $p_name;
                $erromessage = '';
                if ($erromessage == '' && $model->save()) {
                    Yii::app()->user->setFlash('success', "Settings is updated successfully!");
                } else {
                    if (!empty($erromessage)) {
                        Yii::app()->user->setFlash('success', $erromessage);
                    } else {
                        Yii::app()->user->setFlash('success', "Something is wrong. Please try again!");
                    }
                }
            }
        }
        $model = Psettings::model()->findByAttributes(array('tps_id' => 1));
        $this->render(Yii::app()->params['AppViews']['adsettings'], array(
            'model' => $model,
        ));
    }

    public function actionCategories() {
        $criteria = new CDbCriteria();
        $criteria->order = 'tc_id DESC';
        $count = Category::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = VIEW_PER_PAGE;
        $pages->applyLimit($criteria);
        $models = Category::model()->findAll($criteria);
        $this->render(Yii::app()->params['AppViews']['adcategories'], array(
            'models' => $models,
            'pages' => $pages,
            'total' => $count
        ));
    }

    public function actionNewcategory() {
        if (isset($_POST['tc_name'])) {
            $c_name = $_POST['tc_name'];
            $c_name = trim($c_name);
            if (!empty($c_name)) {
                $model = new Category;
                $model->tc_name = Helpers::getCleanValue($_POST['tc_name']);
                $model->tc_slug = Helpers::getUniqueCatSlug($model->tc_name);
                $model->tc_slug = str_replace("&", "and", $model->tc_slug);
                $model->tc_key = Helpers::getUnqiueKey();
                $erromessage = '';
                if ($erromessage == '' && $model->save()) {
                    Yii::app()->user->setFlash('success', "Category is created successfully!");
                } else {
                    if (!empty($erromessage)) {
                        Yii::app()->user->setFlash('success', $erromessage);
                    } else {
                        Yii::app()->user->setFlash('success', "Something is wrong. Please try again!");
                    }
                }
            }
        }
        $model = array();
        $this->render(Yii::app()->params['AppViews']['adnewcategory'], array(
            'model' => $model,
        ));
    }

    public function actionGames() {

        $criteria = new CDbCriteria();
        $criteria->order = 'tg_order ASC';
        $count = Game::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = VIEW_PER_PAGE;
        $pages->applyLimit($criteria);
        $models = Game::model()->findAll($criteria);
        if (isset($models) && !empty($models) && count($models) > 0) {
            for ($i = 0; $i < count($models); $i++) {
                $models[$i]->c_name = Helpers::getCatNameById($models[$i]->tg_cat);
                $models[$i]->p_name = Helpers::getProviderNameById($models[$i]->tg_pro);
            }
        }
        $this->render(Yii::app()->params['AppViews']['adgames'], array(
            'models' => $models,
            'pages' => $pages,
            'total' => $count
        ));
    }

    public function actionOrdergames() {
        $pages = '';
        $criteria = new CDbCriteria();
        $criteria->order = 'tg_order ASC';
        $count = Game::model()->count($criteria);
        $models = Game::model()->findAll($criteria);
        $this->render(Yii::app()->params['AppViews']['adordergames'], array(
            'models' => $models,
            'pages' => $pages,
            'total' => $count
        ));
    }

    public function actionNewgame() {
        if (isset($_POST['tg_name'])) {
            $p_name = $_POST['tg_name'];
            $p_name = trim($p_name);
            if (!empty($p_name)) {
                $erromessage = '';
                $allowedExts = array("jpg", "jpeg", "png", "JPG", "JPEG", "PNG", "GIF", "gif");
                $temp = explode(".", $_FILES["tg_thumb"]["name"]);
                $extension = end($temp);
                if (in_array($extension, $allowedExts)) {
                    if ($_FILES["tg_thumb"]["error"] > 0) {
                        echo $_FILES["tg_thumb"]["error"];
                        Yii::app()->user->setFlash('success', "Something is wrong. Please try again!");
                    } else {
                        move_uploaded_file($_FILES["tg_thumb"]["tmp_name"], "tempuploads/" . $_FILES["tg_thumb"]["name"]);
                        $savepath = Yii::getPathOfAlias('webroot') . '/tempuploads/';
                        $new_filename = Helpers::getFilenameAsUnique($savepath, $_FILES["tg_thumb"]["name"]);
                        $savepath = Yii::getPathOfAlias('webroot') . '/tempuploads/' . $_FILES["tg_thumb"]["name"];
                        $newsavepath = Yii::getPathOfAlias('webroot') . '/cdnimg/';
                        Helpers::fileRename($savepath, $new_filename, $newsavepath);
                        $logo_thumbnail = $new_filename;
                    }
                }

                $erromessage = '';
                $allowedExts = array("jpg", "jpeg", "png", "JPG", "JPEG", "PNG", "GIF", "gif");
                $temp = explode(".", $_FILES["tg_rthumb"]["name"]);
                $extension = end($temp);
                if (in_array($extension, $allowedExts)) {
                    if ($_FILES["tg_rthumb"]["error"] > 0) {
                        Yii::app()->user->setFlash('success', "Something is wrong. Please try again!");
                    } else {
                        move_uploaded_file($_FILES["tg_rthumb"]["tmp_name"], "tempuploads/" . $_FILES["tg_rthumb"]["name"]);
                        $savepath = Yii::getPathOfAlias('webroot') . '/tempuploads/';
                        $new_rfilename = Helpers::getFilenameAsUnique($savepath, $_FILES["tg_rthumb"]["name"]);
                        $savepath = Yii::getPathOfAlias('webroot') . '/tempuploads/' . $_FILES["tg_rthumb"]["name"];
                        $newsavepath = Yii::getPathOfAlias('webroot') . '/cdnimg/';
                        Helpers::fileRename($savepath, $new_rfilename, $newsavepath);
                        $logo_thumbnail = $new_rfilename;
                    }
                }

                $model = new Game;
                $model->tg_name = Helpers::getCleanValue($_POST['tg_name']);
                $model->tg_slug = Helpers::getUniqueGameSlug($model->tg_name);
                $model->tg_key = Helpers::getUnqiueKey();
                $model->tg_des = Helpers::getCleanValue($_POST['tg_des']);
                $model->tg_iurl = Helpers::getCleanValue($_POST['tg_iurl']);
                $model->tg_width = Helpers::getCleanValue($_POST['tg_width']);
                $model->tg_height = Helpers::getCleanValue($_POST['tg_height']);
                $model->tg_cat = Helpers::getCleanValue($_POST['tg_cat']);
                $model->tg_pro = Helpers::getCleanValue($_POST['tg_pro']);
                $block_string = '';
                if (isset($_POST['tg_block']) && !empty($_POST['tg_block']) && count($_POST['tg_block']) > 0) {
                    for ($i = 0; $i < count($_POST['tg_block']); $i++) {
                        if ($i == count($_POST['tg_block']) - 1) {
                            $block_string = $block_string . $_POST['tg_block'][$i];
                        } else {
                            $block_string = $block_string . $_POST['tg_block'][$i] . ',';
                        }
                    }
                }
                $model->tg_block = $block_string;

                if (isset($new_filename)) {

                    $model->tg_thumb = $new_filename;
                }
                if (isset($new_rfilename)) {

                    $model->tg_rthumb = $new_rfilename;
                }
                $erromessage = '';
                if ($erromessage == '' && isset($new_filename) && $model->save()) {
                    Yii::app()->user->setFlash('success', "Game is created successfully!");
                } else {
                    if (!empty($erromessage)) {
                        Yii::app()->user->setFlash('success', $erromessage);
                    } else {
                        Yii::app()->user->setFlash('success', "Something is wrong. Please try again!");
                    }
                }
            }
        }
        $_country_list = Helpers::getAllCountries();
        $_provider_list = Helpers::getAllProviders();
        $_cat_list = Helpers::getAllCategories();
        $model = array();
        $this->render(Yii::app()->params['AppViews']['adnewgame'], array(
            'countrylist' => $_country_list,
            'categorylist' => $_cat_list,
            'providerlist' => $_provider_list
        ));
    }

    public function actionEditgame() {
        $game_key = '';
        if (isset($_GET['key']) && !empty($_GET['key'])) {
            $game_key = $_GET['key'];
        }
        $game_details = Helpers::getGameDetailsByGameKey($game_key);
        if (isset($game_details['tg_key'])) {
            
        } else {
            $this->redirect(array(Yii::app()->params['AppUrls']['aderror']));
        }
        if (isset($_POST['tg_name'])) {
            $p_name = $_POST['tg_name'];
            $p_name = trim($p_name);
            if (!empty($p_name)) {
                $model = Game::model()->findByAttributes(array('tg_key' => $game_key));
                $erromessage = '';
                $allowedExts = array("jpg", "jpeg", "png", "JPG", "JPEG", "PNG", "GIF", "gif");
                $temp = explode(".", $_FILES["tg_thumb"]["name"]);
                $extension = end($temp);
                if (in_array($extension, $allowedExts)) {
                    if ($_FILES["tg_thumb"]["error"] > 0) {
                        echo $_FILES["tg_thumb"]["error"];
                        Yii::app()->user->setFlash('success', "Something is wrong. Please try again!");
                    } else {
                        move_uploaded_file($_FILES["tg_thumb"]["tmp_name"], "tempuploads/" . $_FILES["tg_thumb"]["name"]);
                        $savepath = Yii::getPathOfAlias('webroot') . '/tempuploads/';
                        $new_filename = Helpers::getFilenameAsUnique($savepath, $_FILES["tg_thumb"]["name"]);
                        $savepath = Yii::getPathOfAlias('webroot') . '/tempuploads/' . $_FILES["tg_thumb"]["name"];
                        $newsavepath = Yii::getPathOfAlias('webroot') . '/cdnimg/';
                        Helpers::fileRename($savepath, $new_filename, $newsavepath);
                        $logo_thumbnail = $new_filename;
                    }
                }

                $erromessage = '';
                $allowedExts = array("jpg", "jpeg", "png", "JPG", "JPEG", "PNG", "GIF", "gif");
                $temp = explode(".", $_FILES["tg_rthumb"]["name"]);
                $extension = end($temp);
                if (in_array($extension, $allowedExts)) {
                    if ($_FILES["tg_rthumb"]["error"] > 0) {
                        Yii::app()->user->setFlash('success', "Something is wrong. Please try again!");
                    } else {
                        move_uploaded_file($_FILES["tg_rthumb"]["tmp_name"], "tempuploads/" . $_FILES["tg_rthumb"]["name"]);
                        $savepath = Yii::getPathOfAlias('webroot') . '/tempuploads/';
                        $new_rfilename = Helpers::getFilenameAsUnique($savepath, $_FILES["tg_rthumb"]["name"]);
                        $savepath = Yii::getPathOfAlias('webroot') . '/tempuploads/' . $_FILES["tg_rthumb"]["name"];
                        $newsavepath = Yii::getPathOfAlias('webroot') . '/cdnimg/';
                        Helpers::fileRename($savepath, $new_rfilename, $newsavepath);
                        $logo_thumbnail = $new_rfilename;
                    }
                }


                $model->tg_name = Helpers::getCleanValue($_POST['tg_name']);
                //$model->tg_slug = Helpers::getUniqueGameSlug($model->tg_name);
                //$model->tg_key = Helpers::getUnqiueKey();
                $model->tg_des = Helpers::getCleanValue($_POST['tg_des']);
                $model->tg_iurl = Helpers::getCleanValue($_POST['tg_iurl']);
                $model->tg_width = Helpers::getCleanValue($_POST['tg_width']);
                $model->tg_height = Helpers::getCleanValue($_POST['tg_height']);
                $model->tg_cat = Helpers::getCleanValue($_POST['tg_cat']);
                $model->tg_pro = Helpers::getCleanValue($_POST['tg_pro']);
                $block_string = '';
                if (isset($_POST['tg_block']) && !empty($_POST['tg_block']) && count($_POST['tg_block']) > 0) {
                    for ($i = 0; $i < count($_POST['tg_block']); $i++) {
                        if ($i == count($_POST['tg_block']) - 1) {
                            $block_string = $block_string . $_POST['tg_block'][$i];
                        } else {
                            $block_string = $block_string . $_POST['tg_block'][$i] . ',';
                        }
                    }
                }
                $model->tg_block = $block_string;

                if (isset($new_filename)) {

                    $model->tg_thumb = $new_filename;
                }
                if (isset($new_rfilename)) {

                    $model->tg_rthumb = $new_rfilename;
                }
                $erromessage = '';
                if ($erromessage == '' && $model->save()) {
                    Yii::app()->user->setFlash('success', "Game is updated successfully!");
                } else {
                    if (!empty($erromessage)) {
                        Yii::app()->user->setFlash('success', $erromessage);
                    } else {
                        Yii::app()->user->setFlash('success', "Something is wrong. Please try again!");
                    }
                }
            }
        }
        $game_details = Helpers::getGameDetailsByGameKey($game_key);
        $_country_list = Helpers::getAllCountries();
        $_provider_list = Helpers::getAllProviders();
        $_cat_list = Helpers::getAllCategories();
        $model = array();
        $this->render(Yii::app()->params['AppViews']['adeditgame'], array(
            'countrylist' => $_country_list,
            'categorylist' => $_cat_list,
            'providerlist' => $_provider_list,
            'game_details' => $game_details
        ));
    }

    public function actionDeleteuser() {
        if (isset($_GET['key'])) {
            $slug_name = $_GET['key'];
        } else {
            $this->redirect(array(Yii::app()->params['AppUrls']['aderror']));
        }
        $criteria = new CDbCriteria();
        $criteria->addInCondition('tu_user_key', array($slug_name));
        $models = User::model()->findAll($criteria);
        if (!isset($models[0]->tu_user_key)) {
            $this->redirect(array(Yii::app()->params['AppUrls']['aderror']));
        }
        $command = Yii::app()->db->createCommand("Delete From tbl_users where tu_user_key = '$slug_name'");
        $command->execute();
        $this->redirect(array(Yii::app()->params['AppUrls']['adusers']));
    }

    public function actionDeletegame() {
        if (isset($_GET['key'])) {
            $slug_name = $_GET['key'];
        } else {
            $this->redirect(array(Yii::app()->params['AppUrls']['aderror']));
        }
        $criteria = new CDbCriteria();
        $criteria->addInCondition('tg_key', array($slug_name));
        $models = Game::model()->findAll($criteria);
        if (!isset($models[0]->tg_slug)) {
            $this->redirect(array(Yii::app()->params['AppUrls']['aderror']));
        }
        $command = Yii::app()->db->createCommand("Delete From tbl_games where tg_key = '$slug_name'");
        $command->execute();
        $this->redirect(array(Yii::app()->params['AppUrls']['adgames']));
    }

    public function actionSavegameorder() {
        $values = $_GET['order'];
        $list = explode(',', $values);
        $i = 0;
        foreach ($list as $item) {
            $i = $i + 1;
            echo $item;
            $findAct = Yii::app()->db->createCommand("UPDATE tbl_games SET `tg_order` = $i where tg_id = $item");
            $findAct->execute();
        }
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(array(Yii::app()->params['AppUrls']['adsignin']));
    }

    public function actionError() {
        $this->render(Yii::app()->params['AppViews']['aderror']);
    }

    public function actionGetmyreports() {
        if (Yii::app()->getRequest()->getIsAjaxRequest() && isset($_POST['limit']) && isset($_POST['offset'])) {
            $dataset = array();
            $success = false;
            $login = false;
            $offset = 0;
            $limit = 0;
            $uid = 0;
            $qstring = '';
            $orderby = 0;
            $tco = '';
            $user_id = Yii::app()->user->getId();
            if (isset($_POST['offset']) && isset($_POST['limit'])) {
                $offset = $_POST['offset'];
                $limit = $_POST['limit'];
                $uid = $_POST['uid'];
                $qstring = $_POST['qstring'];
                $orderby = $_POST['ordercriteria'];
                $tco = $_POST['tco'];
                $success = true;
            }
            if ($this->isLoggedIn() && $limit > 0) {
                $login = true;
                $dataset = $this->getGamewiseReports($offset, $limit, $uid, $qstring, $orderby, $tco);
            }
            echo CJSON::encode(array(
                'items' => $dataset,
                'success' => $success,
                'login' => $login
            ));
        } else {
            $this->redirect(array('admin/error'));
        }
    }

    public function isLoggedIn() {
        if (isset(Yii::app()->user->useremail) && !empty(Yii::app()->user->useremail)) {
            return true;
        }
        return false;
    }

    public function getGamewiseReports($offset = 0, $limit = 0, $uid = 0, $qstring = '', $orderby = 0, $tco = '') {
        $tco = trim($tco);
        if (!empty($tco)) {
            $tco = " and ta_country = '$tco'";
        } else {
            $tco = '';
        }
        if ($uid > 0) {
            $query_builder = "SELECT tg_id,tg_name,tg_thumb,(SELECT count( ta_id )
                FROM `tbl_ac_log`
                WHERE `ta_relation_key` = tbl_games.tg_key and ta_type='play' and `ta_user_id` = $uid $tco) as total_played,(SELECT count( distinct(ta_relation_key))
                FROM `tbl_ac_log`
                WHERE `ta_relation_key` = tbl_games.tg_key and ta_type='play' and `ta_user_id` = $uid $tco) as total_un_played 
                From tbl_games";
        } else {
            $query_builder = "SELECT tg_id,tg_name,tg_thumb,(SELECT count( ta_id )
                FROM `tbl_ac_log`
                WHERE `ta_relation_key` = tbl_games.tg_key and ta_type='play' $tco) as total_played,(SELECT count( distinct(ta_relation_key))
                FROM `tbl_ac_log`
                WHERE `ta_relation_key` = tbl_games.tg_key and ta_type='play' $tco) as total_un_played 
                From tbl_games";
        }
        $qstring = trim($qstring);
        if (!empty($qstring)) {
            $qstring = " where `tg_name` LIKE '%$qstring%'";
        }

        if ($orderby == 0) {
            $orde_clase = " ORDER BY total_un_played ASC LIMIT $offset,$limit";
        } else if ($orderby == 1) {
            $orde_clase = " ORDER BY total_un_played DESC LIMIT $offset,$limit";
        } else if ($orderby == 2) {
            $orde_clase = " ORDER BY total_played ASC LIMIT $offset,$limit";
        } else if ($orderby == 3) {
            $orde_clase = " ORDER BY total_played DESC LIMIT $offset,$limit";
        } else if ($orderby == 4) {
            $orde_clase = " ORDER BY tg_name ASC LIMIT $offset,$limit";
        } else if ($orderby == 5) {
            $orde_clase = " ORDER BY tg_name DESC LIMIT $offset,$limit";
        } else {
            $orde_clase = " ORDER BY tg_name ASC LIMIT $offset,$limit";
        }
        $query_builder = $query_builder . $qstring . $orde_clase;
        $command = Yii::app()->db->createCommand($query_builder);
        $result = $command->queryAll();
        if (isset($result) && !empty($result) && count($result) > 0) {
            for ($i = 0; $i < count($result); $i++) {
                $result[$i] = (object) $result[$i];
            }
            return $result;
        }
        return false;
    }

}
