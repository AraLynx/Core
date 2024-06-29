<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax("cr");
//FORM VALIDATION
$ajax->addValidation("post","Id",["required"]);
$ajax->addValidation("post","Username",["required"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","Id",["int"]);
$ajax->addSanitation("post","Username",["string"]);
$ajax->addSanitation("post","IsEnableGaia",["bool"]);
$ajax->addSanitation("post","IsEnableSelene",["bool"]);
$ajax->addSanitation("post","IsEnablePlutus",["bool"]);
//$ajax->addSanitation("post","IsEnableHephaestus",["bool"]);
$ajax->addSanitation("post","IsEnableAPIHSO",["bool"]);
//$ajax->addSanitation("post","IsEnableAPIBCA",["bool"]);
$ajax->addSanitation("post","IsEnableEunomia",["bool"]);
$ajax->sanitize('post');

$PasswordText = DEFAULT_PASSWORD;
$MD5 = md5($PasswordText);
$Hash = password_hash($PasswordText, PASSWORD_DEFAULT);
$BCrypt = password_hash($PasswordText, PASSWORD_BCRYPT);

//-------------------------------- STORED PROCEDURE
$SP = new StoredProcedure(APP_NAME, "SP_3_7_tdeUserCreateUser");
$SP->initParameter($ajax->post);
$SP->removeParameters(["loginUserId"]);
$SP->removeParameters(["Name"]);
$SP->addParameters(["MD5" => $MD5, "Hash" => $Hash, "BCrypt" => $BCrypt]);
//$data = $SP->SPGenerateQuery();
$data = $SP->f5()[0];

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
