<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
//-------------------------------- INIT
$ajax = new Ajax();
//FORM VALIDATION
$ajax->addValidation("post","PeriodeStart",["required"]);
$ajax->addValidation("post","PeriodeEnd",["required"]);
$ajax->addValidation("post","SparepartPOSId",["required"]);
$ajax->addValidation("post","TransactionCode",["required"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","PeriodeStart",["date"]);
$ajax->addSanitation("post","PeriodeEnd",["date"]);
$ajax->addSanitation("post","SparepartPOSId",["int"]);
$ajax->addSanitation("post","TransactionCode",["string"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    //-------------------------------- STORED PROCEDURE
    $SP = new \app\core\StoredProcedure("uranus", "SP_Sys_Report_ReportGetReport_20_Detail");
    $SP->initParameter($ajax->getPost());
    //$data = $SP->SPGenerateQuery();
    $datas = $SP->f5();
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
