<?php

class UserLog extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{tbl_ac_log}}';
    }
}