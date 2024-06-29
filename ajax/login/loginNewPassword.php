<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,2)."/configs/ajax.php";
$ajax = new Ajax();

//FORM VALIDATION
$ajax->addValidation("post","UserId",["hidden"]);
$ajax->addValidation("post","Password",["required",["min",8]]);
$ajax->addValidation("post","RetypePassword",["required",["match","Password"]]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","Password",["string"]);
$ajax->addSanitation("post","RetypePassword",["string"]);
$ajax->sanitize('post');

//UPDATE PASSWORD PREPARE
$SP = new StoredProcedure("uranus");

$MD5 = md5($ajax->post["Password"]);
$Hash = password_hash($ajax->post["Password"], PASSWORD_DEFAULT);
$BCrypt = password_hash($ajax->post["Password"], PASSWORD_BCRYPT);

$q = "EXEC [SP_Sys_Login_UpdateFUser_PasswordByUserId]
    @UserId = '{$ajax->post["UserId"]}'
    ,@MD5 = '{$MD5}'
    ,@Hash = '{$Hash}'
    ,@BCrypt = '{$BCrypt}';";
$SP->SPPrepare($q);

//UPDATE PASSWORD EXECUTE
$SP->execute();

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
