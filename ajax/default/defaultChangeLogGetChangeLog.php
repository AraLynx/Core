<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,2)."/configs/ajax.php";
$ajax = new Ajax();

//FORM VALIDATION
$ajax->addValidation("post","Id",["hidden"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","Id",["int"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    $SP = new StoredProcedure("uranus");
    $SP->initParameter($ajax->post);
    $SP->renameParameter("loginUserId","UserId");
    $SP->renameParameter("Id","ApplicationUpdateId");

    $q = "EXEC [SP_Sys_ChangeLog_GetChangeLog]";
    $q .= $SP->SPGenerateParameters();
    //$data = $q;
    $SP->SPPrepare($q);

    $SP->execute();
    $data = $SP->getRow()[0];

    $SP->nextRowset();
    foreach($SP->getRow() AS $content)
    {
        $content["Content"] = html_entity_decode($content["Content"]);
        $datas[] = $content;
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
