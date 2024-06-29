<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();

//FORM VALIDATION
$ajax->addValidation("post","Id",["hidden"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","Id",["int"]);
$ajax->sanitize('post');

//-------------------------------- STORED PROCEDURE
$model = new \app\modelDims\UranusAttendanceRequestType();
$model->initParameter($ajax->post);
$model->removeParameters(["loginUserId"]);//buang index post loginUserId
$dims = $model->f5();
$dim = $dims[0];
$data = $dim->DateTypeId;

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
