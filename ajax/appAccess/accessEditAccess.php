<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$pageId = 3;
$ajax = new Ajax("rud", $pageId);
//FORM VALIDATION
$ajax->addValidation("post","UserId",["hidden"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","UserId",["int"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    //-------------------------------- STORED PROCEDURE
    $compiledData = [];
    if(isset($ajax->post["Auth"]))
    {
        $Auths = $ajax->post["Auth"];
        foreach($Auths AS $CRUD => $Auth)
        {
            foreach($Auth AS $PageId => $Value)
            {
                $compiledData[$PageId][$CRUD] = 1;
            }
        }
    }

    $SP = new StoredProcedure(APP_NAME);
    $SP->tranStart();
    $SP->tranTry("SP_2_accessEditAccess_ResetAuth", ["UserId" => $ajax->post["UserId"]]);
    foreach($compiledData AS $PageId => $Auth)
    {
        $params = [
            "UserId" => $ajax->post["UserId"],
            "PageId" => $PageId,
        ];
        if(isset($Auth["C"]))$params["Create"] = 1;
        if(isset($Auth["U"]))$params["Update"] = 1;
        if(isset($Auth["D"]))$params["Delete"] = 1;

        $SP->tranTry("SP_2_accessEditAccess_AddAccess", $params);
    }
    $SP->tranEnd();
    $data = $SP->tranF5();
}

/*
$SP = new StoredProcedure(APP_NAME, "SP_2_accessEditAccess_ResetAuth");
$SP->addParameters(["UserId" => $ajax->post["UserId"]]);
//$datas[] = $SP->SPGenerateQuery();
$SP->f5();
//$datas[] = $compiledData;
foreach($compiledData AS $ModuleId => $Auth)
{
    $SP = new StoredProcedure(APP_NAME, "SP_2_accessEditAccess_AddAccess");
    $SP->addParameters(["UserId" => $ajax->post["UserId"]]);
    $SP->addParameters(["PageId" => $ModuleId]);
    if(isset($Auth["C"]))$SP->addParameters(["Create" => 1]);
    //if(isset($Auth["R"]))$SP->addParameters(["Read" => 1]);
    if(isset($Auth["U"]))$SP->addParameters(["Update" => 1]);
    if(isset($Auth["D"]))$SP->addParameters(["Delete" => 1]);
    //$datas[] = $SP->SPGenerateQuery();
    $SP->f5();
}
*/

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
