<?php
namespace app\core;
//-------------------------------- INIT
require_once dirname(__DIR__,3)."/Chronos/configs/ajax.php";
$ajax = new Ajax("ru");
//FORM VALIDATION
$ajax->addValidation("post","Id",["required"]);
$ajax->addValidation("post","TrimandiriEmailAddress",["required"]);
$ajax->addValidation("post","TrimandiriEmailPassword",["required"]);
$ajax->validate('post');

//FORM SANITATION
$ajax->addSanitation("post","Id",["int"]);
$ajax->addSanitation("post","TrimandiriEmailAddress",["string"]);
$ajax->addSanitation("post","TrimandiriEmailPassword",["string"]);
$ajax->sanitize('post');

if($app->getStatusCode() == 100)
{
    $model = new \app\modelAlls\UranusEmployee_Detail();
    $model->addParameters(["TrimandiriEmailAddress" => $ajax->post["TrimandiriEmailAddress"]]);
    $model->addParameters(["NotId" => $ajax->post["Id"]]);
    if(count($model->f5()))$ajax->setError("Email address already being used. Please use other address");
    else
    {
        $hostname = '{mail.trimandirigroup.com:993/imap/ssl}INBOX';
        $username = $ajax->post["TrimandiriEmailAddress"];
        $password = $ajax->post["TrimandiriEmailPassword"];

        /* try to connect */
        $inbox = imap_open($hostname,$username,$password);

        /* grab emails */
        if($inbox)
        {
            $SP = new \app\core\StoredProcedure(APP_NAME,"SP_3_7_tdeUserSetTrimandiriEmail");
            $SP->addParameters([
                "Id" => $ajax->post["Id"],
                "TrimandiriEmailAddress" => $ajax->post["TrimandiriEmailAddress"],
                "TrimandiriEmailPassword" => $ajax->post["TrimandiriEmailPassword"]
            ]);
            $SP->f5();
            imap_close($inbox);
        }
        else
        {
            $ajax->setError(imap_last_error());
        }
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
