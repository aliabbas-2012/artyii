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

        $result = $uploader->handleUpload($path);

        echo CJSON::encode($result);
    }

}
