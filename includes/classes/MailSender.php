<?php

class MailSender{
    private static $subj = "Registration in login system site ";
    private static $msg = "Congratulation to subscribe out site\nwe would like to thank you";

    public static function send($to , $username){
        $message = 'Dear,' . $username . '\n' . self::$msg ;
        mail($to,self::$subj,$message);
    }
}