<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();

require_once __DIR__."/reportGetReport_Prepare.php";
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

    $datas = $report;
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
