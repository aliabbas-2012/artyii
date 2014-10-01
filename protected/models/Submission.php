<?php

class User extends CActiveRecord {

    public $repeat_password;
    public $validacion;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{tbl_users}}';
    }

    public function rules() {
        return array(
            array('tu_email', 'required', 'on' => 'signup', 'message' => 'Email can not be blank!'),
            array('tu_password', 'required', 'on' => 'signup', 'message' => 'Password length at least be 6!'),
            array('tu_email', 'email'),
            array(
                'validacion',
                'application.extensions.recaptcha.EReCaptchaValidator',
                'privateKey' => ENVII_CAPTCHA_PRIVATE_KEY,
                'on' => 'signup',
                'message' => 'The Captcha verification code is incorrect.'
            ),
        );
    }

    /**
     *
     * @param type $password
     * @return type 
     */
    public function validatePassword($password) {
        //echo "vvbb";exit();
        if ($password == $this->tu_password) {
            return $password === $this->tu_password;
        }
        return $this->hashPassword($password) === $this->tu_password;
    }

    /**
     *
     * @param type $password
     * @return type 
     */
    public function hashPassword($password) {
        return md5($password);
    }

    /**
     *
     * Function for check email address is available or not
     *
     * */
    public static function getUserEmail($userEmail = "") {

        if (!empty($userEmail)) {
            //exit();
            $command = Yii::app()->db->createCommand("
                SELECT * FROM " . TABLE_PREFIX . "users WHERE email = '" . $userEmail . "'");
        } else {
            return false;
        }
        $row = $command->queryRow();
        $row = (object) $row;

        if (!empty($row->email)) {
            return true;
        }

        return false;
    }

}
