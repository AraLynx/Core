<?php
namespace app\core;
session_start();
//var_dump($_SESSION);

//-------------------------------- INIT
require_once dirname(__DIR__,2)."/configs/ajax.php";
$ajax = new Ajax();

if($app->getStatusCode() == 100)
{
    //LOG OUT PROCESS
    $auth = new Auth($ajax->post["loginUserId"]);
    if($app->getStatusCode() == 100)$auth->setLogout();
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
