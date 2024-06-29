<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();
//FORM VALIDATION
$ajax->addValidation("post","UserId",["hidden"]);
$ajax->addValidation("post","OldPassword",["required"]);
$ajax->addValidation("post","Password1",["required", ["min",6]]);
$ajax->addValidation("post","Password2",["required",["match","Password1"]]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","UserId",["int"]);
$ajax->addSanitation("post","OldPassword",["string"]);
$ajax->addSanitation("post","Password1",["string"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    //$datas = $ajax->post;
    $UserId = $ajax->post["UserId"];
    $OldPassword = $ajax->post["OldPassword"];
    $Password1 = $ajax->post["Password1"];

    $SP = new StoredProcedure("uranus", "SP_Sys_GetFUserByUserId");
    $SP->addParameters(["UserId" => $UserId]);
    $rows = $SP->f5();
    if(count($rows) == 1)
    {
        $user = $SP->getRow()[0];
        if(password_verify($OldPassword,$user["PasswordHash"]))
        {
            $MD5 = md5($Password1);
            $Hash = password_hash($Password1, PASSWORD_DEFAULT);
            $BCrypt = password_hash($Password1, PASSWORD_BCRYPT);

            if(!password_verify($OldPassword,$Hash))
            {
                $SP = new StoredProcedure("uranus");

                $q = "EXEC [SP_Sys_Login_UpdateFUser_PasswordByUserId]
                    @UserId = '{$UserId}'
                    ,@MD5 = '{$MD5}'
                    ,@Hash = '{$Hash}'
                    ,@BCrypt = '{$BCrypt}';";
                $SP->SPPrepare($q);

                $SP->execute();
            }
            else $ajax->setError("The new password is identical to the existing password");
        }
        else $ajax->setError("Incorrect password.");
    }
    else $ajax->setError("User duplicate");
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
