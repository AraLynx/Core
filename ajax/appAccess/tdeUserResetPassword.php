<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax("ru");
//FORM VALIDATION
$ajax->addValidation("post","Id",["hidden"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","Id",["int"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    $MD5 = md5(DEFAULT_PASSWORD);
    $Hash = password_hash(DEFAULT_PASSWORD, PASSWORD_DEFAULT);
    $BCrypt = password_hash(DEFAULT_PASSWORD, PASSWORD_BCRYPT);

    $SP = new \app\core\StoredProcedure("uranus");
    $q = "EXEC [SP_Sys_Login_UpdateFUser_PasswordByUserId]
        @UserId = '{$ajax->post["Id"]}'
        ,@MD5 = '{$MD5}'
        ,@Hash = '{$Hash}'
        ,@BCrypt = '{$BCrypt}';";
    $SP->SPPrepare($q);
    $SP->execute();
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
