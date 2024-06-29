<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,2)."/configs/ajax.php";
$ajax = new Ajax();

//FORM VALIDATION
$ajax->addValidation("post","ModuleId",["hidden"]);
$ajax->addValidation("post","PageId",["hidden"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","ModuleId",["allowEmpty","int"]);
$ajax->addSanitation("post","PageId",["allowEmpty","int"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    $ChangeLog = new \app\TDEs\ChangeLogHelper($ajax->post["loginUserId"]);
    $datas = $ChangeLog->getChangeLogs($ajax->post["ModuleId"],$ajax->post["PageId"]);
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
