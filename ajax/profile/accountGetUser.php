<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();
//$datas = $ajax->post;

$SP = new StoredProcedure("uranus", "SP_Sys_profile_accountGetUser");
$SP->initParameter($ajax->post);
$SP->renameParameter("loginUserId","UserId");
$SP->removeParameters(["loginBranchId"]);
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
