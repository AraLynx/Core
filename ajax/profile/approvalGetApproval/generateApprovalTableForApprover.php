<?php
namespace app\core;

$model = new \app\modelFacts\UranusApproval();
$model->addParameters(["DBName" => $ajax->getPost("DBName"), "Id" => $ajax->getPost("ApprovalId")]);
$approvals = $model->F5();
$approval = $approvals[0];
$datas["approval"] = $approval;

$SP = new StoredProcedure("uranus", "SP_All_Approval_Detail");
$SP->addParameters(
    [
        "DBName" => $approval->DBName,
        "ApplicationId" => $approval->ApplicationId,
        "ReferenceTypeId" => $approval->ReferenceTypeId,
        "ReferenceId1" => $approval->ReferenceId1,
        "ReferenceId2" => $approval->ReferenceId2,
        "ReferenceId3" => $approval->ReferenceId3,
        "Group" => $approval->Group,
    ]);
foreach($SP->f5() AS $approvalDetail)
{
    $approvalDetail["Action"] = "<p class='text-center'><span class='text-center text-decoration-underline' title='".$approvalDetail["Status"]."' role='button'>".$approvalDetail["StatusCode"]."</span></p>";
    if($approvalDetail["StatusCode"] == "NU")
    {
        $approvalDetail["EmployeeName"] = $approvalDetail["ApproveByEmployeeName"].$approvalDetail["DisapproveByEmployeeName"];
        $approvalDetail["DateTime"] = $approvalDetail["ApproveDateTime"].$approvalDetail["DisapproveDateTime"];
        $approvalDetail["GeneralNotes"] = $approvalDetail["ApproveGeneralNotes"].$approvalDetail["DisapproveGeneralNotes"];
        $approvalDetail["RowClass"] = "light_grey";
    }
    else if($approvalDetail["StatusCode"] == "AP")
    {
        $approvalDetail["EmployeeName"] = $approvalDetail["ApproveByEmployeeName"];
        $approvalDetail["DateTime"] = $approvalDetail["ApproveDateTime"];
        $approvalDetail["GeneralNotes"] = $approvalDetail["ApproveGeneralNotes"];
        $approvalDetail["RowClass"] = "black";
        if($ajax->getPost("ApprovalId") == $approvalDetail["Id"])
        {
            //$approvalDetail["Action"] = "<p class='text-center'><button class='btn btn-sm btn-outline-secondary' title='DISAPPROVE' onClick='viewWindowDisapproveRequestOpen(".$ajax->getPost("ApprovalId").");'><i class='fa fa-thumbs-down'></i></button></p>";
        }
    }
    else if($approvalDetail["StatusCode"] == "DAP")
    {
        $approvalDetail["EmployeeName"] = $approvalDetail["DisapproveByEmployeeName"];
        $approvalDetail["DateTime"] = $approvalDetail["DisapproveDateTime"];
        $approvalDetail["GeneralNotes"] = $approvalDetail["DisapproveGeneralNotes"];
        $approvalDetail["RowClass"] = "retro_red";
        if($ajax->getPost("ApprovalId") == $approvalDetail["Id"])
        {
            //$approvalDetail["Action"] = "<p class='text-center'><button class='btn btn-sm btn-outline-secondary' title='APPROVE' onClick='viewWindowApproveRequestOpen(".$ajax->getPost("ApprovalId").");'><i class='fa fa-thumbs-up'></i></button>";
        }
    }
    else if($approvalDetail["StatusCode"] == "OS")
    {
        $approvalDetail["EmployeeName"] = "...MENUNGGU...";
        $approvalDetail["DateTime"] = "...MENUNGGU...";
        $approvalDetail["GeneralNotes"] = "...MENUNGGU...";
        $approvalDetail["RowClass"] = "retro_orange";
        if($ajax->getPost("ApprovalId") == $approvalDetail["Id"])
        {
            $approvalDetail["Action"] = "<p class='text-center'>";
            $approvalDetail["Action"] .= "<button class='btn btn-sm btn-outline-success' title='APPROVE' onClick='approvalSetApproveConfirmation(&quot;{$approval->DBName}&quot;,{$ajax->getPost("ApprovalId")});'><i class='fa-regular fa-thumbs-up'></i></button>";
            $approvalDetail["Action"] .= " <span class='text-center text-decoration-underline' title='{$approvalDetail["Status"]}' role='button'>{$approvalDetail["StatusCode"]}</span>";
            $approvalDetail["Action"] .= " <button class='btn btn-sm btn-outline-danger' title='DISAPPROVE' onClick='approvalSetDisapproveConfirmation(&quot;{$approval->DBName}&quot;,{$ajax->getPost("ApprovalId")});'><i class='fa-regular fa-thumbs-down'></i></button>";
            $approvalDetail["Action"] .= "</p>";
        }
    }

    if($approvalDetail["DateTime"] != "...MENUNGGU...")
        $approvalDetail["DateTime"] = date('d M Y, H:i:s', strtotime($approvalDetail["DateTime"]));

    $Approvals[] = $approvalDetail;
}
$datas["approvals"] = $Approvals;
