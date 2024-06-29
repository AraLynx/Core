<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();

//-------------------------------- STORED PROCEDURE
$model = new \app\modelDims\UranusAttendanceRequestType();
$model->addParameter("IsEnable",1);
$model->setReturnColumns(["Id","Name"]);
$model->f5();

$datas["AttendanceRequestTypes"] = $model->getSelectValuesAndTexts();


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
