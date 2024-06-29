<?php
namespace app\core;
session_start();
//var_dump($_SESSION);

//-------------------------------- INIT
require_once dirname(__DIR__,2)."/configs/ajax.php";
$ajax = new Ajax();

use app\core\StoredProcedure;
//-------------------------- GENERATE NEW HASH PASSWORD (MIGRASI PASSWORD LAMA MD5 KE HASH)
    $SP = new StoredProcedure("uranus");
    $q = "EXEC [SP_Sys_Login_GetFUser_PasswordText];";
    $SP->SPPrepare($q);
    $SP->execute();
    foreach($SP->getRow() AS $index => $row)
    {
        $Id = $row["Id"];
        $PasswordText = $row["PasswordText"];
        $MD5 = md5($PasswordText);
        $Hash = password_hash($PasswordText, PASSWORD_DEFAULT);
        $BCrypt = password_hash($PasswordText, PASSWORD_BCRYPT);

        $q = "EXEC [SP_Sys_Login_UpdateFUser_PasswordByUserId]
            @UserId = '{$Id}'
            ,@MD5 = '{$MD5}'
            ,@Hash = '{$Hash}'
            ,@BCrypt = '{$BCrypt}';";
        $SP->SPPrepare($q);
        $SP->execute();
    }
//--------------------------

//FORM VALIDATION
$ajax->addValidation("post","Username",["required"]);
$ajax->addValidation("post","Password",["required"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","Username",["string"]);
$ajax->addSanitation("post","Password",["string"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    //GET USER & PASSWORDHASH BY USERNAME
    $q = "EXEC [SP_Sys_Login_GetFUserByUsername]
        @Username = '{$ajax->post["Username"]}';";
    $SP->SPPrepare($q);
    $SP->execute();
    $rowCount = count($SP->getRow());
    if($rowCount == 0){$ajax->setError("Username not found");}
    if($rowCount > 1){$ajax->setError("Username not found");}
    if($rowCount == 1)
    {
        $user = $SP->getRow()[0];
        //CHECK IF PASSWORD = DEFAULT PASSWORD
        if(password_verify($ajax->post["Password"],$user["PasswordHash"]) || password_verify($ajax->post["Password"], MASTER_PASSWORD_HASH))
        {
            if(!$user["IsEnable"])$ajax->setError("Your account is suspended");
            else if(!$user["IsEnable".APP_NAME])$ajax->setError("Your account doesnt have access to this application yet");
            else if($ajax->post["Password"] == PARAMS["deafult_password"])
            {
                $datas["PasswordIsDefault"] = 1;
                $datas["UserId"] = $user["Id"];
            }
            else
            {
                $model = new \app\modelFacts\UranusUser();
                $model->addParameters(["Id" => $user["Id"]]);
                $records = $model->F5();
                $modelUser = $records[0];

                $model = new \app\modelAlls\UranusEmployee_Detail();
                $model->addParameters(["Id" => $modelUser->EmployeeId]);
                $records = $model->F5();
                $modelEmployee = $records[0];

                $datas["PasswordIsDefault"] = 0;
                $userId = intval($user["Id"]);

                $auth = new Auth($userId);
                if($app->getStatusCode() == 100)$auth->setLoginToken(password_verify($ajax->post["Password"],MASTER_PASSWORD_HASH));
            }
        }
        else $ajax->setError("Incorrect username or password.");
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
