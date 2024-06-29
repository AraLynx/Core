<?php
namespace app\core;
session_start();
//-------------------------------- INIT
require_once dirname(__DIR__,2)."/configs/ajax.php";
$ajax = new Ajax();
//FORM VALIDATION
$ajax->addValidation("post","BranchId",["required"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","BranchId",["int"]);
$ajax->sanitize('post');

$SP = new \app\core\StoredProcedure(APP_NAME, "SP_Sys_Auth_getCompanyBranches");
$SP->addParameters(["UserId" => $ajax->post["loginUserId"]]);
$SP->addParameters(["BranchId" => $ajax->post["BranchId"]]);
if(count($SP->f5()))
{
    $_SESSION[APP_NAME]["login"]["branchId"] = $ajax->post["BranchId"];
}
else
{
    $ajax->setError("Login to branch failed");
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
