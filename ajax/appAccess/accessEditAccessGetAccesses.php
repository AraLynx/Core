<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$pageId = 3;
$ajax = new Ajax("r",$pageId);

//FORM SANITATION
$ajax->addSanitation("post","UserId",["hidden"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    //-------------------------- SP
    $SP = new StoredProcedure("payroll", "SP_2_accessEditAccessGetAccesses");
    $SP->initParameter($ajax->post);
    $SP->removeParameters(["loginUserId"]);
    $datas = $SP->f5();
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
