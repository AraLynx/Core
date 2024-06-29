<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$pageId = 3;
$ajax = new Ajax("rd",$pageId);
//FORM VALIDATION
$ajax->addValidation("post","Id",["hidden"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","Id",["int"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    //-------------------------------- STORED PROCEDURE
    $SP = new StoredProcedure("payroll", "SP_2_accessDisableUser");
    $SP->initParameter($ajax->post);
    $SP->removeParameters(["loginUserId"]);
    //$data = $SP->SPGenerateQuery();
    $SP->f5();
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
