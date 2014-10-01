<?php

class Game extends CActiveRecord {
    
    public $c_name;
    public $p_name;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{tbl_games}}';
    }
}