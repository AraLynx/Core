<?php
namespace app\core;
require_once dirname(__DIR__,3)."/Chronos/configs/attendaceLegends.php";
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();
//FORM VALIDATION
$ajax->addValidation("post","PeriodeStart",["required"]);
$ajax->addValidation("post","PeriodeEnd",["required"]);
$ajax->addValidation("post","OriginalEmployeeIds",["required"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","PeriodeStart",["string"]);
$ajax->addSanitation("post","PeriodeEnd",["string"]);
$ajax->addSanitation("post","PositionIds",["int"]);
$ajax->addSanitation("post","EmployeeIds",["int"]);
$ajax->addValidation("post","OriginalEmployeeIds",["required"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    //-------------------------------- SEARCH EMPLOYEE ID
    $model = new \app\modelAlls\UranusEmployee_Detail();
    $model->addParameter("Ids", implode(";",array_keys($ajax->post["OriginalEmployeeIds"])));
    $model->setReturnColumns(["Id","Name", "Username","PositionId","PositionName","GenderId","AvatarFileName"]);
    $model->setReturnIdAsKey(true);
    $childEmployees = $model->f5();
    //$datas = $childEmployees;

    #region generate employee ids
    $employeeIds = [];
    if(isset($ajax->post["EmployeeIds"]))
    {
        //$data = "SELECT SPECIFIC EMPLOYEE";
        $employeeIds = $ajax->post["EmployeeIds"];
    }
    else
    {
        if(isset($ajax->post["PositionIds"]))
        {
            //$data = "SELECT EMPLOYEE BY SPECIFIC POSITION";
            foreach($ajax->post["OriginalEmployeeIds"] AS $EmployeeId => $PositionId)
                if(in_array($PositionId, $ajax->post["PositionIds"]))
                    $employeeIds[] = $EmployeeId;

            if(!count($employeeIds))$employeeIds = [0];
        }
        else
        {
            //$data = "SELECT ALL EMPLOYEE";
            $employeeIds = array_keys($ajax->post["OriginalEmployeeIds"]);
        }
    }

    //-------------------------- Stored Procedure
    $SP = new StoredProcedure("gaia", "SP_Sys_profile_teamAttendanceGetAttendances");
    $SP->addParameters(["PeriodeStart" => $ajax->post["PeriodeStart"]]);
    $SP->addParameters(["PeriodeEnd" => $ajax->post["PeriodeEnd"]]);
    $SP->addParameters(["EmployeeIds" => implode(";",$employeeIds)]);
    //$data = $SP->SPGenerateQuery();
    $attendances = $SP->f5();
    //$datas = $attendances;

    $employees = [];
    foreach($attendances AS $index => $att)
    {
        if($att["EmployeeId"] && isset($childEmployees[$att["EmployeeId"]]))
        {
            $employeeId = $att["EmployeeId"];
            $employeeName = $childEmployees[$employeeId]->Name;

            if(!isset($employees[$employeeName]))
            {
                $employees[$employeeName] = $childEmployees[$employeeId];
                $employees[$employeeName]->Ijins = [];
                $employees[$employeeName]->IHKInCount = 0;
                $employees[$employeeName]->IHKOutCount = 0;
                $employees[$employeeName]->Items = [];
            }

            $status = $att["Status"];
            $ihkin = $att["IHKIn"];
            $ihkout = $att["IHKOut"];

            if($ihkin)
            {
                $att["IHKIn"] = '<i class="fa-solid fa-check"></i>';
                $employees[$employeeName]->IHKInCount++;
            }
            else $att["IHKIn"] = '<i class="fa-solid fa-xmark retro_red "></i>';
            if($ihkout)
            {
                $att["IHKOut"] = '<i class="fa-solid fa-check"></i>';
                $employees[$employeeName]->IHKOutCount++;
            }
            else $att["IHKOut"] = '<i class="fa-solid fa-xmark retro_red "></i>';

            if($status == "REG")
            {
                if(!$ihkin)
                {
                    $att["RowClass"] = "retro_red fw-bold";
                    if(!isset($employees[$employeeName]->Ijins["TelatMinute"]))
                        $employees[$employeeName]->Ijins["TelatMinute"] = 0;
                    $employees[$employeeName]->Ijins["TelatMinute"] += $att["MenitTelat"];

                    if(!isset($employees[$employeeName]->Ijins["Telat"]))
                        $employees[$employeeName]->Ijins["Telat"] = 0;
                    $employees[$employeeName]->Ijins["Telat"]++;
                }

                if(!$ihkout)
                {
                }
            }
            else if($status == "OFF")
            {
                $att["IHKIn"] = '';
                $att["IHKOut"] = '';
                $att["RowClass"] = "retro_green";
            }
            else
            {
                if(!isset($employees[$employeeName]->Ijins [$status]))
                    $employees[$employeeName]->Ijins [$status] = 0;
                $employees[$employeeName]->Ijins [$status]++;
            }
            //$datas["atts"][] = $att;

            if($att["MenitTelat"])$att["Description"] = $att["MenitTelat"]." MINUTE";
            $employees[$employeeName]->Items[] = $att;
        }
    }
    //$datas = $employees;
    ksort($employees);
    foreach($employees AS $employeeName => $employee)
    {
        $employeeProfile = "<div class='d-flex align-items-center'>
                <div>{$employee->avatarHtml}</div>
                <div class='ms-4'>
                    <div><span class='fw-bold'>{$employee->Name}</span> ({$employee->Id})</div>";
                    if($employee->Username)$employeeProfile .= "<div class='text-muted fst-italic'>aka {$employee->Username}</div>";
                    $employeeProfile .= "<div>{$employee->PositionName}</div>
                </div>
            </div>
        ";

        $Descriptions = [];
        if(array_key_exists("Telat",$employee->Ijins))
            $Descriptions[] = "TELAT: ".$employee->Ijins["Telat"]."x (".$employee->Ijins["TelatMinute"]." MINUTE)";

        foreach($attendaceLegends AS $attendaceCode => $attendaceName)
        {
            if(array_key_exists($attendaceCode,$employee->Ijins))
                $Descriptions[] = $attendaceName.": ".$employee->Ijins[$attendaceCode]."x";
        }

        $summaryProfile = "<div class='d-flex'>
                <div>
                    IHK In {$employee->IHKInCount}
                    <br/>IHK Out {$employee->IHKOutCount}
                </div>
                <div class='ms-5'>".implode("<br/>",$Descriptions)."</div>
            </div>
        ";

        $employee->Items[] = [
            "IHKIn" => $employee->IHKInCount
            ,"IHKOut" => $employee->IHKOutCount
        ];

        $datas[] = [
            "EmployeeProfile" => $employeeProfile,
            "SummaryProfile" => $summaryProfile,

            "Items" => $employee->Items
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
