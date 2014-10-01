<?php

class AppMailEvents {

    public function test() {

        echo "AppMailEvents";
    }

    
    public function registeremail($to = "", $toName = "", $token = "") {
        if (empty($to)) {
            return false;
        }
        $route = 'site/verifyuser/?email='.$to.'&token='.$token;
        $verification_link = Yii::app()->createAbsoluteUrl($route);
        $filepath = Yii::getPathOfAlias('webroot') . '/email_templates/register_email.html';
        $from = EMAIL_FROM_EMAIL;
        $to = $to;
        $fromName = EMAIL_FROM_NAME;
        $toName = $toName;
        $subject = 'Art Portal Registration';
        $htmlEmail = file_get_contents($filepath);
        $htmlEmail = str_replace("@@Verification_Link@@", $verification_link, $htmlEmail);
        $altMailBody = strip_tags($htmlEmail);
        $this->sendEmail($from, $to, $fromName, $toName, $subject, $altMailBody, $htmlEmail);
        return true;
    }
    
    public function forgotPassEmail($to = "", $toName = "", $token = "") {
        if (empty($to)) {
            return false;
        }
        $route = 'site/activepassword/?passkey='.$token;
        $verification_link = Yii::app()->createAbsoluteUrl($route);
        $filepath = Yii::getPathOfAlias('webroot') . '/email_templates/forgot_pass_email.html';
        $from = EMAIL_FROM_EMAIL;
        $to = $to;
        $fromName = EMAIL_FROM_NAME;
        $toName = $toName;
        $subject = 'Art Portal password setup';
        $htmlEmail = file_get_contents($filepath);
        $htmlEmail = str_replace("@@Verification_Link@@", $verification_link, $htmlEmail);
        $altMailBody = strip_tags($htmlEmail);
        $this->sendEmail($from, $to, $fromName, $toName, $subject, $altMailBody, $htmlEmail);
        return true;
    }
    
    
    
    public function sendEmail($from = '', $to = '', $fromName = '', $toName = '', $subject = '', $altMailBody = '', $htmlEmail = '') {
        $appUtility = new AppUtility;
        //print_r($htmlEmail);
        //exit();
        $appUtility->send_email($from, $to, $fromName, $toName, $subject, $altMailBody, $htmlEmail);
    }
    
    
    

}