<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,2)."/configs/ajax.php";
$ajax = new Ajax();
//FORM VALIDATION
$ajax->addValidation("post","EmployeeId",["required"]);
$ajax->addValidation("post","EmailAddress",["required", "email"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","EmployeeId",["int"]);
$ajax->addSanitation("post","EmailAddress",["string"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    $model = new \app\modelAlls\UranusUser();
    $model->addParameters(["EmployeeId" => $ajax->post["EmployeeId"]]);
    //$data = $model->getQuery();
    $records = $model->f5();
    if(!count($records))
    {
        $ajax->setError("The Employee ID (NIK) is not yet registered<br/>Please contact IT to activate.");
    }
    else
    {
        $User = $records[0];
        if(strtolower($User->EmailAddress) != strtolower($ajax->post["EmailAddress"]))
            $ajax->setError("The EMAIL ADDRESS is not match with Employee ID (NIK)<br/>Please check your spelling<br/>If you forgot your registered email, please contact IT for manual reset.");

        else
        {
            $token = password_hash(date("Y-m-d H:i:s")." : reset password token for ".$User->Name, PASSWORD_DEFAULT);
            $SP = new StoredProcedure("uranus", "SP_Auth_GenerateResetPasswordToken");
            $SP->addParameters(["Id" => $User->Id, "Token" => $token]);
            $SP->f5();

            $PHPMailer = new \app\TDEs\PHPMailerHelper();
            $mail = $PHPMailer->getMail();
            try {
                ob_start();
                require_once("../PHPMailer/defaultTemplate.php");
                $mailTemplate = ob_get_clean();

                ob_start();
                require_once("loginForgotPassword_mailContent.php");
                $mailContent = ob_get_clean();

                $mailBody = str_replace("{{content}}",$mailContent, $mailTemplate);

                $mail->addAddress($User->EmailAddress, $User->Name);
                $mail->Subject = "TDE System : Reset Password Login";
                $mail->Body = $mailBody;
                $mail->send();
            }
            catch (Exception $e) {
                $ajax->setError("Message could not be sent. Mailer Error: {$mail->ErrorInfo}") ;
            }
        }
    }
}
if(!is_null(error_get_last()))
{
    $ajax->setStatusCode(500);
}
else
{
    if($ajax->getStatusCode() == 100)
    {
        $ajax->setData($data);
        $ajax->setDatas($datas);
        $ajax->setError($message);
    }
}
$ajax->end();
