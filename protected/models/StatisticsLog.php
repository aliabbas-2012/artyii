<?php

class StatisticsLog extends CActiveRecord {
    public $sell_item_name;
    public $product_name;
    public $partner_name;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{tbl_statistics_log}}';
    }
}