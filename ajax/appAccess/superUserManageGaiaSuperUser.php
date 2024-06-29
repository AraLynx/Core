<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax("crud");

//FORM VALIDATION
$ajax->addValidation("post","Id",["required"]);
$ajax->addValidation("post","ModuleIds",["required"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","Id",["int"]);
$ajax->addSanitation("post","ModuleIds",["int"]);
$ajax->sanitize('post');

//--------------------------------- STORED PROCEDURE
$SP = new \app\core\StoredProcedure(APP_NAME);
$SP->tranStart();
$SP->tranTry("SP_3_7_superUserManageGaiaSuperUser_resetAccess",["UserId" => $ajax->post["Id"], "ExecuteByUserId" => $ajax->post["loginUserId"]]);
foreach(array_keys($ajax->post["ModuleIds"]) AS $index => $ModuleId)
{
	$SP->tranTry("SP_3_7_superUserManageGaiaSuperUser_addAccess",["UserId" => $ajax->post["Id"],"ModuleId" => $ModuleId, "ExecuteByUserId" => $ajax->post["loginUserId"]]);
}
$SP->tranEnd();
$data = $SP->tranF5();

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
