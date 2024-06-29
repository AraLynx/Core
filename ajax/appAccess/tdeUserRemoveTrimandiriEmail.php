<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax("rd");
//FORM VALIDATION
$ajax->addValidation("post","Id",["required"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","Id",["int"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    $SP = new \app\core\StoredProcedure(APP_NAME,"SP_3_7_tdeUserSetTrimandiriEmail");
    $SP->addParameters([
        "Id" => $ajax->post["Id"],
        "TrimandiriEmailAddress" => "",
        "TrimandiriEmailPassword" => ""
    ]);
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
