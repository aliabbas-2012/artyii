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
        $width = $_POST['width'];
        $height = $_POST['height'];
        $dimension_type = 'portrait';
        if ($width >= $height) {
            $dimension_type = 'landscape';
        }
        $attributes = array("height" => $height, "width" => $width,'dimension_type'=>$dimension_type);
        $image = Images::model()->findByPk($id);

        $image_path = Yii::getPathOfAlias('webroot.collage') . "/" . $image->cropped_img;
        $pathToThumbs = Yii::getPathOfAlias('webroot.collage.');

        DTUploadedFile::createThumbs($image_path, $pathToThumbs, $width, $image->cropped_img, $height);

        Images::model()->updateByPk($id, $attributes);
    }

}
