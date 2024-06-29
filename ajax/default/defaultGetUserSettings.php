<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,2)."/configs/ajax.php";
$ajax = new Ajax();
//$ajax->validate('post');

//FORM SANITATION
//$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    $model = new \app\modelFacts\UranusUserSetting();
    $model->addParameters(["UserId" => $ajax->post["loginUserId"]]);
    $model->f5();
    $datas = $model->getUserSettings();
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
