<?php
use app\TDEs\PHPMailerHelper;
if($app->getStatusCode() == 100)
{
    $mailHelper = new PHPMailerHelper();
    //$mailHelper = new \app\TDEs\PHPMailerHelper("debug");
    try {
        $mail = $mailHelper->getMail();

        //DOCUMENTATION https://github.com/PHPMailer/PHPMailer

        ob_start();
        require_once("../PHPMailer/defaultTemplate.php");
        $mailTemplate = ob_get_clean();

        ob_start();
        require_once("someHtmlContentPage.php");
        $mailContent = ob_get_clean();

        $mailBody = str_replace("{{content}}",$mailContent, $mailTemplate);

        $mail->addAddress('Email Address', 'Person Name [OPTIONAL]');

        //Content
        $mail->Subject = "Some subject email";
        $mail->Body = $mailBody;

        //$mail->addAttachment("/".TDE_ROOT."/".APP_NAME."/some_folder_name/some_file_name.xls", "new_file_name.xls");

        $mail->send();
    }
    catch (Exception $e) {
        $ajax->setError("Message could not be sent. Mailer Error: {$mail->ErrorInfo}") ;
    }

}
