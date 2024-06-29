<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();

//FORM VALIDATION
$ajax->addValidation("post","DBName",["required"]);
$ajax->addValidation("post","ApprovalId",["required"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","DBName",["string"]);
$ajax->addSanitation("post","ApprovalId",["int"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    require_once __DIR__."/approvalGetApproval/generateApprovalTableForApprover.php";

    $SP = new StoredProcedure("uranus", "SP_Sys_Approval_approvalGetApproval");
    $SP->initParameter($ajax->getPost());
    $SP->removeParameters(["loginUserId"]);
    $approval = $SP->f5()[0];

    $ApprovalTypeId = $approval["ApprovalTypeId"];
    $AppId = $approval["ApplicationId"];
    $RTId = $approval["ReferenceTypeId"];
    $RId1 = $approval["ReferenceId1"];
    $RId2 = $approval["ReferenceId2"];
    $RId3 = $approval["ReferenceId3"];

    $SPName = "";
    if($AppId == 1)
    {
        if($RTId == 96 && in_array($ApprovalTypeId,[54,55]))$SPName = "ReleasePO";//PO ASEST IT
        else if($RTId == 156 && in_array($ApprovalTypeId,[118,119]))$SPName = "ReleasePO";//PO ASEST AFTER SALES
    }
    else if($AppId == 2)
    {
        if($RTId == 29 && in_array($ApprovalTypeId,[129]))$SPName = "ReleaseMAP";//Selene - Marketing Activity Plan
    }
    else if($AppId == 3)
    {
        if($RTId == 6 && in_array($ApprovalTypeId,[182,183,184]))$SPName = "ReleasePKB"; //ISZ, DHT, HDA
        else if($RTId == 30 && in_array($ApprovalTypeId,[185]))$SPName = "ReleasePS_AdditionalPlafond";//RELEASE ADDITIONAL PLAFOND PS
        else if($RTId == 44 && in_array($ApprovalTypeId,[
            16,19,32,33,34,42,52,78,79 //DHT
            ,164,165,166,167,168,169,170,171,172 //ISZ
            ,173,174,175,176,177,178,179,180,181 //HDA
        ]))$SPName = "ReleaseSPK";
        else if($RTId == 76 && in_array($ApprovalTypeId,[137]))$SPName = "ReturPOSparepart";
        else if($RTId == 37 && in_array($ApprovalTypeId,[155,156,157]))$SPName = "SparepartMutationSend";
        else if($RTId == 17 && in_array($ApprovalTypeId,[160,162]))$SPName = "RefundAsuransi";
        else if($RTId == 24 && in_array($ApprovalTypeId,[161,163]))$SPName = "RefundAsuransi";
    }

    if($SPName)
    {
        $approvalName = "{$AppId}_{$RTId}_{$SPName}";
        $data = $approvalName;
        $subSPName = "approvalGetApproval_{$approvalName}";
        require_once __DIR__."/approvalGetApproval/{$approvalName}.php";
    }
    else{
        $datas["SPResult"] = $approval;
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
