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

$positionHierarchies = $employee->getPositionHierarchy(["searchParent" => false]);
$datas["positions"] = [];
$datas["children"] = [];
if(count($positionHierarchies["allChildPositionIds"]))
{
    $childPositionIds = $positionHierarchies["allChildPositionIds"];

    $selectTextTemplates = [];
    if($employee->DivisionId)$selectTextTemplates = ["DepartmentCode", "SubDepatmentCode","SectionName", "PositionName"];
    if($employee->DepartmentId)$selectTextTemplates = ["SubDepatmentCode","SectionName", "PositionName"];
    if($employee->SubDepartmentId)$selectTextTemplates = ["SectionName", "PositionName"];
    if($employee->SectionId)$selectTextTemplates = ["PositionName"];

    $recordParams = [
        "isGenerateSelectValueAndText" => true,
        "selectTextTemplates" => $selectTextTemplates,
    ];
    $model = new \app\modelAlls\UranusOS6Position(["recordParams" => $recordParams]);
    $model->addParameter("PositionIds", implode(";",$childPositionIds));
    $model->setReturnColumns(["Id","DepartmentCode", "SectionName", "PositionName"]);
    $positions = $model->f5();
    foreach($positions AS $index => $position)
    {
        $datas["positions"][] = $position->selectValueAndText;
    }

    $recordParams = ["generateSelectTemplate" => true];
    $model = new \app\modelAlls\UranusEmployee_Detail(["recordParams" => $recordParams]);
    $model->addParameter("EmployeeIsActive", 1);
    $model->addParameter("PositionIds", implode(";",$childPositionIds));
    $model->setReturnColumns(["Id","Name","PositionId","PositionName","GenderId","AvatarFileName"]);
    //$data = $model->getQuery();
    $children = $model->f5();
    foreach($children AS $index => $child)
    {
        //$datas["positions"][] = $child;
        $selectTemplate = $child->selectTemplate;
        $selectTemplate["PositionId"] = $child->PositionId;
        $datas["children"][] = $selectTemplate;
    }
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
