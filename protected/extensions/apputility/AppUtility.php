<?php

Yii::import('application.extensions.phpmailer.JPhpMailer');

class AppUtility {

    public function test() {
        echo "AppUtility";
    }

    public function send_email($from = '', $to = '', $fromName = '', $toName = '', $subject = '', $altMailBody = '', $htmlEmail = '') {
         //mail("YourEmailHere@domain.com", "Test Subject", "Test Message");  return true;
        $mail = new JPhpMailer;
        if (SMTP_MAIL_SEND) {
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = SMTP_AUTH;
            $mail->Username = SMTP_USERNAME;
            $mail->Password = SMTP_PASSWORD;
        } else {
            $mail->IsMail();
        }
        $mail->SetFrom($from, $fromName);
        $mail->Subject = $subject;
        $mail->AltBody = $altMailBody;
        $mail->MsgHTML($htmlEmail);
        $mail->AddAddress($to, $toName);
        if (Yii::app()->request->serverName != 'localhost') {
            $mail->Send();
        }
        return true;
    }

}