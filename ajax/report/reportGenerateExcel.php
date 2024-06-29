<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();

require_once __DIR__."/reportGetReport_Prepare.php";
//-------------------------- Stored Procedure
if($app->getStatusCode() == 100)
{
    //-------------------------- Stored Procedure
    $report = [];

    $SP = new \app\core\StoredProcedure("uranus");

    $SP->initParameter($ajax->getPost());

    $SP->removeParameters(["DepartmentId","ReportGroup"
        ,"CompanyName","BranchName","POSName"
    ]);

    require_once __DIR__."/process/{$ReportId}.php";
}

//-------------------------- GENERATE EXCEL
if($app->getStatusCode() == 100)
{
    $fileDir = "/generateExcel_{$ReportId}";
    $datas["ExcelFileName"] = "Report";
    $datas["FileLink"] = "";

    $model = new \app\modelDims\UranusReport();
    if($ReportId == "20Raw")$paramReportId = 20;
    else $paramReportId = $ReportId;
    $model->addParameters(["Id" => $paramReportId]);
    $records = $model->F5();
    $modelReport = $records[0];

    $DepartmentName = $modelReport->DepartmentName;
    $GroupName = $modelReport->Group;
    $ReportName = $modelReport->Name;
    $reportDescription = "{$DepartmentName} - Laporan {$GroupName}, {$ReportName}";

    $datas["ExcelFileName"] = $reportDescription;

    $params = [
        "fileDir" => $fileDir
        ,"generateRowNumber" => true
        ,"data" => $report
    ];
    $spreadSheet = new \app\TDEs\PhpSpreadsheetHelper($params);

    $headerInfos = [
        "_callerOrigin" => true,
        "_createdByUserId" => $ajax->getPost("loginUserId"),
        "_createdDateTime" => true,
    ];
    $tryHeaderInfos = [
        "CompanyName" => "Company"
        ,"BranchName" => "Branch"
        ,"POSName" => "POS",
    ];

    require_once __DIR__."/generateExcel/{$ReportId}.php";
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
