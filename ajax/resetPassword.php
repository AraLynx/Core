<?php
use app\core\Application;
use app\core\Ajax;
use app\core\CSRF;

//require_once __DIR__.'/../init.php';
//require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../configs/ajax.php';

$key = bin2hex(random_bytes(32));

$formGroup = "chronos";
$formId = "ResetPassword";
$elementId = "{$formGroup}Form{$formId}";

$CSRF = new CSRF(array("key" => $key, "salt" => $elementId));
$token = $CSRF->getToken();

$_POST["isAuth"] = 0;
$_POST["key"] = $key;
$_POST["token"] = $token;
$_POST["formId"] = $elementId;
$_POST["formGroup"] = $formGroup;

//-------------------------------- INIT
$ajax = new Ajax();
//FORM VALIDATION
$ajax->addValidation("get","a",["required"]);
$ajax->addValidation("get","t",["required"]);
$ajax->validate('get');

//FORM SANITATION
$ajax->addSanitation("get","a",["string"]);
$ajax->addSanitation("get","t",["string"]);
$ajax->sanitize('get');

if($app->getStatusCode() == 100)
{
    $model = new \app\modelAlls\UranusUser();
    $model->addParameters(["ResetTokenPassword" => $ajax->get["t"]]);
    $records = $model->f5();

    if(count($records) == 1)
    {
        $User = $records[0];
        $newPassword = substr(md5(date("Y-m-d H:i:s")." : reset password token for ".$User->Name), 0, 8);

        $MD5 = md5($newPassword);
        $Hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $BCrypt = password_hash($newPassword, PASSWORD_BCRYPT);

        $SP = new app\core\StoredProcedure("uranus", "SP_Sys_Login_UpdateFUser_PasswordByUserId");
        $SP->addParameters([
            "UserId" => $User->Id,
            "MD5" => $MD5,
            "Hash" => $Hash,
            "BCrypt" => $BCrypt,
        ]);
        $SP->f5();

        $PHPMailer = new \app\TDEs\PHPMailerHelper();
        $mail = $PHPMailer->getMail();
        try {
            ob_start();
            require_once("PHPMailer/defaultTemplate.php");
            $mailTemplate = ob_get_clean();

            ob_start();
            require_once("resetPassword_mailContent.php");
            $mailContent = ob_get_clean();

            $mailBody = str_replace("{{content}}",$mailContent, $mailTemplate);

            $mail->addAddress($User->EmailAddress, $User->Name);
            $mail->Subject = "TDE System : New Temporary Password";
            $mail->Body = $mailBody;
            $mail->send();

            include_once("resetPassword_HtmlOk.php");
        }
        catch (Exception $e) {
            $ajax->setError("Message could not be sent. Mailer Error: {$mail->ErrorInfo}") ;
        }
    }
    else
        include_once("resetPassword_HtmlNotOk.php");
}
