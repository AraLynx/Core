<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();
//FORM VALIDATION
//$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","NotificationSound",["string"]);
$ajax->addSanitation("post","NotificationVibrate",["allowEmpty", "int"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    $SP = new StoredProcedure("uranus","SP_Sys_profile_accountEditSetting");
    $SP->tranStart();
    $SP->tranTry("SP_Sys_profile_accountEditSetting", ["UserId" => $ajax->post["loginUserId"], "SettingName" => "NotificationSound", "SettingValue" => $ajax->post["NotificationSound"]]);
    $SP->tranTry("SP_Sys_profile_accountEditSetting", ["UserId" => $ajax->post["loginUserId"], "SettingName" => "NotificationVibrate", "SettingValue" => $ajax->post["NotificationVibrate"]]);
    $SP->tranEnd();
    $data = $SP->tranF5();
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
