<?php

class LoginForm extends CFormModel {

    public $tu_email;
    public $tu_password;
    private $_identity;
    public $rememberMe;

    /**
     *
     * @return type  Login rules 
     */
    public function rules() {
        return array(
            array('tu_email', 'required', 'on' => 'login', 'message' => 'Email can not be blank!'),
            array('tu_password', 'required', 'on' => 'login,signup', 'message' => 'Password can not be blank!'),
            array('tu_password', 'authenticate'),
        );
    }

    /**
     *
     * @param type $attribute
     * @param type $params  Authenticate the user when user try to login
     */
    public function authenticate($attribute, $params) {
        $this->_identity = new UserIdentity($this->tu_email, $this->tu_password);
        if (!$this->_identity->authenticate())
            $this->addError('password', 'Invalid combination of email and password.');
    }

    /**
     *
     * @return boolean  Authenticate the user when user try to login
     */
    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->tu_email, $this->tu_password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        }
        else
            return false;
    }

}
