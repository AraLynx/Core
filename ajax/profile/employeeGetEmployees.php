<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();
$ajax->isCbpPicker("post");

//FORM SANITATION
$ajax->addSanitation("post","Id",["int"]);
$ajax->addSanitation("post","Name",["string"]);
$ajax->addSanitation("post","CompanyId",["int"]);
$ajax->addSanitation("post","BranchId",["int"]);
$ajax->addSanitation("post","POSId",["int"]);
$ajax->addSanitation("post","PositionName",["string"]);
$ajax->addSanitation("post","EmployeeIsActive",["int"]);
$ajax->sanitize('post');

//-------------------------- MODEL
$employees = new \app\modelAlls\UranusEmployee_Detail();
$employees->initParameter($ajax->post);
$employees->removeParameters(["loginUserId","loginBranchId"]);//buang index post loginUserId, dan loginBranchId khusus Plutus
$records = $employees->f5();

if($app->getStatusCode() == 100)
{
    foreach($records AS $index => $employee)
    {
        $avatarParams = array(
            "page" => "profile",
            "group" => "employee",
            "id" => "Id".$employee->Id,
            "employee" => [
                "AvatarFileName" => $employee->AvatarFileName
                ,"GenderId" => $employee->GenderId
            ],
            "size" => 60
        );
        $avatar = new \app\components\Avatar($avatarParams);
        $avatar->begin();
        $avatar->end();

        $datas[] = [
            "Avatar" => "<div class='text-center'>{$avatar->getHtml()}</div>"
            ,"NameProfile" => $employee->getNameProfile()
            ,"PositionProfile" => $employee->getPositionProfile(["glue" => "<br/>"])
            ,"POSProfile" => $employee->getPOSProfile(["glue" => "<br/>"])
            ,"RowClass"=> $employee->EmployeeIsActive ? "" : "light_grey"
            //,"Raw" => $employee
        ];
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
