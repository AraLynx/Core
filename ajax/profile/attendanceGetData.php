<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();
//FORM VALIDATION
$ajax->addValidation("post","EmployeeId",["hidden"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","EmployeeId",["int"]);
$ajax->sanitize('post');

//-------------------------------- STORED PROCEDURE
$model = new \app\modelAlls\UranusEmployee_Detail();
$model->addParameter("Id",$ajax->post["EmployeeId"]);
$employee = $model->f5()[0];
//$data = $employee;
//$datas["employee"] = $employee;

$datas["isParent"] = 0;
$positionHierarchies = $employee->getPositionHierarchy(["searchParent" => false, "childOrderLimit" => 1]);
if(count($positionHierarchies["allChildPositionIds"]))
    $datas["isParent"] = 1;

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
