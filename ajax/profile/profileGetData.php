<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();

$model = new \app\modelAlls\UranusUser(["recordParams" => ["isGenerateAvatar" => true]]);
$model->initParameter($ajax->post);
$model->renameParameter("loginUserId", "Id");
$model->removeParameters(["loginBranchId"]);
//$data = $model->getQuery();
$user = $model->f5()[0];
$data = $user;

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
