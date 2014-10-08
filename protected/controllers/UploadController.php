<?php

/*
 * $this->createUrl('/upload/fileUpload');
 */

class UploadController extends Controller {

    /**
     * action will call qupload
     */
    public function actionFileUpload() {

        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $allowedExtensions = array();
        // max file size in bytes
        $sizeLimit = 2 * 1024 * 1024;

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $path = Yii::app()->basePath . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "collage" . DIRECTORY_SEPARATOR;

        // $size = getimagesize($pathToImage);
        $result = $uploader->handleUpload($path);

        echo CJSON::encode($result);
    }

    /**
     * rotate image 
     */
    public function actionRotateImage() {
        $id = $_POST['id'];
        $angle = $_POST['angle'];

        $image = Images::model()->findByPk($id);
        $image_path = Yii::getPathOfAlias('webroot.collage') . "/" . $image->cropped_img;
        $pathToThumbs = Yii::getPathOfAlias('webroot.collage.');
        $thumb = DTUploadedFile::rotateImage($image_path, $pathToThumbs, $angle);
    }

    /**
     * 
     */
    public function actionUpdateResize() {
        $id = $_POST['id'];
        $attributes = array();
        $image = Images::model()->findByPk($id);
        if (isset($_POST['width']) && isset($_POST['height'])) {
            $width = $_POST['width'];
            $height = $_POST['height'];
            $dimension_type = 'portrait';
            if ($width >= $height) {
                $dimension_type = 'landscape';
            }
            $attributes = array("height" => $height, "width" => $width, 'dimension_type' => $dimension_type);


            $image_path = Yii::getPathOfAlias('webroot.collage') . "/" . $image->cropped_img;
            $pathToThumbs = Yii::getPathOfAlias('webroot.collage.');

            DTUploadedFile::createThumbs($image_path, $pathToThumbs, $width, $image->cropped_img, $height);
        } else if (isset($_POST['left']) && isset($_POST['top'])) {
            $attributes = array("left" => $_POST['left'], "top" => $_POST['top']);
        } else if (isset($_POST['angle'])) {
            $attributes = array("angle" => $_POST['angle']);
        }
        Images::model()->updateByPk($id, $attributes);
    }

    /**
     * update size is like a cron
     * job
     */
    public function actionUpdatesizes() {
        $images = Images::model()->findAll();
        foreach ($images as $model) {
            $filePath = Yii::getPathOfAlias('webroot') . '/collage/' . $model->cropped_img;
            $model = DTUploadedFile::setImageAttribute($model, $filePath);
            $attributes = array("height" => $model->height, "width" => $model->width, 
                'dimension_type' => $model->dimension_type);
             Images::model()->updateByPk($model->id, $attributes);
        }
    }

}
