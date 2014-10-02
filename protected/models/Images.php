<?php

class Images extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{tbl_images}}';
    }

    /**
     * get Proejct background images
     */
    public function getProjectBgModelImages($_project_id) {
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->addCondition("(project_id=$_project_id and bg_img=1 and img_serial=5) OR (project_key='XXX' and bg_img=1)");
        $count = Images::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = VIEW_PER_PAGE;
        $pages->applyLimit($criteria);
        $_project_bg_model_imges = Images::model()->findAll($criteria);
        return array($_project_bg_model_imges, $pages,$count);
    }

    /**
     * get Proejct getProjectModelImages
     */
    public function getProjectModelImages($_project_id) {
        $criteria = new CDbCriteria();
        $criteria->order = 'id DESC';
        $criteria->addCondition("project_id=$_project_id and bg_img=0");
        $count = Images::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = VIEW_PER_PAGE;
        $pages->applyLimit($criteria);
        $_project_model_imges = Images::model()->findAll($criteria);
        return array($_project_model_imges, $pages,$count);
    }

}
