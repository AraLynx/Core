<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();
$ajax->isCbpPicker("post");

//FORM VALIDATION
$ajax->addValidation("post","PositionId",["required"]);
$ajax->addValidation("post","DateStart",["required"]);
$ajax->addValidation("post","DateEnd",["required"]);
$ajax->addValidation("post","StatusCode",["required"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","DateStart",["date"]);
$ajax->addSanitation("post","DateEnd",["date"]);
$ajax->addSanitation("post","StatusCode",["string"]);

$ajax->addSanitation("post","ReferenceNumber",["string"]);
$ajax->addSanitation("post","PositionId",["int"]);
$ajax->addSanitation("post","ApplicationId",["int"]);
$ajax->addSanitation("post","PageId",["string"]);
$ajax->addSanitation("post","ApprovalTypeId",["string"]);
$ajax->addSanitation("post","ApprovalTypeItemId",["string"]);
$ajax->sanitize('post');

//dd(APP_NAME);

if($app->getStatusCode() == 100)
{
    if($ajax->getPost("PageId") && $ajax->getPost("PageId") != "*")
    {
        $array = explode("_", $ajax->getPost("PageId"));
        $ajax->setPost("DBName", $array[0]);
        $ajax->setPost("PageId", $array[1] * 1);
    }
    if($ajax->getPost("ApprovalTypeId") && $ajax->getPost("ApprovalTypeId") != "*")
    {
        $array = explode("_", $ajax->getPost("ApprovalTypeId"));
        $ajax->setPost("DBName", $array[0]);
        $ajax->setPost("ApprovalTypeId", $array[1] * 1);
    }
    if($ajax->getPost("ApprovalTypeItemId") && $ajax->getPost("ApprovalTypeItemId") != "*")
    {
        $array = explode("_", $ajax->getPost("ApprovalTypeItemId"));
        $ajax->setPost("DBName", $array[0]);
        $ajax->setPost("ApprovalTypeItemId", $array[1] * 1);
    }

    $SP = new StoredProcedure("uranus");
    $SP->initParameter($ajax->post);
    $SP->renameParameter("loginUserId", "UserId");
    $q = "EXEC [SP_Sys_Approval_approvalGetApprovals]";
    $q .= $SP->SPGenerateParameters();
    //dd($q);
    $SP->SPPrepare($q);
    $SP->addSanitation("DBName",["string"]);

    $SP->addSanitation("ApprovalId",["int"]);
    $SP->addSanitation("ApprovalGroup",["string"]);
    $SP->addSanitation("ApprovalTypeId",["int"]);
    $SP->addSanitation("ApprovalTypeName",["string"]);

    $SP->addSanitation("ApprovalTypeItemId",["int"]);
    $SP->addSanitation("ApprovalTypeItemName",["string"]);
    $SP->addSanitation("ApprovalTypeItemOrder",["string"]);

    $SP->addSanitation("AppCount",["int"]);
    $SP->addSanitation("ApprovedCount",["int"]);
    $SP->addSanitation("DisapprovedCount",["int"]);
    $SP->addSanitation("AppBeforeCount",["int"]);

    $SP->addSanitation("ApplicationId",["int"]);
    $SP->addSanitation("ReferenceTypeId",["int"]);
    $SP->addSanitation("ReferenceId1",["int"]);
    $SP->addSanitation("ReferenceId2",["int"]);
    $SP->addSanitation("ReferenceId3",["int"]);

    $SP->addSanitation("ApprovedByUserId",["int"]);
    $SP->addSanitation("DisapprovedByUserId",["int"]);
    $SP->addSanitation("ApprovalGeneralNotes",["string"]);
    $SP->addSanitation("ApprovalInternalNotes",["string"]);
    $SP->addSanitation("IsAdditional",["int"]);

    $SP->addSanitation("StatusCode",["string"]);
    $SP->addSanitation("StatusName",["string"]);
    $SP->addSanitation("AdditionalData01",["string"]);
    $SP->addSanitation("AdditionalData02",["string"]);
    $SP->addSanitation("AdditionalData03",["string"]);
    $SP->addSanitation("AdditionalData04",["string"]);
    $SP->addSanitation("AdditionalData05",["string"]);

    $SP->addSanitation("IsEnable",["int"]);
    $SP->addSanitation("CreatedByUserId",["int"]);
    $SP->addSanitation("CreatedByEmployeeId",["int"]);
    $SP->addSanitation("CreatedByEmployeeName",["string"]);
    $SP->addSanitation("CreatedDateTime",["datetime"]);

    $SP->setAdditionalField("Status", ["concatenate",["<span class='text-decoration-underline' role='button' title='","StatusName","'>","StatusCode","</span>"]]);

    $SP->setAdditionalField("RowClass", ["if",[
        ["StatusCode", "e", "NU", "light_grey"]
        ,["StatusCode", "e", "AP", "fw-bold"]
        ,["StatusCode", "e", "DAP", "retro_red"]
        ,["StatusCode", "e", "ODAP", "retro_red"]
        ,["StatusCode", "e", "WMAP", "retro_orange"]
        ,["StatusCode", "e", "WOAP", "text-secondary"]
    ]]);

    $SP->setAdditionalField("TEMP_CBP", ["implode", " ", ["CompanyAlias", "BranchAlias", " (", "POSName",")"]]);
    $SP->setAdditionalField("TEMP_ApprovalGeneralNotes", ["concatenate",["REF : ","ApprovalGeneralNotes"]]);
    $SP->setAdditionalField("TEMP_DateAndStatus", ["concatenate",["DATE : ","CreatedDateTime"," (","Status",")"]]);
    //$SP->setAdditionalField("TEMP_ApprovalTypeName", ["implode", " ", ["TYPE : ","ApprovalTypeName"]]);
    $SP->setAdditionalField("TEMP_ApprovalTypeItemName", ["implode", " ", ["STEP : ","ApprovalTypeItemName"]]);

    $SP->setAdditionalField("ApprovalProfile", ["implode", "<br/>", ["ApprovalTypeName", "TEMP_CBP", "TEMP_ApprovalGeneralNotes", "AdditionalData01", "AdditionalData02"]]);

    $SP->setAdditionalField("AdditionalData", ["implode", "<br/>", ["TEMP_DateAndStatus", "TEMP_ApprovalTypeItemName", "AdditionalData03", "AdditionalData04", "AdditionalData05"]]);

    $SP->setAdditionalField("Action",["concatenate",["<p class='btn btn-sm btn-outline-secondary' title='View Request' onClick='approvalGetApprovalPrepareData(&quot;","DBName","&quot;, ","ApprovalId",");'><i class='fa-regular fa-fw fa-eye'></i></p>"]]);

    $SP->execute();
    $datas = $SP->getRow();
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
