<?php
namespace app\core;
require_once dirname(__DIR__,3)."/Chronos/configs/attendaceLegends.php";
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();
//FORM VALIDATION
$ajax->addValidation("post","PeriodeStart",["required"]);
$ajax->addValidation("post","PeriodeEnd",["required"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","PeriodeStart",["string"]);
$ajax->addSanitation("post","PeriodeEnd",["string"]);
$ajax->sanitize('post');
if($app->getStatusCode() == 100)
{
    //-------------------------- Stored Procedure
    $SP = new StoredProcedure("gaia", "SP_Sys_profile_attendanceGetAttendances");
    $SP->initParameter($ajax->post);
    $SP->renameParameter("loginUserId","UserId");
    $attendances = $SP->f5();

    $Ijins = [];
    $IHKInCount = 0;
    $IHKOutCount = 0;
    $datas["atts"] = [];
    foreach($attendances AS $index => $attendance)
    {
        $status = $attendance["Status"];
        $ihkin = $attendance["IHKIn"];
        $ihkout = $attendance["IHKOut"];

        if($ihkin)
        {
            $attendance["IHKIn"] = '<i class="fa-solid fa-check"></i>';
            $IHKInCount++;
        }
        else $attendance["IHKIn"] = '<i class="fa-solid fa-xmark retro_red "></i>';
        if($ihkout)
        {
            $attendance["IHKOut"] = '<i class="fa-solid fa-check"></i>';
            $IHKOutCount++;
        }
        else $attendance["IHKOut"] = '<i class="fa-solid fa-xmark retro_red "></i>';

        if($status == "REG")
        {
            if(!$ihkin)
            {
                $attendance["RowClass"] = "retro_red fw-bold";
                if(!isset($Ijins["TelatMinute"]))
                    $Ijins["TelatMinute"] = 0;
                $Ijins["TelatMinute"] += $attendance["MenitTelat"];

                if(!isset($Ijins["Telat"]))
                    $Ijins["Telat"] = 0;
                $Ijins["Telat"]++;
            }

            if(!$ihkout)
            {
            }
        }
        else if($status == "OFF")
        {
            $attendance["IHKIn"] = '';
            $attendance["IHKOut"] = '';
            $attendance["RowClass"] = "retro_green";
        }
        else
        {
            if(!isset($Ijins[$status]))
                $Ijins[$status] = 0;
            $Ijins[$status]++;
        }
        $datas["atts"][] = $attendance;
    }

    $Descriptions = [];
    if(array_key_exists("Telat",$Ijins))
        $Descriptions[] = "TELAT: ".$Ijins["Telat"]."x (".$Ijins["TelatMinute"]." MINUTE)";

    foreach($attendaceLegends AS $attendaceCode => $attendaceName)
    {
        if(array_key_exists($attendaceCode,$Ijins))
            $Descriptions[] = $attendaceName.": ".$Ijins[$attendaceCode]."x";
    }

    $datas["atts"][] = array(
        "IHKIn" => $IHKInCount,
        "IHKOut" => $IHKOutCount,
        "Description" => implode("<br/>",$Descriptions)
    );
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
