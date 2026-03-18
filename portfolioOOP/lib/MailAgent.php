<?php

namespace lib;

use PHPMailer\PHPMailer\PHPMailer;

class MailAgent {
    private PHPMailer $_mail;

    function __construct(string $defMail = "", string $defCaption = "")
    {
        $this->_mail = new PHPMailer(true);
        $this->_mail->CharSet = 'UTF-8';
        $this->_mail->isSMTP();
        $this->_mail->Host = config('mail.host');
        $this->_mail->SMTPAuth = true;
        $this->_mail->Username = config('mail.user');
        $this->_mail->Password = config('mail.password');
        $this->_mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->_mail->Port = config('mail.port');
        $this->_mail->setFrom(
            $defMail ?: config('mail.defaultMail'),
            $defCaption ?: config('mail.defaultCaption')
        );
        $this->_mail->isHTML(true);
    }

    function setMessage(string $caption, string $text){
        $this->_mail->Subject = $caption;
        $this->_mail->Body = $text;
        $this->_mail->AltBody = strip_tags($text);
    }

    function addAddress(string $mail, string $caption = '', bool $clearAddresses = false){
        if($clearAddresses)
            $this->_mail->clearAddresses();
        $this->_mail->addAddress($mail, $caption);
    }

    function addFile(string $pathFile, bool $clearFiles = false){
        if($clearFiles)
            $this->_mail->clearAttachments();
        $this->_mail->addAttachment($pathFile);
    }

    function addReplyTo(string $mail, string $caption = ''){
        $this->_mail->addReplyTo($mail, $caption);
    }

    function send(): bool {
        try {
            $this->_mail->send();
            return true;
        } catch(\Exception $e){
            return false;
        }
    }
}