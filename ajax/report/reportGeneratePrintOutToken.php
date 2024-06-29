<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();

if($app->getStatusCode() == 100)
{
    $ajax->addValidation("post","ReportId",["required"]);
    $ajax->validate('post');
}
if($app->getStatusCode() == 100)
{
    //FORM SANITATION
    $ajax->addSanitation("post","ReportId",["string"]);
    $ajax->sanitize('post');
}
if($app->getStatusCode() == 100)
{
    $Token = new Token($ajax->getPost("loginUserId"));
    $tokenString = $Token->getToken();
    $datas = [
        "reportId" => $ajax->getPost("ReportId"),
        "tokenString" => $tokenString,
    ];
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
