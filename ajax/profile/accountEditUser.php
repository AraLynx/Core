<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();
//FORM VALIDATION
$ajax->addValidation("post","Username",["required",["min",6]]);
$ajax->addValidation("post","EmailAddress",["required","email"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","Username",["string"]);
$ajax->addSanitation("post","EmailAddress",["string"]);
$ajax->sanitize('post');

//-------------------------- Stored Procedure
$SP = new StoredProcedure("uranus", "SP_Sys_UpdateFUserByUserId");
$SP->initParameter($ajax->post);
$SP->renameParameter("loginUserId","UserId");
$SP->removeParameters("EmployeeName");
$SP->removeParameters("PositionName");
$SP->removeParameters("EmployeeId");
$SP->f5();

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
