<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax();
//FORM VALIDATION
$ajax->addValidation("post","DBName",["hidden"]);
$ajax->addValidation("post","ApprovalId",["hidden"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","DBName",["string"]);
$ajax->addSanitation("post","ApprovalId",["int"]);
$ajax->addSanitation("post","GeneralNotes",["string"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    $SP = new StoredProcedure("uranus");
    $SP->tranStart();
    $SP->tranTry("SP_Sys_Approval_approvalSetApprove",
        [
            "DBName" => $ajax->getPost("DBName")
            ,"ApprovalId" => $ajax->getPost("ApprovalId")
            ,"GeneralNotes" => $ajax->getPost("GeneralNotes") ?? ""
            ,"UserId" => $ajax->getPost("loginUserId")
        ]);
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
