<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax("r");
$ajax->isCbpPicker("post");

//FORM SANITATION
$ajax->addSanitation("post","Id",["int"]);
$ajax->addSanitation("post","EmployeeId",["int"]);
$ajax->addSanitation("post","EmployeeName",["string"]);
$ajax->addSanitation("post","Username",["string"]);

$ajax->addSanitation("post","BrandId",["int"]);
$ajax->addSanitation("post","CompanyId",["int"]);
$ajax->addSanitation("post","BranchId",["int"]);
$ajax->addSanitation("post","POSId",["int"]);
$ajax->addSanitation("post","PositionName",["string"]);
$ajax->sanitize('post');

//-------------------------- MODEL
$recordParams = [
    "isGenerateAvatar" => true
    ,"isGenerateNameProfile" => true
    ,"generateNameProfileParams" => ["glue" => "<br/>"]
    ,"isGeneratePositionProfile" => true
    ,"generatePositionProfileParams" => ["glue" => "<br/>"]
    ,"isGeneratePOSProfile" => true
    ,"generatePOSProfileParams" => ["glue" => "<br/>"]
];
$model = new \app\modelAlls\UranusUser(["recordParams" => $recordParams]);
$model->initParameter($ajax->post);
$model->removeParameters(["loginUserId"]);//buang index post loginUserId
//$data = $model->getQuery();
$records = $model->f5();

foreach($records AS $index => $user)
{
    //$datas[] = $user;
    $NameProfile = $user->nameProfile;
    $NameProfile .= "<br/>";
    $NameProfile .= "<span class='btn btn-success' role='button' title='Manage Gaia Super Access' onClick='superUserManageSuperUserSetUserId(&quot;gaia&quot;,{$user->Id})'><i class='fa-solid fa-fw fa-star'></i> GAIA</span>";
    $NameProfile .= "<span class='btn btn-secondary' role='button' title='Manage Selene Super Access' onClick='superUserManageSuperUserSetUserId(&quot;selene&quot;,{$user->Id})'><i class='fa-solid fa-fw fa-star'></i> SELENE</span>";
    $NameProfile .= "<span class='btn btn-warning' role='button' title='Manage Plutus Super Access' onClick='superUserManageSuperUserSetUserId(&quot;plutus&quot;,{$user->Id})'><i class='fa-solid fa-fw fa-star'></i> PLUTUS</span>";
    /*
    if(!$user->UserId)$NameProfile .= "<div class='btn btn-warning' role='button' onClick='tdeUserAddUserSetEmployeeId({$user->Id})'>CREATE USER LOGIN</div>";
    else if(!$user->IsEnableUser)
    {
        $NameProfile .= "<div class='text-danger text-end'>LOGIN ACCESS : DISABLED</div>";
        $NameProfile .= "<div class='text-danger text-decoration-underline fst-italic text-end' role='button' title='activate user login for {$user->Name}' onClick='tdeUserEnableUserSetUserId({$user->UserId})'>&lt;activate user&gt;</div>";
    }
    else
    {
        if($user->IsEnableGaia)$NameProfile .= "<div class='btn btn-success' role='button' onClick='tdeUserGetAuthSetUserId({$user->UserId});'>GAIA ACCESS</div>";
        $NameProfile .= "<div class='btn btn-primary' role='button' onClick='tdeUserEditAccessSetData(
            {$user->Id}
            ,&quot;{$user->Name}&quot;
            ,{$user->UserId}
            ,&quot;{$user->Username}&quot;
            ,{$user->IsEnableGaia}
            ,{$user->IsEnableSelene}
            ,{$user->IsEnablePlutus}
            ,{$user->IsEnableHephaestus}
            ,{$user->IsEnableAPIHSO}
            ,{$user->IsEnableAPIBCA}
            ,{$user->IsEnableEunomia}
        );'>LOGIN & ACCESS</div>";
        $NameProfile .= "<div class='text-muted text-decoration-underline fst-italic text-end' role='button' title='deactivate user login for {$user->Name}' onClick='tdeUserDisableUserSetUserId({$user->UserId})'>&lt;deactivate user&gt;</div>";
    }
    */
    $datas[] = [
        "Avatar" => "<div class='text-center'>{$user->avatarHtml}</div>"
        ,"NameProfile" => $NameProfile
        ,"PositionProfile" => $user->positionProfile
        ,"POSProfile" => $user->POSProfile
        //,"RowClass"=> $user->UserId ? ($user->IsEnableUser ? "" : "light_grey") : "light_grey"
    ];
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
