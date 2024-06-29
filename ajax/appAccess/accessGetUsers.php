<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$pageId = 3;
$ajax = new Ajax("r",$pageId);
$ajax->isCbpPicker("post");
$ajax->addValidation("post","EmployeeIsActive",["hidden"]);

//FORM SANITATION
$ajax->addSanitation("post","EmployeeIsActive",["int"]);
$ajax->addSanitation("post","EmployeeId",["int"]);
$ajax->addSanitation("post","EmployeeName",["string"]);
$ajax->addSanitation("post","BrandId",["int"]);
$ajax->addSanitation("post","CompanyId",["int"]);
$ajax->addSanitation("post","BranchId",["int"]);
$ajax->addSanitation("post","POSId",["int"]);
$ajax->addSanitation("post","PositionName",["string"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    $model = new \app\modelAlls\UranusUser_Detail();
    $model->initParameter($ajax->post);
    $model->removeParameters(["loginUserId"]);//buang index post loginUserId
    //$data = $model->getQuery();
    $records = $model->f5();

    foreach($records AS $index => $user)
    {
        $avatarParams = array(
            "page" => "access",
            "group" => "employee",
            "id" => "Id".$user->EmployeeId,
            "employee" => [
                "AvatarFileName" => $user->AvatarFileName
                ,"GenderId" => $user->GenderId
            ],
            "size" => 50
        );
        $avatar = new \app\pages\Avatar($avatarParams);
        $avatar->begin();
        $avatar->end();

        $NameProfile = $user->getNameProfile();
        $NameProfile .= "<br/>";
        if($user->TrimandiriEmailAddress)
        {
            $NameProfile .= "<div><i class='fa-solid fa-at fa-fw'></i> ";
                $NameProfile .= "{$user->TrimandiriEmailAddress}";
            $NameProfile .= "</div>";
        }

        if(!$user->IsEnablePayroll)
        {
            $NameProfile .= "<div class='text-danger text-end'>NO ACCESS</div>";
            $NameProfile .= "<div class='text-danger text-decoration-underline fst-italic text-end' role='button' title='grant payroll access for {$user->Name}' onClick='accessEnableUserSetUserId({$user->Id})'>&lt;activate user&gt;</div>";
        }
        else
        {
            $NameProfile .= "<div class='btn btn-primary' role='button' onClick='accessEditAccessSetData({$user->Id});'>MANAGE ACCESS</div>";
            $NameProfile .= "<div class='text-muted text-decoration-underline fst-italic text-end' role='button' title='revoke payroll access for {$user->Name}' onClick='accessDisableUserSetUserId({$user->Id})'>&lt;revoke access&gt;</div>";
        }

        $datas[] = [
            "Avatar" => "<div class='text-center'>{$avatar->getHtml()}</div>"
            ,"NameProfile" => $NameProfile
            ,"PositionProfile" => $user->getPositionProfile(["glue" => "<br/>"])
            ,"POSProfile" => $user->getPOSProfile(["glue" => "<br/>"])
            ,"RowClass"=> $user->Id ? ($user->IsEnable ? "" : "light_grey") : "light_grey"
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
