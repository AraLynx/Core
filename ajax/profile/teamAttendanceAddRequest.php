<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();
//FORM VALIDATION
$ajax->addValidation("post","EmployeeId",["required"]);
$ajax->addValidation("post","AttendanceRequestTypeId",["required"]);
$ajax->addValidation("post","DateTypeId",["required"]);
if($ajax->post["DateTypeId"] == 1)$ajax->addValidation("post","DateTypeId1Date",["required"]);
if($ajax->post["DateTypeId"] == 2)
{
    $ajax->addValidation("post","DateTypeId2DateStart",["required"]);
    $ajax->addValidation("post","DateTypeId2DateEnd",["required"]);
}
$ajax->addValidation("post","Description",["required"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","EmployeeId",["int"]);
$ajax->addSanitation("post","AttendanceRequestTypeId",["int"]);
$ajax->addSanitation("post","DateTypeId",["int"]);
if($ajax->post["DateTypeId"] == 1)$ajax->addSanitation("post","DateTypeId1Date",["date"]);
if($ajax->post["DateTypeId"] == 2)
{
    $ajax->addSanitation("post","DateTypeId2DateStart",["date"]);
    $ajax->addSanitation("post","DateTypeId2DateEnd",["date"]);
}
$ajax->addSanitation("post","Description",["string"]);
$ajax->sanitize('post');
//$inputName = $ajax->post["inputName"];
//$ExecutedByUserId = $ajax->post["loginUserId"];
/*
DO OTHER STUFF HERE
*/

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
