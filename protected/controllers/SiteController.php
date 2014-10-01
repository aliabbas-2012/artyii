<?php

/**
 * Site Controller.
 *
 */
class SiteController extends AppController {

    public $layout = 'resadmin';
    //public $layout = 'sitewheader';
    public function actionIndex() {
        
        //$this->render(Yii::app()->params['AppViews']['si_index']);
        $this->redirect(array('site/signin'));
    }

    public function actionDashboard() {
        $_user_id = Yii::app()->user->getId();
        if($_user_id<=0){$this->redirect(array('site/signin'));}
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->addCondition("owner_id=$_user_id");
        $count = Project::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = VIEW_PER_PAGE;
        $pages->applyLimit($criteria);
        $models = Project::model()->findAll($criteria);
        $this->render(Yii::app()->params['AppViews']['si_dashboard'], array(
            'models' => $models,
            'pages' => $pages,
            'total' => $count
        ));
    }

    public function actionCreate() {
        $_user_id = Yii::app()->user->getId();
        if($_user_id<=0){$this->redirect(array('site/signin'));}
        $model = New Project;
        if (isset($_POST['Project'])) {
            $model->attributes = $_POST['Project'];
            $model->ukey = Helpers::getUnqiueKey();
            $model->mode = 0;
            $model->owner_id = Yii::app()->user->getId();
            $model->created_at = date(DB_INSERT_TIME_FORMAT, time());
            if($model->save())
            $this->redirect(array(Yii::app()->params['AppUrls']['si_upload_project_bg_img'] . "/?ukey=" . $model->ukey));
        }
        $this->render(Yii::app()->params['AppViews']['si_project_create'], array(
            'model' => $model
        ));
    }

    public function actionBgupload() {
        
        if (!empty($_GET['ukey'])) {
            $_ukey = $_GET['ukey'];
            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where owner_id = '$_owner_id' and mode = 0 and ukey='$_ukey'");
            $result = $command->queryRow();
            if (isset($result['ukey'])) {
                $_id = $result['id'];
                $model = $this->loadModel($_id);
                $this->render(Yii::app()->params['AppViews']['si_upload_project_bg_images'], array(
                    'model' => $model
                ));
                exit();
            }
        }
        $this->redirect(array(Yii::app()->params['AppUrls']['si_dashboard']));
        exit();
    }
    
    public function actionUpload() {
        
        if (!empty($_GET['ukey'])) {
            $_ukey = $_GET['ukey'];
            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where owner_id = '$_owner_id' and mode = 0 and ukey='$_ukey'");
            $result = $command->queryRow();
            if (isset($result['ukey'])) {
                $_id = $result['id'];
                $model = $this->loadModel($_id);
                $this->render(Yii::app()->params['AppViews']['si_upload_project_images'], array(
                    'model' => $model
                ));
                exit();
            }
        }
        $this->redirect(array(Yii::app()->params['AppUrls']['si_dashboard']));
        exit();
    }

