<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax("cr");
$ajax->addValidation("post","Id",["hidden"]);

//FORM SANITATION
$ajax->addSanitation("post","Id",["int"]);
$ajax->sanitize('post');

//-------------------------- MODEL
$employees = new \app\modelAlls\UranusEmployee_Detail();
$employees->initParameter($ajax->post);
$employees->removeParameters(["loginUserId"]);//buang index post loginUserId
//$data = $employees->getQuery();
$employee = $employees->f5()[0];
$employee->Username = substr(str_replace(" ","",$employee->Name),0,8).$employee->Id;

$data = $employee;

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
