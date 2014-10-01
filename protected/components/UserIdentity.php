<?php

class UserIdentity extends CUserIdentity {

    private $_id;

    /**
     * User Authentication method for signin
     * @return type 
     */
    public function authenticate() {
       
        $user = User::model()->find('tu_email=:tu_email', array(':tu_email' => $this->username));
        if ($user === null||$user->tu_status==0) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else if (!$user->validatePassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            //echo "bb";exit();
            $this->_id = $user->tu_id;
            if($user->tu_password==$this->password){
                 $this->setState('password',false);
            }else{
                 $this->setState('password', true);
            }
            $this->setState('useremail', $user->tu_email);
            if($user->tu_role==3){
                $this->setState('admin', 3);
            }else{
                $this->setState('admin', 0);
            }
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    /**
     *
     * @return type 
     */
    public function getId() {
        return $this->_id;
    }

}