     public function actionLoadbgimages() {
        if (!empty($_POST['ukey'])) {
            
            $_ukey = $_POST['ukey'];
            $_file_name = $_POST['newimage'];
            $_imgpos = $_POST['imgpos'];
            
            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where owner_id = '$_owner_id' and mode = 0 and ukey='$_ukey'");
            $result = $command->queryRow();
            $_upload_message = "";
            $_done=false;
            if (isset($result['ukey'])) {
                $_project_id = $result['id'];
                if (!empty($_file_name)) {
                    $savepath = Yii::getPathOfAlias('webroot') . '/collage/';
                    $new_filename = Helpers::getFilenameAsUnique($savepath, $_file_name);
                    $savepath = Yii::getPathOfAlias('webroot') . '/collage/' . $_file_name;
                    $newsavepath = Yii::getPathOfAlias('webroot') . '/collage/';
                    Helpers::fileRename($savepath, $new_filename, $newsavepath);
                    $logo_thumbnail = $new_filename;
                    
                    $commandyes = Yii::app()->db->createCommand("SELECT * From tbl_images where project_key = '$_ukey' and img_serial = $_imgpos");
                    $back_img = $commandyes->queryRow();
                   
                    if(isset($back_img['img_serial'])){
                        $model_img = Images::model()->findByPk($back_img['id']);
                    }else{
                        $model_img = new Images();
                        $model_img->img_key = Helpers::getUnqiueKey();
                        $model_img->project_id = $_project_id;
                        $model_img->project_key = $_ukey;
                        $model_img->created_at = date(DB_INSERT_TIME_FORMAT, time());
                    }
                    $_done =true;
                    $model_img->img_serial = $_imgpos;
                    $model_img->main_img = $_file_name;
                    $model_img->cropped_img = $new_filename;
                    if($_imgpos==5){
                       $model_img->bg_img = 1; 
                    }
                    $model_img->save();
                    
                }
                $_retArray = '';
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("project_id=$_project_id and bg_img=0");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = VIEW_PER_PAGE;
                $pages->applyLimit($criteria);
                $_project_model_imges = Images::model()->findAll($criteria);
                
                
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("(project_id=$_project_id and bg_img=1 and img_serial=5) OR (project_key='XXX' and bg_img=1)");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = VIEW_PER_PAGE;
                $pages->applyLimit($criteria);
                $_project_bg_model_imges = Images::model()->findAll($criteria);
                
                
                $_data = $this->renderPartial(Yii::app()->params['AppViews']['si_partial_bg_img_view'], array(
                'models' => $_project_model_imges,
                'modelsbg' => $_project_bg_model_imges,
                'project_img_id' => $result['bg_id'],
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
    public function actionLoadimages() {
        if (!empty($_POST['ukey'])) {
            
            $_ukey = $_POST['ukey'];
            $_file_name = $_POST['newimage'];
            $_imgpos = $_POST['imgpos'];
            
            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where owner_id = '$_owner_id' and mode = 0 and ukey='$_ukey'");
            $result = $command->queryRow();
            $_upload_message = "";
            $_done=false;
            if (isset($result['ukey'])) {
                $_project_id = $result['id'];
                if (!empty($_file_name)) {
                    $savepath = Yii::getPathOfAlias('webroot') . '/collage/';
                    $new_filename = Helpers::getFilenameAsUnique($savepath, $_file_name);
                    $savepath = Yii::getPathOfAlias('webroot') . '/collage/' . $_file_name;
                    $newsavepath = Yii::getPathOfAlias('webroot') . '/collage/';
                    Helpers::fileRename($savepath, $new_filename, $newsavepath);
                    $logo_thumbnail = $new_filename;
                    
                    $commandyes = Yii::app()->db->createCommand("SELECT * From tbl_images where project_key = '$_ukey' and img_serial = $_imgpos");
                    $back_img = $commandyes->queryRow();
                   
                    if(isset($back_img['img_serial'])){
                        $model_img = Images::model()->findByPk($back_img['id']);
                    }else{
                        $model_img = new Images();
                        $model_img->img_key = Helpers::getUnqiueKey();
                        $model_img->project_id = $_project_id;
                        $model_img->project_key = $_ukey;
                        $model_img->created_at = date(DB_INSERT_TIME_FORMAT, time());
                    }
                    $_done =true;
                    $model_img->img_serial = $_imgpos;
                    $model_img->main_img = $_file_name;
                    $model_img->cropped_img = $new_filename;
                    if($_imgpos==5){
                       $model_img->bg_img = 1; 
                    }
                    $model_img->save();
                    
                }
                $_retArray = '';
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("project_id=$_project_id and bg_img=0");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = VIEW_PER_PAGE;
                $pages->applyLimit($criteria);
                $_project_model_imges = Images::model()->findAll($criteria);
                
                
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("(project_id=$_project_id and bg_img=1 and img_serial=5) OR (project_key='XXX' and bg_img=1)");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = VIEW_PER_PAGE;
                $pages->applyLimit($criteria);
                $_project_bg_model_imges = Images::model()->findAll($criteria);
                
                
                $_data = $this->renderPartial(Yii::app()->params['AppViews']['si_partial_img_view'], array(
                'models' => $_project_model_imges,
                'modelsbg' => $_project_bg_model_imges,
                'project_img_id' => $result['bg_id'],
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
    
    public function actionLoaddefaultimages(){
        if (!empty($_POST['ukey'])) {
            
            $_ukey = $_POST['ukey'];
            
            $_done=false;
            $_upload_message = "";
                $_done=true;
                $_data = $this->renderPartial(Yii::app()->params['AppViews']['si_default_project_img_view'], array(
                    '_upload_message'=>$_upload_message
                ), true);
                
                echo CJSON::encode(array(
                        'message' => $_upload_message,
                        'dataset' => $_data,
                ));
        }
        exit();
    }

    public function actionDeleteproject() {

        if (!empty($_GET['ukey'])) {
            $_ukey = $_GET['ukey'];
            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("DELETE FROM tbl_projects where owner_id = '$_owner_id' and ukey ='$_ukey'");
            $command->execute();
        }

        $this->redirect(array(Yii::app()->params['AppUrls']['si_dashboard']));
        exit();
    }

    public function actionMakebackground() {
        if (!empty($_POST['ukey'])) {

            $_ukey = $_POST['ukey'];
            $_img_key = $_POST['imgkey'];

            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where owner_id = '$_owner_id' and mode = 0 and ukey='$_ukey'");
            $result = $command->queryRow();
            $_upload_message = "";
            $_done = false;
            if (isset($result['ukey'])) {
                $_project_id = $result['id'];
                
                
                $commandyes = Yii::app()->db->createCommand("SELECT * From tbl_images where img_key = '$_img_key'");
                $back_img = $commandyes->queryRow();
                
                if(isset($back_img['img_key'])){
                    
                     $model_project = Project::model()->findByPk($_project_id);
                     $model_project->bg_id = $back_img['id'];
                     $model_project->save();
                }
                
                $_retArray = '';
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("project_id=$_project_id and bg_img=0");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = VIEW_PER_PAGE;
                $pages->applyLimit($criteria);
                $_project_model_imges = Images::model()->findAll($criteria);


                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("(project_id=$_project_id and bg_img=1 and img_serial=5) OR (project_key='XXX' and bg_img=1)");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = VIEW_PER_PAGE;
                $pages->applyLimit($criteria);
                $_project_bg_model_imges = Images::model()->findAll($criteria);


                $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where owner_id = '$_owner_id' and mode = 0 and ukey='$_ukey'");
                $result = $command->queryRow();
                $_data = $this->renderPartial(Yii::app()->params['AppViews']['si_partial_bg_img_view'], array(
                    'models' => $_project_model_imges,
                    'modelsbg' => $_project_bg_model_imges,
                    'project_img_id' => $result['bg_id'],
                    'pages' => $pages,
                    'total' => $count,
                    '_upload_message' => $_upload_message
                        ), true);

                echo CJSON::encode(array(
                    'message' => $_upload_message,
                    'cc' => $result['bg_id'],
                    'dataset' => $_data,
                    
                ));
            }
        }
        exit();
    }

    public function actionMakebackgroundpast() {
        if (!empty($_POST['ukey'])) {
            $_ukey = $_POST['ukey'];
            $_imgkey = $_POST['imgkey'];
            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where owner_id = '$_owner_id' and mode = 0 and ukey='$_ukey'");
            $result = $command->queryRow();

            if (isset($result['ukey'])) {
                $_project_id = $result['id'];
                if (!empty($_imgkey)) {
                    $command = Yii::app()->db->createCommand("SELECT * From tbl_images where project_key='$_ukey' and img_key = '$_imgkey'");
                    $result_img = $command->queryRow();
                    if (isset($result_img['img_key'])) {

                        $command_update_all = Yii::app()->db->createCommand("UPDATE `tbl_images` SET `bg_img` = '0' WHERE project_key='$_ukey'");
                        $command_update_all->execute();

                        $command_update = Yii::app()->db->createCommand("UPDATE `tbl_images` SET `bg_img` = '1' WHERE project_key='$_ukey' and img_key = '$_imgkey'");
                        $command_update->execute();
                    }
                }

                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("project_id=$_project_id");
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

    public function actionCropimgcollage() {

        if (!empty($_POST['ukey'])) {
            $_ukey = $_POST['ukey'];
            $_imgkey = $_POST['imgkey'];
            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where owner_id = '$_owner_id' and mode = 0 and ukey='$_ukey'");
            $result = $command->queryRow();
            
            if (isset($result['ukey'])) {
                $_project_id = $result['id'];
                if (!empty($_imgkey)) {
                    $command = Yii::app()->db->createCommand("SELECT * From tbl_images where project_key='$_ukey' and img_key = '$_imgkey'");
                    $result_img = $command->queryRow();
                    if (isset($result_img['img_key'])) {
                        $targ_wmain = $targ_hmain = 370;
                        $targ_hmain = 170;
                        $targ_w = $targ_wmain = $_POST['w'];
                        $targ_h = $targ_hmain = $_POST['h'];
                        $targ_x = $_POST['x'];
                        $targ_y = $_POST['y'];
                        $savepath = Yii::getPathOfAlias('webroot') . '/collage/' . $result_img['main_img'];
                        if ($savepath) {
                            $_ext = Helpers::getFilenameAsUniqueExt($savepath, $result_img['main_img'], $targ_w, $targ_h);
                            $new_crop_file_name = Helpers::getFilenameAsUniqueCrop($savepath, $result_img['main_img'], $targ_w, $targ_h);
                        }
                        if ($targ_w > 200 and $targ_h > 200) {
                            $jpeg_quality = 80;
                        } else {
                            $jpeg_quality = 9;
                        }
                       $pinfo = pathinfo($result_img['cropped_img'], PATHINFO_EXTENSION);
                        echo 'ssss '.$pinfo;
                        $src = 'collage/' . $result_img['main_img'];
                        $dsrc = 'collage/' . $new_crop_file_name;
                        if ($_ext == '.png' || $_ext == '.PNG') {
                            $jpeg_quality = 9;
                            $img_r = imagecreatefrompng($src);
                            $dst_r = ImageCreateTrueColor($targ_wmain, $targ_hmain);
                            imagecopyresampled($dst_r, $img_r, 0, 0, $targ_x, $targ_y, $targ_wmain, $targ_hmain, $targ_w, $targ_h);
                            if(imagepng($dst_r, $dsrc, $jpeg_quality)){
                            echo $new_crop_file_name."done";
                            }else{
                            echo "fail";
                            }
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
                        
                        $command_update = Yii::app()->db->createCommand("UPDATE `tbl_images` SET `cropped_img` = '$new_crop_file_name' WHERE project_key='$_ukey' and img_key = '$_imgkey'");
                        $command_update->execute();
                        
                    }
                }
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("project_id=$_project_id");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = VIEW_PER_PAGE;
                $pages->applyLimit($criteria);
                $_project_model_imges = Images::model()->findAll($criteria);
                echo CJSON::encode(array(
                        'new_crop_file_name' => $new_crop_file_name,
                        'imgkey' => $_imgkey,
                ));
                
                /*echo $_data = $this->renderPartial(Yii::app()->params['AppViews']['si_partial_img_view'], array(
                'models' => $_project_model_imges,
                'pages' => $pages,
                'total' => $count
                    ), true);*/
                
                }
        }
        exit();
    }
    
    public function actionScaleimg() {

        if (!empty($_POST['ukey'])) {
            $_ukey = $_POST['ukey'];
            $_imgkey = $_POST['imgkey'];
            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where owner_id = '$_owner_id' and mode = 0 and ukey='$_ukey'");
            $result = $command->queryRow();

            if (isset($result['ukey'])) {
                $_project_id = $result['id'];
                if (!empty($_imgkey)) {
                    $command = Yii::app()->db->createCommand("SELECT * From tbl_images where project_key='$_ukey' and img_key = '$_imgkey'");
                    $result_img = $command->queryRow();
                    if (isset($result_img['img_key'])) {


                        $targ_wmain = $targ_hmain = 370;
                        $targ_hmain = 170;
                        $targ_w = $targ_wmain = $_POST['scalew'];

                        $targ_h = $targ_hmain = $_POST['scaleh'];

                        $targ_x = 0;

                        $targ_y = 0;

                        
                        $savepath = Yii::getPathOfAlias('webroot') . '/collage/' . $result_img['main_img'];

                        if (1) {
                            $_ext = Helpers::getFilenameAsUniqueExt($savepath, $result_img['main_img'], $targ_w, $targ_h);
                            $new_crop_file_name = Helpers::getFilenameAsUniqueCrop($savepath, $result_img['main_img'], $targ_w, $targ_h);
                        }
                        list($mywidth, $myheight) = getimagesize($savepath);
                        if ($targ_w > 200 and $targ_h > 200) {
                            $jpeg_quality = 80;
                        } else {
                            $jpeg_quality = 80;
                        }

                        $src = 'collage/' . $result_img['main_img'];
                        $dsrc = 'collage/' . $new_crop_file_name;
                        if ($_ext == '.png' || $_ext == '.PNG') {
                            $jpeg_quality = 9;
                            $img_r = imagecreatefrompng($src);
                            $dst_r = ImageCreateTrueColor($targ_wmain, $targ_hmain);

                            //imagecopyresized($dst_r, $img_r, 0, 0, $targ_x, $targ_y, $targ_wmain, $targ_hmain, $targ_w, $targ_h);
                            imagecopyresized($dst_r, $img_r, 0, 0, 0, 0, $targ_w, $targ_h, $mywidth, $myheight);
                            imagepng($dst_r, $dsrc, $jpeg_quality);
                        } else if ($_ext == '.gif' || $_ext == '.GIF') {
                            $jpeg_quality = 9;
                            $img_r = imagecreatefromgif($src);
                            $dst_r = ImageCreateTrueColor($targ_wmain, $targ_hmain);

                            //imagecopyresized($dst_r, $img_r, 0, 0, $targ_x, $targ_y, $targ_wmain, $targ_hmain, $targ_w, $targ_h);
                            imagecopyresized($dst_r, $img_r, 0, 0, 0, 0, $targ_w, $targ_h, $mywidth, $myheight);
                            imagegif($dst_r, $dsrc, $jpeg_quality);
                        } else {
                            $img_r = imagecreatefromjpeg($src);
                            $dst_r = ImageCreateTrueColor($targ_wmain, $targ_hmain);

                            //imagecopyresized($dst_r, $img_r, 0, 0, $targ_x, $targ_y, $targ_wmain, $targ_hmain, $targ_w, $targ_h);
                            imagecopyresized($dst_r, $img_r, 0, 0, 0, 0, $targ_w, $targ_h, $mywidth, $myheight);
                            imagejpeg($dst_r, $dsrc, $jpeg_quality);
                        }
                       
                        
                        $command_update = Yii::app()->db->createCommand("UPDATE `tbl_images` SET `cropped_img` = '$new_crop_file_name' WHERE project_key='$_ukey' and img_key = '$_imgkey'");
                        $command_update->execute();
                        
                    }
                }

                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("project_id=$_project_id");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = VIEW_PER_PAGE;
                $pages->applyLimit($criteria);
                $_project_model_imges = Images::model()->findAll($criteria);
                
                
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("(project_id=$_project_id and bg_img=1 and img_serial=5) OR (project_key='XXX' and bg_img=1)");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = VIEW_PER_PAGE;
                $pages->applyLimit($criteria);
                $_project_bg_model_imges = Images::model()->findAll($criteria);
                
                
                echo $_data = $this->renderPartial(Yii::app()->params['AppViews']['si_partial_img_view'], array(
                'models' => $_project_model_imges,
                'modelsbg' => $_project_bg_model_imges,
                'project_img_id' => $result['bg_id'],
                'pages' => $pages,
                'total' => $count
                    ), true);
                }
        }
        exit();
    }
     public function actionCropbgimg() {

        if (!empty($_POST['ukey'])) {
            $_ukey = $_POST['ukey'];
            $_imgkey = $_POST['imgkey'];
            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where owner_id = '$_owner_id' and mode = 0 and ukey='$_ukey'");
            $result = $command->queryRow();

            if (isset($result['ukey'])) {
                $_project_id = $result['id'];
                if (!empty($_imgkey)) {
                    $command = Yii::app()->db->createCommand("SELECT * From tbl_images where project_key='$_ukey' and img_key = '$_imgkey'");
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
                       
                        
                        $command_update = Yii::app()->db->createCommand("UPDATE `tbl_images` SET `cropped_img` = '$new_crop_file_name' WHERE project_key='$_ukey' and img_key = '$_imgkey'");
                        $command_update->execute();
                        
                    }
                }

                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("project_id=$_project_id");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = VIEW_PER_PAGE;
                $pages->applyLimit($criteria);
                $_project_model_imges = Images::model()->findAll($criteria);
                
                
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("(project_id=$_project_id and bg_img=1 and img_serial=5) OR (project_key='XXX' and bg_img=1)");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = VIEW_PER_PAGE;
                $pages->applyLimit($criteria);
                $_project_bg_model_imges = Images::model()->findAll($criteria);
                
                
                echo $_data = $this->renderPartial(Yii::app()->params['AppViews']['si_partial_bg_img_view'], array(
                'models' => $_project_model_imges,
                'modelsbg' => $_project_bg_model_imges,
                'project_img_id' => $result['bg_id'],
                'pages' => $pages,
                'total' => $count
                    ), true);
                }
        }
        exit();
    }
    public function actionCropimg() {

        if (!empty($_POST['ukey'])) {
            $_ukey = $_POST['ukey'];
            $_imgkey = $_POST['imgkey'];
            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where owner_id = '$_owner_id' and mode = 0 and ukey='$_ukey'");
            $result = $command->queryRow();

            if (isset($result['ukey'])) {
                $_project_id = $result['id'];
                if (!empty($_imgkey)) {
                    $command = Yii::app()->db->createCommand("SELECT * From tbl_images where project_key='$_ukey' and img_key = '$_imgkey'");
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
                       
                        
                        $command_update = Yii::app()->db->createCommand("UPDATE `tbl_images` SET `cropped_img` = '$new_crop_file_name' WHERE project_key='$_ukey' and img_key = '$_imgkey'");
                        $command_update->execute();
                        
                    }
                }

                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("project_id=$_project_id");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = VIEW_PER_PAGE;
                $pages->applyLimit($criteria);
                $_project_model_imges = Images::model()->findAll($criteria);
                
                
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("(project_id=$_project_id and bg_img=1 and img_serial=5) OR (project_key='XXX' and bg_img=1)");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = VIEW_PER_PAGE;
                $pages->applyLimit($criteria);
                $_project_bg_model_imges = Images::model()->findAll($criteria);
                
                
                echo $_data = $this->renderPartial(Yii::app()->params['AppViews']['si_partial_img_view'], array(
                'models' => $_project_model_imges,
                'modelsbg' => $_project_bg_model_imges,
                'project_img_id' => $result['bg_id'],
                'pages' => $pages,
                'total' => $count
                    ), true);
                }
        }
        exit();
    }
   public function actionDeletebgimage() {
        if (!empty($_POST['ukey'])) {
            $_ukey = $_POST['ukey'];
            $_imgkey = $_POST['imgkey'];
            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where owner_id = '$_owner_id' and mode = 0 and ukey='$_ukey'");
            $result = $command->queryRow();
            $_upload_message = '';
            if (isset($result['ukey'])) {
                $_project_id = $result['id'];
                if (!empty($_imgkey)) {
                    $command = Yii::app()->db->createCommand("SELECT * From tbl_images where project_key='$_ukey' and img_key = '$_imgkey'");
                    $result_img = $command->queryRow();
                    if (isset($result_img['img_key'])) {
                        $_url_main_img = Yii::getPathOfAlias('webroot') . '/collage/' . $result_img['main_img'];
                        $_cropped_img = Yii::getPathOfAlias('webroot') . '/collage/' . $result_img['cropped_img'];
                        if (file_exists($_url_main_img)) {
                            unlink($_url_main_img);
                        }
                        if (file_exists($_cropped_img)) {
                            unlink($_cropped_img);
                        }
                        $command = Yii::app()->db->createCommand("DELETE FROM `tbl_images` WHERE `img_key` = '$_imgkey'");
                        $command->execute();
                    }
                }

                
                $commandyes = Yii::app()->db->createCommand("SELECT * From tbl_images where project_key = '$_ukey' and bg_img = 1");
                $back_img = $commandyes->queryRow();
                
                if(isset($back_img['project_key'])){
                     
                    $_upload_message = 'To upload a new backgorund image you must have to delete your previous background image.';
                    
                }
                
                
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("project_id=$_project_id");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = VIEW_PER_PAGE;
                $pages->applyLimit($criteria);
                $_project_model_imges = Images::model()->findAll($criteria);
                $_data = $this->renderPartial(Yii::app()->params['AppViews']['si_partial_bg_img_view'], array(
                'models' => $_project_model_imges,
                'pages' => $pages,
                'total' => $count
                    ), true);
                
                echo CJSON::encode(array(
                        'message' => $_upload_message,
                        'dataset' => $_data,
                ));
                
                
                }
        }
        exit();
    }
    public function actionDeleteimage() {
        if (!empty($_POST['ukey'])) {
            $_ukey = $_POST['ukey'];
            $_imgkey = $_POST['imgkey'];
            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where owner_id = '$_owner_id' and mode = 0 and ukey='$_ukey'");
            $result = $command->queryRow();
            $_upload_message = '';
            if (isset($result['ukey'])) {
                $_project_id = $result['id'];
                if (!empty($_imgkey)) {
                    $command = Yii::app()->db->createCommand("SELECT * From tbl_images where project_key='$_ukey' and img_key = '$_imgkey'");
                    $result_img = $command->queryRow();
                    if (isset($result_img['img_key'])) {
                        $_url_main_img = Yii::getPathOfAlias('webroot') . '/collage/' . $result_img['main_img'];
                        $_cropped_img = Yii::getPathOfAlias('webroot') . '/collage/' . $result_img['cropped_img'];
                        if (file_exists($_url_main_img)) {
                            unlink($_url_main_img);
                        }
                        if (file_exists($_cropped_img)) {
                            unlink($_cropped_img);
                        }
                        $command = Yii::app()->db->createCommand("DELETE FROM `tbl_images` WHERE `img_key` = '$_imgkey'");
                        $command->execute();
                    }
                }

                
                $commandyes = Yii::app()->db->createCommand("SELECT * From tbl_images where project_key = '$_ukey' and bg_img = 1");
                $back_img = $commandyes->queryRow();
                
                if(isset($back_img['project_key'])){
                     
                    $_upload_message = 'To upload a new backgorund image you must have to delete your previous background image.';
                    
                }
                
                
                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("project_id=$_project_id");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = VIEW_PER_PAGE;
                $pages->applyLimit($criteria);
                $_project_model_imges = Images::model()->findAll($criteria);
                $_data = $this->renderPartial(Yii::app()->params['AppViews']['si_partial_img_view'], array(
                'models' => $_project_model_imges,
                'pages' => $pages,
                'total' => $count
                    ), true);
                
                echo CJSON::encode(array(
                        'message' => $_upload_message,
                        'dataset' => $_data,
                ));
                
                
                }
        }
        exit();
    }

    public function actionCollage() {
        $_user_id = Yii::app()->user->getId();
        if($_user_id<=0){$this->redirect(array('site/signin'));}
        if (!empty($_GET['ukey'])) {
            $_ukey = $_GET['ukey'];
            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where owner_id = '$_owner_id' and mode = 0 and ukey='$_ukey'");
            $result = $command->queryRow();
            
            if (isset($result['ukey'])) {
                $_id = $result['id'];
                $model = $this->loadModel($_id);


                $criteria = new CDbCriteria();
                $criteria->order = 'id DESC';
                $criteria->addCondition("project_key='$_ukey'");
                $criteria->addCondition("bg_img=0");
                $count = Images::model()->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = 10000;
                $pages->applyLimit($criteria);
                $_project_img_models = Images::model()->findAll($criteria);

                $_image_id = $model->bg_id;
                $command = Yii::app()->db->createCommand("SELECT * From tbl_images where id=$_image_id and bg_img = 1");
                $result_bg = $command->queryRow();
                 //print_r($result_bg);exit();
                $this->render(Yii::app()->params['AppViews']['si_project_collage'], array(
                    'model' => $model,
                    'imgmodel' => $_project_img_models,
                    'result_bg' => $result_bg,
                ));
                exit();
            }
        }
        $this->redirect(array(Yii::app()->params['AppUrls']['si_dashboard']));
        exit();
    }

    public function actionDownloadcollage() {
        $_user_id = Yii::app()->user->getId();
        if($_user_id<=0){$this->redirect(array('site/signin'));}
        if (!empty($_GET['ukey'])) {
            $_ukey = $_GET['ukey'];
            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where owner_id = '$_owner_id' and mode = 1 and ukey='$_ukey'");
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

    public function actionSuccess() {
        $_user_id = Yii::app()->user->getId();
        if($_user_id<=0){$this->redirect(array('site/signin'));}
        if (!empty($_GET['ukey'])) {
            $_ukey = $_GET['ukey'];
            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where owner_id = '$_owner_id' and mode = 1 and ukey='$_ukey'");
            $result = $command->queryRow();
            if (isset($result['ukey'])) {
                $_id = $result['id'];
                $model = $this->loadModel($_id);
                $this->render(Yii::app()->params['AppViews']['si_project_success'], array(
                    'model' => $model
                ));
                exit();
            }
        }
        $this->redirect(array(Yii::app()->params['AppUrls']['si_dashboard']));
        exit();
    }

    public function actionSaveimg() {
        if (!empty($_POST['ukey'])) {
            $_ukey = $_POST['ukey'];
            $_owner_id = Yii::app()->user->getId();
            $command = Yii::app()->db->createCommand("SELECT * From tbl_projects where owner_id = '$_owner_id' and mode = 0 and ukey='$_ukey'");
            $result = $command->queryRow();
            if (isset($result['ukey'])) {

                $data = $_POST['data'];
                $file = md5(uniqid()) . '.png';
                $uri = substr($data, strpos($data, ",") + 1);
                file_put_contents('./finalimages/' . $file, base64_decode($uri));
                $_id = $result['id'];
                $model = $this->loadModel($_id);
                $model->final_image_name = $file;
                $model->mode = 1;
                $model->save();
                echo $file;
            }
        }
        exit;
    }

    public function loadModel($id) {
        $model = Project::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionSignin() {
        if (isset(Yii::app()->user->useremail)) { 
             $this->redirect(array(Yii::app()->params['AppUrls']['si_dashboard']));
        }
        $this->layout = 'resadmin';
        $model = new LoginForm('login');
        if (isset($_POST['txtEmail'])) {
            $model->tu_email = Helpers::getCleanValue($_POST['txtEmail']);
            $model->tu_password = Helpers::getCleanValue($_POST['txtPassword']);
            if ($model->validate() && $model->login()) {
                Helpers::$log_user_id = Yii::app()->user->getId();
                Helpers::$log_relation_key = Helpers::getUserKeyById(Helpers::$log_user_id);
                Helpers::$log_relation_table = 'tbl_users';
                Helpers::$log_type = LOG_LOGIN;
                //Helpers::createLog();
                $this->redirect(array(Yii::app()->params['AppUrls']['si_dashboard']));
            }
        }
        $this->render('sisignin', array(
            'model' => $model,
        ));
    }

    public function actionContactus() {
        $this->layout = 'sitewheader';
        $this->render(Yii::app()->params['AppViews']['si_contactus']);
    }

    public function actionAboutus() {
        $this->layout = 'sitewheader';
        $this->render(Yii::app()->params['AppViews']['si_aboutus']);
    }

    public function actionResponsibly() {
        $this->layout = 'sitewheader';
        $this->render(Yii::app()->params['AppViews']['si_responsibly']);
    }

    public function actionTos() {
        $this->layout = 'sitewheader';
        $this->render(Yii::app()->params['AppViews']['si_tos']);
    }

    public function actionPrivacy() {
        $this->layout = 'sitewheader';
        $this->render(Yii::app()->params['AppViews']['si_privacy']);
    }

    public function actionMessage() {

        $this->render(Yii::app()->params['AppViews']['site_message']);
    }

    public function actionEmailcheck() {
        $model = new User;
        if (isset($_POST['tu_email'])) {
            $thisEmail = Helpers::getCleanValue(trim($_POST['tu_email']));
            $checkEmail = $model->find('tu_email=:tu_email', array(':tu_email' => $thisEmail));
            if (empty($checkEmail)) {
                echo "true";
            } else {
                echo "false";
            }
        } else {
            Yii::app()->user->setFlash('error', "You are trying to access invalid URL!");
            $this->redirect(array("user/error"));
        }
    }

    public function actionForgotpass() {
        $message = '';
        if (1) {
            if (isset($_POST['forgotpassbtn'])) {
                $email = Helpers::getCleanValue($_POST['tu_email']);
                $command = Yii::app()->db->createCommand("SELECT * From tbl_users where tu_email = '$email' and tu_status=1");
                $result = $command->queryRow();
                if (isset($result['tu_email'])) {
                    $code = uniqid('', true);
                    $findAct = Yii::app()->db->createCommand("UPDATE tbl_users SET `tu_fokey` = '$code' where tu_email = '$email'");
                    $findAct->execute();
                    $this->sendForgotpassEmail($email, $code);
                    $message = 'Please check your email to set your new password.';
                } else {
                    $message = 'Something is wrong. Please try again!';
                }
            } else {
                
            }
        }
        $model = new User;
        /*$this->layout = 'sitewheader';
        $this->render(Yii::app()->params['AppViews']['si_forgotpass'], array(
            'model' => $model,
            'message' => $message
        ));*/
        $this->layout = 'resadmin';
        $this->render('siforgotpass', array(
            'model' => $model,
            'message' => $message
        ));
    }

    public function actionSignup() {
        $model = new User('signup');
        //$this->layout = 'sitewheader';
        $this->layout = 'resadmin';
        $message = '';
        $success = false;
        if (isset($_POST['Submit'])) {
            if (isset($_POST['tu_email']) && isset($_POST['recaptcha_response_field']) && isset($_POST['tu_username']) && isset($_POST['tu_mobile']) && isset($_POST['tu_password'])) {
                $model->tu_email = Helpers::getCleanValue($_POST['tu_email']);
                $model->tu_username = Helpers::getCleanValue($_POST['tu_username']);
                $modeltu_password = md5(Helpers::getCleanValue($_POST['tu_password']));
                $model->tu_password = $modeltu_password;
                $model->tu_ackey = uniqid('', true);
                $model->tu_mobile = Helpers::getCleanValue($_POST['tu_mobile']);
                $model->tu_ip = $_SERVER['REMOTE_ADDR'];
                $model->tu_user_key = Helpers::getUnqiueKey();
                $model->tu_role = 1;
                $model->tu_created_at = date(DB_INSERT_TIME_FORMAT, time());



                $model->tu_dob = Helpers::getCleanValue($_POST['birthdate']);
                $model->tu_fname = Helpers::getCleanValue($_POST['tu_fname']);
                $model->tu_lname = Helpers::getCleanValue($_POST['tu_lname']);
                $model->tu_cur = Helpers::getCleanValue($_POST['tu_cur']);
                $model->tu_street = Helpers::getCleanValue($_POST['tu_street']);
                $model->tu_city = Helpers::getCleanValue($_POST['tu_city']);
                $model->tu_zip = Helpers::getCleanValue($_POST['tu_zip']);
                $model->tu_sex = Helpers::getCleanValue($_POST['tu_sex']);
                $model->tu_long_country = Helpers::getCleanValue($_POST['tu_long_country']);
                $client = @$_SERVER['HTTP_CLIENT_IP'];
                $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
                $remote = $_SERVER['REMOTE_ADDR'];
                $result = "Unknown";
                if (filter_var($client, FILTER_VALIDATE_IP)) {
                    $ip = $client;
                } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
                    $ip = $forward;
                } else {
                    $ip = $remote;
                }

                //$ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));
                //if($ip_data && $ip_data->geoplugin_countryName != null)
                //{
                //$result = $ip_data->geoplugin_countryName;
                //$model->tu_long_country = $result;
                //}

                $expire = time() - 3600;
                setcookie("tu_username", '', $expire);
                setcookie("email", '', $expire);
                setcookie("mobile", '', $expire);
                setcookie("password", '', $expire);

                $expire = time() + 60 * 60 * 24 * 30;
                setcookie("tu_username", $model->tu_username, $expire);
                setcookie("email", $model->tu_email, $expire);
                setcookie("mobile", $model->tu_mobile, $expire);
                setcookie("password", $modeltu_password, $expire);



                $to = '';
                if ($model->save()) {
                    $this->sendRegisterEmail($model->tu_email, $to, $model->tu_ackey);
                    $message = 'Success! Please check your email to activate.';
                    $expire = time() - 3600;
                    setcookie("tu_username", '', $expire);
                    setcookie("email", '', $expire);
                    setcookie("mobile", '', $expire);
                    setcookie("password", '', $expire);
                    $success = true;
                } else {
                    
                }
            } else {
                if ($model->save()) {
                    
                } else {
                    
                }
            }
        }
        $command = Yii::app()->db->createCommand("SELECT * FROM `tbl_country` order by name asc");
        $allcountries = $command->queryAll();

        $this->render('sisignup', array(
            'model' => $model,
            'message' => $message,
            'success' => $success,
            'allcountries' => $allcountries
        ));
        /*$this->render(Yii::app()->params['AppViews']['si_signup'], array(
            'model' => $model,
            'message' => $message,
            'success' => $success,
            'allcountries' => $allcountries
        ));*/
    }

    public function actionActivepassword() {
        //$this->layout = 'sitewheader';
        $this->layout = 'resadmin';
        $model = new User;
        $message = '';
        if (isset($_POST['activepassbtn'])) {
            if (isset($_POST['activepassbtn'])) {
                $email = Helpers::getCleanValue($_POST['emailsignup']);
                $password = md5(Helpers::getCleanValue($_POST['passwordsignup']));
                $passkey = Helpers::getCleanValue($_POST['password_key']);
                $command = Yii::app()->db->createCommand("SELECT * From tbl_users where tu_email = '$email' and tu_fokey ='$passkey'");
                $result = $command->queryRow();
                if (isset($result['tu_email'])) {
                    $findAct = Yii::app()->db->createCommand("UPDATE tbl_users SET `tu_password` = '$password',tu_fokey ='' where tu_email = '$email'");
                    $findAct->execute();
                    $message = 'Your new password has been activated!';
                } else {
                    $message = 'Email address is not found!';
                }
            } else {
                $message = 'Something is wrong. Please try again.';
            }
        } else {
            if (isset($_GET['passkey']) && !empty($_GET['passkey'])) {
                $passkey = Helpers::getCleanValue($_GET['passkey']);
                $command = Yii::app()->db->createCommand("SELECT * From tbl_users where tu_fokey   = '$passkey'");
                $result = $command->queryRow();
                if (isset($result['tu_fokey'])) {
                    
                } else {
                    $this->redirect(array('site/error'));
                }
            } else {
                $this->redirect(array('site/error'));
            }
        }
        $this->render('siactive_password', array(
            'model' => $model,
            'passkey' => $passkey,
            'message' => $message,
        ));
        /*$this->render(Yii::app()->params['AppViews']['active_password'], array(
            'model' => $model,
            'passkey' => $passkey,
            'message' => $message,
        ));*/
    }

    public function actionChangepassword() {
        $this->layout = 'sitewheader';
        $model = new User;
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            if (isset($_POST['changepassbtn'])) {
                $user_id = Yii::app()->user->getId();
                if (isset($_POST['passwordsignup']) && isset($_POST['passwordsignup_confirm'])) {
                    $password = md5(Helpers::getCleanValue($_POST['passwordsignup']));
                    $findAct = Yii::app()->db->createCommand("UPDATE tbl_users SET `tu_password` = '$password' where tu_id = $user_id");
                    $findAct->execute();
                    Yii::app()->user->setState('password', true);
                    echo CJSON::encode(array(
                        'status' => 'success'
                    ));
                } else {
                    
                }
            } else {
                
            }
        } else {
            $this->render(Yii::app()->params['AppViews']['change_password'], array(
                'model' => $model,
            ));
        }
    }

    public function actionVerifyuser() {
        //$this->layout = 'sitewheader';
        $this->layout = 'resadmin';
        $message = '';
        if (isset($_GET['token']) && isset($_GET['email'])) {
            $activkey = Helpers::getCleanValue($_GET['token']);
            $email = Helpers::getCleanValue($_GET['email']);
            if ($activkey && !empty($activkey) && !empty($email)) {
                $command = Yii::app()->db->createCommand("SELECT * From tbl_users where tu_email = '$email' and tu_ackey = '$activkey'");
                //echo "SELECT * From users where email = '$email' and activate_code = '$activkey'";exit();
                $result = $command->queryRow();
                if (isset($result['tu_email'])) {
                    if ($result['tu_status'] == 1) {
                        $message = "This account is already activated!";
                    } else {
                        $findAct = Yii::app()->db->createCommand("UPDATE tbl_users SET `tu_status` = '1' where tu_email = '$email' and tu_ackey = '$activkey'");
                        $findAct->execute();
                        $message = "Your account is successfully activated!";
                    }
                    
                    $this->layout = 'resadmin';
        
                    $this->render('siverify_view', array(
                        'message' => $message,
                    ));
                    
                    /*$this->render(Yii::app()->params['AppViews']['verify_view'], array(
                        'message' => $message,
                    ));*/
                } else {
                    $this->redirect(array('site/error'));
                }
            } else {
                $this->redirect(array('site/error'));
            }
        } else {
            $this->redirect(array('site/error'));
        }
    }

    public function actionDofunction() {
        $this_user_id = Yii::app()->user->getId();
        if ($this_user_id > 0) {
            $model = UserOnline::model()->findByAttributes(array('tou_user_id' => $this_user_id));
            if (isset($model->tou_user_id)) {
                $model->tou_last_track = date(DB_INSERT_TIME_FORMAT, time());
                $model->save();
            } else {
                $model = new UserOnline;
                $model->tou_user_id = $this_user_id;
                $model->tou_last_track = date(DB_INSERT_TIME_FORMAT, time());
                $model->tou_key = Helpers::getUnqiueKey();
                $model->save();
            }
        }
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(array(Yii::app()->params['AppUrls']['si_index']));
    }

    public function actionError() {
        $message = 'Something is wrong. Please try again!';
        //$this->layout = 'sitewheader';
        $this->layout = 'resadmin';
        $this->render('sisi_error', array(
            'message' => $message
        ));
         
        /*$this->render(Yii::app()->params['AppViews']['si_error'], array(
            'message' => $message
        ));*/
    }

    public function sendForgotpassEmail($email = '', $code = '') {
        if (!empty($email) && !empty($code)) {
            $appMailEvents = new AppMailEvents;
            $appMailEvents->forgotPassEmail($email, '', $code);
        }
    }

    public function sendRegisterEmail($to = "", $toName = "", $token = "") {
        $appMailEvents = new AppMailEvents;
        $appMailEvents->registeremail($to, $toName, $token);
    }

}
