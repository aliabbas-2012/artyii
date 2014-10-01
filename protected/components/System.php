<?php

class System extends AppClass {

    //return type boolean
    public static function isLoggedIn() {

        if (isset(Yii::app()->user->useremail) && !empty(Yii::app()->user->useremail)) {
            return true;
        }
        return false;
    }


}
