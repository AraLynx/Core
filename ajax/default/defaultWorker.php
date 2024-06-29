<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,2)."/configs/ajax.php";
$ajax = new Ajax();

//FORM VALIDATION
$ajax->addValidation("post","EmployeeId",["required"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","EmployeeId",["int"]);
$ajax->sanitize('post');

$datas["unreadEmailCounter"] = 0;
$datas["approvalWMAPCounter"] = 0;
$datas["changeLog"] = [];

if($app->getStatusCode() == 100 && $app->configs["worker"]["main_engine"] == "on")
{
    #region unreadEmailCounter
        if($app->configs["worker"]["unread_email"] == "on")
        {
            //unreadEmailCounter
            $model = new \app\modelAlls\UranusEmployee();
            $model->addParameters(["Id" => $ajax->post["EmployeeId"]]);
            $records = $model->f5();
            $employee = $records[0];

            /*
            if($employee->TrimandiriEmailAddress && $employee->TrimandiriEmailPassword)
            {
                $username = $employee->TrimandiriEmailAddress;
                $password = $employee->TrimandiriEmailPassword;

                $hostname = '{mail.tmsgroup.co.id:993/imap/ssl/novalidate-cert}INBOX';
                $inbox = imap_open($hostname,$username,$password);

                if($inbox)
                {
                    $emails = imap_search($inbox,'UNSEEN');
                    //$datas["emails"] = $emails;
                    if($emails)
                    {
                        $datas["unreadEmailCounter"] = count($emails);
                    }

                    imap_close($inbox);
                }
            }
            */
        }
    #endregion

    #region approvalWMAPCounter
        if($app->configs["worker"]["wmap"] == "on")
        {
            $SP = new StoredProcedure("uranus");
            $SP->initParameter($ajax->post);
            $SP->removeParameters(["loginUserId"]);
            $q = "EXEC [SP_Sys_Approval_approvalGetApprovals]";
            $q .= " @PositionId = {$ajax->post["PositionId"]}";
            $q .= ",@StatusCode = {$ajax->post["StatusCode"]}";
            $q .= ",@DateStart = '1900-01-01'";
            $q .= ",@DateEnd = '".date("Y-m-d")."'";
            if(APP_NAME == "Plutus")
            {
                $q .= ",@DBName = 'plutus'";
                $q .= ",@BranchId = {$ajax->post["BranchId"]}";
            }
            //dd($q);
            $SP->SPPrepare($q);
            $SP->execute();
            foreach($SP->getRow() AS $row)
            {
                $datas["approvalWMAPCounter"]++;
            }
        }
    #endregion

    #region change log
        if($app->configs["worker"]["new_change_log"] == "on")
        {
            $ChangeLog = new \app\TDEs\ChangeLogHelper($ajax->post["loginUserId"]);
            $datas["changeLog"] = $ChangeLog->getNewNotif();
        }
    #endregion
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
