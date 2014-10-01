<?php

class MyUrlManager extends CUrlManager {

    private function getRules() {

        //$_command = Yii::app()->db->createCommand("SELECT * FROM `tbl_site_settings` WHERE 1");
        //$_results = $_command->queryRow();
        //echo "<pre>";
        //print_r($_results);
        //exit();
        $rules = array(
           
            '<controller:\w+>/<id:\d+>' => '<controller>/view',
            '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>'
        );

        return $rules;
    }

    protected function processRules() {
        $this->rules = $this->getRules();
        return parent::processRules();
    }

}
