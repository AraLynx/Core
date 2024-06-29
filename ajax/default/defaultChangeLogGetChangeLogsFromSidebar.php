<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,2)."/configs/ajax.php";
$ajax = new Ajax();

//FORM VALIDATION
//$ajax->validate('post');

//FORM SANITATION
//$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    $ChangeLog = new \app\TDEs\ChangeLogHelper($ajax->post["loginUserId"]);
    $datas["ModuleId"] = $ChangeLog->getModuleId();
    $datas["PageId"] = $ChangeLog->getPageId();
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
